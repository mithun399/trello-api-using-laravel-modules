<?php

namespace Modules\Trello\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TrelloController extends Controller
{
    public function auth(Request $request){
        $tokenUrl = "https://trello.com/1/OAuthGetRequestToken";
        $authUrl = "https://trello.com/1/OAuthAuthorizeToken";
        $returnUrl = "http://127.0.0.1:8000/";
        $timestamp = time();
        
        Session::put('consumerkey', $request->apikey);
        Session::put('consumerSecret', $request->apisecret);
        
        $nonce = md5(mt_rand());
        $oauthSignatureMethod = "HMAC-SHA1";
        $oauthVersion = "1.0";
        
        $sigBase = "GET&" . rawurlencode($tokenUrl) . "&"
            . rawurlencode("oauth_consumer_key=" . rawurlencode(Session::get('consumerkey'))
            . "&oauth_nonce=" . rawurlencode($nonce)
            . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
            . "&oauth_timestamp=" . $timestamp 
            . "&oauth_version=" . $oauthVersion);
        
        $sigKey = Session::get('consumerSecret') . "&";
        $oauthSig = base64_encode(hash_hmac("sha1", $sigBase, $sigKey, true));
        $requestUrl = $tokenUrl . "?"
            . "oauth_consumer_key=" . rawurlencode(Session::get('consumerkey'))
            . "&oauth_nonce=" . rawurlencode($nonce)
            . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
            . "&oauth_timestamp=" . rawurlencode($$timestamp)
            . "&oauth_version=" . rawurlencode($oauthVersion)
            . "&oauth_signature=" . rawurlencode($oauthSig);
        
        
            $headers = get_headers($requestUrl, 1);
            if ($headers[0] == 'HTTP/1.1 200 OK') {
                $response = file_get_contents($requestUrl, false);
                $scope = 'read,write,account';
                $expiration = '1hour';
                parse_str($response, $values);
                Session::put('requestTokenSecret', $values["oauth_token_secret"]);
                Session::put('requestToken', $values["oauth_token"]);
                
                $redirectUrl = $authUrl . "?"
                    . "&oauth_token=" . Session::get('requestToken')
                    . "&scope=" . $scope
                    ."&expiration=" . $expiration;
        
             return $redirectUrl;
            }
                
        
        else{
            return "failed";
        }
        
        
        }
        
        
        public function accessToken(){
             
        $nonce = md5(mt_rand());
        $timestamp = time();
        
        $oauth_signature_base = 'GET&'.
        rawurlencode('https://trello.com/1/OAuthGetAccessToken').'&'.
        rawurlencode(implode('&',[
            'oauth_consumer_key='.rawurlencode('CONSUMER_KEY_HERE'),
            'oauth_nonce='.rawurlencode($nonce),
            'oauth_signature_method='.rawurlencode('HMAC-SHA1'),
            'oauth_timestamp='.rawurlencode($timestamp),
            'oauth_token='.rawurlencode('OAUTH_TOKEN_HERE'),
            'oauth_verifier='.rawurlencode('OAUTH_VERIFIER_HERE'),
            'oauth_version='.rawurlencode('1.0')
            ]));
        
        
        $signature = base64_encode(hash_hmac('sha1', $oauth_signature_base, 'CONSUMER_SECRET_HERE&TOKEN_SECRET_HERE', true));
        
        $params = [
        'oauth_consumer_key='.rawurlencode('CONSUMER_KEY_HERE'),
        'oauth_nonce='.rawurlencode($nonce),
        'oauth_signature_method='.rawurlencode('HMAC-SHA1'),
        'oauth_timestamp='.rawurlencode($timestamp),
        'oauth_token='.rawurlencode('OAUTH_TOKEN_HERE'),
        'oauth_verifier='.rawurlencode('OAUTH_VERIFIER_HERE'),
        'oauth_version='.rawurlencode('1.0'),
        'oauth_signature='.rawurlencode($signature)
        ];
        
         $url = file_get_contents(sprintf('%s?%s', 'https://trello.com/1/OAuthGetAccessToken', implode('&', $params)));
        
        parse_str($url, $values);
        
        Session::put('oauth_access_token',$values['oauth_token']);
        
        $key = Session::get('consumerkey');
                $token = Session::get('oauth_access_token');
                $data = Http::get('https://api.trello.com/1/members/me/organizations?key='.$key.'&token='.$token)->json();
                $data= collect($data);
                Session::put('orgid',$data[0]['id']);
        
        return redirect('/board')->with('msg','Api access Successful');
    }         
        public function getBoard(){
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
            $orgid = Session::get('orgid');
            $list = Http::get('https://api.trello.com/1/organizations/'.$orgid.'/boards?key='.$key.'&token='. $token)->json();
            $list = collect($list);
            return view('trello::board',['list'=>$list]);
    
        }      
        
        public function deleteBoard($id){
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
            $url = 'https://api.trello.com/1/boards/'.$id.'?key='.$key.'&token='.$token;
            $response = Http::delete($url);
            if($response){
             return redirect('/board');
            }
    
        }
       
        public function viewBoard(){

            return view('trello::createboard');
   
       }

        public function createBoard(Request $request){
            $name = $request->name;
            $desc = $request->desc;
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
            $url = 'https://api.trello.com/1/boards/?name='.$name.'&key='.$key.'&token='.$token.'&desc='.$desc;
            $response = Http::post($url);
            if($response){
             return redirect('/board');
            }
    
    
        }
        public function editView($id){

            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
    
            $url = 'https://api.trello.com/1/boards/'.$id.'?key='.$key.'&token='.$token;
    
            $response = Http::get($url);
            if($response){
             return view('trello::editboard',['data'=>$response]);
            }
    
    
        }
        public function updateBoard(Request $request,$id){
            $name = $request->name;
            $desc = $request->desc;
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
    
            $url = 'https://api.trello.com/1/boards/'.$id.'?name='.$name.'&key='.$key.'&token='.$token.'&desc='.$desc;
    
            $response = Http::put($url);
            if($response){
                return redirect('/board');
            }
    
    
        }
        public function boardList(Request $request,$id){
    
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
    
            $url = 'https://api.trello.com/1/boards/'.$id.'/lists?key='.$key.'&token='.$token;
    
            $response = Http::get($url)->json();
            $response = collect($response);
            if($response){
             return view('trello::boardlist',compact('response','id'));
            }
    
    
        }
        public function viewList($id){
    
            return view('trello::createlist',compact('id'));
    
       }
       public function addList(Request $request){

            $name = $request->name;
            $id = $request->id;
            $token = Session::get('oauth_access_token');
            $key = Session::get('consumerkey');
    
            $url = 'https://api.trello.com/1/lists?name='.$name.'&idBoard='.$id.'&key='.$key.'&token='.$token;
    
            $response = Http::post($url);
            if($response){
                return redirect('/getboadlist/'.$id);
            }
    
    }
    public function cardList(Request $request,$id){
    
        $token = Session::get('oauth_access_token');
        $key = Session::get('consumerkey');
    
        $url = 'https://api.trello.com/1/lists/'.$id.'/cards?key='.$key.'&token='.$token;
    
        $response = Http::get($url)->json();
        $response = collect($response);
    
        if($response){
         return view('trello::cardlist',compact('response'));
        }
    
    
    }
    public function cardView($id){
    
    return view('trello::addcard',compact('id'));
    
    
    }
    public function addCard(Request $request){
        $name = $request->name;
        $desc = $request->desc;
        $id = $request->id;
        $token = Session::get('oauth_access_token');
        $key = Session::get('consumerkey');
        $url = 'https://api.trello.com/1/cards?idList='.$id.'&key='.$key.'&token='.$token.'&name='.$name.'&desc='.$desc;
        $response = Http::post($url);
        if($response){
         return redirect('/getcardlist/'.$id);
        }
    
    
    }
    
}
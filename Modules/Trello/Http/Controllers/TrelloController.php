<?php

namespace Modules\Trello\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TrelloController extends Controller
{
    const BASE_URL_API='https://api.trello.com/1/';
    const ME_URL='members/me/';
    const MEMBER_BOARD_URL='members/[id]/boards';
    const BOARD_CARDS_URL='boards/[id]/cards';
    const CREATE_BOARD_URL='members/boards';
    const ORG_URL='members/organizations/[id]/boards';
    public function getUser(){
        $response=Http::get(url:self::BASE_URL_API .self::ME_URL . '/?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7');
        return json_decode($response->body());
    }
         
        public function getBoard(){
           
            $user=$this->getUser();
            $url=self::BASE_URL_API .self::MEMBER_BOARD_URL . '/?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
            $url=str_replace('[id]',$user->id,$url);
           
            
           $response=Http::get($url);
           $json=json_decode($response);
          
            return view('trello::board',['json'=>$json]);
    
        }      
        
        public function deleteBoard($id){
          
            $url = 'https://api.trello.com/1/boards/'.$id.'/?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
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
            
            $url = 'https://api.trello.com/1/boards/?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7'.'&name='.$name.$desc;
            $response = Http::post($url);
            if($response){
             return redirect('/board');
            }
    
    
        }
        public function editView($id){

        
    
            $url = 'https://api.trello.com/1/boards/'.$id.'/?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
    
            $response = Http::get($url);
            if($response){
             return view('trello::editboard',['data'=>$response]);
            }
    
    
        }
        public function updateBoard(Request $request,$id){
            $name = $request->name;
            $desc = $request->desc;
            
    
            $url = 'https://api.trello.com/1/boards/'.$id.'?name='.$name.'&key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7'.'&desc='.$desc;
    
            $response = Http::put($url);
            if($response){
                return redirect('/board');
            }
    
    
        }
        public function boardList(Request $request,$id){
    
           
    
            $url = 'https://api.trello.com/1/boards/'.$id.'/lists?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
    
            $response = Http::get($url)->json();
            $response = collect($response);
            if($response){
             return view('trello::boardlist',compact('response','id'));
            }
    
    
        }
        public function createlistview($id){

            return view('createlist',compact('id'));
    
    
    
       }
       public function addlist(Request $request){
    
    
    
            $name = $request->name;
            $id = $request->id;
           
    
            $url = 'https://api.trello.com/1/lists?name='.$name.'&idBoard='.$id.'&key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
    
            $response = Http::post($url);
            if($response){
                return redirect('/getboadlist/'.$id);
            }
    
    }
    public function getcardlist(Request $request,$id){
    
       
    
        $url = 'https://api.trello.com/1/lists/'.$id.'/cards?key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7';
    
        $response = Http::get($url)->json();
        $response = collect($response);
    
        if($response){
         return view('trello::cardlist',compact('response'));
        }
    
    
    }
    public function addcardview($id){
    
    return view('trello::addcard',compact('id'));
    
    
    }
    public function addcard(Request $request){
        $name = $request->name;
        $desc = $request->desc;
        $id = $request->id;
        
        $url = 'https://api.trello.com/1/cards?idList='.$id.'&key=277197d1e9b2e41487902b82cd2b35d8&token=f4be9a5ee3af38fe6a2c8c525004919f58a7b05885d11fdcf92a3eb8147829b7'.'&name='.$name.'&desc='.$desc;
        $response = Http::post($url);
        if($response){
         return redirect('/getcardlist/'.$id);
        }
    
    
    }
    
    
}
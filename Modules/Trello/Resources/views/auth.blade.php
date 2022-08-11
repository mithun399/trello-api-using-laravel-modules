@extends('master')
@section('title','Trello API')
@section('content')

<form action="" method="" id="key">
    @csrf
    <div class="form-outline">
    <label class="form-label">Key</label>
      <input type="text"  class="form-control" name="apikey" required/>
    </div>
    
    <div class="form-outline">
    <label class="form-label" >Secret API</label>
      <input type="text"  class="form-control"  name="apisecret" required/>
    </div>
    <br>
    <button type="submit" class="btn btn-primary btn-block  " id="btnkey">Submit</button>
  </form>
  @endsection

@extends('master')
@section('title','Add Card')
@section('content')
<h2>Add Card</h2>
<form action="/addcard" method="GET" >

    <div class="form-outline mb-4">
    <label class="form-label">Name</label>
      <input type="text"  class="form-control" name="name" required/>
    </div>
   
    <div class="form-outline mb-4">
        <label class="form-label">Description</label>
      <input type="text"  class="form-control"  name="desc" required/>

    </div>
    <input type="hidden"   name="id" value="{{ $id }}"/>
    <button type="submit" class="btn btn-primary btn-block mb-4" >Submit</button>
  </form>
  @endsection

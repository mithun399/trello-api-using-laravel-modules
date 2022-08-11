@extends('master')
@section('title','Edit Board')
@section('content')
<h2>Edit Baord</h2>
<form action="/updateboard/{{  $data['id'] }}" method="GET" >

    <div class="form-outline mb-4">
      <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" required/>

    </div>

    <div class="form-outline mb-4">
    <label class="form-label">Description</label>
      <input type="text" class="form-control"  name="desc" value="{{ $data['desc'] }}" required/>

    </div>
    <button type="submit" class="btn btn-primary btn-block mb-4" >Update</button>
  </form>
  @endsection

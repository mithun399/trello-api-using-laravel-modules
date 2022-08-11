@extends('master')
@section('title','Create Board')
@section('content')
<h2>Create Board</h2>
<form action="/createboard" method="GET" >

    <div class="form-outline mb-4">
        <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" required/>
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" >Desc</label>
      <input type="text" class="form-control"  name="desc" required/>

    </div>

    <button type="submit" class="btn btn-primary btn-block mb-4" >Submit</button>
  </form>
  @endsection

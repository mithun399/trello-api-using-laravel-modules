@extends('master')
@section('title','Create List')
@section('content')
<h2>Create List</h2>
<form action="/addlist" method="GET" >
    <div class="form-outline mb-4">
    <label class="form-label">Name</label>
      <input type="text" class="form-control" name="name" required/>

    </div>
    <input type="hidden"  name="id" value="{{ $id }}"/>
    <button type="submit" class="btn btn-primary btn-block mb-4" >Submit</button>
  </form>
  @endsection

@extends('master')
@section('title','All Board')
@section('content')
<a href="/createboardview">
<button type="button" class="btn btn-primary mb-2">Add Board</button>
</a>
<h2>All Board</h2>
<table class="table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th  scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($json as $key => $value )
      <tr>
        <td>{{ $value->name}}</td>
        <td>{{ $value->desc}}</td>
        <td>
          <a href="/editview/{{ $value->id }}">
            <button type="button" class="btn btn-primary">Edit</button>
            </a>
            <a href="/boarddelete/{{ $value->id }}">
            <button type="button" class="btn btn-danger">Delete</button>
            </a>
            <a href="/getboadlist/{{ $value->id }}">
                <button type="button" class="btn btn-success">View List</button>
            </a>
        </td>

      </tr>
      @endforeach

    </tbody>
  </table>
@endsection

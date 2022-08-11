@extends('master')
@section('title','Board List')
@section('content')

@if(session()->has('message'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert"></button>
          {{session()->get('msg')}}
          </div>

        @endif
<a href="/createlistview/{{ $id }}">
    <button type="button" class="btn btn-primary  mb-2">Add List</button>
    </a>
    <h2>Board List</h2>
<table class="table">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($response as $key => $value )


      <tr>

        <td>{{ $value['name']}}</td>

        <td>
           {{-- <a href="/editview/{{ $value['id'] }}">
            <button type="button" class="btn btn-primary btn-sm">Edit</button>
            </a> --}}
            <a href="/getcardlist/{{ $value['id']}}">
            <button type="button" class="btn btn-danger btn-sm">View Card</button>
            </a>

                <a href="/addcardview/{{ $value['id']}}">
                    <button type="button" class="btn btn-warning btn-sm">Add Card</button>
                    </a>
        </td>

      </tr>
      @endforeach

    </tbody>
  </table>
@endsection

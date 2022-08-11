@extends('master')
@section('title','Card List')
@section('content')

<h2>Card List</h2>
<table class="table">
    <thead>
      <tr>   
        <th scope="col">Name</th>
        <th scope="col">Description</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($response as $key => $value )
      <tr>
        <td>{{ $value['name']}}</td>
        <td>{{ $value['desc']}}</td>
      </tr>
      @endforeach

    </tbody>
  </table>
@endsection

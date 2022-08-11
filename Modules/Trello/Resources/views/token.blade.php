@extends('master')
@section('title','Enter Verification Code')
@section('content')
<form  id="token">
    @csrf
    <div class="form-outline mb-4">
        <label class="form-label">Verification Code</label>
      <input type="text" class="form-control" name="token_api" required/>
    </div>
    <button type="submit" class="btn btn-primary btn-block mb-4" id="btntoken">Authintaicated</button>
  </form>
@endsection

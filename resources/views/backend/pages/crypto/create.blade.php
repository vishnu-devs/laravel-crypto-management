@extends('backend.layouts.master')

@section('title')
Add Crypto Currency
@endsection

@section('admin-content')

<style>
    form {
    display: flex;
    flex-direction: column;
    width: 400px;
    margin: 80px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  label {
    display: block;
    margin-bottom: 5px;
  }
  input[type="text"], input[type="number"], input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }

  button{
        margin: 10px 0 0 0;
          background: linear-gradient(to right, #8914fe 0%, #8063f5 100%);
          color: white;
    border: none;
    padding: 10px
  }
      
</style>
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Add Crypto Currency</h4>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

  <form action="{{ route("crypto.store") }}" method="post">
    @csrf
    <label for="currency">Currency Name:</label>
    <input type="text" id="currency" name="currency" placeholder="Enter currency name">
    @error('currency')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    
    <button type="submit">Add Currency</button>
</form>

@endsection

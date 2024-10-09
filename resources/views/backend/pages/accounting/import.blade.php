
@extends('backend.layouts.master')

@section('title')
Import Csv File
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
  input[type="file"] {
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
                <h4 class="page-title pull-left">Import Csv File</h4>

            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('import.csv') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">Upload CSV File:</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control-file" accept=".csv">
                        </div>
                    
                        <button type="submit" name="submit">Upload and Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
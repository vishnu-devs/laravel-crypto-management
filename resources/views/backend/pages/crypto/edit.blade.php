@extends('backend.layouts.master')

@section('title')
Update Crypto Currency
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

  button[type="submit"]{
        margin: 10px 0 0 0;
          background: linear-gradient(to right, #8914fe 0%, #8063f5 100%);
          color: white;
    border: none;
    padding: 10px
  }
      
  h1 {
      text-align: center;
  }

  .toggle-button {
    width: 80px; /* Adjusted width to accommodate text */
    height: 40px;
    border-radius: 20px;
    background-color: rgba(255, 0, 0, 0.815); /* Default color */
    border: none;
    cursor: pointer;
    color: white; /* Text color */
    font-weight: bold; /* Bold text */
}

  .active_status {
      background-color: green;
  }

</style>
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Update Crypto Currency</h4>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<body>
    <form action="{{ route('crypto.update', $currency->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="currency">Currency</label>
            <input type="text" name="currency" id="currency" class="form-control" value="{{ $currency->currency }}" required>
            @if ($errors->has('currency'))
                <span class="text-danger">{{ $errors->first('currency') }}</span>
            @endif
            <br>
            <button type="button" class="toggle-button {{ $currency->status ? 'active_status' : '' }}" id="toggleButton">
                {{ $currency->status ? 'Active' : 'Inactive' }}
            </button>
            <input type="hidden" name="status" id="status" value="{{ $currency->status }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#toggleButton').click(function() {
                var statusInput = $('#status');
                var currentStatus = statusInput.val();
                var newStatus = currentStatus === '1' ? '0' : '1';

                statusInput.val(newStatus);
                $(this).toggleClass('active_status');

                // Update button text based on the new status
                if (newStatus === '1') {
                    $(this).text('Active');
                } else {
                    $(this).text('Inactive');
                }
            });
        });
    </script>
</body>
@endsection

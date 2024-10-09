
@extends('backend.layouts.master')

@section('title')
Sale Currency
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>

    .form-check-label {
        text-transform: capitalize;
    }

    select.form-control:not([size]):not([multiple]) {
        height: 45px;
    }

    div.card p.float-right.mb-2 {
        display: flex;
        justify-content: end;
        margin: 25px 25px 0 25px;
    }
    .d-none-custom{
        color: red;
        margin-top: 5px;
        display: none;
    }

</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Sale Currency</h4>
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
                <p class="float-right mb-2">
                    <a class="btn btn-primary text-white" href="{{route("accountingSale.index")}}">All Sale Currencies</a>
                </p>
                <div class="card-body">
                    <form action="{{ route('accountingSale.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="currency-name">Currency Name</label>
                                <select class="form-control" name="currency_id" id="currency_id">
                                    <option value="" disabled selected>Select Currency</option>
                                    @foreach($currecnies as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->currency }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('currency_id'))
                                    <div class="text-danger">{{ $errors->first('currency_id') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="qty">Quantity</label>
                                <input type="number" class="form-control" id="currency_qty" name="qty" placeholder="Enter Quantity" value="{{ old('qty') }}">
                                <div class="text-danger d-none-custom" id="hidden_bal_message"></div>
                                <input type="hidden" id="hidden_bal_available">
                                @if ($errors->has('qty'))
                                    <div class="text-danger">{{ $errors->first('qty') }}</div>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control" name="rate" placeholder="Enter Rate" value="{{ old('rate') }}">
                                @if ($errors->has('rate'))
                                    <div class="text-danger">{{ $errors->first('rate') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="timing">Date & Time</label>
                                <input type="datetime-local" class="form-control" name="timing" value="{{ old('timing') }}">
                                @if ($errors->has('timing'))
                                    <div class="text-danger $errors->first('timing') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#currency_id').change(function() {
            var currency_id = $(this).val();
            // console.log(currency_id);
            if (currency_id) {
                $.ajax({
                    url: '/admin/get-currency-balance/',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        currency_id: currency_id,
                    },
                    success: function(response) {
                        // console.log(response.purchaseBalance);
                        $('#hidden_bal_available').val(response.purchaseBalance);
                    },
                    error: function(xhr) {
                        console.log('An error occurred.');
                    }
                });
            } else {
                //   alert('Please select a currency and enter a purchase balance.');
            }
        });

        $('#currency_qty').on('input', function() {
            // Get the value of the hidden balance available
            var hidden_bal_available = parseFloat($('#hidden_bal_available').val());

            // Get the current value of the input field
            var current_value = parseFloat($(this).val());

            // Check if the current value exceeds the hidden balance available
            if (current_value > hidden_bal_available) {
                // If it exceeds, set the input value to the hidden balance available
                $(this).val(hidden_bal_available);
                var hidden_bal_message = $('#hidden_bal_message');

                hidden_bal_message.html('You cannot enter a value greater than the available balance of ' + hidden_bal_available);
                hidden_bal_message.show();

                // Hide the error message after 5 seconds
                setTimeout(function() {
                    hidden_bal_message.hide();
                }, 3000);
            }
        });  

    })
</script>
@endsection

@extends('backend.layouts.master')

@section('title')
Purchased Currency
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

</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Purchased Currency</h4>
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
                    <a class="btn btn-primary text-white" href="{{route("accountingPurchase.index")}}">All Purchased Currencies</a>
                </p>
                <div class="card-body">
                    <form action="{{ route('accountingPurchase.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="currency-name">Currency Name</label>
                                <select class="form-control" name="currency_id">
                                    <option value="" disabled selected>Select Currency</option>
                                    @foreach($currency_name as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency_id', $purchase->currency_id ?? '') == $currency->id ? 'selected' : '' }}>{{ $currency->currency }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('currency_id'))
                                    <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" step="0.01" name="qty" placeholder="Enter Quantity" value="{{ old('qty', $purchase->qty ?? '') }}">
                                @if ($errors->has('qty'))
                                    <span class="text-danger">{{ $errors->first('qty') }}</span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control" step="0.01" name="rate" placeholder="Enter Rate" value="{{ old('rate', $purchase->rate ?? '') }}">
                                @if ($errors->has('rate'))
                                    <span class="text-danger">{{ $errors->first('rate') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="timing">Date & Time</label>
                                <input type="datetime-local" class="form-control" name="timing" value="{{ old('timing', $purchase->timing ?? '') }}">

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
    })
</script>
@endsection

@extends('backend.layouts.master')

@section('title')
All Crypto Balance
@endsection


@section('admin-content')


<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">All Crypto Balance</h4>

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
                    {{-- <h4 class="header-title float-left">Users List</h4> --}}
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sr. No.</th>
                                    <th>Currency Name</th>
                                    <th>Quantity</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($purchased_data as $purchase)
                               <tr>
                                   <td>{{  $loop->index+1 }}</td>
                                    <td>
                                        @foreach($currency_name as $currency)
                                            @if($currency->id == $purchase->currency_id)
                                                {{ $currency->currency }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $purchase->balance }}</td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection


@section('scripts')
     
     <script>
          /*================================
         datatable active
         ==================================*/
         var wd = screen.width;
        //  console.log(wd);
          if ($('#dataTable').length) {
            
            if(wd >= 600){
            $('#dataTable').DataTable({
                    responsive: false
                    });
            } else{
                $('#dataTable').DataTable({
                    responsive: true
                    });
            }
        
            }

     </script>

    
@endsection
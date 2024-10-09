
@extends('backend.layouts.master')

@section('title')
All Sale currencies
@endsection

@section('styles')
    <!-- Start datatable css -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css"> --}}

@endsection


@section('admin-content')


<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">All Sale currencies</h4>

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
                    {{-- <form action="{{ route('import.csv') }}" method="post" enctype="multipart/form-data" class="float-left">
                        @csrf
                        <label for="sale_file">Sale CSV:</label>
                        <input type="file" name="sale_file" accept=".csv"><br>
                        <button type="submit" name="submit">Upload and Import</button>
                    </form> --}}
                    {{-- <h4 class="header-title float-left">Users List</h4> --}}
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{route("accountingSale.create")}}">Register New Sale data</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sr. No.</th>
                                    <th>Currency Name</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Timing</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($sale_data as $sale)
                               <tr>
                                   <td>{{  $loop->index+1 }}</td>
                                    <td>
                                        @foreach($currency_name as $currency)
                                            @if($currency->id == $sale->currency_id)
                                                {{ $currency->currency }}
                                            @endif
                                        @endforeach
                                    </td>
                                    
                                    <td>{{ $sale->qty }}</td>
                                    <td>{{ $sale->rate }}</td>
                                    <td>{{ $sale->timing }}</td>
                                    <td>
                                        {{-- <a class="btn btn-success text-white" href="{{ route("accountingPurchase.create")}}">Edit</a>
                                        <a class="btn btn-danger text-white" href="{{ route("accountingPurchase.create")}}">Delete</a> --}}
                                        <a class="btn btn-success text-white" href="{{ route('accountingSale.edit', $sale->id) }}">Edit</a>
                                        
                                        <form id="deleteForm{{ $sale->id }}" action="{{ route('accountingSale.destroy', $sale->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $sale->id }})" class="btn btn-danger text-white">Delete</button>
                                        </form>
                                        
                                        <script>
                                            function confirmDelete(id) {
                                                if (confirm('Are you sure you want to delete this record?')) {
                                                    document.getElementById('deleteForm'+id).submit();
                                                }
                                            }
                                        </script>
                                        

                                    </td>
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
     <!-- Start datatable js -->
     {{-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> --}}
     
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
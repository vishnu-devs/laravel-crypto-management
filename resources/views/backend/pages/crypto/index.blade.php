
@extends('backend.layouts.master')

@section('title')
All Crypto currencies
@endsection

@section('styles')

    <style>
        /* Custom styles for making the table responsive below 600px width */
        @media screen and (max-width: 600px), screen and (max-height: 600px) {
          .dataTables_wrapper {
            overflow-x: auto;
          }
          table.dataTable {
            width: 100%;
          }
        }

        .alert {
            position: relative;
        
            right: -100%; 
            margin-left: 10px;
            transition: right 1s ease-in-out;
            padding: 10px; 
            opacity: 1;
        }

      
        .alert.show {
            right: 20px;
        }

      
        .alert.hide {
            right: 100%;
            opacity: 0;
            transition: right 2s ease-in-out, opacity 0.8s ease-in-out;
        }

      </style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">All Crypto currencies</h4>

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
                    <p class="float-right mb-2">
                        <a class="btn btn-primary text-white" href="{{route("crypto.create")}}">Register New Crypto Currency</a>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sr. No.</th>
                                    <th>Currency Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $index => $item): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $item->currency; ?></td>                     
                                        <td>
                                            <?php if ($item->status == 1): ?>
                                                <span class="btn text-success status-toggle" data-id="<?php echo $item->id; ?>">Active</span>
                                            <?php else: ?>
                                                <span class="btn text-danger status-toggle" data-id="<?php echo $item->id; ?>">Inactive</span>
                                            <?php endif; ?>
                                        </td>                     
                                        </td>
                                        <td>
                                            <a class="btn btn-success text-white" href="{{ route('crypto.edit', $item->id) }}">Edit</a>
                                            
                                            <form id="deleteForm{{ $item->id }}" action="{{ route('crypto.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $item->id }})" class="btn btn-danger text-white">Delete</button>
                                            </form>
                                            
                        
                                        </td>
                                    </tr>
                                <?php endforeach;?>
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

            $(document).ready(function() {
                var $flashMessage = $('.alert');
                
                $flashMessage.addClass('show');
                setTimeout(function() {
                    $flashMessage.addClass('hide');
                }, 5000); 
            });
            </script>

            <script>
                function confirmDelete(id) {
                    if (confirm('Are you sure you want to delete this record?')) {
                        document.getElementById('deleteForm'+id).submit();
                    }
                }
            </script>
    
@endsection


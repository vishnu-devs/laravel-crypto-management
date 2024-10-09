
@extends('backend.layouts.master')

@section('title')
Profit Loss
@endsection

@section('admin-content')


<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Profit Loss</h4>
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
                                    <th>Sale ID</th>
                                    <th>Purchase Balance ID</th>
                                    <th>Sale Quantity</th>
                                    <th>Sale Rate</th>
                                    <th>Purchase Balance Quantity</th>
                                    <th>Purchase Rate</th>
                                    <th>Profit/Loss</th>
                                    <th>Total Profit/Loss</th>
                                    <th>Date/time</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                {{-- @foreach ($matched_records as $index => $record)
                                @php
                                // Determine if the index is even or odd
                                $class = ($record['profit_loss']->sale_id % 2 == 0) ? 'tr_even' : 'tr_odd';

                                $profitOrLoss = $record['profit_loss']->profit_or_loss;
                                $profitOrLossLabel = $profitOrLoss == 2 ? '-' : ($profitOrLoss > 0 ? 'Profit' : 'Loss');
                                $textClass = $profitOrLoss == 2 ? 'text-muted' : ($profitOrLoss > 0 ? 'text-success' : 'text-danger');

                                @endphp
                                <tr class="{{ $class }}" data-sale-id="{{ $record['profit_loss']->sale_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $record['table_history']->currency->currency }}</td>
                                    <td>{{ $record['profit_loss']->sale_id }}</td>
                                    <td>{{ $record['table_history']->purchase_balance_id }}</td>
                                    <td>{{ $record['profit_loss']->qty }}</td>
                                    <td>{{ $record['profit_loss']->sale_rate }}</td>
                                    <td>{{ $record['table_history']->qty }}</td>
                                    <td>{{ $record['profit_loss']->purchase_rate }}</td>
                                    <td class="{{ $textClass }} ">
                                        {{ $profitOrLossLabel }}
                                    </td>
                                    <td>{{ $record['profit_loss']->difference }}</td>
                                    <td>{{ $record['profit_loss']->created_at }}</td>
                                </tr>
                                @endforeach --}}

                                @php
                                // Group records by sale_id
                                $groupedRecords = [];
                                foreach ($matched_records as $record) {
                                    $saleId = $record['profit_loss']->sale_id;
                                    $groupedRecords[$saleId][] = $record;
                                }
                                
                                // Flatten the grouped records into a single array
                                $allRecords = [];
                                foreach ($groupedRecords as $records) {
                                    foreach ($records as $record) {
                                        $allRecords[] = $record;
                                    }
                                }
                                
                                // Sort the flattened records by created_at in descending order
                                usort($allRecords, function($a, $b) {
                                    return strtotime($a['profit_loss']->created_at) - strtotime($b['profit_loss']->created_at);
                                });
                                
                                // Rebuild grouped records after sorting
                                $groupedRecords = [];
                                foreach ($allRecords as $record) {
                                    $saleId = $record['profit_loss']->sale_id;
                                    $groupedRecords[$saleId][] = $record;
                                }
                                
                                // Prepare array to store assigned classes
                                $saleIdClasses = [];
                                $classToggle = 'tr_odd'; // Start with 'tr_odd' for the first group
                                
                                // Initialize a global serial number counter
                                $serialNumber = 1;
                                @endphp
                                
                                @foreach ($groupedRecords as $saleId => $records)
                                    @php
                                    // Assign a class to this sale_id
                                    $saleIdClasses[$saleId] = $classToggle;
                                    $classToggle = ($classToggle === 'tr_odd') ? 'tr_even' : 'tr_odd';
                                    @endphp
                                
                                    @foreach ($records as $index => $record)
                                        @php
                                        $profitOrLoss = $record['profit_loss']->profit_or_loss;
                                        $profitOrLossLabel = $profitOrLoss == 2 ? '-' : ($profitOrLoss > 0 ? 'Profit' : 'Loss');
                                        $textClass = $profitOrLoss == 2 ? 'text-muted' : ($profitOrLoss > 0 ? 'text-success' : 'text-danger');
                                        $rowClass = $saleIdClasses[$saleId];
                                        @endphp
                                
                                        <tr class="{{ $rowClass }}" data-sale-id="{{ $saleId }}" role="row">
                                            <td class="sorting_1">{{ $serialNumber++ }}</td>
                                            <td>{{ $record['table_history']->currency->currency }}</td>
                                            <td>{{ $saleId }}</td>
                                            <td>{{ $record['table_history']->purchase_balance_id }}</td>
                                            <td>{{ $record['profit_loss']->qty }}</td>
                                            <td>{{ $record['profit_loss']->sale_rate }}</td>
                                            <td>{{ $record['table_history']->qty }}</td>
                                            <td>{{ $record['profit_loss']->purchase_rate }}</td>
                                            <td class="{{ $textClass }}">
                                                {{ $profitOrLossLabel }}
                                            </td>
                                            <td>{{ $record['profit_loss']->difference }}</td>
                                            <td>{{ $record['profit_loss']->created_at }}</td>
                                        </tr>
                                        
                                    @endforeach
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
            
            if(wd >= 1370){
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
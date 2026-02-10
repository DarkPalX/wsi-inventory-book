@extends('theme.main')

@section('pagecss')
<!-- Add any specific CSS for the show page here -->
@endsection

@section('content')
    <div class="wrapper p-5">
        
        <div class="row">
            <div class="col-md-6">
                <strong class="text-uppercase">Issuance Transaction Details</strong>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receiving.transactions.index') }}">Transactions</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Issuance Transaction Details</span>
                        <div class="card-tools">
                            <a href="javascript:void(0)" class="text-decoration-none" onclick="print_area('print-area')">
                                <i class="fa fa-print"></i> Print
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="print-area">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <p class="form-control-plaintext">
                                        <strong><small class="rounded text-white {{ $transaction->status == 'SAVED' ? 'bg-warning' : ($transaction->status == 'CANCELLED' ? 'bg-danger' : 'bg-success') }} p-1">{{ $transaction->status }}</small></strong>
                                        <small class="text-secondary" {{ $transaction->status == 'SAVED' ? 'hidden' : '' }}> | 
                                            @if($transaction->status == 'POSTED')
                                                {{ User::getName($transaction->posted_by) }} ({{ $transaction->posted_at }})
                                            @else
                                                {{ User::getName($transaction->cancelled_by) }} ({{ $transaction->cancelled_at }})
                                            @endif
                                        </small>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-sm-3 col-form-label">Reference #</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $transaction->id }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Receiver</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">
                                        @php
                                            $receiverNames = [];
                                            foreach ($receivers as $receiver) {
                                                if (in_array($receiver->id, json_decode($transaction->receiver_id ?? '[]', true))) {
                                                    $receiverNames[] = $receiver->name;
                                                }
                                            }
                                        @endphp

                                        {{ implode(', ', $receiverNames) }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date Received</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $transaction->date_released }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Created by</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ User::getName($transaction->created_by) }} <small class="text-secondary">({{ $transaction->created_at }})</small></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Remarks</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $transaction->remarks }}</p>
                                </div>
                            </div>

                            <div class="divider text-uppercase divider-center"><small>Book Details</small></div>
                            
                            <div class="table-responsive-faker">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="15%">SKU</th>
                                            <th>Item Title</th>				
                                            <th class="text-end" width="20%">Quantity</th>
                                            <th class="text-end" width="15%">Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($issuance_total_quantity = 0)
                                        @php($issuance_total_cost = 0)

                                        @foreach($issuance_details as $issuance_detail)

                                            @php($issuance_total_quantity += $issuance_detail->quantity)
                                            @php($issuance_total_cost += $issuance_detail->cost)

                                            <tr>
                                                <td>
                                                    {{ $issuance_detail->sku }}
                                                </td>
                                                <td>
                                                    {{ $issuance_detail->book->name }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $issuance_detail->quantity }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $issuance_detail->cost }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-end" colspan="100%"><hr></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end" colspan="2"><strong>Total</strong></td>
                                            <td class="text-end text-primary"><strong>{{ $issuance_total_quantity }}</strong></td>
                                            <td class="text-end text-primary"><strong>{{ number_format($issuance_total_cost, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-secondary mt-4">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script>
        function print_area(area) {
            var printContents = document.querySelector('.' + area).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = '<div class="' + area + '">' + printContents + '</div>';

            window.print();

            document.body.innerHTML = originalContents;
            window.location.reload(); // Optionally reload the page to restore the original state
        }
    </script>
@endsection

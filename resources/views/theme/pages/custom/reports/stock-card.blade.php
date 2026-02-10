@extends('theme.layouts.report')

@section('pagecss')
@endsection

@section('content')
    <div class="wrapper p-5">
        
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-uppercase">{{ $page->name }}</h4>
            </div>
        </div>
        
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8">
                
                
                <form id="select_book_form" class="d-flex justify-content-between align-items-end" action="{{ route('reports.stock-card') }}" method="get">
                    <div class="col-4">
                        <strong>Select a book</strong>
                        <select name="id" class="selectpicker border w-100" data-live-search="true" onchange="document.getElementById('select_book_form').submit()">
                            <option>-- SELECT A BOOK --</option>
                            @foreach($books as $selection)
                                <option value="{{ $selection->id }}" @if($book->id == $selection->id) selected @endif>{{ $selection->sku }}: {{ $selection->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                
                <div class="card">
                    <div class="card-header">Stock Card</div>

                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="10%">Book ID</td>
                                <td width="1%">:</td>
                                <td>{{ $book->id ?? 'Select a book first' }}</td>
                            </tr>
                            <tr>
                                <td width="10%">Title</td>
                                <td width="1%">:</td>
                                <td>{{ $book->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td width="10%">Inventory</td>
                                <td width="1%">:</td>
                                <td>{{ $book->Inventory }}</td>
                            </tr>
                        </table>
                        
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Transaction ID</th>
                                        <th>Quantity</th>
                                        <th>Running Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stock_card as $entry)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($entry['date'])->format('m/d/Y') }}</td>
                                            <td>{{ $entry['type'] }}</td>
                                            <td>{{ $entry['transaction_id'] }}</td>
                                            <td>{{ $entry['quantity'] }}</td>
                                            <td>{{ $entry['running_balance'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-danger text-center">No transaction history</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- <a href="javascript:window.history.back()" class="btn btn-secondary mt-4">Back</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
@endsection

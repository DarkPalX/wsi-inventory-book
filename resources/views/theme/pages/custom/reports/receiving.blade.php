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
        
        <div class="row mt-5">

            <div class="table-responsive-faker">
                <table id="example" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="10%">Ref #</th>
                            <th width="10%">Date Received</th>
                            <th width="10%">Created</th>
                            <th width="10%">Posted</th>
                            <th width="10%">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr id="row{{$transaction->id}}">
                                <td><strong>{{ $transaction->id }}</strong></td>
                                <td>{{ (new DateTime($transaction->date_received))->format('M d, Y') }}</td>
                                <td>
                                    <small>
                                        <strong>{{ User::getName($transaction->created_by) }}</strong><br>
                                        {{ Setting::date_for_listing($transaction->created_at) }}
                                    </small>
                                </td>
                                <td>
                                    <small>
                                        <strong>{{ User::getName($transaction->posted_by) }}</strong><br>
                                        {{ Setting::date_for_listing($transaction->posted_at) }}
                                    </small>
                                </td>
                                <td><strong><small style="display: inline-block; width: 100px; text-align: center;" class="rounded text-white {{ $transaction->status == 'SAVED' ? 'bg-warning' : ($transaction->status == 'CANCELLED' ? 'bg-danger' : 'bg-success') }} p-1">{{ $transaction->status }}</small></strong></td>
                                <td>{{ $transaction->remarks }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center text-danger p-5" colspan="100%">No item available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="row">
                    <div class="col-md-12">
                        {{ $transactions->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('pagejs')
@endsection
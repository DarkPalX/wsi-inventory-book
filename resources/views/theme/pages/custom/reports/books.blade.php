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
                            <th>SKU</th>
                            <th width="20%">Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Publication Date</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr id="row{{$transaction->id}}">
                                <td>{{ $transaction->sku }}</td>
                                <td>
                                    <strong>{{ $transaction->name }}</strong><br>
                                    <small @if($transaction->trashed()) style="text-decoration:line-through;" @endif>{{ $transaction->subtitle }}</small>
                                </td>
                                <td>{{ $transaction->category->name }}</td>
                                <td>
                                    @foreach($transaction->authors as $author)
                                        <small>{{ $author->name }}</small><br>
                                    @endforeach
                                </td>
                                <td>{{ $transaction->publisher->name }}</td>
                                <td>{{ $transaction->publication_date }}</td>
                                <td>₱ {{ number_format($transaction->total_cost, 2) }}</td>
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
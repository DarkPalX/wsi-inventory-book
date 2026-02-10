@extends('theme.main')

@section('pagecss')
@endsection

@section('content')
    <div class="wrapper p-5">
        
        <div class="row">

            <div class="col-md-6">
                <strong class="text-uppercase">{{ $page->name }}</strong>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item">{{ $page->name }}</li>
                        <li class="breadcrumb-item">Manage</li>
                    </ol>
                </nav>
                
            </div>
            
        </div>

        <div class="row mt-4 mb-3">
            
            {{-- FILTERS AMD ACTIONS --}}
            @include('theme.layouts.transaction-filters')


            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <form class="d-flex align-items-center" id="searchForm" style="margin-bottom: 0; margin-right: -2%;">
                    <input name="search" type="search" id="search" class="form-control" placeholder="Search by Ref#" value="{{ $filter->search }}" style="width: auto;">
                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                </form>

                <a href="{{ route('issuance.transactions.create') }}" class="btn btn-primary">Create Transaction</a>
            </div>
            
        </div>
        
        <div class="row">

            <div class="table-responsive-faker" style="background-color: aliceblue;">
                <table id="authors_tbl" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="2%">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th width="10%">Ref #</th>
                            <th width="10%">Date Released</th>
                            <th width="10%">Created</th>
                            <th width="10%">Posted</th>
                            <th width="10%">Status</th>
                            <th width="35%">Remarks</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr id="row{{$transaction->id}}" @if($transaction->trashed()) class="table-danger" @endif>
                                <td>
                                    <input type="checkbox" class="{{ $transaction->status == 'SAVED' ? 'select-item' : 'item-trashed' }}" id="cb{{ $transaction->id }}" {{ $transaction->status == 'SAVED' ? '' : 'disabled' }}>
                                    <label class="custom-control-label" for="cb{{ $transaction->id }}"></label>
                                </td>
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
                                <td>
                                    <div style="position: relative; display: inline-block;">
                                        <p id="remarks-text-{{ $transaction->id }}" class="remarks-text" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $transaction->remarks }}
                                        </p>
                                        <small id="read-more-{{ $transaction->id }}" style="cursor: pointer; display: none; position: absolute; bottom: 0; background: #f8f9fa; padding: 0 4px; border-radius: 4px;" onclick="toggleText({{ $transaction->id }})"> See More ..</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('issuance.transactions.show', ['id' => $transaction->id]) }}" class="btn btn-light text-primary" title="View Transaction"><i class="bi-eye"></i></a>

                                    {{-- <a href="{{ route('issuance.transactions.show', $transaction->id) }}" class="btn btn-light text-primary" title="View Transaction"><i class="bi-eye"></i></a> --}}
                                    
                                    @if($transaction->status == 'SAVED')
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light text-secondary shadow-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if($transaction->status == 'SAVED')
                                                    <li>
                                                        <a href="{{ route('issuance.transactions.edit', $transaction->id) }}" class="dropdown-item" title="Edit">
                                                            <i class="uil-edit-alt"></i> Edit Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="single_post({{ $transaction->id }})" title="Post Transaction">
                                                            <i class="bi-send"></i> Post Transaction
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="single_cancel({{ $transaction->id }})" title="Delete Transaction">
                                                            <i class="fa-solid fa-cancel"></i> Cancel Transaction
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <small class="text-success">Transaction Complete</small>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-light text-secondary shadow-0" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if($transaction->trashed())
                                                <li>
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="single_restore({{ $transaction->id }})" title="Restore">
                                                        <i class="fa-solid fa-undo-alt"></i> Restore
                                                    </a>
                                                </li>
                                            @else
                                                @if($transaction->status == 'SAVED')
                                                    <li>
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="single_post({{ $transaction->id }})" title="Post Transaction">
                                                            <i class="bi-send"></i> Post Transaction
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('issuance.transactions.edit', $transaction->id) }}" class="dropdown-item" title="Edit">
                                                            <i class="uil-edit-alt"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="dropdown-item" onclick="single_delete({{ $transaction->id }})" title="Delete Transaction">
                                                            <i class="uil-trash-alt"></i> Delete
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <small class="text-success">Transaction Complete</small>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>
                                    </div> --}}

                                </td>
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


    {{-- MODALS --}}
    @include('theme.layouts.modals')
    
    
    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="transactions" name="transactions">
        <input type="text" id="status" name="status">
    </form>

@endsection

@section('pagejs')
	
    <!-- jQuery -->
    <script src="{{ asset('theme/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>
        let listingUrl = "{{ route('issuance.transactions.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
        
        function single_restore(id){
            post_form("{{ route('issuance.transactions.single-restore') }}",'',id);
        }

        function multiple_restore() {
            var counter = 0;
            var selected_items = '';

            $(".select-item:checked").each(function() {
                counter++;
                var fid = $(this).attr('id');
                
                if (fid !== undefined) {
                    selected_items += fid.substring(2) + '|';
                }
            });

            if (counter < 1) {
                $('.prompt-no-selected').modal('show');
                return false;
            } else {
                $('.multiple-restore').modal('show');
                $('.btn-restore-multiple').on('click', function() {
                    post_form("{{ route('issuance.transactions.multiple-restore') }}", '', selected_items);
                });
            }
        }
        
        function single_post(id){
            $('.single-post').modal('show');
            $('.btn-post').on('click', function() {
                post_form("{{ route('issuance.transactions.single-post') }}",'',id);
            });
        }
        
        function single_cancel(id){
            $('.single-delete').modal('show');
            $('.btn-delete').on('click', function() {
                post_form("{{ route('issuance.transactions.single-delete') }}",'',id);
            });
        }

        function multiple_cancel() {
            var counter = 0;
            var selected_items = '';

            $(".select-item:checked").each(function() {
                counter++;
                var fid = $(this).attr('id');
                
                if (fid !== undefined) {
                    selected_items += fid.substring(2) + '|';
                }
            });

            if (counter < 1) {
                $('.prompt-no-selected').modal('show');
                return false;
            } else {
                $('.multiple-delete').modal('show');
                $('.btn-delete-multiple').on('click', function() {
                    post_form("{{ route('issuance.transactions.multiple-delete') }}", '', selected_items);
                });
            }
        }
        
        function post_form(url,status,transactions){
            $('#posting_form').attr('action',url);
            $('#transactions').val(transactions);
            $('#status').val(status);
            $('#posting_form').submit();
        }
    </script>
    
    <script>
        document.querySelectorAll('.dropdown-menu').forEach(function (dropdown) {
            dropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>

    {{-- <script>
        jQuery(document).ready(function() {
            jQuery('#authors_tbl').dataTable();
        });
    </script> --}}
@endsection
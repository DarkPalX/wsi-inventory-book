@extends('theme.main')

@section('pagecss')
    <style>
        .navigation-item:hover i {
            color: #fe6400; /* Change icon color on hover */
        }

        .navigation-item i {
            color: #000; /* Default icon color */
        }

        .navigation-item:hover .dropdown-menu {
            display: block;
            position: absolute;
            margin-top: -50%; /* Adjust dropdown position as needed */
            margin-left: 100%;
            bottom: 0;
            left: 42px;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu .dropdown-item {
            font-size: 12px;
        }

        .dropdown-item:hover {
            background-color: #fe6400;
        }

        .posted td {
            background-color: rgb(189, 243, 231);
        }
        body {
            font-family: Poppins;
            font-size:13px;
        }

        /* custom styles */
        @media only screen and (min-width: 769px) and (max-width: 1351px) {
            .text-pills {
                color: white;
                background-color: black;
                padding: 5px 14px;
                position: absolute;
                text-wrap: nowrap;
                z-index: 9999;
                border-radius: 50px;
                font-size: 16px;
                transform: translate(48px, -52px);
                font-weight: 600;
                cursor: pointer;
            }
            .text-pills-holder:hover .text-pills {
                display: none !important;
                /* display: block !important; */
            }
            .text-vanish small {
                display: none;
            }
        }
    </style>


@endsection

@section('content')

    <div class="wrapper mx-5 mt-4">
        <div class="row mb-5">

            <div class="col-lg-1 col-md-12 col-sm-12 mb-md-5 mb-sm-5 shadow rounded-5" style="display: none;">
                
                <div class="col-md-12 text-menu-holder">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row justify-content-center mb-3">
                
                                <div class="col-auto text-center navigation-item text-pills-holder">
                                    <a href="{{ route('books.index') }}"><i class="bi-boxes display-6 mt-2 mb-2 mx-auto d-block"></i></a>

                                    <a href="{{ route('books.index') }}" class="text-dark mt-2 mb-2 mx-auto d-block text-uppercase text-vanish">
                                        <small style="font-size: 12px;">Manage Items</small>
                                        <span class="text-pills" style="display: none">Manage Items</span>
                                    </a>

                                    <div class="btn-group">
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('books.index') }}">Items List</a>
                                            <a class="dropdown-item" href="{{ route('books.create') }}">Create New Item</a>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-auto text-center navigation-item text-pills-holder">
                                    <a href="{{ route('receiving.transactions.index') }}"><i class="uil-download-alt display-6 mt-2 mb-2 mx-auto d-block"></i></a>

                                    <a href="{{ route('receiving.transactions.index') }}" class="text-dark mt-2 mb-2 mx-auto d-block text-uppercase text-vanish">
                                        <small style="font-size: 12px;">Receiving</small>
                                        <span class="text-pills" style="display: none">Receiving</span>
                                    </a>
                                    
                                    <div class="btn-group">
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('receiving.transactions.index') }}">Receiving Transaction List</a>
                                            <a class="dropdown-item" href="{{ route('receiving.transactions.create') }}">Create New Transaction</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto text-center navigation-item text-pills-holder">
                                    <a href="{{ route('issuance.transactions.index') }}"><i class="uil-upload-alt display-6 mt-2 mb-2 mx-auto d-block"></i></a>

                                    <a href="{{ route('issuance.transactions.index') }}" class="text-dark mt-2 mb-2 mx-auto d-block text-uppercase text-vanish">
                                        <small style="font-size: 12px;">Issuance</small>
                                        <span class="text-pills" style="display: none">Issuance</span>
                                    </a>
                                    
                                    <div class="btn-group">
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('issuance.transactions.index') }}">Issuance Transaction List</a>
                                            <a class="dropdown-item" href="{{ route('issuance.transactions.create') }}">Create New Transaction</a>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-auto text-center navigation-item text-pills-holder">
                                    <a href="javascript:void(0)"><i class="bi-graph-up display-6 mt-2 mb-2 mx-auto d-block"></i></a>

                                    <a href="javascript:void(0)" class="text-dark mt-2 mb-2 mx-auto d-block text-uppercase text-vanish"><small style="font-size: 12px;">Reports</small></a>
                                    
                                    <div class="btn-group">
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('reports.issuance') }}" target="_blank">Issuance Report</a>
                                            <a class="dropdown-item" href="{{ route('reports.receiving') }}" target="_blank">Receiving Stock Report</a>
                                            <a class="dropdown-item" href="{{ route('reports.stock-card') }}" target="_blank">Stock Card Report</a>
                                            {{-- <a class="dropdown-item" href="javascript:void(0)" data-bs-target=".funding-management-modal" data-bs-toggle="modal">Stock Card Report</a> --}}
                                            <a class="dropdown-item" href="{{ route('reports.inventory') }}" target="_blank">Inventory Report</a>
                                            <a class="dropdown-item" href="{{ route('reports.users') }}" target="_blank">User Report</a>
                                            <a class="dropdown-item" href="{{ route('reports.audit-trail') }}" target="_blank">Audit Trail</a>
                                            <a class="dropdown-item" href="{{ route('reports.books') }}" target="_blank">Book List</a>
                                        </div>
                                    </div>
                                </div>
                
                                <div class="col-auto text-center navigation-item text-pills-holder" @if(auth()->user()->role_id != 1) hidden @endif>
                                    <a href="javascript:void(0)"><i class="bi-gear display-6 mt-2 mb-2 mx-auto d-block"></i></a>

                                    <a href="javascript:void(0)" class="text-dark mt-2 mb-2 mx-auto d-block text-uppercase text-vanish"><small style="font-size: 12px;">Maintenance</small></a>
                                    
                                    <div class="btn-group">
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('books.categories.index') }}">Manage Categories</a>
                                            <a class="dropdown-item" href="{{ route('books.authors.index') }}">Manage Authors</a>
                                            <a class="dropdown-item" href="{{ route('books.publishers.index') }}">Manage Publishers</a>
                                            <a class="dropdown-item" href="{{ route('books.agencies.index') }}">Manage Agencies</a>
                                            <a class="dropdown-item" href="{{ route('accounts.users.index') }}">Manage Users</a>
                                            <a class="dropdown-item" href="{{ route('accounts.roles.index') }}">Manage Roles</a>
                                            <a class="dropdown-item" href="{{ route('receiving.suppliers.index') }}">Manage Suppliers</a>
                                            <a class="dropdown-item" href="{{ route('issuance.receivers.index') }}">Manage Receivers</a>
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="col-md-12 mb-2">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-books-center mb-4">
                                <h4 class="card-title mb-0">Dashboard</h4>
                                {{-- <div class="tools">
                                    <button class="btn btn-primary">Add New</button>
                                    <button class="btn btn-secondary">Settings</button>
                                </div> --}}
                            </div>
                            
                            <div class="row justify-content-center">

                                <div class="col-sm-6 col-lg-3 mb-4">
                                    <div class="border rounded-5 shadow p-3 h-100">
                                        <div class="feature-box fbox-effect">
                                            <div class="fbox-icon">
                                                <a href="{{ route('books.index') }}"><i class="bi-book"></i></a>
                                            </div>
                                            <div class="fbox-content">
                                                <div class="counter counter-small">
                                                    <span data-from="0" data-to="{{ $books_count }}" data-refresh-interval="50" data-speed="700"></span>
                                                </div>
                                                <p>BOOKS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="col-sm-6 col-lg-3 mb-4">
                                    <div class="border rounded-5 shadow p-3 h-100">
                                        <div class="feature-box fbox-effect">
                                            <div class="fbox-icon">
                                                <a href="{{ route('accounts.users.index') }}"><i class="uil-users-alt"></i></a>
                                            </div>
                                            <div class="fbox-content">
                                                <div class="counter counter-small">
                                                    <span data-from="0" data-to="{{ $users_count }}" data-refresh-interval="50" data-speed="700"></span>
                                                </div>
                                                <p>USERS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="col-sm-6 col-lg-3 mb-4">
                                    <div class="border rounded-5 shadow p-3 h-100">
                                        <div class="feature-box fbox-effect">
                                            <div class="fbox-icon">
                                                <a href="{{ route('receiving.transactions.index') }}"><i class="uil-download-alt"></i></a>
                                            </div>
                                            <div class="fbox-content">
                                                <div class="counter counter-small">
                                                    <span data-from="0" data-to="{{ $current_receiving_count }}" data-refresh-interval="50" data-speed="700"></span>
                                                </div>
                                                <p>NEW RECEIVING ENTRIES</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="col-sm-6 col-lg-3 mb-4">
                                    <div class="border rounded-5 shadow p-3 h-100">
                                        <div class="feature-box fbox-effect">
                                            <div class="fbox-icon">
                                                <a href="{{ route('issuance.transactions.index') }}"><i class="uil-upload-alt"></i></a>
                                            </div>
                                            <div class="fbox-content">
                                                <div class="counter counter-small">
                                                    <span data-from="0" data-to="{{ $current_issuance_count }}" data-refresh-interval="50" data-speed="700"></span>
                                                </div>
                                                <p>NEW ISSUANCE ENTRIES</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-2">
                    <div class="col-md-6 mb-2">
                        <div class="card border-0 shadow h-100">
                            <div class="card-header">
                                <strong><small>Issuance vs Receiving (Monthly)</small></strong>
                            </div>
                            <div class="card-body">
                                <div style="height:260px">
                                    <canvas id="trendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="card border-0 shadow h-100">
                            <div class="card-header">
                                <strong><small>Recent Transactions Volume</small></strong>
                            </div>
                            <div class="card-body">
                                <div style="height:260px">
                                    <canvas id="volumeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="card border-0 shadow">
                                    <div class="card-header d-flex justify-content-between align-books-center">
                                        <strong><small>Latest Issuance Transactions</small></strong>
                                        <div class="tools">
                                            <a href="{{ route('issuance.transactions.index') }}" class="btn btn-light text-dark"><i class="fa fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive-faker">
                                            <table class="table table-hover" cellspacing="0" width="100%">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="10%">Ref #</th>
                                                        <th>Received</th>
                                                        <th>Created</th>
                                                        <th>Posted</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($issuance_transactions as $issuance_transaction)
                                                        <tr id="row{{$issuance_transaction->id}}" onclick="window.location.href='{{ route('issuance.transactions.show', ['id' => $issuance_transaction->id]) }}';" class="{{ $issuance_transaction->status == 'POSTED' ? 'posted' : '' }}">
                                                            <td><strong>{{ $issuance_transaction->id }}</strong></td>
                                                            <td>{{ (new DateTime($issuance_transaction->date_received))->format('M d, Y') }}</td>
                                                            <td>
                                                                <small>
                                                                    <strong>{{ User::getName($issuance_transaction->created_by) }}</strong><br>
                                                                    {{ Setting::date_for_listing($issuance_transaction->created_at) }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <small>
                                                                    <strong>{{ User::getName($issuance_transaction->posted_by) }}</strong><br>
                                                                    {{ Setting::date_for_listing($issuance_transaction->posted_at) }}
                                                                </small>
                                                            </td>
                                                            <td>{{ $issuance_transaction->remarks }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center text-danger p-3" colspan="100%">No item available</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{ $issuance_transactions->onEachSide(1)->links('pagination::bootstrap-5') }}
                                                </div>
                                            </div>
                            
                                        </div>
                            
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <div class="card border-0 shadow">
                                    <div class="card-header d-flex justify-content-between align-books-center">
                                        <strong><small>Latest Receiving Transactions</small></strong>
                                        <div class="tools">
                                            <a href="{{ route('receiving.transactions.index') }}" class="btn btn-light text-dark"><i class="fa fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive-faker">
                                            
                                            <table class="table table-hover" cellspacing="0" width="100%">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th width="10%">Ref #</th>
                                                        <th>Received</th>
                                                        <th>Created</th>
                                                        <th>Posted</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($receiving_transactions as $receiving_transaction)
                                                        <tr id="row{{$receiving_transaction->id}}" onclick="window.location.href='{{ route('receiving.transactions.show', ['id' => $receiving_transaction->id]) }}';" class="{{ $receiving_transaction->status == 'POSTED' ? 'posted' : '' }}">
                                                            <td><strong>{{ $receiving_transaction->id }}</strong></td>
                                                            <td>{{ (new DateTime($receiving_transaction->date_received))->format('M d, Y') }}</td>
                                                            <td>
                                                                <small>
                                                                    <strong>{{ User::getName($receiving_transaction->created_by) }}</strong><br>
                                                                    {{ Setting::date_for_listing($receiving_transaction->created_at) }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <small>
                                                                    <strong>{{ User::getName($receiving_transaction->posted_by) }}</strong><br>
                                                                    {{ Setting::date_for_listing($receiving_transaction->posted_at) }}
                                                                </small>
                                                            </td>
                                                            <td>{{ $receiving_transaction->remarks }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center text-danger p-3" colspan="100%">No item available</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{ $receiving_transactions->onEachSide(1)->links('pagination::bootstrap-5') }}
                                                </div>
                                            </div>
                            
                                        </div>
                            
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="col-md-12 mb-2">
                            <div class="card border-0 shadow">
                                <div class="card-header d-flex justify-content-between align-books-center">
                                    <strong><small>Recent Activities</small></strong>
                                    <div class="tools">
                                        <a href="{{ route('reports.audit-trail') }}" target="_blank" class="btn btn-light text-dark"><i class="fa fa-list"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-faker">
                                        <table class="table table-hover" cellspacing="0" width="100%">
                                            <tbody>
                                                @forelse ($activity_logs as $activity_log)
                                                    <tr>
                                                        <td>
                                                            <small><strong>{{ User::getName($activity_log->log_by) }}</strong> {{ $activity_log->dashboard_activity }}</small>
                                                        </td>
                                                        <td class="text-end">
                                                            <small style="font-size:10px">{{ Setting::date_for_listing($activity_log->activity_date) }}</small>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-center text-danger p-3" colspan="100%">No book available</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                        
                                    </div>
                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



    {{-- MODAL --}}

    <div class="modal fade text-start funding-management-modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi-wallet i-alt mr-2"></i> Funding</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">Manage Agencies</a>
                        <a href="#" class="list-group-item list-group-item-action">Create an Agency</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejs')
    <script>
        $(document).ready(function() {

            var table = new DataTable('.transactions', {
                order: [[2, 'desc']], 

                columnDefs: [
                    {
                        visible: false,
                        target: []
                    }
                ]
            });
        });
    </script>

	<script src="{{ asset('theme/js/chart-npm.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // ===== Prepare monthly counts from PHP collections =====
            const issuanceDates = [
                @foreach($issuance_transactions as $t)
                    "{{ \Carbon\Carbon::parse($t->date_received)->format('Y-m') }}",
                @endforeach
            ];

            const receivingDates = [
                @foreach($receiving_transactions as $t)
                    "{{ \Carbon\Carbon::parse($t->date_received)->format('Y-m') }}",
                @endforeach
            ];

            function groupCounts(arr){
                const map = {};
                arr.forEach(m => map[m] = (map[m]||0)+1);
                return map;
            }

            const issuanceMap = groupCounts(issuanceDates);
            const receivingMap = groupCounts(receivingDates);

            const months = [...new Set([...issuanceDates, ...receivingDates])].sort();

            const issuanceData = months.map(m => issuanceMap[m] || 0);
            const receivingData = months.map(m => receivingMap[m] || 0);

            // ===== Trend Chart =====
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Issuance',
                            data: issuanceData,
                            borderWidth: 2,
                            tension: 0.3
                        },
                        {
                            label: 'Receiving',
                            data: receivingData,
                            borderWidth: 2,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio:false,
                    responsive:true
                }
            });

            // ===== Volume Pie =====
            new Chart(document.getElementById('volumeChart'), {
                type: 'pie',
                data: {
                    labels: ['Issuance','Receiving'],
                    datasets: [{
                        data: [
                            issuanceDates.length,
                            receivingDates.length
                        ]
                    }]
                },
                options:{
                    maintainAspectRatio:false
                }
            });

        });
    </script>
@endsection
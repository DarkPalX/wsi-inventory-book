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
            @include('theme.layouts.filters')

            <div class="col-md-6 d-flex align-items-center justify-content-end">
                <form class="d-flex align-items-center" id="searchForm" style="margin-bottom: 0; margin-right: -2%;">
                    <input name="search" type="search" id="search" class="form-control" placeholder="Search by Name" value="{{ $filter->search }}" style="width: auto;">
                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                </form>

                <a data-bs-toggle="modal" data-bs-target=".create-form-modal" class="btn btn-primary">Create Perimission</a>
                {{-- <a href="{{ route('accounts.permissions.create') }}" class="btn btn-primary">Create an permission</a> --}}
            </div>
            
        </div>
        
        <div class="row">

            <div class="table-responsive-faker" style="background-color: aliceblue;">
                <table id="permissions_tbl" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="table-secondary">
                        <tr>
                            <th width="2%">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>Permission Route</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th width="15%">Date Modified</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            <tr id="row{{$permission->id}}">
                                <td>
                                    <input type="checkbox" class="select-item" id="cb{{ $permission->id }}">
                                    <label class="custom-control-label" for="cb{{ $permission->id }}"></label>
                                </td>
                                <td><strong>{{ $permission->name }}</strong></td>
                                <td>{{ $permission->module }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>{{ Setting::date_for_listing($permission->updated_at) }}</td>
                                <td class="flex justify-center items-center">
                                    @if($permission->trashed())
                                        <a href="javascript:void(0)" class="btn btn-light text-primary" onclick="single_restore({{ $permission->id }})"><i class="fa-solid fa-undo-alt"></i></a>
                                    @else
                                        <a data-bs-toggle="modal" data-bs-target="#edit_permission{{ $permission->id }}" class="btn btn-light text-warning"><i class="uil-edit-alt"></i></a>
                                        {{-- <a href="{{ route('accounts.permissions.edit', $permission->id) }}" class="btn btn-light text-warning"><i class="uil-edit-alt"></i></a> --}}
                                        <a href="javascript:void(0)" class="btn btn-light text-danger" onclick="single_delete({{ $permission->id }})"><i class="uil-trash-alt"></i></a>
                                    @endif
                                </td>
                            </tr>

                            {{-- EDIT permission MODAL --}}
                            <div id="edit_permission{{ $permission->id }}" class="modal fade text-start" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="centerModalLabel">permission's Information</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ route('accounts.permissions.update', $permission->id) }}">
                                                @csrf
                                                @method('put')
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <a data-bs-dismiss="modal" class="btn btn-light">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td class="text-center text-danger p-5" colspan="100%">No item available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="row">
                    <div class="col-md-12">
                        {{ $permissions->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                
            </div>

        </div>

    </div>


    {{-- MODALS --}}
    @include('theme.layouts.modals')
    
    <div class="modal fade text-start create-form-modal" tabindex="-1" role="dialog" aria-labelledby="centerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="centerModalLabel">Create Perimission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('accounts.permissions.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Routes</label>
                            <div class="col-sm-10">
                                <select id="methods" name="methods[]" class="select-tags form-select" multiple aria-hidden="true" style="width:100%;">
                                    @foreach ($panelRoutes as $route)
                                        <option value="{{ $route->getActionMethod() }}" data-id="{{ $loop->iteration }}" id="method{{ $loop->iteration }}">{{ $route->getName() }} - {{ $route->uri() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a data-bs-dismiss="modal" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="permissions" name="permissions">
        <input type="text" id="status" name="status">
    </form>

@endsection

@section('pagejs')
	
    <!-- jQuery -->
    <script src="{{ asset('theme/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>
        let listingUrl = "{{ route('accounts.permissions.index') }}";
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
        
        function single_delete(id){
            $('.single-delete').modal('show');
            $('.btn-delete').on('click', function() {
                post_form("{{ route('accounts.permissions.single-delete') }}",'',id);
            });
        }

        function multiple_delete() {
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
                    post_form("{{ route('accounts.permissions.multiple-delete') }}", '', selected_items);
                });
            }
        }
        
        function single_restore(id){
            post_form("{{ route('accounts.permissions.single-restore') }}",'',id);
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
                    post_form("{{ route('accounts.permissions.multiple-restore') }}", '', selected_items);
                });
            }
        }
        
        function post_form(url,status,permissions){
            $('#posting_form').attr('action',url);
            $('#permissions').val(permissions);
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
            jQuery('#permissions_tbl').dataTable();
        });
    </script> --}}
@endsection
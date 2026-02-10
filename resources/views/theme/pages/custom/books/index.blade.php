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
                    <input name="search" type="search" id="search" class="form-control" placeholder="Search" value="{{ $filter->search }}" style="width: auto;">
                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                </form>

                <a href="{{ route('books.create') }}" class="btn btn-primary">Create a Book</a>
            </div>
            
        </div>
        
        <div class="row">

            <div class="table-responsive" style="background-color: aliceblue;">
                <table id="books_tbl" class="table table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="2%">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>SKU</th>
                            <th width="20%">Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Publication Date</th>
                            <th>Cost</th>
                            <th>Inventory</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr id="row{{$book->id}}" onclick="show_book({{ $book->id }}, '{{ addslashes($book->name) }}', '{{ addslashes($book->subtitle) }}', '{{ $book->authors }}', '{{ $book->publication_date }}', '{{ $book->isbn }}')" @if($book->trashed()) class="table-danger" @endif>
                                <td onclick="event.stopPropagation();">
                                    <input type="checkbox" class="@if($book->trashed()) item-trashed @else select-item @endif" id="cb{{ $book->id }}" @if($book->trashed()) disabled @endif>
                                    <label class="custom-control-label" for="cb{{ $book->id }}"></label>
                                </td>
                                <td>{{ $book->sku }}</td>
                                <td>
                                    <strong>{{ $book->name }}</strong><br>
                                    <small>{{ $book->subtitle }}</small>
                                </td>
                                <td>{{ $book->category->name }}</td>
                                <td>
                                    @foreach($book->authors as $author)
                                        <small>{{ $author->name }}</small><br>
                                    @endforeach
                                </td>
                                <td>{{ $book->publisher->name }}</td>
                                <td>{{ $book->publication_date }}</td>
                                <td>₱ {{ number_format($book->total_cost, 2) }}</td>
                                <td onclick="event.stopPropagation();"><a href="{{ route('books.stock-card', $book->id) }}">{{ $book->Inventory }}</a></td>
                                <td class="flex justify-center items-center" onclick="event.stopPropagation();">
                                    @if($book->trashed())
                                        {{-- <a href="javascript:void(0)" class="btn text-primary" onclick="single_restore({{ $book->id }})"><i class="fa-solid fa-undo-alt"></i></a> --}}
                                    @else
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-light text-warning"><i class="uil-edit-alt"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-light text-danger" onclick="single_delete({{ $book->id }})"><i class="uil-trash-alt"></i></a>
                                    @endif
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
                        {{ $books->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- SHOW BOOK --}}
    
    <div class="modal fade show-book mt-5" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content bg-transparent border-0 shadow-none" style="width:80%">
                <div class="flip-card text-center shadow" style="height: 584px;">
                    <div class="flip-card-front dark h-100" style="background-image: url('{{ asset('images/no-image.png') }}');">{{-- no-image.png --}}
                        <div class="flip-card-inner h-100 d-flex flex-column justify-content-between">
                            <div class="card bg-transparent border-0 text-center p-5">
                                <h1 class="card-title book-title mt-3">Title</h1>
                                <div class="card-body text-contrast-900">
                                    <p class="card-text fw-normal book-subtitle">Subtitle</p>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent text-center">
                                <p><span class="book-authors">Authors</span></p><br>
                                <p><span class="book-year">August 28, 2024</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flip-card-back h-100" style="background-image: url('{{ asset('images/dfa-logo.png') }}'); background-size: 350px; background-repeat: no-repeat; background-position: center;">
                        <div class="flip-card-inner h-100 d-flex flex-column align-items-center justify-content-center">
                            <p class="mb-0"><h4 class="book-isbn text-light">1234567890</h4></p>
                            <a class="btn btn-outline-light mt-2 book-details-button">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODALS --}}
    @include('theme.layouts.modals')
    
    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="books" name="books">
        <input type="text" id="status" name="status">
    </form>

@endsection

@section('pagejs')
	
    <!-- jQuery -->
    <script src="{{ asset('theme/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>
        let listingUrl = "{{ route('books.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
        
    <script>
        // document.getElementById('select-all').addEventListener('change', function() {
        //     var checkboxes = document.querySelectorAll('.select-item');
        //     checkboxes.forEach(function(checkbox) {
        //         checkbox.checked = this.checked;
        //     }, this);
        // });
        
        function single_delete(id){
            $('.single-delete').modal('show');
            $('.btn-delete').on('click', function() {
                post_form("{{ route('books.single-delete') }}",'',id);
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
                    post_form("{{ route('books.multiple-delete') }}", '', selected_items);
                });
            }
        }
        
        function single_restore(id){
            post_form("{{ route('books.single-restore') }}",'',id);
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
                    post_form("{{ route('books.multiple-restore') }}", '', selected_items);
                });
            }
        }
        
        function post_form(url,status,books){
            $('#posting_form').attr('action',url);
            $('#books').val(books);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        function show_book(id, title, subtitle, authors_arr, date, isbn){

            
            const authors = JSON.parse(authors_arr);

            const author_names = authors.map(author => author.name).join('<br>');
            const year = new Date(date).getFullYear();

            $('.show-book').modal('show');
            $('.book-title').html(title);
            $('.book-subtitle').html(subtitle);
            $('.book-authors').html(author_names);
            $('.book-year').html(year);
            $('.book-isbn').html(isbn);
            $('.book-details-button').attr('href', '{{ route('books.show', '') }}/' + id);

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
            jQuery('#books_tbl').dataTable();
        });
    </script> --}}
@endsection
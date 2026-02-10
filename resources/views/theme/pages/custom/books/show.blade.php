@extends('theme.main')

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
                <div class="card">
                    <div class="card-header">Book Details</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="25%">Book ID</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->id }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">SKU</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->sku }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Title</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Subtitle</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->subtitle }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Category</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Authors</td>
                                        <td width="1%">:</td>
                                        <td>
                                            @foreach($book->authors as $author)
                                                {{ $author->name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Inventory</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->Inventory }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="25%">Publisher</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->publisher->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Publication Date</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->publication_date }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Edition</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->edition }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">ISBN</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->isbn }}</td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Copyright</td>
                                        <td width="1%">:</td>
                                        <td>{{ $book->copyright }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive mt-5">
                                    <strong><small>Additional Infos</small></strong>
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Attribute</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Format</td>
                                                <td>{{ $book->format }}</td>
                                            </tr>
                                            <tr>
                                                <td>Paper Height (cm)</td>
                                                <td>{{ $book->paper_height }}</td>
                                            </tr>
                                            <tr>
                                                <td>Paper Width (cm)</td>
                                                <td>{{ $book->paper_width }}</td>
                                            </tr>
                                            <tr>
                                                <td>Cover Height (cm)</td>
                                                <td>{{ $book->cover_height }}</td>
                                            </tr>
                                            <tr>
                                                <td>Cover Width (cm)</td>
                                                <td>{{ $book->cover_width }}</td>
                                            </tr>
                                            <tr>
                                                <td>No. of Pages</td>
                                                <td>{{ $book->pages }}</td>
                                            </tr>
                                            <tr>
                                                <td>Color</td>
                                                <td>{{ $book->color }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="table-responsive mt-5">
                                    <strong><small>Cost Breakdown</small></strong>
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Editor</td>
                                                <td>{{ $book->editor }}</td>
                                            </tr>
                                            <tr>
                                                <td>Researcher</td>
                                                <td>{{ $book->researcher }}</td>
                                            </tr>
                                            <tr>
                                                <td>Writer</td>
                                                <td>{{ $book->writer }}</td>
                                            </tr>
                                            <tr>
                                                <td>Graphic Designer</td>
                                                <td>{{ $book->graphic_designer }}</td>
                                            </tr>
                                            <tr>
                                                <td>Layout Designer</td>
                                                <td>{{ $book->layout_designer }}</td>
                                            </tr>
                                            <tr>
                                                <td>Photographer</td>
                                                <td>{{ $book->photographer }}</td>
                                            </tr>
                                            <tr>
                                                <td>Markup Fee</td>
                                                <td>{{ $book->markup_fee }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Cost</strong></td>
                                                <td><strong>{{ $book->total_cost }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <a href="javascript:window.history.back()" class="btn btn-secondary mt-4">Back</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('pagejs')
@endsection
@extends('theme.main')

@section('pagecss')
	<!-- Plugins/Components CSS -->
	<link rel="stylesheet" href="{{ asset('theme/css/components/select-boxes.css') }}">
@endsection

@section('content')
    <div class="wrapper p-5">
        
        <div class="row">
        
            <div class="col-md-6">
                <strong class="text-uppercase">{{ $page->name }}</strong>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('books.index') }}">{{ $page->name }}</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ol>
                </nav>
                
            </div>
        </div>
        
        <div class="row mt-5">

            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">Book Properties</div>

                        <div class="card-body">
                            
							<form method="post" action="{{ route('books.store') }}" enctype="multipart/form-data">
                                @csrf

								<ul class="nav canvas-alt-tabs tabs-alt tabs-tb tabs nav-tabs mb-3" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#main-tab" type="button" role="tab" aria-selected="true">Main</button>
									</li>
									{{-- <li class="nav-item" role="presentation">
										<button class="nav-link" data-bs-toggle="pill" data-bs-target="#additional-tab" type="button" role="tab" aria-selected="false">Cost and Additional Info</button>
									</li> --}}
								</ul>

								<div class="tab-content">

									{{-- MAIN --}}
									<div class="tab-pane fade show active" id="main-tab" role="tabpanel" tabindex="0">

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Code (SKU)</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" id="sku" name="sku" value="{{ old('sku', '') }}" required>
												@error('sku')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Title</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name', '') }}" required>
												@error('name')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Subtitle</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('subtitle') ? 'is-invalid' : '' }}" id="subtitle" name="subtitle" value="{{ old('subtitle', '') }}" required>
												@error('subtitle')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Edition</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('edition') ? 'is-invalid' : '' }}" id="edition" name="edition" value="{{ old('edition', '') }}">
												@error('edition')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">ISBN</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('isbn') ? 'is-invalid' : '' }}" id="isbn" name="isbn" value="{{ old('isbn', '') }}">
												@error('isbn')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Publisher</label>
											<div class="col-sm-10">
												<select id="publisher_id" name="publisher_id" class="select-tags form-select {{ $errors->has('publisher_id') ? 'is-invalid' : '' }}" aria-hidden="true" style="width:100%;" required>
													<option value="">-- SELECT PUBLISHER --</option>
													@foreach($publishers as $publisher)
														<option value="{{ $publisher->id }}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
													@endforeach
												</select>
												@error('publisher_id')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Publication Date</label>
											<div class="col-sm-10">
												<input type="date" class="form-control {{ $errors->has('publication_date') ? 'is-invalid' : '' }}" id="publication_date" name="publication_date" value="{{ old('publication_date', '') }}" required>
												@error('publication_date')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Copyright</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('copyright') ? 'is-invalid' : '' }}" id="copyright" name="copyright" value="{{ old('copyright', '') }}">
												@error('copyright')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Category</label>
											<div class="col-sm-10">
												<select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category_id" name="category_id" required>
													<option value="">-- SELECT CATEGORY --</option>
													@foreach($categories as $category)
														<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
													@endforeach
												</select>
												@error('category_id')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Author</label>
											<div class="col-sm-10">
												<select id="author_id" name="author_id[]" class="select-tags form-select {{ $errors->has('author_id') ? 'is-invalid' : '' }}" multiple aria-hidden="true" style="width:100%;">
													@foreach($authors as $author)
														<option value="{{ $author->id }}" {{ in_array($author->id, old('author_id', [])) ? 'selected' : '' }}>{{ $author->name }}</option>
													@endforeach
												</select>
												@error('author_id')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
								
										<div class="divider">Attachments</div>
										
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">File</label>
											<div class="col-sm-10">
												<input id="file_url" name="file_url" class="input-file" type="file" class="file-loading" data-show-preview="false" accept=".pdf">
												<small id="file_url_error" class="text-danger" style="display: none;">File size must not exceed {{ env('FILE_URL_SIZE') }} MB.</small>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Print Request Form</label>
											<div class="col-sm-10">
												<input id="print_file_url" name="print_file_url" class="input-file" type="file" class="file-loading" data-show-preview="false" accept=".pdf, .docx">
												<small id="print_file_url_error" class="text-danger" style="display: none;">File size must not exceed {{ env('PRINT_FILE_URL_SIZE') }} MB.</small>
											</div>
										</div>
										
										<div class="line my-3"></div>

										{{-- TOGGLE ADDITIONAL INFO --}}
										<div class="toggle toggle-bg">
											<div class="toggle-header">
												<div class="toggle-icon">
													<i class="toggle-closed uil uil-plus"></i>
													<i class="toggle-open uil uil-minus"></i>
												</div>
												<div class="toggle-title">
													Cost and Additional Info
												</div>
											</div>

											<div class="toggle-content">
												<div class="divider">Detailed Cost</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Researcher</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('researcher') ? 'is-invalid' : '' }}" id="researcher" name="researcher" step="0.01" min="0" value="{{ old('researcher', '0.00') }}" onclick="select()">
														@error('researcher')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Writer</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('writer') ? 'is-invalid' : '' }}" id="writer" name="writer" step="0.01" min="0" value="{{ old('writer', '0.00') }}" onclick="select()">
														@error('writer')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Editor</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('editor') ? 'is-invalid' : '' }}" id="editor" name="editor" step="0.01" min="0" value="{{ old('editor', '0.00') }}" onclick="select()">
														@error('editor')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Graphic Designer</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('graphic_designer') ? 'is-invalid' : '' }}" id="graphic_designer" name="graphic_designer" step="0.01" min="0" value="{{ old('graphic_designer', '0.00') }}" onclick="select()">
														@error('graphic_designer')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Layout Designer</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('layout_designer') ? 'is-invalid' : '' }}" id="layout_designer" name="layout_designer" step="0.01" min="0" value="{{ old('layout_designer', '0.00') }}" onclick="select()">
														@error('layout_designer')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Photographer</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('photographer') ? 'is-invalid' : '' }}" id="photographer" name="photographer" step="0.01" min="0" value="{{ old('photographer', '0.00') }}" onclick="select()">
														@error('photographer')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Markup Fee</label>
													<div class="col-sm-10">
														<input type="number" class="form-control cost-input {{ $errors->has('markup_fee') ? 'is-invalid' : '' }}" id="markup_fee" name="markup_fee" step="0.01" min="0" value="{{ old('markup_fee', '0.00') }}" onclick="select()">
														@error('markup_fee')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Total Cost</label>
													<div class="col-sm-10">
														<input type="number" class="form-control bg-light" id="total_cost" name="total_cost" step="0.01" min="0" readonly value="{{ old('total_cost', '0.00') }}">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Source of Funding</label>
													<div class="col-sm-10">
														<select id="agency_id" name="agency_id[]" class="select-tags form-select {{ $errors->has('agency_id') ? 'is-invalid' : '' }}" multiple aria-hidden="true" style="width:100%;">
															@foreach($agencies as $agency)
																<option value="{{ $agency->id }}" {{ in_array($agency->id, old('agency_id', [])) ? 'selected' : '' }}>{{ $agency->name }}</option>
															@endforeach
														</select>
														@error('agency_id')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
										
												<div class="divider">Technical Specifications</div>
										
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Format</label>
													<div class="col-sm-10">
														<select id="format" name="format[]" class="select-tags form-select {{ $errors->has('format') ? 'is-invalid' : '' }}" multiple aria-hidden="true" style="width:100%;">
															<option value=".epub" {{ in_array('.epub', old('format', [])) ? 'selected' : '' }}>E-Pub (.epub)</option>
															<option value="hardbound" {{ in_array('hardbound', old('format', [])) ? 'selected' : '' }}>Hardbound (Physical)</option>
															<option value=".mobi" {{ in_array('.mobi', old('format', [])) ? 'selected' : '' }}>MOBI (.mobi)</option>
															<option value=".azw" {{ in_array('.azw', old('format', [])) ? 'selected' : '' }}>Kindle (.azw)</option>
															<option value=".azw3" {{ in_array('.azw3', old('format', [])) ? 'selected' : '' }}>Kindle (.azw3)</option>
															<option value="softbound" {{ in_array('softbound', old('format', [])) ? 'selected' : '' }}>Softbound/Paperback (Physical)</option>
															<option value=".pdf" {{ in_array('.pdf', old('format', [])) ? 'selected' : '' }}>PDF (.pdf)</option>
															<option value="kit" {{ in_array('kit', old('format', [])) ? 'selected' : '' }}>Mixed-Media Publication (Kit)</option>
														</select>
														@error('format')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Paper Height (cm)</label>
													<div class="col-sm-10">
														<input type="text" class="form-control {{ $errors->has('paper_height') ? 'is-invalid' : '' }}" id="paper_height" name="paper_height" value="{{ old('paper_height', '') }}">
														@error('paper_height')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Paper Width (cm)</label>
													<div class="col-sm-10">
														<input type="text" class="form-control {{ $errors->has('paper_width') ? 'is-invalid' : '' }}" id="paper_width" name="paper_width" value="{{ old('paper_width', '') }}">
														@error('paper_width')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Cover Height (cm)</label>
													<div class="col-sm-10">
														<input type="text" class="form-control {{ $errors->has('cover_height') ? 'is-invalid' : '' }}" id="cover_height" name="cover_height" value="{{ old('cover_height', '') }}">
														@error('cover_height')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Cover Width (cm)</label>
													<div class="col-sm-10">
														<input type="text" class="form-control {{ $errors->has('cover_width') ? 'is-invalid' : '' }}" id="cover_width" name="cover_width" value="{{ old('cover_width', '') }}">
														@error('cover_width')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">No. of Pages</label>
													<div class="col-sm-10">
														<input type="number" class="form-control {{ $errors->has('pages') ? 'is-invalid' : '' }}" id="pages" name="pages" value="{{ old('pages', '') }}">
														@error('pages')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-2 col-form-label">Color</label>
													<div class="col-sm-10">
														<input type="text" class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" id="color" name="color" value="{{ old('color', '') }}">
														@error('color')
															<small class="text-danger">{{ $message }}</small>
														@enderror
													</div>
												</div>
											</div>
										</div>

									</div>
								
									{{-- ADDITIONAL INFO --}}

									{{-- <div class="tab-pane fade" id="additional-tab" role="tabpanel" tabindex="0">

										<div class="divider">Detailed Cost</div>

										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Researcher</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('researcher') ? 'is-invalid' : '' }}" id="researcher" name="researcher" step="0.01" min="0" value="{{ old('researcher', '0.00') }}" onclick="select()">
												@error('researcher')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Writer</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('writer') ? 'is-invalid' : '' }}" id="writer" name="writer" step="0.01" min="0" value="{{ old('writer', '0.00') }}" onclick="select()">
												@error('writer')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Editor</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('editor') ? 'is-invalid' : '' }}" id="editor" name="editor" step="0.01" min="0" value="{{ old('editor', '0.00') }}" onclick="select()">
												@error('editor')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Graphic Designer</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('graphic_designer') ? 'is-invalid' : '' }}" id="graphic_designer" name="graphic_designer" step="0.01" min="0" value="{{ old('graphic_designer', '0.00') }}" onclick="select()">
												@error('graphic_designer')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Layout Designer</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('layout_designer') ? 'is-invalid' : '' }}" id="layout_designer" name="layout_designer" step="0.01" min="0" value="{{ old('layout_designer', '0.00') }}" onclick="select()">
												@error('layout_designer')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Photographer</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('photographer') ? 'is-invalid' : '' }}" id="photographer" name="photographer" step="0.01" min="0" value="{{ old('photographer', '0.00') }}" onclick="select()">
												@error('photographer')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Markup Fee</label>
											<div class="col-sm-10">
												<input type="number" class="form-control cost-input {{ $errors->has('markup_fee') ? 'is-invalid' : '' }}" id="markup_fee" name="markup_fee" step="0.01" min="0" value="{{ old('markup_fee', '0.00') }}" onclick="select()">
												@error('markup_fee')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Total Cost</label>
											<div class="col-sm-10">
												<input type="number" class="form-control bg-light" id="total_cost" name="total_cost" step="0.01" min="0" readonly value="{{ old('total_cost', '0.00') }}">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Source of Funding</label>
											<div class="col-sm-10">
												<select id="agency_id" name="agency_id[]" class="select-tags form-select {{ $errors->has('agency_id') ? 'is-invalid' : '' }}" multiple aria-hidden="true" style="width:100%;">
													@foreach($agencies as $agency)
														<option value="{{ $agency->id }}" {{ in_array($agency->id, old('agency_id', [])) ? 'selected' : '' }}>{{ $agency->name }}</option>
													@endforeach
												</select>
												@error('agency_id')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
								
										<div class="divider">Technical Specifications</div>
								
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Format</label>
											<div class="col-sm-10">
												<select id="format" name="format[]" class="select-tags form-select {{ $errors->has('format') ? 'is-invalid' : '' }}" multiple aria-hidden="true" style="width:100%;">
													<option value=".epub" {{ in_array('.epub', old('format', [])) ? 'selected' : '' }}>E-Pub (.epub)</option>
													<option value="hardbound" {{ in_array('hardbound', old('format', [])) ? 'selected' : '' }}>Hardbound (Physical)</option>
													<option value=".mobi" {{ in_array('.mobi', old('format', [])) ? 'selected' : '' }}>MOBI (.mobi)</option>
													<option value=".azw" {{ in_array('.azw', old('format', [])) ? 'selected' : '' }}>Kindle (.azw)</option>
													<option value=".azw3" {{ in_array('.azw3', old('format', [])) ? 'selected' : '' }}>Kindle (.azw3)</option>
													<option value="softbound" {{ in_array('softbound', old('format', [])) ? 'selected' : '' }}>Softbound/Paperback (Physical)</option>
													<option value=".pdf" {{ in_array('.pdf', old('format', [])) ? 'selected' : '' }}>PDF (.pdf)</option>
													<option value="kit" {{ in_array('kit', old('format', [])) ? 'selected' : '' }}>Mixed-Media Publication (Kit)</option>
												</select>
												@error('format')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Paper Height (cm)</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('paper_height') ? 'is-invalid' : '' }}" id="paper_height" name="paper_height" value="{{ old('paper_height', '') }}">
												@error('paper_height')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Paper Width (cm)</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('paper_width') ? 'is-invalid' : '' }}" id="paper_width" name="paper_width" value="{{ old('paper_width', '') }}">
												@error('paper_width')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Cover Height (cm)</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('cover_height') ? 'is-invalid' : '' }}" id="cover_height" name="cover_height" value="{{ old('cover_height', '') }}">
												@error('cover_height')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Cover Width (cm)</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('cover_width') ? 'is-invalid' : '' }}" id="cover_width" name="cover_width" value="{{ old('cover_width', '') }}">
												@error('cover_width')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">No. of Pages</label>
											<div class="col-sm-10">
												<input type="number" class="form-control {{ $errors->has('pages') ? 'is-invalid' : '' }}" id="pages" name="pages" value="{{ old('pages', '') }}">
												@error('pages')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Color</label>
											<div class="col-sm-10">
												<input type="text" class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" id="color" name="color" value="{{ old('color', '') }}">
												@error('color')
													<small class="text-danger">{{ $message }}</small>
												@enderror
											</div>
										</div>
										
									</div> --}}
								</div>

								<div class="form-group row">
									<div class="col-sm-10">
										<button type="submit" class="btn btn-primary">Save</button>
										<a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-light">Cancel</a>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('pagejs')
	<script>
		jQuery(document).ready( function(){

			// select Tags
			jQuery(".select-tags").select2({
				tags: true
			});
		});
	</script>

	<!-- For Calculation -->
	<script>
		jQuery(document).ready(function() {
			$ = jQuery;

			$('.cost-input').on('input', function() {
				let total = 0;
				$('.cost-input').each(function() {
					total += parseFloat($(this).val()) || 0;
				});
				$('#total_cost').val(total);
			});
		});
	</script>

	{{-- FILE VALIDATION --}}
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			function validateFileSize(inputElementId, errorElementId, maxSizeMb) {
				const fileInput = document.getElementById(inputElementId);
				const fileError = document.getElementById(errorElementId);
				const maxSize = maxSizeMb * 1024 * 1024;
	
				fileInput.addEventListener('change', function () {
					const file = fileInput.files[0];
					if (file && file.size > maxSize) {
						fileError.style.display = 'block';
						fileInput.value = '';
					} else {
						fileError.style.display = 'none';
					}
				});
			}
	
			// Apply the validation function to both file inputs
			validateFileSize('file_url', 'file_url_error', {{ env('FILE_URL_SIZE') }});
			validateFileSize('print_file_url', 'print_file_url_error', {{ env('PRINT_FILE_URL_SIZE') }});
		});
	</script>
	
@endsection
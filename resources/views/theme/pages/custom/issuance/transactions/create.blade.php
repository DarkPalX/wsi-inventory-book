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
                        <li class="breadcrumb-item"><a href="{{ route('issuance.transactions.index') }}">{{ $page->name }}</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ol>
                </nav>
                
            </div>
        </div>
        
        <div class="row mt-5">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Transaction Details</div>

                        <div class="card-body">
                            
							<form method="post" action="{{ route('issuance.transactions.store') }}" enctype="multipart/form-data" onsubmit="return checkSelectedItems();">
                                @csrf
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Receivers</label>
									<div class="col-sm-10">
										<select id="receiver_id" name="receiver_id[]" class="select-tags form-select" multiple aria-hidden="true" style="width:100%;" required>
											<option value="">-- SELECT RECEIVER --</option>
											@foreach($receivers as $receiver)
												<option value="{{ $receiver->id }}" {{ old('receiver_id') == $receiver->id ? 'selected' : '' }}>{{ $receiver->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label for="name" class="col-sm-2 col-form-label">Release Date</label>
									<div class="col-sm-10">
										<input type="date" class="form-control" id="date_released" name="date_released" value="<?= date('Y-m-d'); ?>" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Attachments</label>
									<div class="col-sm-10">
										<input id="attachments" name="attachments[]" class="input-file file-loading" type="file" data-show-upload="false" data-show-caption="true" data-show-preview="false" accept=".pdf, .jpeg, .jpg, .png, .xlsx, .docx, .gif" multiple>
									</div>
								</div>
								<div class="form-group row">
									<label for="name" class="col-sm-2 col-form-label">Remarks</label>
									<div class="col-sm-10">
										<textarea class="form-control" id="remarks" name="remarks"></textarea>
									</div>
								</div>

								<div class="divider text-uppercase divider-center"><small>Book Details</small></div>
								
								<div class="form-group row">
									<div class="col-sm-12">
										<table class="table table-hover" id="selected_items_table">
											<thead>
												<tr>
													<th width="1%"></th>
													<th width="10%">ID</th>
													<th width="15%">SKU</th>
													<th>Item Title</th>													
													<th width="15%">Stock</th>
													<th width="15%">Cost</th>
													<th width="20%">Quantity</th>
												</tr>
											</thead>
											<tbody>
												<!-- Selected items will be appended here -->
											</tbody>
										</table>
									</div>
								</div>

								<div class="divider text-uppercase divider-center"><small>Reference</small></div>

								<div class="form-group row">
									<div class="col-md-11">
										<input type="text" class="form-control" id="item_search" name="item_search" placeholder="Search item via ID or book title .." onkeypress="if(event.key === 'Enter') { event.preventDefault(); }">
									</div>
									<div class="col-md-1">
										<button type="button" class="btn btn-secondary" onclick="document.getElementById('item_search').value=''; document.getElementById('item_search').dispatchEvent(new Event('input')); document.getElementById('item_search').dispatchEvent(new Event('change'));">Clear</button>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-12">
										<table class="table table-hover" id="search_results_table">
											<thead>
												<tr>
													<th width="10%">ID</th>
													<th width="15%">SKU</th>
													<th>Item Title</th>
													<th width="15%">Stock</th>
													<th width="15%">Cost</th>
													<th width="10%">Action</th>
												</tr>
											</thead>
											<tbody>
												<!-- Results will be appended here via AJAX -->
											</tbody>
										</table>
									</div>
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

	<script>
		// Handle AJAX search and displaying results
		jQuery(document).ready(function() {
			$ = jQuery;

			$('#item_search').on('input', function() {
				let searchQuery = $(this).val();
				if (searchQuery.length) {
					$.ajax({
						url: '{{ route("issuance.transactions.search-item") }}',
						method: 'GET',
						data: { query: searchQuery },
						success: function(data) {
							console.log(data);
							let resultsTableBody = $('#search_results_table tbody');
							resultsTableBody.html(''); // Clear the table

							if (data.results.length) {
								data.results.forEach(item => {
									resultsTableBody.append(`
										<tr>
											<td>${item.id}</td>
											<td>${item.sku}</td>
											<td>${item.name}</td>
											<td>${item.inventory}</td>
											<td>${(parseFloat(item.total_cost) || 0).toFixed(2)}</td>
											<td><button type="button" class="btn btn-outline-primary add-item-btn" data-id="${item.id}" data-sku="${item.sku}" data-name="${item.name}" data-inventory="${item.inventory}" data-cost="${item.total_cost}">Add</button></td>
										</tr>
									`);
								});
							} else {
								resultsTableBody.append('<tr><td class="text-center text-danger" colspan="100$">No items found</td></tr>');
							}
						},
						error: function(xhr) {
							console.log('Error:', xhr.responseText);
						}
					});
				} else {
					$('#search_results_table tbody').html('<tr><td class="text-center text-danger" colspan="100%">Search query is empty</td></tr>');
				}
			});
		});

		// Handle adding items to the selected list
		document.addEventListener('click', function(event) {
			let target = event.target.closest('button'); // Get the closest button element
			let id = target.getAttribute('data-id');
			let sku = target.getAttribute('data-sku');
			let name = target.getAttribute('data-name');
			let inventory = target.getAttribute('data-inventory');
			let cost = isNaN(parseFloat(target.getAttribute('data-cost'))) ? 0.00 : parseFloat(target.getAttribute('data-cost'));

			// Handle adding items to the selected list
			if (target.classList.contains('add-item-btn')) {
				let selectedTableBody = document.querySelector('#selected_items_table tbody');

				// Check if the item already exists in the selected items table
				let exists = Array.from(selectedTableBody.querySelectorAll('tr')).some(row => {
					return row.querySelector('input[name="book_id[]"]').value === id;
				});

				if (!exists) {
					// Create a new row for the selected items table
					let newRow = selectedTableBody.insertRow();

					// Insert cells and their content
					let actionCell = newRow.insertCell(0);
					actionCell.innerHTML = '<button class="btn btn-outline-danger remove-item-btn" data-id="'+id+'" data-sku="'+sku+'" data-name="'+name+'" data-cost="'+cost+'"><i class="bi-trash remove-item-btn"></i></button>';

					let idCell = newRow.insertCell(1);
					idCell.innerHTML = id + '<input name="book_id[]" type="text" value="' + id +'" hidden>';

					let skuCell = newRow.insertCell(2);
					skuCell.innerHTML = sku + '<input name="sku[]" type="text" value="' + sku +'" hidden>';

					let nameCell = newRow.insertCell(3);
					nameCell.textContent = name;

					let inventoryCell = newRow.insertCell(4);
					inventoryCell.textContent = inventory;

					let costCell = newRow.insertCell(5);
					costCell.innerHTML = '<input name="cost[]" type="number" step="0.1" class="form-control form-control-sm bg-light" value="'+ cost.toFixed(2) +'" readonly>';

					let quantityCell = newRow.insertCell(6);
					quantityCell.innerHTML = '<input name="quantity[]" type="number" step="1" class="form-control form-control-sm" value="1" min="1" max="'+ inventory +'" oninput="this.value = this.value < 1 ? 1 : Math.min(this.value, this.max);" onclick="select()">';

					// Optionally remove the item from the search results
					target.closest('tr').remove();
				} else {
					Swal.fire({
						icon: 'warning',
						title: 'Item Already Added',
						text: 'This item is already in the selected list.',
						confirmButtonText: 'OK'
					});
				}
			}

			// Handle removing items from the selected list and returning them to the search results
			if (target.classList.contains('remove-item-btn')) {
				let searchResultsTableBody = document.querySelector('#search_results_table tbody');

				// Remove the item from the selected items table
				target.closest('tr').remove();


				// // Create a new row for the search results table
				// let newRow = searchResultsTableBody.insertRow();

				// // Insert cells and their content
				// let idCell = newRow.insertCell(0);
				// idCell.textContent = id;

				// let skuCell = newRow.insertCell(1);
				// skuCell.textContent = sku;

				// let nameCell = newRow.insertCell(2);
				// nameCell.textContent = name;

				// let actionCell = newRow.insertCell(3);
				// actionCell.innerHTML = '<button class="btn btn-primary btn-sm add-item-btn" data-id="'+id+'" data-sku="'+sku+'" data-name="'+name+'" data-cost="'+cost+'">Add</button>';

			}
		});
		
		function checkSelectedItems() {
			const selectedItemsTable = document.querySelector('#selected_items_table tbody');
			if (!selectedItemsTable || selectedItemsTable.children.length === 0) {
				Swal.fire({
					icon: 'warning',
					title: 'No Items Selected',
					text: 'Please select at least one item before saving.',
				});
				return false; // Prevent form submission
			}
			return true; // Allow form submission if items are selected
		}
	</script>
	
@endsection
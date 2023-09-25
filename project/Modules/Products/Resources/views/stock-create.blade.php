@extends('layouts.app')

@section('content')
<style type="text/css">
	.cursor-pointer{
		cursor: pointer;
	}
</style>

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Products</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Add Stock</li>
					</ol>
				</nav>
			</div>
		</div>

		@if(Session::has('successMessage'))
		<div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
			<div class="d-flex align-items-center">
				<div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
				</div>
				<div class="ms-3">
					<h6 class="mb-0 text-success">Success Alerts</h6>
					<div>{!! Session::get('successMessage') !!}</div>
				</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endif

		@if(Session::has('errorMessage'))
		<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
			<div class="d-flex align-items-center">
				<div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
				</div>
				<div class="ms-3">
					<h6 class="mb-0 text-danger">Error Alerts</h6>
					<div>{!! Session::get('errorMessage') !!}</div>
				</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endif


		<!-- content section -->
		<div class="card">
			<div class="card-body p-5">
				<div class="border p-4 rounded">
					<form method="post" action="{!! route('Products Stock Store', $dataInfo->id) !!}" enctype="multipart/form-data">
						@csrf

						<h6>Add Stock: {!! $dataInfo->title !!}</h6>
						<hr>

						<div class="itemDiv">
							<div class="row mb-3">
								<div class="col-sm-12">
									<div class="position-relative">
										<span class="position-absolute top-0 translate-middle badge rounded-pill bg-primary">ITEM 01</span>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="7">
														<div class="form-check">
															<label class="form-check-label" for="flexCheckDefault">Select row for all item</label>
															<input class="form-check-input selectAllRow" type="checkbox" value="" id="flexCheckDefault">
														</div>
													</th>
												</tr>

												<tr style="background-color: #e9ecef;vertical-align: middle;">
													<th>
														<input class="form-check-input selectParentRow" type="checkbox" value="" id="flexCheckDefault">
													</th>
													<th>
														<label class="form-label">Purchase Date</label>
														<input type="text" name="purchase_date[]" class="form-control datepicker parentPurchaseDate" />
													</th>
													<th>
														<label class="form-label">Warranty Start</label>
														<input type="text" name="warranty_start[]" class="form-control datepicker parentWarrantyStartDate" />
													</th>
													<th>
														<label class="form-label">Warranty End</label>
														<input type="text" name="warranty_end[]" class="form-control datepicker parentWarrantyEndDate" />
													</th>
													<th>
														<label class="form-label">Price</label>
														<input type="number" name="price[]" class="form-control parentPrice" value="0" min="0" />
													</th>
													<th>
														<label class="form-label">Quantity *</label>
														<input type="number" name="stock[]" class="form-control parentQuantity" value="1" min="0" required="required" />
													</th>
													<th>
														<label class="form-label">Vendor</label>
														<select name="vendor[]" class="form-select single-select parentVendor ajaxVendorData">
															<option value="">-Select Vendor-</option>
														</select>
													</th>
												</tr>

												<tr style="background-color: #e9ecef">
													<th></th>
													<th width="25%">Specification *</th>
													<th colspan="5">Detail *</th>
												</tr>
											</thead>
											<tbody>
												@if(!empty($specTypes) && (count($specTypes)>0))
												@foreach($specTypes as $key => $list)
												<tr>
													<td><input class="form-check-input selectSpecRow{{$list->id}}" type="checkbox" value="" id="flexCheckDefault"></td>
													<td><input type="text" name="items[0][{{$list->id}}]" value="{!! $list->title !!}" class="form-control" readonly="readonly"></td>
													<td colspan="5"><input type="text" name="items[0][{{$list->id}}]" class="form-control parentSpecRow{{$list->id}}" placeholder="{!! $list->title !!}" required="required"></td>
												</tr>
												@endforeach
												@endif
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="newItemDiv"></div>

						<div class="row">
							<div class="col-sm-9">
								<button type="button" class="btn btn-outline-warning addMoreItem"><i class="bx bx-plus"></i> Add New Item</button>
								<button type="submit" class="btn btn-outline-primary px-5" name="exit" value="yes">Save & Exit</button>
								<button type="submit" class="btn btn-outline-primary px-5">Save</button>
								<a href="{!! route('Products') !!}" class="btn btn-outline-danger px-3">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection
@push('js')
<script type="text/javascript">

	$(document).ready(function(){
		$.ajax({
			type:'GET',
			url: '{{route('Contacts Ajax Get List')}}',
			success:function(data){
				window.vendorData = '';
				if(data != ''){
					$.each(data, function( index, value ) {
						vendorData = vendorData+'<option value="'+value.id+'">'+value.title+'</option>';
					});
					$('.ajaxVendorData').append(vendorData);
				}
			}
		});
	});

	$(document).ready(function(){
		$('.selectAllRow').click(function(){
			$('input:checkbox').not(this).prop('checked', this.checked);
		});
	});

	$(document).ready(function(){
		$.ajax({
			type:'GET',
			url: '{{route('Products Ajax Get Spec Types', $dataInfo->id)}}',
			success:function(data){
				window.specTypes = '';
				if(data != ''){
					specTypes = data;
				}
			}
		});

		var max_fields = 500; 
		var wrapper = $(".itemDiv"); 
		var add_button = $(".addMoreItem"); 
		var count = 0; 
		$(add_button).click(function(e){
			e.preventDefault();
			if(count < max_fields){ 
				count++;
				var itemCount = count+1;
				if(itemCount < 10){
					itemCount = '0'+itemCount;
				}

				if(specTypes != ''){
					var specTypesHtml = '';
					$.each(specTypes, function( index, value ) {
						var parentSpecValue = '';
						if ($(".selectSpecRow"+value.id).is(":checked")) {
							parentSpecValue = $('.parentSpecRow'+value.id).val();
						}

						specTypesHtml = specTypesHtml+'<tr><td><input type="text" name="items['+count+']['+value.id+']" value="'+value.title+'" class="form-control" readonly="readonly"></td><td colspan="5"><input type="text" name="items['+count+']['+value.id+']" value="'+parentSpecValue+'" class="form-control" placeholder="'+value.title+'" required="required"></td></tr>'
					});

					var parentPurchaseDate = '';
					var parentWarrantyStartDate = '';
					var parentWarrantyEndDate = '';
					var parentPrice = 0;
					var parentQuantity = 1;
					var parentVendor = '';
					if ($(".selectParentRow").is(":checked")) {
						parentPurchaseDate = $('.parentPurchaseDate').val();
						parentWarrantyStartDate = $('.parentWarrantyStartDate').val();
						parentWarrantyEndDate = $('.parentWarrantyEndDate').val();
						parentPrice = $('.parentPrice').val();
						parentQuantity = $('.parentQuantity').val();
						parentVendor = $('.parentVendor').val();
					}

					$(wrapper).append('<div class="row mb-3 itemDivRow"><div class="col-sm-12"><div class="position-relative"><span class="position-absolute top-0 translate-middle badge rounded-pill bg-primary cursor-pointer removeItem">ITEM '+itemCount+' <i class="lni lni-cross-circle"></i></span><table class="table table-bordered"><thead><tr style="background-color: #e9ecef"><th><label class="form-label">Purchase Date</label><input type="text" name="purchase_date[]" class="form-control datepicker" value="'+parentPurchaseDate+'" /></th><th><label class="form-label">Warranty Start</label><input type="text" name="warranty_start[]" class="form-control datepicker" value="'+parentWarrantyStartDate+'" /></th><th><label class="form-label">Warranty End</label><input type="text" name="warranty_end[]" class="form-control datepicker" value="'+parentWarrantyEndDate+'" /></th><th><label class="form-label">Price</label><input type="number" name="price[]" class="form-control" value="'+parentPrice+'" min="0" /></th><th><label class="form-label">Quantity *</label><input type="number" name="stock[]" class="form-control" value="'+parentQuantity+'" min="0" required="required" /></th><th><label class="form-label">Vendor</label><select name="vendor[]" class="form-select single-select ajaxVendorData'+itemCount+'"><option value="">-Select Vendor-</option>'+vendorData+'</select></th></tr><tr style="background-color: #e9ecef"><th width="25%">Specification *</th><th colspan="5">Detail *</th></tr></thead><tbody>'+specTypesHtml+'</tbody></table></div></div></div>');

					$('.datepicker').pickadate({
						selectMonths: true,
						selectYears: true,
					});

					$('.ajaxVendorData'+itemCount).val(parentVendor);
					$('.ajaxVendorData'+itemCount).select2({
						theme: 'bootstrap4',
						width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
						placeholder: $(this).data('placeholder'),
						allowClear: Boolean($(this).data('allow-clear')),
					});
				}
			}
		});
		$(wrapper).on("click",".removeItem", function(e){
			e.preventDefault(); $(this).closest('.itemDivRow').remove(); count--;
		})
	});
</script>

@endpush

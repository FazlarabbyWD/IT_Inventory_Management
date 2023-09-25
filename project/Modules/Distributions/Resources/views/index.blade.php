@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Distributions</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">List</li>
					</ol>
				</nav>
			</div>
		</div>


		@if (Session::has('successMessage'))
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

		@if (Session::has('errorMessage'))
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


		<!-- search -->
		<div class="card">
			<div class="card-body">
				<form method="get" class="row g-3">
					<div class="col-md-2">
						<select name="contact_type_id" class="form-select single-select selectedContactType" id="contact_type_id">
							<option value="">-Select Contact Type-</option>
							@if(!empty($contactTypes) && (count($contactTypes)>0))
							@foreach($contactTypes as $key => $list)
							<option {!! isset($_GET['contact_type_id']) && $_GET['contact_type_id'] == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-md-2">
						<select name="contact_id" class="form-select single-select ajaxContactData" id="contact_id">
							<option value="">-Select Contact-</option>
						</select>
					</div>

					<div class="col-md-2">
						<select name="product_id" class="form-select single-select selectedProduct" id="product_id">
							<option value="">-Select Product-</option>
							@if(!empty($products) && (count($products)>0))
							@foreach($products as $key => $list)
							<option {!! isset($_GET['product_id']) && $_GET['product_id'] == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-md-2">
						<select name="product_item_id" class="form-select single-select ajaxProductItemData" id="product_item_id">
							<option value="">-Select Item-</option>
						</select>
					</div>

					<div class="col-md-2">
						<select name="category_id" class="form-select single-select" id="category_id">
							<option value="">-Select Category-</option>
							@if(!empty($categories) && (count($categories)>0))
							@foreach($categories as $key => $list)
							<option {!! isset($_GET['category_id']) && $_GET['category_id'] == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-md-2">
						<select name="brand_id" class="form-select single-select" id="brand_id">
							<option value="">-Select Brand-</option>
							@if(!empty($brands) && (count($brands)>0))
							@foreach($brands as $key => $list)
							<option {!! isset($_GET['brand_id']) && $_GET['brand_id'] == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-md-2">
						<select name="office_id" class="form-select single-select" id="office_id">
							<option value="">-Select Office-</option>
							@if(!empty($offices) && (count($offices)>0))
							@foreach($offices as $key => $list)
							<option {!! isset($_GET['office_id']) && $_GET['office_id'] == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="col-md-2">
						<input type="text" name="start_using" value="{!! isset($_GET['start_using']) ? $_GET['start_using'] : '' !!}" class="form-control datepicker" placeholder="Distribute From" />
					</div>

					<div class="col-md-2">
						<input type="text" name="end_using" value="{!! isset($_GET['end_using']) ? $_GET['end_using'] : '' !!}" class="form-control datepicker" placeholder="Distribute To" />
					</div>

					<div class="col-md-2">
						<input type="text" name="note" value="{!! isset($_GET['note']) ? $_GET['note'] : '' !!}" class="form-control" placeholder="Note">
					</div>


					<div class="col-md-2">
						<button class="btn btn-outline-success" type="submit"><i class="lni lni-search"></i></button>
					</div>
				</form>
			</div>
		</div>

		<!-- content section -->
		<div class="card">
			<div class="card-body">
				<table class="table mb-0 table-hover">
					<thead>
						<tr>
							<th scope="col">SL</th>
							<th scope="col">Contact</th>
							<th scope="col">Product</th>
							<th scope="col">Item</th>
							<th scope="col">Date</th>
							<th scope="col">Note</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@if (!empty($lists) && count($lists) > 0)
						@foreach ($lists as $key => $list)
						<tr>
							<td scope="row">{!! $key + 1 !!}</td>
							<td>
								<b>{!! $list->contactInfo->title !!}</b>
								{!! $list->contactInfo->code ? ', '.$list->contactInfo->code : '' !!}
								{!! $list->contactInfo->bio ? '<br>'.$list->contactInfo->bio : '' !!}
								{!! $list->contactInfo->contact ? '<br>'.$list->contactInfo->contact : '' !!}
								{!! $list->contactInfo->contactTypeInfo ? '<br>'.$list->contactInfo->contactTypeInfo->title : '' !!}
								{!! $list->contactInfo->officeInfo ? '<br>'.$list->contactInfo->officeInfo->title : '' !!}
							</td>
							<td>
								<b>{!! $list->productInfo->title !!}</b>
								{!! $list->productInfo->categoryInfo->title ? '<br>Category: '.$list->productInfo->categoryInfo->title : '' !!}
								{!! $list->productInfo->brandInfo->title ? '<br>Brand: '.$list->productInfo->brandInfo->title : '' !!}
							</td>
							<td>
								<b>Code: {!! $list->productItemInfo->t_code !!}</b>
								{!! $list->productItemInfo->vendorInfo ? '<br>Vendor: '.$list->productItemInfo->vendorInfo->title : '' !!}
							</td>
							<td>
								Time Period:<br>
								<b>{!! date('d M Y', strtotime($list->start_using)) !!} To
								{!! $list->end_using ? date('d M Y', strtotime($list->end_using)) : 'Present' !!}</b>
							</td>
							<td>{!! $list->note !!}</td>

							<td>
								<div class="dropdown">
									<button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>
									<ul class="dropdown-menu" style="margin: 0px;">
										<li><a class="dropdown-item" href="{!! route('Distributions Edit', $list->id) !!}">Edit</a>
										</li>
										<li><a class="dropdown-item confirmDelete"
											href="{!! route('Distributions Delete', $list->id) !!}">Delete</a>
										</li>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>

			@if (!empty($lists) && count($lists) > 0)
			<div class="col-12 mt-3">
				<div class="float-end">{!! $lists->links() !!}</div>
			</div>
			@endif

		</div>
	</div>

</div>
</div>

@endsection

@push('js')
<script type="text/javascript">
	$(document).ready(function(){
		var productId = $(".selectedProduct").val();
		$(".selectedProduct").on('change', function (e) {
			productId = $(".selectedProduct").val();
			getProductItems(productId);
		});
		if(productId != ''){
			getProductItems(productId);
		}
	});

	function getProductItems(productId){
		$(".ajaxProductItemData").empty();
		$.ajax({
			type:'GET',
			url: '{{route('Products')}}/ajax/get/items/'+productId,
			success:function(data){
				window.productItemData = '';
				if(data != ''){
					$.each(data, function( index, value ) {
						var quality = '';
						if(value.quality_status == 1){
							quality = 'Usable';
						}else if(value.quality_status == 2){
							quality = 'Damaged';
						}else if(value.quality_status == 3){
							quality = 'Missing';
						}
						productItemData = productItemData+'<option value="'+value.id+'">Code: '+value.t_code+' - '+quality+'</option>';
					});
				}
				$('.ajaxProductItemData').append('<option value="">-Select Item-</option>'+productItemData);
				$('.ajaxProductItemData').val('{!! isset($_GET['product_item_id']) ? $_GET['product_item_id'] : '' !!}');
			}
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		var contactTypeId = $(".selectedContactType").val();
		$(".selectedContactType").on('change', function (e) {
			contactTypeId = $(".selectedContactType").val();
			getContactsByType(contactTypeId);
		});
		if(contactTypeId != ''){
			getContactsByType(contactTypeId);
		}
	});

	function getContactsByType(contactTypeId){
		$(".ajaxContactData").empty();
		$.ajax({
			type:'GET',
			url: '{{route('Contacts')}}/ajax/get/list/bycontacttype/'+contactTypeId,
			success:function(data){
				window.contactData = '';
				if(data != ''){
					$.each(data, function( index, value ) {
						contactData = contactData+'<option value="'+value.id+'">'+value.title+'</option>';
					});
				}
				$('.ajaxContactData').append('<option value="">-Select Contact-</option>'+contactData);
				$('.ajaxContactData').val('{!! isset($_GET['contact_id']) ? $_GET['contact_id'] : '' !!}');
			}
		});
	}
</script>
@endpush
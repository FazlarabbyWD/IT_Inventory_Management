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
						<li class="breadcrumb-item active" aria-current="page">Create</li>
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
					<form method="post" action="{!! route('Distributions Store') !!}" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<div class="col-sm-6">
								<label for="contact_id" class="col-form-label">Distribute To *</label>
								<select name="contact_id" class="form-select single-select" id="contact_id" required="required">
									@if(!empty($contacts) && (count($contacts)>0))
									@foreach($contacts as $key => $list)
									<option {!! old('contact_id') == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}- {!! $list->bio !!}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="itemDivRow">
							<div class="row mb-3">
								<div class="col-sm-3">
									<label for="product_id" class="col-form-label">Product *</label>
									<select name="product_id[]" class="form-select single-select selectedProduct" id="product_id" required="required">
										@if(!empty($products) && (count($products)>0))
										@foreach($products as $key => $list)
										<option value="{!! $list->id !!}">{!! $list->title !!}</option>
										@endforeach
										@endif
									</select>
								</div>

								<div class="col-sm-3">
									<label for="product_item_id" class="col-form-label">Product Item *</label>
									<select name="product_item_id[]" class="form-select single-select ajaxProductItemData" id="product_item_id" required="required">
									</select>
								</div>

								<div class="col-sm-2">
									<label for="date_from" class="col-form-label">Distribute From *</label>
									<input type="text" name="date_from[]" value="" class="form-control datepicker" required="required" placeholder="Date From" />
								</div>

								<div class="col-sm-2">
									<label for="date_to" class="col-form-label">Distribute To</label>
									<input type="text" name="date_to[]" value="" class="form-control datepicker" placeholder="Date To" />
								</div>

								<div class="col-sm-2">
									<label for="note" class="col-form-label">Note</label>
									<input type="text" name="note[]" value="" id="note" class="form-control" placeholder="Note">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<hr>
								<button type="button" class="btn btn-outline-warning addMoreItem"><i class="bx bx-plus"></i> More Item</button>
								<button type="submit" class="btn btn-outline-primary px-5" name="exit" value="yes">Save & Exit</button>
								<button type="submit" class="btn btn-outline-primary px-5">Save</button>
								<a href="{!! route('Distributions') !!}" class="btn btn-outline-danger px-3">Cancel</a>
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
		var productId = $(".selectedProduct").val();
		$(".selectedProduct").on('change', function (e) {
			productId = $(".selectedProduct").val();
			getProductItems(productId, '.ajaxProductItemData');
		});
		getProductItems(productId, '.ajaxProductItemData');
	});

	function getProductItems(productId, className){
		$(className).empty();
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

						var contact_name = '';
						if(value.distribution_info != null && value.distribution_info.contact_info != null){
							var contact_name = value.distribution_info.contact_info.title;
						}

						productItemData = productItemData+'<option value="'+value.id+'">Code: '+value.t_code+' - '+quality+' - '+contact_name+'</option>';
					});
					$(className).append(productItemData);
				}
			}
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		window.productData = '';
		$.ajax({
			type:'GET',
			url: '{{route('Products Ajax Get List')}}',
			success:function(data){
				if(data != ''){
					$.each(data, function( index, value ) {
						productData = productData+'<option value="'+value.id+'">'+value.title+'</option>';
					});
				}
			}
		});

		var max_fields = 500; 
		var wrapper = $(".itemDivRow"); 
		var add_button = $(".addMoreItem"); 
		var count = 0; 
		$(add_button).click(function(e){
			e.preventDefault();
			count++; 

			var itemDivRow  = '<div class="row mb-3"><div class="col-sm-3"><label for="product_id" class="col-form-label">Product *</label><select name="product_id[]" class="form-select single-select" id="selectedProduct'+count+'" required="required">'+productData+'</select></div><div class="col-sm-3"><label for="product_item_id" class="col-form-label">Product Item *</label><select name="product_item_id[]" class="form-select single-select" id="ajaxProductItemData'+count+'" required="required"></select></div><div class="col-sm-2"><label for="date_from" class="col-form-label">Date From *</label><input type="text" name="date_from[]" value="" class="form-control datepicker'+count+'" required="required" placeholder="Date From" /></div><div class="col-sm-2"><label for="date_to" class="col-form-label">Date To</label><input type="text" name="date_to[]" value="" class="form-control datepicker'+count+'" placeholder="Date To" /></div><div class="col-sm-2"><label for="note" class="col-form-label">Note</label><input type="text" name="note[]" value="" id="note" class="form-control" placeholder="Note"></div></div>';
			$(wrapper).append('<div class="item'+count+'">'+itemDivRow+'</div>');

			$('.datepicker'+count).pickadate({
				selectMonths: true,
				selectYears: true,
			});

			$('#selectedProduct'+count).select2({
				theme: 'bootstrap4',
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				placeholder: $(this).data('placeholder'),
				allowClear: Boolean($(this).data('allow-clear')),
			});
			var productId = $("#selectedProduct"+count).val();
			$("#selectedProduct"+count).on('change', function (e) {
				productId = $("#selectedProduct"+count).val();
				getProductItems(productId, '#ajaxProductItemData'+count);
			});
			getProductItems(productId, '#ajaxProductItemData'+count);
			$('#ajaxProductItemData'+count).select2({
				theme: 'bootstrap4',
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				placeholder: $(this).data('placeholder'),
				allowClear: Boolean($(this).data('allow-clear')),
			});

		});
		$(wrapper).on("click",".removeItem", function(e){
			e.preventDefault(); $(this).closest('.itemDivRow').remove(); count--;
		})
	});
</script>
@endpush
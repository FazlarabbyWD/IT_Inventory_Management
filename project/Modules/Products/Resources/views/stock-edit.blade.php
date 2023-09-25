@extends('layouts.app')

@section('content')

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
						<li class="breadcrumb-item active" aria-current="page">Edit Stock</li>
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
					<form method="post" action="{!! route('Products Stock Update', $dataInfo->id) !!}" enctype="multipart/form-data">
						@csrf

						<h6>Edit Stock: {!! $dataInfo->productInfo->title !!}</h6>
						<hr>

						<div class="itemDiv">
							<div class="row mb-3">
								<div class="col-sm-12">
									<div style="position: relative;">
										<table class="table table-bordered">
											<thead>
												<tr style="background-color: #e9ecef">
													<th>
														<label class="form-label">Purchase Date</label>
														<input type="text" name="purchase_date" value="{!! $dataInfo->purchase_date ? date('d M, Y', strtotime($dataInfo->purchase_date)) : '' !!}" class="form-control datepicker" />
													</th>
													<th>
														<label class="form-label">Warranty Start</label>
														<input type="text" name="warranty_start" value="{!! $dataInfo->warranty_start ? date('d M, Y', strtotime($dataInfo->warranty_start)) : '' !!}" class="form-control datepicker" />
													</th>
													<th>
														<label class="form-label">Warranty End</label>
														<input type="text" name="warranty_end" value="{!! $dataInfo->warranty_end ? date('d M, Y', strtotime($dataInfo->warranty_end)) : '' !!}" class="form-control datepicker" />
													</th>
													<th>
														<label class="form-label">Price</label>
														<input type="number" name="price" value="{!! $dataInfo->price !!}" class="form-control" value="0" min="0" />
													</th>
													<th>
														<label class="form-label">Quantity *</label>
														<input type="number" name="stock" value="{!! $dataInfo->stock !!}" class="form-control" value="1" min="0" required="required" />
													</th>
													<th>
														<label class="form-label">Vendor</label>
														<select name="vendor" class="form-select single-select parentVendor ajaxVendorData">
															<option value="">-Select Vendor-</option>
															@if(!empty($contacts) && (count($contacts)>0))
															@foreach($contacts as $key => $list)
															<option {!! $list->id == $dataInfo->vendor_id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
															@endforeach
															@endif
														</select>
													</th>
												</tr>

												<tr style="background-color: #e9ecef">
													<th width="25%">Specification *</th>
													<th colspan="5">Detail *</th>
												</tr>
											</thead>
											<tbody>
												@if(!empty($dataInfo->productItemDetails) && (count($dataInfo->productItemDetails)>0))
												@foreach($dataInfo->productItemDetails as $key => $list)
												<tr>
													<td><input type="text" value="{!! $list->specTypeInfo->title !!}" class="form-control" readonly="readonly"></td>
													<td colspan="5"><input type="text" name="itemDetails[{{$list->id}}]" class="form-control" placeholder="{!! $list->specTypeInfo->title !!}" value="{!! $list->spec_detail !!}" required="required"></td>
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
								<button type="submit" class="btn btn-outline-primary px-5">Save</button>
								<a href="{!! route('Products Stock List', $dataInfo->product_id) !!}" class="btn btn-outline-danger px-3">Cancel</a>
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
@endpush

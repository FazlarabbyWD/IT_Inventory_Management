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
					<form method="post" action="{!! route('Products Store') !!}" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<label for="title" class="col-sm-3 col-form-label">Product Title *</label>
							<div class="col-sm-9">
								<input type="text" name="title" value="{!! old('title') !!}" id="title" class="form-control" placeholder="Title" required="required">
								@error('title')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="title" class="col-sm-3 col-form-label">Product Spec Types *</label>
							<div class="col-sm-8">
								<select name="spec_types_ids[]" class="multiple-select" data-placeholder="Choose Specification Types" multiple="multiple" required="required">
									@if(!empty($specTypes) && (count($specTypes)>0))
									@foreach($specTypes as $key => $list)
									<option {!! !empty(old('spec_types_ids')) && in_array($list->id, old('spec_types_ids')) ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
									@endforeach
									@endif
								</select>
								@error('spec_types_ids')
								<b>{{ $message }}</b>
								@enderror
							</div>
							<div class="col-sm-1">
								<a href="{!! route('SpecificationTypes Create') !!}?ref={!! Request::url() !!}" class="btn btn-outline-warning col-12"><i class="bx bx-plus"></i></a>
							</div>
						</div>

						<div class="row mb-3">
							<label for="office_id" class="col-sm-3 col-form-label">Office *</label>
							<div class="col-sm-8">
								<select name="office_id" class="form-select single-select" id="office_id" required="required">
									@if(!empty($offices) && (count($offices)>0))
									@foreach($offices as $key => $list)
									<option {!! old('office_id') == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
									@endforeach
									@endif
								</select>
								@error('office_id')
								<b>{{ $message }}</b>
								@enderror
							</div>
							<div class="col-sm-1">
								<a href="{!! route('Offices Create') !!}?ref={!! Request::url() !!}" class="btn btn-outline-warning col-12"><i class="bx bx-plus"></i></a>
							</div>
						</div>

						<div class="row mb-3">
							<label for="category_id" class="col-sm-3 col-form-label">Category</label>
							<div class="col-sm-8">
								<select name="category_id" class="form-select single-select" id="category_id">
									<option value="">-Select Category-</option>
									@if(!empty($categories) && (count($categories)>0))
									@foreach($categories as $key => $list)
									<option {!! old('category_id') == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
									@endforeach
									@endif
								</select>
								@error('category_id')
								<b>{{ $message }}</b>
								@enderror
							</div>
							<div class="col-sm-1">
								<a href="{!! route('Categories Create') !!}?ref={!! Request::url() !!}" class="btn btn-outline-warning col-12"><i class="bx bx-plus"></i></a>
							</div>
						</div>

						<div class="row mb-3">
							<label for="brand_id" class="col-sm-3 col-form-label">Brand</label>
							<div class="col-sm-8">
								<select name="brand_id" class="form-select single-select" id="brand_id">
									<option value="">-Select Brand-</option>
									@if(!empty($brands) && (count($brands)>0))
									@foreach($brands as $key => $list)
									<option {!! old('brand_id') == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
									@endforeach
									@endif
								</select>
								@error('brand_id')
								<b>{{ $message }}</b>
								@enderror
							</div>
							<div class="col-sm-1">
								<a href="{!! route('Brands Create') !!}?ref={!! Request::url() !!}" class="btn btn-outline-warning col-12"><i class="bx bx-plus"></i></a>
							</div>
						</div>

						<div class="row mb-3">
							<label for="photo" class="col-sm-3 col-form-label">Photo</label>
							<div class="col-sm-9">
								<div class="fileupload fileupload-new" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;"></span>
									<label class="btn btn-primary btn-file btn-sm" >
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Photo</span>
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
										<input type="file" name="photo" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('photo')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="status" class="col-sm-3 col-form-label">Status *</label>
							<div class="col-sm-9">
								<select name="status" class="form-select" id="status" required="required">
									<option {!! old('status') == 1 ? 'selected' : '' !!} value="1">Active</option>
									<option {!! old('status') == 2 ? 'selected' : '' !!} value="2">Inactive</option>
								</select>
								@error('status')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row">
							<label class="col-sm-3 col-form-label"></label>
							<div class="col-sm-9">
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

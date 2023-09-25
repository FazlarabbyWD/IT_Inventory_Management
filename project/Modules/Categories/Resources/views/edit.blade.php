@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Categories</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Edit</li>
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
					<form method="post" action="{!! route('Categories Update', $dataInfo->id) !!}" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<div class="col-sm-8">
								<label for="title" class="col-form-label">Title *</label>
								<input type="text" name="title" value="{!! $dataInfo->title !!}" id="title" class="form-control" placeholder="Title" required="required">
								@error('title')
								<b>{{ $message }}</b>
								@enderror
							</div>

							<div class="col-sm-2">
								<label for="status" class="col-form-label">Status *</label>
								<select name="status" class="form-select" id="status" required="required">
									<option {!! $dataInfo->status == 1 ? 'selected' : '' !!} value="1">Active</option>
									<option {!! $dataInfo->status == 2 ? 'selected' : '' !!} value="2">Inactive</option>
								</select>
								@error('status')
								<b>{{ $message }}</b>
								@enderror
							</div>
							
							<div class="col-sm-2">
								<label for="photo" class="col-form-label">Photo</label>
								<div class="fileupload @if(empty($dataInfo->photo)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->photo))
										<img src="{{asset('uploads/categories/'.$dataInfo->photo)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->photo))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
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

						

						<div class="row">
							<div class="col-sm-12">
								<hr>
								<button type="submit" class="btn btn-outline-primary px-5">Save</button>
								<a href="{!! route('Categories') !!}" class="btn btn-outline-danger px-3">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection

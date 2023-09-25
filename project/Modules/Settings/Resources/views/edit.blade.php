@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Settings</div>
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
					<form method="post" action="{!! route('Settings Update') !!}" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<label for="title" class="col-sm-3 col-form-label">Title *</label>
							<div class="col-sm-9">
								<input type="text" name="title" value="{!! !empty($dataInfo->title) ? $dataInfo->title : '' !!}" id="title" class="form-control" placeholder="Title" required="required">
								@error('title')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="contact" class="col-sm-3 col-form-label">Contact</label>
							<div class="col-sm-9">
								<input type="text" name="contact" value="{!! !empty($dataInfo->contact) ? $dataInfo->contact : '' !!}" id="contact" class="form-control" placeholder="Contact">
								@error('contact')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="email" class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
								<input type="email" name="email" value="{!! !empty($dataInfo->email) ? $dataInfo->email : '' !!}" id="email" class="form-control" placeholder="Email">
								@error('email')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="address" class="col-sm-3 col-form-label">Address</label>
							<div class="col-sm-9">
								<input type="text" name="address" value="{!! !empty($dataInfo->address) ? $dataInfo->address : '' !!}" id="address" class="form-control" placeholder="Address">
								@error('address')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="website" class="col-sm-3 col-form-label">Website</label>
							<div class="col-sm-9">
								<input type="text" name="website" value="{!! !empty($dataInfo->website) ? $dataInfo->website : '' !!}" id="website" class="form-control" placeholder="Website">
								@error('website')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="logo_1" class="col-sm-3 col-form-label">Logo 1</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->logo_1)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->logo_1))
										<img src="{{asset('uploads/settings/'.$dataInfo->logo_1)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->logo_1))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="logo_1" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('logo_1')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="logo_2" class="col-sm-3 col-form-label">Logo 2</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->logo_2)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->logo_2))
										<img src="{{asset('uploads/settings/'.$dataInfo->logo_2)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->logo_2))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="logo_2" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('logo_2')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="icon_1" class="col-sm-3 col-form-label">Icon 1</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->icon_1)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->icon_1))
										<img src="{{asset('uploads/settings/'.$dataInfo->icon_1)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->icon_1))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="icon_1" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('icon_1')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="icon_2" class="col-sm-3 col-form-label">Icon 2</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->icon_2)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->icon_2))
										<img src="{{asset('uploads/settings/'.$dataInfo->icon_2)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->icon_2))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="icon_2" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('icon_2')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="thumbnail" class="col-sm-3 col-form-label">Thumbnail</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->thumbnail)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->thumbnail))
										<img src="{{asset('uploads/settings/'.$dataInfo->thumbnail)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->thumbnail))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="thumbnail" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('thumbnail')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row">
							<label class="col-sm-3 col-form-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-outline-primary px-5">Save</button>
								<a href="{!! route('home') !!}" class="btn btn-outline-danger px-3">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection

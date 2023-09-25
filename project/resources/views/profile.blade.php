@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Profile</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">{!! Auth::user()->name !!}</li>
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
		<div class="row">
			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							@if(!empty(Auth::user()->photo))
							<img src="{{asset('uploads/users/'.Auth::user()->photo)}}" class="rounded-circle p-1 bg-primary" width="110">
							@else
							<img src="{{asset('uploads/users/default.png')}}" class="rounded-circle p-1 bg-primary" width="110">
							@endif
							<div class="mt-3">
								<h4>{!! Auth::user()->name !!}</h4>
								<p class="text-secondary mb-1">{!! Auth::user()->designation !!}</p>
							</div>
						</div>
						<hr class="my-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Email</h6>
								<span class="text-secondary">{!! Auth::user()->email !!}</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Contact</h6>
								<span class="text-secondary">{!! Auth::user()->contact !!}</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Address</h6>
								<span class="text-secondary">{!! Auth::user()->address !!}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body p-5">
						<div class="border p-4 rounded">
							<form method="post" action="{!! route('Profile Update') !!}" enctype="multipart/form-data">
								@csrf

								<div class="row mb-3">
									<label for="name" class="col-sm-3 col-form-label">Name *</label>
									<div class="col-sm-9">
										<input type="text" name="name" value="{!! Auth::user()->name !!}" id="name" class="form-control" placeholder="Name" required="required">
										@error('name')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="email" class="col-sm-3 col-form-label">Email *</label>
									<div class="col-sm-9">
										<input type="email" name="email" value="{!! Auth::user()->email !!}" id="email" class="form-control" placeholder="Email" required="required">
										@error('email')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="password" class="col-sm-3 col-form-label">Password</label>
									<div class="col-sm-9">
										<input type="password" name="password" value="" id="password" class="form-control" placeholder="Password">
										@error('password')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="designation" class="col-sm-3 col-form-label">Designation</label>
									<div class="col-sm-9">
										<input type="text" name="designation" value="{!! Auth::user()->designation !!}" id="designation" class="form-control" placeholder="Designation">
										@error('designation')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="contact" class="col-sm-3 col-form-label">Contact</label>
									<div class="col-sm-9">
										<input type="text" name="contact" value="{!! Auth::user()->contact !!}" id="contact" class="form-control" placeholder="Contact">
										@error('contact')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="address" class="col-sm-3 col-form-label">Address</label>
									<div class="col-sm-9">
										<input type="text" name="address" value="{!! Auth::user()->address !!}" id="address" class="form-control" placeholder="Address">
										@error('address')
										<b>{{ $message }}</b>
										@enderror
									</div>
								</div>

								<div class="row mb-3">
									<label for="photo" class="col-sm-3 col-form-label">Photo</label>
									<div class="col-sm-9">
										<div class="fileupload @if(empty(Auth::user()->photo)) fileupload-new @endif" data-provides="fileupload" >
											<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
												@if(!empty(Auth::user()->photo))
												<img src="{{asset('uploads/users/'.Auth::user()->photo)}}" width="75px">
												@endif
											</span>
											<label class="btn btn-primary btn-file btn-sm" >
												@if(empty(Auth::user()->photo))
												<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Photo</span>
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
									<label class="col-sm-3 col-form-label"></label>
									<div class="col-sm-9">
										<button type="submit" class="btn btn-outline-primary px-5">Update</button>
										<a href="{!! route('home') !!}" class="btn btn-outline-danger px-3">Cancel</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>









		

	</div>
</div>

@endsection

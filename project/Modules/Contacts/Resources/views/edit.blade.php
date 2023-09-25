@extends('layouts.app')

@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Contacts</div>
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
					<form method="post" action="{!! route('Contacts Update', $dataInfo->id) !!}" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<label for="office_id" class="col-sm-3 col-form-label">Office</label>
							<div class="col-sm-8">
								<select name="office_id" class="form-select single-select" id="office_id">
									<option value="">-Select Office-</option>
									@if(!empty($offices) && (count($offices)>0))
									@foreach($offices as $key => $list)
									<option {!! $dataInfo->office_id == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
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
							<label for="title" class="col-sm-3 col-form-label">Contact Name *</label>
							<div class="col-sm-9">
								<input type="text" name="title" value="{!! $dataInfo->title !!}" id="title" class="form-control" placeholder="Title" required="required">
								@error('title')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="code" class="col-sm-3 col-form-label">Code</label>
							<div class="col-sm-9">
								<input type="text" name="code" value="{!! $dataInfo->code !!}" id="code" class="form-control" placeholder="Code">
								@error('code')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="bio" class="col-sm-3 col-form-label">Bio</label>
							<div class="col-sm-9">
								<input type="text" name="bio" value="{!! $dataInfo->bio !!}" id="bio" class="form-control" placeholder="Bio">
								@error('bio')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="contact" class="col-sm-3 col-form-label">Contact</label>
							<div class="col-sm-9">
								<input type="text" name="contact" value="{!! $dataInfo->contact !!}" id="contact" class="form-control" placeholder="Contact">
								@error('contact')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="email" class="col-sm-3 col-form-label">Email</label>
							<div class="col-sm-9">
								<input type="email" name="email" value="{!! $dataInfo->email !!}" id="email" class="form-control" placeholder="Email">
								@error('email')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="address" class="col-sm-3 col-form-label">Address</label>
							<div class="col-sm-9">
								<input type="text" name="address" value="{!! $dataInfo->address !!}" id="address" class="form-control" placeholder="Address">
								@error('address')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="photo" class="col-sm-3 col-form-label">Photo</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->photo)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->photo))
										<img src="{{asset('uploads/contacts/'.$dataInfo->photo)}}" width="75px">
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

						<div class="row mb-3">
							<label for="signature" class="col-sm-3 col-form-label">Signature</label>
							<div class="col-sm-9">
								<div class="fileupload @if(empty($dataInfo->signature)) fileupload-new @endif" data-provides="fileupload" >
									<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;">
										@if(!empty($dataInfo->signature))
										<img src="{{asset('uploads/contacts/signatures/'.$dataInfo->signature)}}" width="75px">
										@endif
									</span>
									<label class="btn btn-primary btn-file btn-sm" >
										@if(empty($dataInfo->signature))
										<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
										@endif
										<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Select New</span>
										<input type="file" name="signature" id="image">
									</label>
									<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
								@error('signature')
								<b>{{ $message }}</b>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<label for="contact_type_id" class="col-sm-3 col-form-label">Contact Type</label>
							<div class="col-sm-8">
								<select name="contact_type_id" class="form-select single-select" id="contact_type_id">
									<option value="">-Select Type-</option>
									@if(!empty($contactTypes) && (count($contactTypes)>0))
									@foreach($contactTypes as $key => $list)
									<option {!! $dataInfo->contact_type_id == $list->id ? 'selected' : '' !!} value="{!! $list->id !!}">{!! $list->title !!}</option>
									@endforeach
									@endif
								</select>
								@error('contact_type_id')
								<b>{{ $message }}</b>
								@enderror
							</div>
							<div class="col-sm-1">
								<a href="{!! route('ContactTypes Create') !!}?ref={!! Request::url() !!}" class="btn btn-outline-warning col-12"><i class="bx bx-plus"></i></a>
							</div>
						</div>

						<div class="row mb-3">
							<label for="status" class="col-sm-3 col-form-label">Status *</label>
							<div class="col-sm-9">
								<select name="status" class="form-select" id="status" required="required">
									<option {!! $dataInfo->status == 1 ? 'selected' : '' !!} value="1">Active</option>
									<option {!! $dataInfo->status == 2 ? 'selected' : '' !!} value="2">Inactive</option>
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
								<a href="{!! route('Contacts') !!}" class="btn btn-outline-danger px-3">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection

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
					<form method="post" action="{!! route('Categories Store') !!}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="ref" value="{!! isset($_GET['ref']) ? $_GET['ref'] : '' !!}">

						<div class="itemDiv">
							<div class="row mb-3 itemDivRow">
								<div class="col-sm-7">
									<label for="title" class="col-form-label">Title *</label>
									<input type="text" name="title[]" value="{!! old('title') !!}" id="title" class="form-control" placeholder="Title" required="required">
									@error('title')
									<b>{{ $message }}</b>
									@enderror
								</div>

								<div class="col-sm-2">
									<label for="status" class="col-form-label">Status *</label>
									<select name="status[]" class="form-select" id="status" required="required">
										<option {!! old('status') == 1 ? 'selected' : '' !!} value="1">Active</option>
										<option {!! old('status') == 2 ? 'selected' : '' !!} value="2">Inactive</option>
									</select>
									@error('status')
									<b>{{ $message }}</b>
									@enderror
								</div>

								<div class="col-sm-2">
									<label for="title" class="col-form-label">Photo</label>
									<div class="fileupload fileupload-new" data-provides="fileupload" >
										<span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;"></span>
										<label class="btn btn-primary btn-file btn-sm" >
											<span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span>
											<span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span>
											<input type="file" name="photo[]" id="image">
										</label>
										<a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload">
											<i class="fa fa-times"></i> Remove
										</a>
									</div>
									@error('photo')
									<b>{{ $message }}</b>
									@enderror
								</div>

								<div class="col-sm-1">
									<label for="action" class="col-form-label">Action</label>
									<button type="button" class="btn btn-outline-danger"><i class="bx bx-trash"></i></button>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<hr>
								<button type="button" class="btn btn-outline-warning addMoreItem"><i class="bx bx-plus"></i> Add More</button>
								<button type="submit" class="btn btn-outline-primary px-5" name="exit" value="yes">Save & Exit</button>
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
@push('js')
<script type="text/javascript">
	$(document).ready(function(){
		var max_fields = 500; 
		var wrapper = $(".itemDiv"); 
		var add_button = $(".addMoreItem"); 
		var count = 0; 
		$(add_button).click(function(e){
			e.preventDefault();
			if(count < max_fields){ 
				$(wrapper).append('<div class="row mb-3 itemDivRow"><div class="col-sm-7"><input type="text" name="title[]" value="" id="title" class="form-control" placeholder="Title" required="required"></div><div class="col-sm-2"><select name="status[]" class="form-select" id="status" required="required"><option  value="1">Active</option><option value="2">Inactive</option></select></div><div class="col-sm-2"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-height: 75px;"></span><label class="btn btn-primary btn-file btn-sm" ><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span><input type="file" name="photo[]" id="image"></label><a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload"><i class="fa fa-times"></i> Remove</a></div></div><div class="col-sm-1"><button type="button" class="btn btn-outline-danger removeItem"><i class="bx bx-trash"></i></button></div></div>');
			}
		});
		$(wrapper).on("click",".removeItem", function(e){
			e.preventDefault(); $(this).closest('.itemDivRow').remove(); count--;
		})
	});
</script>
@endpush
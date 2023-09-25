@extends('layouts.app')
@section('content')

<div class="page-wrapper">
	<div class="page-content">

		<!-- title section -->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">{!! $dataInfo->title !!}</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Stock List</li>
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

		<!-- search -->
		<div class="card">
			<div class="card-body">
				<form method="get" class="row g-3">
					<div class="col-md-2">
						<input type="text" name="t_code" value="{!! isset($_GET['t_code']) ? $_GET['t_code'] : '' !!}" class="form-control" placeholder="Tracking Code">
					</div>

					<div class="col-md-2">
						<select name="quality_status" class="form-select" id="quality_status">
							<option value="">-Select Quality-</option>
							<option {!! isset($_GET['quality_status']) && $_GET['quality_status'] == 1 ? 'selected' : '' !!} value="1">Usable</option>
							<option {!! isset($_GET['quality_status']) && $_GET['quality_status'] == 2 ? 'selected' : '' !!} value="2">Damaged</option>
							<option {!! isset($_GET['quality_status']) && $_GET['quality_status'] == 3 ? 'selected' : '' !!} value="3">Missing</option>
						</select>
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
				<table class="table mb-0 table-hover align-middle">
					<thead class="table-light">
						<tr>
							<th scope="col">SL</th>
							<th scope="col">Item Title</th>
							<th scope="col">Tracking Code</th>
							<th scope="col">Detail</th>
							<th scope="col">Purchase Date</th>
							<th scope="col">Warranty</th>
							<th scope="col">Distributed</th>
							<th scope="col">Vendor</th>
							<th scope="col">Price</th>
							<th scope="col">Stock</th>
							<th scope="col">Quality</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($dataInfo) && (count($dataInfo->productItems)>0))
						@foreach($dataInfo->productItems as $key => $list)
						<tr>
							<td scope="row">{!! $key+1 !!}</td>
							<td>{!! $dataInfo->title !!}</td>
							<td><b>{!! $list->t_code !!}</b></td>
							<td>
								@if(!empty($list->productItemDetails) && (count($list->productItemDetails)>0))
								@foreach($list->productItemDetails as $keyItemDetail => $itemDetail)
								<p style="margin-bottom: 5px">{!! $itemDetail->specTypeInfo->title !!}: {!! $itemDetail->spec_detail !!}</p>
								@endforeach
								@endif
							</td>
							<td>{!! $list->purchase_date ? date('d M Y', strtotime($list->purchase_date)) : '--' !!}</td>
							<td>
								{!! $list->warranty_start ? date('d M Y', strtotime($list->warranty_start)) : '--' !!}
								{!! $list->warranty_end ? ' TO '.date('d M Y', strtotime($list->warranty_end)) : '--' !!}
							</td>
							<td>{!! !empty($list->distributionInfo) && !empty($list->distributionInfo->contactInfo) ? $list->distributionInfo->contactInfo->title : '--' !!}</td>
							<td>{!! $list->vendor_id ? $list->vendorInfo->title : '--' !!}</td>
							<td>{!! $list->price !!}</td>
							<td>{!! $list->stock !!}</td>
							<td><div class="badge rounded-pill bg-light-info {!! $list->quality_status == 1 ? 'text-success' : ($list->quality_status == 2 ? 'text-info' : ($list->quality_status == 3 ? 'text-danger' : '')) !!}">{!! $list->quality_status == 1 ? 'Usable' : ($list->quality_status == 2 ? 'Damaged' : ($list->quality_status == 3 ? 'Missing' : '')) !!}</div></td>
							
							<td>
								<div class="dropdown">
									<button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i></button>
									<ul class="dropdown-menu" style="margin: 0px;">
										<li><a class="dropdown-item" href="{!! route('Products Stock Edit', $list->id) !!}">Edit</a>
										</li>
										<li><a class="dropdown-item confirmDelete" href="{!! route('Products Stock Delete', $list->id) !!}">Delete</a>
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

		</div>
	</div>

</div>
</div>

@endsection


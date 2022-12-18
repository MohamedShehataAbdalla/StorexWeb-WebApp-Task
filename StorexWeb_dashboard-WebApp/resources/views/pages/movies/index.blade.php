@extends('layouts.master')
@section('pageTitle','Movies')
@section('styles')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Basic Data</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Movies</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

                @include('layouts.alerts')

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<div class="d-blok">
                                    <a class="modal-effect btn btn-primary btn-sm" data-effect="effect-sign" data-toggle="modal" href="#add_Modal"> Add New <i class="fas fa-plus"></i></a>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('movies.trash') }}"> Archives <i class="fas fa-trash"></i></a>

								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap table-hover table-striped" id="example1">
										<thead>
											<tr>
												<th class="wd-1p border-bottom-0">#</th>
												<th class="wd-40p border-bottom-0 text-center">Title</th>
												<th class="wd-5p border-bottom-0 text-center">Rate</th>
												<th class="wd-20p border-bottom-0 text-center">Category</th>
												<th class="wd-20p border-bottom-0 text-center">Image</th>
												<th class="wd-20p border-bottom-0 text-center">Controll</th>
											</tr>
										</thead>
										<tbody class="">
                                            @forelse ($movies as $movie)
                                                <tr>
                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                    <td class="text-center align-middle">{{ $movie->title }}</td>
                                                    <td class="text-center align-middle">{{ $movie->rate }}</td>
                                                    <td class="text-center align-middle">{{ $movie->category->title }}</td>
                                                    <td class="text-center align-middle">
                                                        @if ($movie->image)
                                                            <img src="{{ asset('storage/images/'.$movie->image) }}" alt="{{ $movie->name }}" width="100" />
                                                        @else
                                                            <img src="{{ asset('storage/images/noImage.png') }}" alt="Empty" width="100" />
                                                        @endif
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-sm btn-warning modal-effect" data-effect="effect-sign" data-toggle="modal" href="#update_Modal" title="Edit"
                                                            data-id="{{ $movie->id }}" data-title="{{ $movie->title }}" data-rate="{{ $movie->rate }}" data-description="{{ $movie->description }}" data-category_id="{{ $movie->category_id }}" data-image="{{ asset('storage/images/'.$movie->image) }}">
                                                                <i class="las la-pen"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm" href="{{ route('movies.show',$movie->id) }}" title="View"><i class="fas fa-solid fa-binoculars"></i></a>
                                                        <a class="btn btn-danger btn-sm" href="{{ route('movies.softDelete',$movie->id) }}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="thead-light text-center">
                                                    <td colspan="6">No Items</td>
                                                </tr>
                                            @endforelse
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->

            <!-- Start Add Modal effects -->
            <div class="modal fade" id="add_Modal">
                <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title"> Create Movie </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('movies.store') }}" method="post" enctype="multipart/form-data">
                            {{method_field('POST')}}
                            {{ csrf_field() }}

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                                    placeholder="Action Movies"  value="{{old('title')}}" autofocus  maxlength="100">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 mt-5">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                    <option value="" selected>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : null }}> {{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class=" d-flex justify-content-center" style="height:100px; max-height:100px">
                                                    <img src="{{ asset('storage/images/noImage.png') }}"  id="preview" alt="Empty" class="img-fluid img-thumbnail" />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                                                    placeholder="Select Image"  value="{{old('image')}}" accept="image/png, image/jpg, image/jpeg" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                        placeholder="......." rows="4" dir="auto">{{old('description')}}</textarea>
                                                    @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Add Modal effects-->

            <!-- Start Update Modal effects -->
            <div class="modal fade" id="update_Modal">
                <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title"> Modify Movie </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('movies.update') }}" method="post" enctype="multipart/form-data">
                            {{method_field('PATCH')}}
                            {{ csrf_field() }}

                                
                                <div class="modal-body">
                                <input type="hidden"  id="id" name="id" value="{{old('id')}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                                    placeholder="Action Movies"  value="{{old('title')}}" autofocus  maxlength="100">
                                                @error('title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 mt-5">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                                    <option value="" >Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : null }}> {{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class=" d-flex justify-content-center" style="height:100px; max-height:100px">
                                                    <img src="" alt="Empty" id="preview_update"  class="img-fluid img-thumbnail" />
{{-- 
                                                    @if ($movie->image)
                                                            <img src="{{ asset('storage/images/'.$movie->image) }}" alt="{{ $movie->name }}" width="100" />
                                                        @else
                                                            <img src="{{ asset('storage/images/noImage.png') }}" alt="Empty" width="100" />
                                                        @endif --}}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                                                    placeholder="Select Image"  value="{{old('image')}}" accept="image/png, image/jpg, image/jpeg" onchange="document.getElementById('preview_update').src = window.URL.createObjectURL(this.files[0])">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                        placeholder="......." rows="4" dir="auto">{{old('description')}}</textarea>
                                                    @error('description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Update Modal effects-->


		</div>
		<!-- main-content closed -->
@endsection
@section('scripts')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>
         $('#update_Modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var image = button.data('image')
            var category_id = button.data('category_id')
            
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #title').val(title);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #category_id').val(category_id);
            if(image)
                {
                    modal.find('.modal-body #preview_update').prop('src', image);
                    // modal.find('.modal-body #image').prop('src', image);
                }
            

         });
    </script>
@endsection

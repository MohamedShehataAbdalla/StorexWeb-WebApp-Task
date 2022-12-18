@extends('layouts.master')
@section('pageTitle','Users')
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
							<h4 class="content-title mb-0 my-auto">Basic Data</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Users</span>
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
                                    <a class="btn btn-secondary btn-sm" href="{{ route('users.trash') }}"> Archives <i class="fas fa-trash"></i></a>

								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap table-hover table-striped" id="example1">
										<thead>
											<tr>
												<th class="wd-1p border-bottom-0">#</th>
												<th class="wd-40p border-bottom-0 text-center">Name</th>
												<th class="wd-20p border-bottom-0 text-center">Email</th>
												<th class="wd-20p border-bottom-0 text-center">BirthDate</th>
												<th class="wd-20p border-bottom-0 text-center">Controll</th>
											</tr>
										</thead>
										<tbody class="">
                                            @forelse ($users as $user)
                                                <tr>
                                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                                    <td class="text-center align-middle">{{ $user->name }}</td>
                                                    <td class="text-center align-middle">{{ $user->email }}</td>
                                                    <td class="text-center align-middle">{{ $user->birthdate }}</td>
                                                    <td class="text-center align-middle">
                                                        <a class="btn btn-sm btn-warning modal-effect" data-effect="effect-sign" data-toggle="modal" href="#update_Modal" title="Edit"
                                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-birthdate="{{ $user->birthdate }}">
                                                                <i class="las la-pen"></i>
                                                        </a>
                                                        <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}" title="View"><i class="fas fa-solid fa-binoculars"></i></a>
                                                        <a class="btn btn-danger btn-sm" href="{{ route('users.softDelete',$user->id) }}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="thead-light text-center">
                                                    <td colspan="5">No Items</td>
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
                            <h6 class="modal-title"> Create User </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            {{method_field('POST')}}
                            {{ csrf_field() }}

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                    placeholder="Mohamed Shehata"  value="{{old('name')}}" autofocus required maxlength="100">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="birthdate" class="form-label">BirthDate</label>
                                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate"
                                                     value="{{old('birthdate')}}" maxlength="100">
                                                @error('birthdate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                    placeholder="admin@system.com" required value="{{old('email')}}" >
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                                    placeholder="********"  required autocomplete="new-password" >
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="confirm-password" class="form-label">Re-Password</label>
                                                <input type="password" class="form-control @error('confirm-password') is-invalid @enderror" id="password-confirm" name="password_confirmation" 
                                                    placeholder="********"  required autocomplete="new-password" >
                                                @error('confirm-password')
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
                            <h6 class="modal-title"> Modify User </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('users.update') }}" method="post" enctype="multipart/form-data">
                            {{method_field('PATCH')}}
                            {{ csrf_field() }}

                                
                                <div class="modal-body">
                                <input type="hidden"  id="id" name="id" value="{{old('id')}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                    placeholder="Mohamed Shehata"  value="{{old('name')}}" autofocus required maxlength="100">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="birthdate" class="form-label">BirthDate</label>
                                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate"
                                                     value="{{old('birthdate')}}" maxlength="100">
                                                @error('birthdate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                    placeholder="admin@system.com" required value="{{old('email')}}" >
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                                    placeholder="********"  autocomplete="new-password" >
                                                @error('password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="confirm-password" class="form-label">Re-Password</label>
                                                <input type="password" class="form-control @error('confirm-password') is-invalid @enderror" id="password-confirm" name="password_confirmation" 
                                                    placeholder="********"  autocomplete="new-password" >
                                                @error('confirm-password')
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
            var name = button.data('name')
            var email = button.data('email')
            var password = button.data('password')
            var birthdate = button.data('birthdate')
            
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #password').val(password);
            modal.find('.modal-body #birthdate').val(birthdate);
            
            

         });
    </script>
@endsection

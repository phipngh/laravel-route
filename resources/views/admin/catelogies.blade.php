@extends('layout.admin.master')

@section('title')
    Catelogies
@endsection

@section('additionStyle')

    {{Html::style('https://fonts.googleapis.com/icon?family=Material+Icons')}}
    {{Html::style('admin/assets/css/customTable.css')}}

@endsection

@section('content')

<div class="content">
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Catelogies</b></h2>


					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
                @if(session()->has('msg'))
                    <div class="alert alert-success">
                        {{session('msg')}}
                    </div>

                @endif
				<thead>
					<tr>
                        <th>#</th>
						<th>Name</th>
						<th>Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
                    @foreach($catelogies as $catelogy)
					<tr>
                        <td>{{$catelogy->id}}</td>
						<td>{{$catelogy->name}}</td>
						<td>{{$catelogy->created_at->diffForHumans()}}</td>
						<td>
							<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a href="#deleteEmployeeModal-{{$catelogy->id}}" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
                    </tr>
                    @endforeach

				</tbody>
			</table>

		</div>
	</div>
</div>
<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('adminCreateCatelogies')}}" method="POST">
                @csrf
				<div class="modal-header">
					<h4 class="modal-title">Add Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>

                @include('layout.message')
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" required id="name" name="name">
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">
					<h4 class="modal-title">Edit Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->

    @foreach($catelogies as $catelogy)
<div id="deleteEmployeeModal-{{$catelogy->id}}" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('adminDeleteCatelogies',$catelogy->id)}}" method="POST">
                @csrf
				<div class="modal-header">
					<h4 class="modal-title">Delete Catelogy</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete "{{$catelogy->name}}"</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>

    @endforeach

</div>



@endsection

@section('additionScript')

    {{Html::script('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js')}}

@endsection

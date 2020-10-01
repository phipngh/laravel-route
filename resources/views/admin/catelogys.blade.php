@extends('layout.admin.master')

@section('title')
    Catelogies
@endsection

@section('additionStyle')

    {{Html::style('https://fonts.googleapis.com/icon?family=Material+Icons')}}
    {{Html::style('admin/assets/css/customTable.css')}}

    {{Html::style('admin/assets/css/dataTableBootstrap.css')}}


{{--    {{Html::style('https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css')}}--}}



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
                                <a  type="button" name="create_record" id="create_record" class="btn btn-success" ><i class="material-icons">&#xE147;</i> <span>Add New Catelogy</span></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 float-left">
                                <form action="{{route('catelogy.import')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input id="importFile" type="file" name="file" accept=".csv">
                                    <br>
                                    <button id="importButton" class="btn btn-success" disabled>Import User Data</button>
                                    <a class="btn btn-warning" href="{{route('catelogy.export')}}" >Export User Data</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table id="catelogy_table" class="table table-striped table-hover" style="width:100%">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">
                                {{session('msg')}}
                            </div>

                        @endif
                        <thead>
                        <tr>
                            <th style="width: 3%">Index</th>
                            <th style="width: 5%">ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>



@endsection

@section('additionScript')

    {{Html::script('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js')}}

    {{Html::script('https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js')}}
    {{Html::script('https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js')}}



    <script>
        $(document).ready(function(){

            $('#catelogy_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('catelogys.index') }}",
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            //Add

            $('#create_record').click(function(){
                $('.modal-title').text('Add New Record');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');

                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('catelogys.store') }}";
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "{{ route('catelogys.update') }}";
                }

                $.ajax({
                    url: action_url,
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('#catelogy_table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html);
                    }
                });
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $('#form_result').html('');
                $.ajax({
                    url :"/admin/catelogys/"+id+"/edit",
                    dataType:"json",
                    success:function(data)
                    {
                        $('#name').val(data.result.name);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record');
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function(){
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    url:"/admin/catelogys/destroy/"+user_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            $('#catelogy_table').DataTable().ajax.reload();

                        }, 500);
                    }
                })
            });

            $('#importFile').change(function(){
                if($('#importFile').val()==''){
                    $('#importButton').attr('disabled',true)
                }
                else{
                    $('button').attr('disabled',false);
                }
            })
        });
    </script>


@endsection


@section('modal')



{{--    Add AND Edit --}}
    <div id="formModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="sample_form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add Catelogy</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" required id="name" name="name">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--Delete--}}
<div id="confirmModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Record</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4 style="margin:0;">Are you sure you want to remove this data?</h4>

            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success" data-dismiss="modal" value="Cancel">
{{--                <input type="button" name="ok_button" id="ok_button" class="btn btn-danger" value="OK">--}}
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </div>
    </div>
</div>




@endsection


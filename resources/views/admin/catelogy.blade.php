@extends('layout.admin.master')

@section('title')
    Catelogies
@endsection

@section('additionStyle')

    {{Html::style('https://fonts.googleapis.com/icon?family=Material+Icons')}}
    {{Html::style('admin/assets/css/customTable.css')}}


    {{Html::style('https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css')}}



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
                                <a  name="create_record" id="create_record" class="btn btn-success" ><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                            </div>
                        </div>
                    </div>
                    <table id="catelogy_table" class="table table-striped table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
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
                    url: "{{ route('catelogy.index') }}",
                },
                columns: [
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

            $('#create_record').click(function(){
                // $('.modal-title').text('Add New Record');
                // $('#action_button').val('Add');
                // $('#action').val('Add');
                // $('#form_result').html('');

                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('catelogy.store') }}";
                }

                // if($('#action').val() == 'Edit')
                // {
                //     action_url = " route('sample.update') ";
                // }

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

            // $(document).on('click', '.edit', function(){
            //     var id = $(this).attr('id');
            //     $('#form_result').html('');
            //     $.ajax({
            //         url :"/sample/"+id+"/edit",
            //         dataType:"json",
            //         success:function(data)
            //         {
            //             $('#first_name').val(data.result.first_name);
            //             $('#last_name').val(data.result.last_name);
            //             $('#hidden_id').val(id);
            //             $('.modal-title').text('Edit Record');
            //             $('#action_button').val('Edit');
            //             $('#action').val('Edit');
            //             $('#formModal').modal('show');
            //         }
            //     })
            // });
            //
            // var user_id;
            //
            // $(document).on('click', '.delete', function(){
            //     user_id = $(this).attr('id');
            //     $('#confirmModal').modal('show');
            // });
            //
            // $('#ok_button').click(function(){
            //     $.ajax({
            //         url:"sample/destroy/"+user_id,
            //         beforeSend:function(){
            //             $('#ok_button').text('Deleting...');
            //         },
            //         success:function(data)
            //         {
            //             setTimeout(function(){
            //                 $('#confirmModal').modal('hide');
            //                 $('#user_table').DataTable().ajax.reload();
            //                 alert('Data Deleted');
            //             }, 2000);
            //         }
            //     })
            // });

        });
    </script>


@endsection


@section('modal')
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Record</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4" >Name : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" />
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label class="control-label col-md-4">Last Name : </label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="last_name" id="last_name" class="form-control" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action" value="Add" />
{{--                            <input type="hidden" name="hidden_id" id="hidden_id" />--}}
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


{{--    --------------------}}

{{--    <div id="formModal" class="modal fade">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">Add Catelogy</h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <span id="form_result"></span>--}}
{{--                    <form id="sample_form" method="POST">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Name</label>--}}
{{--                            <input type="text" class="form-control" required id="name" name="name">--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">--}}
{{--                            <input type="hidden" name="action" id="action" value="Add" />--}}
{{--                            <input type="hidden" name="hidden_id" id="hidden_id" />--}}
{{--                            <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add">--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    --------------------}}



{{--    <div id="confirmModal" class="modal fade" role="dialog">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                    <h2 class="modal-title">Confirmation</h2>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>--}}
{{--                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

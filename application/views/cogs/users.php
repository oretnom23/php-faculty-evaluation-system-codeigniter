<div class="conteiner-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <b>Users List</b>
                </span>
                <button class="btn btn-sm btn-primary btn-block col-sm-3 float-right" type="button" id="new_user"><i class="fa fa-plus"></i> New Users</button>
            </div>
            <div class="card-body">
                
                <table class="table-bordered table" id="tbl-users">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.load_users = function(){
        start_load()
        $.ajax({
            url:'<?php echo base_url('cogs/users_list') ?>',
            success:function(resp){
                if(typeof resp != undefined){
                    resp= JSON.parse(resp)
                    if(Object.keys(resp).length <= 0 ){
                        $('#tbl-users tbody').html('')
                    }else{
                        var i = 1 ;
                        Object.keys(resp).map(k=>{
                            var tr = $("<tr></tr>")
                            tr.append("<td>"+(i++)+"</td>")
                            tr.append("<td>"+resp[k].name+"</td>")
                            tr.append("<td>"+resp[k].username+"</td>")
                            tr.append('<td><center><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_user" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_user" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></center></td>')
                            $('#tbl-users tbody').append(tr)
                        })
                    }
                }
            },
            complete:function(){
                $('.edit_user').click(function(){
                    frmModal('manage-users',"Edit User","<?php echo base_url('cogs/manage_users/') ?>"+$(this).attr('data-id'))
                })
                $('#tbl-users').dataTable()
                end_load()
            }
        })
    }
    $(document).ready(function(){
        load_users()
    })
    $('#new_user').click(function(){
        frmModal('manage-users',"New User","<?php echo base_url('cogs/manage_users') ?>")
    })
</script>
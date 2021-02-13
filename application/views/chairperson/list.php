<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('chairperson/manage') ?>" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New chairperson</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="chairperson-field">

                   
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID #</th>
                            <th>Name</th>
                            <?php if($_SESSION['login_user_type'] == 1): ?>
                            <th>Department</th>
                            <?php endif; ?>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<script>
window.load_chairperson = function (){
    $('#chairperson-field').dataTable().fnDestroy();
    $('#chairperson-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('chairperson/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#chairperson-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].id_code+'</td>')
                    tr.append('<td>'+resp[k].name+'</td>')
                    if(<?php echo $_SESSION['login_user_type'] ?> == 1)
                    tr.append('<td>'+resp[k].dname+' Department</td>')
                    tr.append('<td>'+resp[k].cname+'</td>')
                    tr.append('<td class="text-center"><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_chairperson" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_chairperson" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></td>')

                $('#chairperson-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#chairperson-field').dataTable()
            $('.edit_chairperson').each(function(e){
                $(this).click(function(){
                    location.replace('<?php echo base_url() ?>chairperson/manage/'+$(this).attr('data-id'))
                })
            })
            $('.remove_chairperson').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_chairperson',[$(this).attr('data-id')])
                })
            })
        }
    })
}
function remove_chairperson($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>chairperson/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_chairperson()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){
    
    if('<?php echo $this->session->flashdata('action_save_chairperson') ?>' == 1)
            Dtoast("Data successfully added",'success');
    load_chairperson();
})
</script>
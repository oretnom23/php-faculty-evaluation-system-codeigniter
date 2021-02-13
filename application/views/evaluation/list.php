<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="javascript:void(0)" onclick="frmModal('manage_evaluation','New Evaluation','<?php echo base_url('evaluation/manage') ?>')" class="btn btn-info float-right btn-sm"><i class="fa fa-plus"> </i> New Evaluation</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="evaluation-field">

                    <colgroup>
                        <col width="5%">
                        <col width="35%">
                        <col width="35%">
                        <col width="5%">
                        <col width="20%">
                    </colgroup>
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Default?</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

    </div>
</div>
<style>
.make_default{
    cursor:pointer
}
</style>

<script>
window.load_evaluation = function (){
    $('#evaluation-field').dataTable().fnDestroy();
    $('#evaluation-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('evaluation/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#evaluation-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].school_year+'</td>')
                    tr.append('<td>'+resp[k].semester+'</td>')
                    if(resp[k].is_default == 1){
                        tr.append('<td><center><div class="badge badge-success">Yes</div></center></td>')
                    }else{
                        tr.append('<td><center><div class="badge badge-danger make_default" data-id = "'+resp[k].id+'">No</div></center></td>')

                    }
                    tr.append('<td><center><a href="<?php echo base_url('evaluation/evaluation_view/') ?>'+resp[k].id+'" class="btn btn-sm btn-outline-info btn-rounded waves-effec view_evaluation" data-id="'+resp[k].id+'"><i class="fa fa-eye"></i></a><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_evaluation" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_evaluation" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></center></td>')

                $('#evaluation-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#evaluation-field').dataTable()
            $('.edit_evaluation').each(function(e){
                $(this).click(function(){
                    frmModal('manage_evaluation','New Evaluation','<?php echo base_url('evaluation/manage/') ?>'+$(this).attr('data-id'))
                })
            })
            $('.remove_evaluation').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_evaluation',[$(this).attr('data-id')])
                })
            })
            $('.make_default').click(function(){
                delete_data('Are you sure to make this as the Default Evaluation?','make_default',[$(this).attr('data-id')])
            })
        }
    })
}
function make_default($id){
    start_load();
    $.ajax({
        url:'<?php echo base_url('evaluation/make_default') ?>',
        method:'POST',
        data:{id:$id},
        success:function(resp){
            if(resp == 1){
                location.reload()
            }
        }
    })

}
function remove_evaluation($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>evaluation/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_evaluation()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){
    
    if('<?php echo $this->session->flashdata('action_cur') ?>' == 1)
            Dtoast("Data successfully added",'success');
            if('<?php echo $this->session->flashdata('action_def') ?>' == 1)
            Dtoast("Data successfully updated",'success');
    
    load_evaluation();
    
})
</script>
<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="javascript:void(0)" id="new_subject" class="btn btn-info float-right"><i class="fa fa-plus"></i> New Subject</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="subject-field">

                    <!-- <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="25%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup> -->
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Description</th>
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
$('#new_subject').click(function(){
    frmModal("manage-subject","New Subject",'<?php echo base_url('subject/manage') ?>')
})
window.load_subject = function (){

    $('#subject-field tbody').html('<tr><td colspan="4">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('subject/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#subject-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].subject+'</td>')
                    tr.append('<td>'+resp[k].description+'</td>')
                    tr.append('<td><center><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_subject" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_subject" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></center></td>')

                $('#subject-field tbody').append(tr)

                    
                })
                

                

                }
            }
        },
        complete:()=>{

            $('.edit_subject').each(function(e){
                $(this).click(function(){
                frmModal("manage-subject","Edit Subject",'<?php echo base_url('subject/manage/') ?>'+$(this).attr('data-id'))
                })
            })
            $('.remove_subject').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_dept',[$(this).attr('data-id')])
                })
            })
            $('#subject-field').dataTable()
        }
    })
}
function remove_dept($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>subject/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_subject()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){

    if('<?php echo !!$this->session->flashdata('action_subject') ? $this->session->flashdata('action_subject') :'' ?>' == 1)
        Dtoast('Data successfully Saved.','success')
    
    
    load_subject();
})
</script>
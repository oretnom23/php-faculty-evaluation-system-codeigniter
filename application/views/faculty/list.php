<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="javascript:void(0)" onclick="frmModal('manage-faculty','New Faculty','<?php echo base_url('faculty/manage') ?>')" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New faculty</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="faculty-field">

                    <colgroup>
                        <col width="5%">
                        <col width="40%">
                        <col width="40%">
                        <col width="15%">
                    </colgroup>
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
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
window.load_faculty = function (){
    $('#faculty-field').dataTable().fnDestroy();
    $('#faculty-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('faculty/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#faculty-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].name+'</td>')
                    tr.append('<td>'+resp[k].dname+' Department</td>')
                    tr.append('<td><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_faculty" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_faculty" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></td>')

                $('#faculty-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#faculty-field').dataTable()
            $('.edit_faculty').each(function(e){
                $(this).click(function(){
                    frmModal('manage-faculty','Edit Faculty','<?php echo base_url('faculty/manage/edit/') ?>'+$(this).attr('data-id'))
                })
            })
            $('.remove_faculty').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_faculty',[$(this).attr('data-id')])
                })
            })
        }
    })
}
function remove_faculty($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>faculty/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_faculty()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){
    
    if('<?php echo $this->session->flashdata('action_fac') ?>' == 1)
            Dtoast("Data successfully added",'success');
    load_faculty();
})
</script>
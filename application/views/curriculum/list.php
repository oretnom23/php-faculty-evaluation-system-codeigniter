<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('curriculum/manage') ?>" class="btn btn-info float-right"><i class="fa fa-plus"></i> New Level</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="curriculum-field">

                    <colgroup>
                        <col width="5%">
                        <col width="30%">
                        <col width="30%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Section</th>
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
window.load_curriculum = function (){
    $('#curriculum-field').dataTable().fnDestroy();
    $('#curriculum-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('curriculum/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#curriculum-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].course+'</td>')
                    tr.append('<td>'+resp[k].year+'</td>')
                    tr.append('<td>'+resp[k].section+'</td>')
                    tr.append('<td><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_curriculum" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_curriculum" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></td>')

                $('#curriculum-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#curriculum-field').dataTable()
            $('.edit_curriculum').each(function(e){
                $(this).click(function(){
                    location.replace('<?php echo base_url() ?>curriculum/manage/edit/'+$(this).attr('data-id'))
                })
            })
            $('.remove_curriculum').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_curriculum',[$(this).attr('data-id')])
                })
            })
        }
    })
}
function remove_curriculum($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>curriculum/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_curriculum()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){
    
    if('<?php echo $this->session->flashdata('action_cur') ?>' == 1)
            Dtoast("Data successfully added",'success');
    load_curriculum();
})
</script>
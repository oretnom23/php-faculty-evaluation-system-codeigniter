<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('course/manage') ?>" class="btn btn-info float-right"><i class="fa fa-plus"></i> New Course</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="course-field">

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
                            <?php if($_SESSION['login_user_type'] == 1): ?>
                            <th>Department</th>
                             <?php endif; ?>
                            <th>Name</th>
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
window.load_course = function (){

    $('#course-field tbody').html('<tr><td colspan="4">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('course/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#course-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    if(<?php echo $_SESSION['login_user_type'] ?>== 1)
                    tr.append('<td>'+resp[k].department+'</td>')
                    tr.append('<td>'+resp[k].course+'</td>')
                    tr.append('<td>'+resp[k].description+'</td>')
                    tr.append('<td><center><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_course" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_course" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></center></td>')

                $('#course-field tbody').append(tr)

                    
                })
                

                

                }
            }
        },
        complete:()=>{

            $('.edit_course').each(function(e){
                $(this).click(function(){
                    location.replace('<?php echo base_url() ?>course/manage/edit/'+$(this).attr('data-id'))
                })
            })
            $('.remove_course').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_dept',[$(this).attr('data-id')])
                })
            })
            $('#course-field').dataTable()
        }
    })
}
function remove_dept($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>course/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_course()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){

    if('<?php echo $this->session->flashdata('action_dept') ?>' == 1)
        Dtoast('Data successfully Saved.','success')
    
    
    load_course();
})
</script>
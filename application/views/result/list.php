<div class="col-md-12 mt1 mb1">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header"><b>Result</b></div>
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="faculty-field">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Name</th>
                            <?php if($_SESSION['login_user_type'] == 1): ?>
                            <th>Department</th>
                            <?php endif; ?>
                            <th width="30%">Evaluation</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
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
                    tr.append('<td class="text-center">'+i+'</td>')
                    tr.append('<td>'+resp[k].name+'</td>')
                    if(<?php echo $_SESSION['login_user_type'] ?> == 1)
                    tr.append('<td>'+resp[k].dname+' Department</td>')
                    tr.append('<td class="text-center"><button type="button" class="btn btn-sm btn-primary waves-effec view_student_eval" data-id="'+resp[k].id+'">Student</button><button type="button" class="btn btn-sm btn-primary waves-effec view_chairperson_eval" data-id="'+resp[k].id+'">Chairperson</button></td>')

                $('#faculty-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#faculty-field').dataTable()
            $('.view_student_eval').each(function(e){
                $(this).click(function(){
                   location.href = '<?php echo base_url('evaluation/result_student/') ?>'+$(this).attr('data-id')
                })
            })
            $('.view_chairperson_eval').each(function(e){
                $(this).click(function(){
                   location.href = '<?php echo base_url('evaluation/result_chairperson/') ?>'+$(this).attr('data-id')
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
<div class="col-md-12 mt1 mb1">
    <div class="row">
        <a href="<?php echo base_url('student/manage') ?>" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New Student</a>
    </div>
</div>

<div class="col-md-12 mt1 mb1">
    <div class="row">

        <div class="card col-md-12">
            <div class="card-body">

                <table class="table table-bordered table-striped" width="100%" id="student-field">

                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="30%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID #</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Level/Section</th>
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
window.load_student = function (){
    $('#student-field').dataTable().fnDestroy();
    $('#student-field tbody').html('<tr><td colspan="6">Loading data.</td></tr>')
    $.ajax({
        url:'<?php echo base_url('student/load_list') ?>',
        method:'POST',
        data:{},
        error:err=>console.log(err),
        success:function(resp){
            if(resp){
                if(typeof resp != undefined){
                $('#student-field tbody').html('')
                resp = JSON.parse(resp)
                var i = 0;
                Object.keys(resp).map(k=>{
                    i++;
                    var tr = $('<tr>')
                    tr.append('<td>'+i+'</td>')
                    tr.append('<td>'+resp[k].student_code+'</td>')
                    tr.append('<td>'+resp[k].name+'</td>')
                    tr.append('<td>'+resp[k].dname+' Department</td>')
                    tr.append('<td>'+resp[k].cl+'</td>')
                    tr.append('<td><button type="button" class="btn btn-sm btn-outline-primary btn-rounded waves-effec edit_student" data-id="'+resp[k].id+'"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-sm btn-outline-danger btn-rounded waves-effec remove_student" data-id="'+resp[k].id+'"><i class="fa fa-trash"></i></button></td>')

                $('#student-field tbody').append(tr)

                    
                })
                

                }
            }
        },
        complete:()=>{
            $('#student-field').dataTable()
            $('.edit_student').each(function(e){
                $(this).click(function(){
                    location.replace('<?php echo base_url() ?>student/manage/'+$(this).attr('data-id'))
                })
            })
            $('.remove_student').each(function(e){
                $(this).click(function(){
                    delete_data('Are you sure to delete this data?','remove_student',[$(this).attr('data-id')])
                })
            })
        }
    })
}
function remove_student($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>student/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
             load_student()
             $('.modal').modal('hide')
            }
        }
    })
}
$(document).ready(function(){
    
    if('<?php echo $this->session->flashdata('action_save_student') ?>' == 1)
            Dtoast("Data successfully added",'success');
    load_student();
})
</script>
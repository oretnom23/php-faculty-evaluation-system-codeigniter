<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
        <h3 class="h3-responsive text-dark"><strong><?php echo "SY ".$meta['school_year'] ?> <?php echo $meta['semester'].' Sem' ?><strong></h3>
        <hr>
        <a class="btn btn-sm btn-primary" id="create_evaluation" href="<?php echo base_url('evaluation/manage_questionaire/').$meta['id'].'/1' ?>">Manage Students Questionaire <i class="fa fa-list"></i></a>
        <a class="btn btn-sm btn-primary" id="create_evaluation" href="<?php echo base_url('evaluation/manage_questionaire/').$meta['id'].'/2' ?>">Manage Chairperson Questionaire <i class="fa fa-list"></i></a>
        <button class="btn btn-sm btn-success" id="add_restriction">Restrict Evaluation <i class="fa fa-list"></i></button>
        <hr>
        <div class="col-md-4 offset-md-4 md-form input-group">
            <input type="text" id="filter" class="form-control" placeholder="Search Faculty Here">
            <div class="input-group-append">
                <span><i class="fa fa-search"></i></span>
            </div>
        </div>
        <div class="col-md-12" id="faculty-list">

        

        </div>
        </div>
    </div>
</div>
<div id="clone-faculty" style="display:none">
    <div class="alert alert-info float-right ml-2 mt-2 mb-2mr-2 col-md-3">
    <i class="fas fa-user-tie"></i>
    <span><b class='name'>Test</b></span>
    <hr>
        <a href="javascript:void(0)" class="float-right view_handles">Handled Classes <i class="fa fa-angle-right"></i></a>
    </div>
</div>
<style>
#faculty-list{
    display:flex
}
</style>

<script>
$('#add_restriction').click(function(){
    frmModal('manage_restriction','New Restriction','<?php echo base_url('evaluation/manage_restriction/').$meta['id'] ?>',[],'mid-large')
})
$(document).ready(function(){
    if('<?php echo $this->session->flashdata('action_save_restriction') ?>' == 1)
            Dtoast("Data successfully added",'success');
            load_faculty();

    $('#filter').keyup(function(){
        var _filter  = $(this).val().toLowerCase();
        $('#faculty-list .alert').each(function(){
            var _name = $(this).find('.name').html().toLowerCase()
            if(_name.includes(_filter) == true){
                $(this).toggle(true)
            }else{
                $(this).toggle(false)
            }
        })
    })
})
window.load_faculty = function(){
    start_load();
    $.ajax({
        url:'<?php echo base_url('evaluation/load_faculty') ?>',
        method:'POST',
        data:{id:'<?php echo $meta['id'] ?>'},
        success:function(resp){
            resp = JSON.parse(resp);
            Object.keys(resp).map(k=>{
                var _f = $('#clone-faculty .alert').clone()

                _f.find('.name').html(resp[k].name)
                _f.find('.view_handles').attr('data-id',resp[k].id)
                $('#faculty-list').append(_f)
            })
        },
        complete:function(){
            end_load()
            $('.view_handles').click(function(){
                frmModal('','Class List of : '+$(this).parent().find('.name').html(),'<?php echo base_url('evaluation/view_handles/').$meta['id'].'/' ?>'+$(this).attr('data-id'))
            })
        }
    })
}
</script>

<?php
if(!empty($id)){
    $qry = $this->db->get_where("chairperson_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<style>
input[type="checkbox"], #rlabel{
    cursor:pointer
}
#rlabel:hover{
    text-decoration:underline
}
</style>
<div class="col-md-12 mb2 mt2">
    <div class="card">
            <h5 class="card-header info-color white-text text-center py-4">
                <strong><?php echo isset($id) && $id > 0 ? "Manage Chairperson" : "New Chairperson" ?></strong>
            </h5>
        <div class="card-body px-lg-5 pt-0">
            
            <form action="" id="manage-chairperson">

             <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="md-form mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" id="lname" name="lname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : "" ?>" required>
                        <label for="lname"  > Last Name</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="fname" name="fname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : "" ?>" required>
                        <label for="fname"  >First Name</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" id="middlename" name="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : "" ?>">
                        <label for="middlename"  >Middle Name</label>
                    </div>
                    <div class="col-md-2">
                        <br>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
            <div class="mt-3 md-form col-md-4">
                <input type="text" id="id_code" name="id_code" class="form-control" value="<?php echo isset($meta['id_code']) ? $meta['id_code'] : "" ?>" required>
                <label for="id_code"  > ID #</label>
            </div>
            <?php if($_SESSION['login_user_type'] == 1): ?>
            <div class="col-md-4">
                        <label for="department_id" >Department</label>
                        <?php
                            $dept = $this->db->query("SELECT * from department_list where status = 1");
                        ?>
                        <select id="department_id" name="department_id" class="browser-default custom-select select2" required>
                            <?php if(empty($id)): ?>
                                <option value="" selected disabled>Select Here</option>
                            <?php endif; ?>
                            <?php
                                foreach($dept->result_array() as $row){
                                    if(isset($meta['department_id']) && $meta['department_id'] == $row['id'])
                                    echo "<option value='".$row['id']."' selected data-did='{$row['id']}'>".$row['department']."</option>";
                                    else
                                    echo "<option value='".$row['id']."' data-did='{$row['id']}'>".$row['department']."</option>";
                                }
                            ?>
                        </select>
            </div>
            <?php else: ?>
            <input type="hidden" id="department_id" name="department_id" value="<?php echo $_SESSION['login_department_id'] ?>">
            <?php endif; ?>
            <div class="col-md-4">
                <label for="course_id" >Course</label>
                <?php
                    $course = $this->db->query("SELECT * from courses where status = 1 ".($_SESSION['login_user_type'] != 1 ? " and department_id = {$_SESSION['login_department_id']}  ":''));
                ?>
                <select id="course_id" name="course_id" class="browser-default custom-select select2" required>
                    <?php if(empty($id)): ?>
                        <option value="" selected disabled>Select Here</option>
                    <?php endif; ?>
                    <?php
                        foreach($course->result_array() as $row){
                            if(isset($meta['course_id']) && $meta['course_id'] == $row['id'])
                            echo "<option value='".$row['id']."' selected data-did='{$row['id']}'>".$row['course']."</option>";
                            else
                            echo "<option value='".$row['id']."' data-did='{$row['id']}'>".$row['course']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mt-3 md-form col-md-4">
               <div id="msg"></div>
            </div>
            </div>
            <?php if($id > 0): ?>
            <div class=" mt-3">
            <label for="">Auto Generated Password</label>
                <p><b><?php echo isset($meta['auto_generated']) ? $meta['auto_generated'] : '' ?></b></p>
            </div>
            <div class=" mb-5">
                    <label for="regen" id="rlabel"><input type="checkbox" name='regen' value="1" id="regen"> <small><i> Check this only when you need to reset the chairperson password to a new generated password</i></small></label>
                     
            </div>
            <?php endif; ?>
            <div class="md-form">
            <center><button class="btn btn-outline-info btn-sm btn-block z-depth-0 my-4 waves-effect col-md-2" type="submit">Save</button></center>

            </div>



            </form>
        </div>
    </div>
</div>

<script>
$('#cl_id').change(function(){
    $('[name="department_id"]').val($('#cl_id option[value="'+$(this).val()+'"]').attr('data-did'))
})
$('.select2').select2({
    width:'100%'
})
    $('input').trigger('focus')
    $('input, textarea').trigger('blur')
    $(document).ready(function(){
        if('<?php echo $this->session->flashdata('action_save_chairperson') ?>' == 1)
            Dtoast("Data successfully added",'success');
        $('#manage-chairperson').submit(function(e){
            e.preventDefault()
            start_load()
            $('#msg').html('')
            var frmData = $(this).serialize();
            console.log(frmData)
            $('button[type="submit"]').attr('disable',true).html('Saving ...')
            $.ajax({
                url:'<?php echo base_url('chairperson/save_chairperson') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    resp = JSON.parse(resp)
                    if(resp.status == 1){
                        if('<?php echo $id ?>' > 0)
                            location.reload();
                        else{
                        location.replace('<?php echo base_url('chairperson/list') ?>')

                        }
                    }else{
                        $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
                        end_load()
                    }
                }
            })
        })
    })
</script>
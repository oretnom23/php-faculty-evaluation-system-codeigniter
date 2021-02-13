<?php
if(!empty($id)){
$user = $this->db->get_where('users',array('id'=>$id));
foreach($user->row() as $k=> $v){
    $$k = $v;
}
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div id="msg"></div>
        <div class="form-group">
            <label for="" class="control-label">First Name</label>
            <input type="text" class="form-control" name="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Middle Name</label>
            <input type="text" class="form-control" name="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>">
        </div>
        <div class="form-group">
            <label for="" class="control-label">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo isset($username) ? $username : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Password</label>
            <input type="password" class="form-control" name="password" value="" required>
            <?php if($id > 0): ?>
                <small><i>Leave this blank if you dont want to update the password</i></small>
            <?php endif; ?>
        </div>
        <?php if($_SESSION['login_user_type'] == 1): ?>
        <div class="form-group">
            <label for="" class="control-label">User Type</label>
            <select name="user_type" id="" class="custom-select browser-default">
                <option value="1" <?php echo isset($user_type) && $user_type == 1 ? "selected": '' ?>>Admin</option>
                <option value="2" <?php echo isset($user_type) && $user_type == 2 ? "selected": '' ?>>Staff</option>
                <option value="3" <?php echo isset($user_type) && $user_type == 3 ? "selected": '' ?>>Dean</option>
            </select>
        </div>
        <div class="form-group" id="not-admin" style="display:none">
            <label for="" class="control-label">Department</label>
            <select name="department_id" id="" class="custom-select browser-default">
                <option value="0" <?php echo isset($department_id) && $department_id == 0 ? "selected": '' ?>>N/A</option>
                <?php 
                    $dept = $this->db->get_where("department_list",array("status"=>1));
                    foreach($dept->result_array() as $row):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? "selected": '' ?>><?php echo $row['department'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
$('[name="user_type"]').change(function(){
    if($(this).val() > 1){
        $('#not-admin').show()
    }else{
        $('#not-admin').hide()
    }
})
   $(document).ready(function(){
    $('[name="user_type"]').trigger('change')
    $('#manage-users').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'<?php echo base_url('cogs/save_users') ?>',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                Dtoast("An error occured","error")
                    end_load()
                
            },
            success:function(resp){
                resp = JSON.parse(resp)
                if(resp.status == 1){
                    Dtoast("User's Data Successfully Saved","success")
                    setTimeout(function(){
                        location.reload();
                    },1000)
                }else{
                    $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
                    end_load()
                }
            }
        })
    })
   })
</script>
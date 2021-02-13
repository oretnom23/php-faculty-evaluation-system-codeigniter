<?php
if(!empty($id)){
$user = $this->db->get_where('student_list',array('id'=>$id));
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
            <label for="" class="control-label">New Password</label>
            <input type="password" class="form-control" name="npassword" id="np" value="" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Confirm New Password</label>
            <input type="password" class="form-control" id="cnp" value="" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Old Password</label>
            <input type="password" class="form-control" id="op" name="opassword" value="" required>
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
    $('#manage-users').submit(function(e){
        e.preventDefault()
        $('#msg').html('')
        var np = $('#np').val();
        var cnp = $('#cnp').val();
        var op = $('#op').val();
        if(np != cnp){
            $('#msg').html('<div class="alert alert-danger">New Password do not match</div>')
            return false;
        }
        start_load()
        $.ajax({
            url:'<?php echo base_url('cogs/update_password') ?>',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                Dtoast("An error occured","error")
                    end_load()
                
            },
            success:function(resp){
                if(resp == 1){
                    Dtoast("Password successfully updated","success")
                    setTimeout(function(){
                        location.reload();
                    },1000)
                }else if(resp == 2){
                    $('#msg').html('<div class="alert alert-danger">Old Password do not match.</div>')
                    end_load()
                }
            }
        })
    })
   })
</script>
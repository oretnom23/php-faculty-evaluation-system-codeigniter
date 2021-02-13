<?php
if(!empty($id)){
    $qry = $this->db->get_where("faculty_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-md-12 mb2 mt2">
   
            

             <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="md-form mt-3">
                        <input type="text" id="lname" name="lname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : "" ?>" required>
                        <label for="lname"  > Last Name</label>
            </div>
            <div class="md-form mt-3">
                        <input type="text" id="fname" name="fname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : "" ?>" required>
                        <label for="fname"  >First Name</label>
            </div>
            <div class="md-form mt-3">
                        <input type="text" id="pref" name="pref" class="form-control" value="<?php echo isset($meta['name_pref']) ? $meta['name_pref'] : "" ?>">
                        <label for="pref"  >Prefix</label>
                        <span><small>(SR., Jr.)</small></span>
            </div>

            <?php if($_SESSION['login_user_type'] == 1): ?>
            <div class=" mt-3">
                        <label for="department" >Department</label>
                        <?php
                            $dept = $this->db->query("SELECT * from department_list where status = 1");
                        ?>
                        <select type="text" id="department" name="department" class="browser-default custom-select" required>
                            <?php if(empty($id)): ?>
                                <option value="" selected disabled>Select Department</option>
                            <?php endif; ?>
                            <?php
                                foreach($dept->result_array() as $row){
                                    if(isset($meta['department_id']) && $meta['department_id'] == $row['id'])
                                    echo "<option value='".$row['id']."' selected>".$row['department']."</option>";
                                    else
                                    echo "<option value='".$row['id']."'>".$row['department']."</option>";
                                }
                            ?>
                        </select>
            </div>
            <?php else: ?>
            <input type="hidden" id="department" name="department" value="<?php echo $_SESSION['login_department_id'] ?>">
            <?php endif; ?>
</div>

<script>
   
    $(document).ready(function(){
        $('input').trigger('focus')
        $('input, textarea').trigger('blur')
        $('input, textarea').trigger('change')
        $('#manage-faculty').submit(function(e){
            e.preventDefault()
            var frmData = $(this).serialize();
            start_load()
            $.ajax({
                url:'<?php echo base_url('faculty/save_faculty') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.reload()
                    }
                }
            })
        })
    })
</script>
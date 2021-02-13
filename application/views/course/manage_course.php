<?php 
if(!empty($id)){
    $qry = $this->db->query("SELECT * FROM courses where id = '$id' ");
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-md-12 mb2 mt2">
    <div class="card">
            <h5 class="card-header info-color white-text text-center py-4">
                <strong><?php echo isset($id) && $id > 0 ? "Manage Course" : "New Course" ?></strong>
            </h5>
        <div class="card-body px-lg-5 pt-0">
            
            <form action="" id="manage-course">

            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <?php if($_SESSION['login_user_type'] == 1): ?>
            <div class="form-group row mt-3">
                <div class="col-md-6">
                    <label for="department_id"  required>Department</label>
                    <select name="department_id" id="department_id" class="custom-select browser-default" required>
                        <option value=""></option>
                        <?php
                        $qry = $this->db->query("SELECT * FROM department_list where status = 1 order by department asc");
                        foreach($qry->result_array() as $row):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['department_id']) && $meta['department_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['department'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php else: ?>
            <input type="hidden" id="department_id" name="department_id" value="<?php echo $_SESSION['login_department_id'] ?>">
            <?php endif; ?>

            <div class="md-form mt-3">
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($meta['course']) ? $meta['course'] : "" ?>">
                <label for="name"  required>Name</label>
            </div>

            <div class="md-form">
                <textarea id="description" class="form-control md-textarea" rows="2" name="description" required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
                <label for="description">Description</label>
            </div>


            

            <center><button class="btn btn-outline-info btn-sm btn-block z-depth-0 my-4 waves-effect col-md-2" type="submit">Save</button></center>


            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    $('#name').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')
        $('#manage-course').submit(function(e){
            e.preventDefault()
            var frmData = $(this).serialize();
            $('button[type="submit"]').attr('disable',true).html('Saving ...')
            $.ajax({
                url:'<?php echo base_url('course/save_course') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.replace('<?php echo base_url('course/index/1') ?>')
                    }
                }
            })
        })
    })
</script>
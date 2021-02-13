<?php
if(!empty($id)){
    $qry = $this->db->get_where("curriculum_level_list",array('id'=>$id));
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
                <strong><?php echo isset($id) && $id > 0 ? "Manage curriculum" : "New curriculum" ?></strong>
            </h5>
        <div class="card-body px-lg-5 pt-0">
            
            <form action="" id="manage-curriculum">

             <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="form-group mt-3">
                <div class="row">
                    <div class="col-md-4">
                    <label for="course_id"  required>Course</label>
                    <select name="course_id" id="course_id" class="custom-select browser-default" required>
                        <option value=""></option>
                        <?php
                        $qry = $this->db->query("SELECT * FROM courses where status = 1 order by course asc");
                        foreach($qry->result_array() as $row):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['course_id']) && $meta['course_id'] == $row['id'] ? 'selected' : '' ?> data-did="<?php echo  $row['department_id'] ?>"><?php echo $row['course'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="col-md-2 md-form">
                        <input type="number" id="year" name="year" class="form-control" value="<?php echo isset($meta['year']) ? $meta['year'] : "" ?>" required>
                        <label for="year"  >Year Level</label>
                    </div>
                    <div class="col-md-3 md-form">
                        <input type="text" id="section" name="section" class="form-control" value="<?php echo isset($meta['section']) ? $meta['section'] : "" ?>" required>
                        <label for="section"  >Section</label>
                    </div>
                </div>
                
                
            </div>

           <input type="hidden" name="department_id" value="<?php echo isset($meta['department_id']) ? $meta['department_id']: '' ?>">

            

            <center><button class="btn btn-outline-info btn-sm btn-block z-depth-0 my-4 waves-effect col-md-2" type="submit">Save</button></center>


            </form>
        </div>
    </div>
</div>

<script>
    $('input').trigger('focus')
    $('input, textarea').trigger('blur')
    $('#course_id').change(function(){
        $('[name="department_id"]').val($('#course_id option[value="'+$(this).val()+'"]').attr('data-did'))
    })
    $(document).ready(function(){
        $('#manage-curriculum').submit(function(e){
            e.preventDefault()
            start_load()
            var frmData = $(this).serialize();
            $.ajax({
                url:'<?php echo base_url('curriculum/save_curriculum') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.replace('<?php echo base_url('curriculum') ?>')
                    }else if(resp == 2){
                        Dtoast("Level and Section already exist.","warning")
                        end_load()
                    }
                }
            })
        })
    })
</script>
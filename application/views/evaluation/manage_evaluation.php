<?php
if(!empty($id)){
    $qry = $this->db->get_where("evaluation_list",array('id'=>$id));
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="col-md-12 mb2 mt2">
            

             <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="md-form mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="school_year" name="school_year" class="form-control" value="<?php echo isset($meta['school_year']) ? $meta['school_year'] : "" ?>" required>
                        <label for="school_year"  > School Year</label>
                    </div>
                </div>
            </div>
            <div class="md-form mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" id="semester" name="semester" class="form-control" value="<?php echo isset($meta['semester']) ? $meta['semester'] : "" ?>" required>
                        <label for="semester"  > Semester</label>
                    </div>
                </div>
            </div>

        </div>
 

<script>
    $(document).ready(function(){
    $('#name').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')
        $('#manage_evaluation').submit(function(e){
            e.stopImmediatePropagation();
            e.preventDefault()
            var frmData = $(this).serialize();
            start_load()
            $.ajax({
                url:'<?php echo base_url('evaluation/save_evaluation') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp > 0){
                        location.replace('<?php echo base_url('evaluation/evaluation_view/') ?>'+resp)
                    }
                }
            })
        })
    })
</script>
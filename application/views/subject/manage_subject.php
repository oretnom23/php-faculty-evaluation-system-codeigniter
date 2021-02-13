<?php 
if(!empty($id)){
    $qry = $this->db->query("SELECT * FROM subjects where id = '$id' ");
    $meta = array();
    foreach($qry->result_array() as $row){
        foreach($row as $key => $val){
            $meta[$key] = $val;
        }
    }
}
?>
<div class="container-fluid">
    <div class="col-lg-12">

            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
            <div class="md-form mt-3">
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($meta['subject']) ? $meta['subject'] : "" ?>">
                <label for="name"  required>Name</label>
            </div>
            <div class="md-form">
                <textarea id="description" class="form-control md-textarea" rows="2" name="description" required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
                <label for="description">Description</label>
            </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    $('#name').trigger('focus')
    $('input, textarea').trigger('blur')
    $('input, textarea').trigger('change')
        $('#manage-subject').submit(function(e){
            e.preventDefault()
            var frmData = $(this).serialize();
            start_load()
            $.ajax({
                url:'<?php echo base_url('subject/save_subject') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.reload('')
                    }
                }
            })
        })
    })
</script>
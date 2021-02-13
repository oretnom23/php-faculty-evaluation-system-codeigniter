<?php 
if(!empty($id)){
    $qry = $this->db->query("SELECT * FROM department_list where id = '$id' ");
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
                <strong><?php echo isset($id) && $id > 0 ? "Manage department" : "New department" ?></strong>
            </h5>
        <div class="card-body px-lg-5 pt-0">
            
            <form action="" id="manage-department">

            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
             
            <div class="md-form mt-3">
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($meta['department']) ? $meta['department'] : "" ?>">
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
    $('textarea').trigger('change')
        $('#manage-department').submit(function(e){
            e.preventDefault()
            var frmData = $(this).serialize();
            console.log(frmData)
            $('button[type="submit"]').attr('disable',true).html('Saving ...')
            $.ajax({
                url:'<?php echo base_url('department/save_department') ?>',
                method:'POST',
                data:frmData,
                error:err=>{ console.log(err)},
                success:function(resp){
                    if(resp == 1){
                        location.replace('<?php echo base_url('department/index/1') ?>')
                    }
                }
            })
        })
    })
</script>
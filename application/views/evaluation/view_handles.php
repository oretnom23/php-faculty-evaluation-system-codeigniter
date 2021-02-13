<?php
$list = $this->db->query("SELECT r.*,concat(co.course,' ' ,c.`year`,'-',c.section) as cl,s.subject FROM restriction_list r inner join curriculum_level_list c on c.id = r.curriculum_id inner join courses co on co.id = c.course_id inner join subjects s on s.id = r.subject_id where r.evaluation_id = '$eid' and r.faculty_id ='$fid' order by concat(co.course,' ' ,c.`year`,'-',c.section) asc ");
?>

<div class="container-fluid">
    <table class="table table-stripped table-bordered">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Class</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($list->result_array() as $row){
                $eid= $row['evaluation_id'];
            ?>
            <tr>
                <td class="text-center"><?php echo $i++ ?></td>
                <td><?php echo $row['cl'] ?></td>
                <td><?php echo $row['subject'] ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="modal-footer display">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-secondary float-right" type="button" id="" data-dismiss="modal">Close</button>
            <button class="btn btn-primary float-right" type="button" id="edit_list">Edit</button>
        </div>
    </div>
</div>
<style>
 #frm_modal .modal-footer{
     display:none;
 }
 #frm_modal .modal-footer.display{
     display:block;
 }
</style>
<script>
$('#edit_list').click(function(){
    frmModal('manage_restriction','Edit Restriction','<?php echo base_url('evaluation/manage_restriction/').$eid.'/'.$fid ?>',[],'mid-large')
})
</script>
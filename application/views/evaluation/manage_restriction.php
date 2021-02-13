<?php
if($fid > 0){
    $qry = $this->db->query("SELECT * from restriction_list where faculty_id = $fid and evaluation_id = $eid ");
    $cids = array_column($qry->result_array(),'curriculum_id','id');
}

?>
<div class="container-fluid">
    <div class="col-lg-12">
        <input type="hidden" name="eid" value="<?php echo $eid ?>">
        <div class="mt-2">
            <label for="faculty_id">Faculty</label>
            <select name="faculty_id" id="faculty_id" class="select2" required>
            <option value=""></option>
            <?php 
                $faculty = $this->db->query("SELECT *,concat(firstname,' ', lastname,' ',name_pref) as name FROM faculty_list where status = 1 and id not in (SELECT faculty_id from restriction_list where evaluation_id = '$eid' and faculty_id!='$fid') ");
                foreach($faculty->result_array() as $row):
            ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($fid) && $fid == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <hr>
        <div class="mt-2">
            <label for="cl_id">Class</label>
            <select id="cl_id" class="select2 form-control" required>
            <?php 
                $cl = $this->db->query("SELECT c.*,concat(co.course,' ',`year`,'-',section) as cls,co.department_id from curriculum_level_list c inner join courses co on co.id = c.course_id where c.status = 1");
                foreach($cl->result_array() as $row):
            ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($cids) && in_array($row['id'],$cids) ?"selected" : '' ?>> <?php echo $row['cls'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <div class="mt-2">
            <label for="subject">Subject</label>
            <select id="subject" class="select2 form-control" required>
            <?php 
                $subject = $this->db->query("SELECT * from `subjects` where status = 1");
                foreach($subject->result_array() as $row):
            ?>
                <option value="<?php echo $row['id'] ?>"> <?php echo $row['subject'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-sm btn-primary float-right" type="button" id="add_to_list">Add to List</button>
        <hr>
        <br>
        <table class="table table-bordered" id="r-list">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $list = $this->db->query("SELECT r.*,concat(co.course,' ' ,c.`year`,'-',c.section) as cl,s.subject FROM restriction_list r inner join curriculum_level_list c on c.id = r.curriculum_id inner join courses co on co.id = c.course_id inner join subjects s on s.id = r.subject_id where r.evaluation_id = '$eid' and r.faculty_id ='$fid'  order by concat(co.course,' ' ,c.`year`,'-',c.section) asc ");
               foreach($list->result_array() as $row):
                ?>
                <tr>
                <td><input name="cl_id[]" type="hidden" value="<?php echo $row['curriculum_id'] ?>"><?php echo $row['cl'] ?></td>
                <td><input name="subject_id[]" type="hidden" value="<?php echo $row['subject_id'] ?>"><?php echo $row['subject'] ?></td>
                <td><button class="btn btn-outline-danger btn-sm" type="button" onclick="rem_this($(this))"><i class="fa fa-times"></i></button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    
    </div>
</div>
<script>
$('#faculty_id').select2({
    placeholder: 'Please select here',
    width:'100%'
    
})
$('#cl_ids').select2({
    width:'100%'
})
$('#add_to_list').click(function(){
    if($('#cl_id').val() == '' || $('#subject').val() == ''){
        alert_toast("Please select a class and subject first.",'warning')
        return false;
    }
    var tr = $('<tr></tr')
    var cl_id = $('#cl_id').val()
    var subject = $('#subject').val()
    var className = $('#cl_id').find('option[value="'+cl_id+'"]').text()
    var subjectName = $('#subject').find('option[value="'+subject+'"]').text()
    tr.append('<td><input name="cl_id[]" type="hidden" value="'+cl_id+'">'+className+'</td>')
    tr.append('<td><input name="subject_id[]" type="hidden" value="'+subject+'">'+subjectName+'</td>')
    tr.append('<td><button class="btn btn-outline-danger btn-sm" type="button" onclick="rem_this($(this))"><i class="fa fa-times"></i></button></td>')
    $('#r-list tbody').append(tr)
})
function rem_this(_this){
    _this.closest('tr').remove()
}
$(document).ready(function(){
    $('#manage_restriction').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
        url:'<?php echo base_url('evaluation/save_restriction') ?>',
        method:'POST',
        data:$(this).serialize(),
        success:function(resp){
            if(resp == 1){
                location.reload();
            }else{
                Dtoast('Ad error occured','error')
                end_load()
            }
        }
    })
})
})
</script>
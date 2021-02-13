<?php 
$sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
foreach($sy as $k => $v){
    $e_arr[$k] = $v;
}
$courses = $this->db->query("SELECT *,cl.course_id FROM restriction_list r inner join curriculum_level_list cl on cl.id = r.curriculum_id where r.faculty_id = $fid and r.evaluation_id = {$e_arr['id']} ");
$c_arr = array_column($courses->result_array(), 'course_id', 'course_id');
if(count($c_arr) > 0){
    $class = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name from chairperson_list where course_id in (".implode(",",$c_arr).") ".($_SESSION['login_user_type'] != 1 ? " and department_id = '{$_SESSION['login_department_id']}' ":""))->result_array();
}
// var_dump($class)
$cid = isset($_GET['cid']) ? $_GET['cid']: '';
?>
<style>
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
        <large><b>Chairperson's Evaluation Result of Faculty</b></larger>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if(count($c_arr) > 0): ?>
                <?php foreach($class as $row ): ?>
                    <button class="btn <?php echo empty($cid)? "btn-info" : ($cid == $row['id'] ? "btn-info" : "btn-primary") ?> btn-sm class_btn" data-cid='<?php echo $row['id'] ?>' type="button"><?php echo $row['name'] ?></button>
                    <?php 
                        if(empty($cid))
                        $cid = $row['id'];
                    ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php 
                if(count($c_arr) > 0):
                $criteria=array();
                $ans=array();
                $count=array();
                $criteria_qry = $this->db->query("SELECT * FROM criteria where id in (SELECT criteria_id from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 2 ) order by order_by asc");
                foreach($criteria_qry->result_array() as $row):
                    $criteria[$row['order_by']] = $row;
                    if($row['parent_id'] > 0){
                        $data =  $controller->get_parent($row['parent_id']);
                        foreach ($data as $v) {
                           $criteria[$v['order_by']] = $v;
                        }
                    }
                endforeach;
                ksort($criteria);
                $question =  $this->db->query("SELECT * from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 2");
                
                $answers_qry = $this->db->query("SELECT a.*,c.id as cid FROM answers a inner join question_list q on q.id = a.question_id inner join criteria c on c.id = q.criteria_id where a.evaluation_id = '{$e_arr['id']}'  and a.chairperson_id ={$cid} and a.faculty_id='$fid' and q.type = 1  ")->result_array();
                foreach($answers_qry as $row){
                    if(!isset($ans[$row['cid']]))
                        $ans[$row['cid']] = 0;
                    if(!isset($count[$row['cid']]))
                        $count[$row['cid']] = 0;
                        $count[$row['cid']] += 1;
                    $ans[$row['cid']] += $row['answer'];
                }
                foreach($question->result_array() as $row):
                    $criteria_q[$row['criteria_id']][] = $row;
                endforeach;
                $i = 1;
            ?>
                <div class="" style="">
                    <table class="table table-bordered" id='criteria-list'>
                        <thead>
                            <tr class="bg-primary text-white">
                                <th>Criteria</th>
                                <th>Average</th>
                                <th>Interpretation</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>Overall Average</th>
                                <th class="text-center" id="oa"></th>
                                <th class="text-center" id="interpretation"></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <h4>No Class Assigned to selected faculty for <?php echo 'SY '.$e_arr['school_year'].' '.$e_arr['semester']." Semester" ?></h4>
                <?php endif; ?>
                </div>
        </div>
    </div>
</div>
<script>
    var criteria = '<?php echo json_encode($criteria) ?>';
    var ans = '<?php echo json_encode($ans) ?>';
    var count = '<?php echo json_encode($count) ?>';
    criteria =JSON.parse(criteria);
    count =JSON.parse(count);
    ans =JSON.parse(ans);
    var oa =0;
    var i = 0;
    if(Object.keys(criteria).length > 0){
        Object.keys(criteria).map(k=>{
            i++;
            var level = $('#criteria-list tbody tr[data-id="'+criteria[k].parent_id+'"]').length > 0 ? $('#criteria-list tbody tr[data-id="'+criteria[k].parent_id+'"]').attr('data-level') : 0 ; 
            level++;

            var margin = 25 * parseFloat(level);
            var ave = ans[criteria[k].id] / count[criteria[k].id];
            oa = parseFloat(oa)  + parseFloat(ans[criteria[k].id] != undefined ? ave : 0);
            var tr = $('<tr class="text-dark" data-id="'+criteria[k].id+'" data-parent_id="'+criteria[k].parent_id+'" data-level="'+level+'"></tr>')
            var interpretation;
            if(ave > 0)
                interpretation = 'Poor';
            if(ave > 1 )
                interpretation = 'Fair';
            if(ave > 2 )
                interpretation = 'Satisfactory';
            if(ave > 3 )
                interpretation = 'Ver Satisfactory';
            if(ave > 3 )
                interpretation = 'Outstanding';
            tr.append('<td><p style="margin-left:'+margin+'px;display: list-item;list-style: square;" class="text-dark"><b>'+criteria[k].criteria+'</b></p></td>')
            tr.append('<td class="text-center">'+(ans[criteria[k].id] != undefined ? ave : '')+'</td>')
            tr.append('<td class="text-center">'+(ans[criteria[k].id] != undefined ? interpretation : '')+'</td>')
            if($('#criteria-list tbody tr[data-parent_id="'+criteria[k].parent_id+'"]').length > 0){
                $('#criteria-list tbody tr[data-parent_id="'+criteria[k].parent_id+'"]').last().after(tr)
                return false;
            }
            if($('#criteria-list tbody tr[data-id="'+criteria[k].parent_id+'"]').length > 0)
                $('#criteria-list tbody tr[data-id="'+criteria[k].parent_id+'"]').after(tr)
            else{
                 $('#criteria-list tbody ').append(tr)
            }
        })
         var interpretation;
            if((parseFloat(oa) / parseFloat(i)) > 0)
                interpretation = 'Poor';
            if((parseFloat(oa) / parseFloat(i)) > 1 )
                interpretation = 'Fair';
            if((parseFloat(oa) / parseFloat(i)) > 2 )
                interpretation = 'Satisfactory';
            if((parseFloat(oa) / parseFloat(i)) > 3 )
                interpretation = 'Ver Satisfactory';
            if((parseFloat(oa) / parseFloat(i)) > 3 )
                interpretation = 'Outstanding';
        $('#oa').text(parseFloat(parseFloat(oa) / parseFloat(i)).toLocaleString("en-US",{style:"decimal",maximumFractionDigits:5}))
        $('#interpretation').text(interpretation)
    }

$('.class_btn').click(function(){
    start_load()
    location.href = '<?php echo base_url('evaluation/result_chairperson/'.$fid.'?cid=') ?>'+$(this).attr('data-cid')
})
</script>
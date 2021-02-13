<?php 
$fname = $this->db->query("SELECT concat(lastname,' ',name_pref,', ',firstname) as name from faculty_list where id = $fid ")->row()->name;
$sy = $this->db->query('SELECT * FROM evaluation_list where status = 1 and is_default = 1 ')->row();
foreach($sy as $k => $v){
    $e_arr[$k] = $v;
}
$class = $this->db->query("SELECT r.*,concat(co.course,' ',cl.year,'-',cl.section,' - ',s.subject) as class,cl.id as cl_id,s.subject,cl.department_id FROM restriction_list r  inner join curriculum_level_list cl on cl.id = r.curriculum_id inner join subjects s on s.id = r.subject_id inner join courses co on co.id = cl.course_id where cl.status = 1 and r.evaluation_id = '{$e_arr['id']}' and r.faculty_id = $fid ".($_SESSION['login_user_type'] != 1 ? " and cl.department_id = '{$_SESSION['login_department_id']}' ":""));
// var_dump($class)
$rid = isset($_GET['rid']) ? $_GET['rid']: '';
$cl_id = isset($_GET['cl_id']) ? $_GET['cl_id']: '';
$sid = isset($_GET['sid']) ? $_GET['sid']: '';
?>
<div class="col-lg-12">
    <div class="card">
        <?php if($class->num_rows() <= 0): ?>
            <h4>No assigned class subject handles yet.</h4>
            <?php else: ?>
        <div class="card-header">
        <large><b>Student's Evaluation Result of Faculty</b></larger>
        <span class="float-right">
            <button class="btn btn-success btn-sm" id="print"><i class="fa fa-print"></i> Print Summary Result</button>
        </span>
        </div>
        <div class="card-body">
        <h5><b><?php echo $fname ?></b></h5>
        <hr>
        <label for="" class="control-label"><b>Select Class</b></label>
            <div class="row">
                <?php foreach($class->result_array() as $row ): ?>
                    <button class="btn <?php echo empty($rid)? "btn-info" : ($rid == $row['id'] ? "btn-info" : "btn-primary") ?> btn-sm class_btn" data-rid='<?php echo $row['id'] ?>' data-sid='<?php echo $row['subject_id'] ?>' data-cl_id='<?php echo $row['cl_id'] ?>' type="button"><?php echo $row['class'] ?></button>
                    <?php 
                    $dept =$this->db->query("SELECT * FROM department_list where id = {$row['department_id']} ")->row();
                    $dname = $dept->description;
                    // $dlogo = $dept->img_logo;
                        if(empty($rid))
                        $rid = $row['id'];
                        if(empty($cl_id))
                        $cl_id = $row['cl_id'];
                        if(empty($sid))
                        $sid = $row['subject_id'];
                        $subject = $row['subject'];
                    ?>
                <?php endforeach; ?>
            </div>
        <hr>
            <?php 
                $criteria_arr=array();
                $ans2=array();
                $count=array();
                $criteria = $this->db->query("SELECT * FROM criteria where id in (SELECT criteria_id from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 1 ) and status = 1 order by order_by asc");
                $student = $this->db->query("SELECT * FROM student_list where cl_id = '$cl_id' ");
                $question =  $this->db->query("SELECT * from question_list where evaluation_id = '{$e_arr['id']}' and question_for = 1");
                foreach($criteria->result_array() as $row):
                    $criteria_arr[$row['order_by']] = $row;
                    if($row['parent_id'] > 0){
                        $data =  $controller->get_parent($row['parent_id']);
                        foreach ($data as $v) {
                           $criteria_arr[$v['order_by']] = $v;
                        }
                    }
                endforeach;
                ksort($criteria_arr);
                $answers_qry = $this->db->query("SELECT a.*,c.id as cid FROM answers a inner join question_list q on q.id = a.question_id inner join criteria c on c.id = q.criteria_id where a.evaluation_id = '{$e_arr['id']}'  and a.student_id in (SELECT id FROM student_list where cl_id = '$cl_id' and status = 1) and q.type = 1 and a.subject_id = '$sid' ")->result_array();
                foreach($answers_qry as $row){
                    if(!isset($ans[$row['student_id']][$row['cid']]))
                    $ans[$row['student_id']][$row['cid']] = 0;
                    $ans[$row['student_id']][$row['cid']] += $row['answer'];
                    }
                foreach($question->result_array() as $row):
                    $criteria_q[$row['criteria_id']][] = $row;
                endforeach;
                $i = 1;
            ?>
                <label for="" class="control-label"><b>Evaluation Result</b></label>
                <div class="" style="width:auto;overflow:auto">
                    <table class="table table-bordered" style="max-width:auto;overflow:auto;min-width:calc(100%);width:inherit">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th width="50px">No.</th>
                                <?php foreach($criteria->result_array() as $row): ?>
                                    <th width="150px"><?php echo $row['criteria'] ?></th>
                                    <th width="100px">Average</th>
                                <?php endforeach; ?>
                                <th width="150px">Total Average</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php 
                           foreach($student->result_array() as $row): 
                           $taverage = 0;
                           $c = 0;
                            ?>
                           <tr>
                                <td class="text-center"><?php echo $i++ ?></td>
                                <?php foreach($criteria->result_array() as $crow): 
                                    $ccount = isset($criteria_q[$crow['id']]) ? count($criteria_q[$crow['id']]) : 0 ;
                                    $score = isset($ans[$row['id']][$crow['id']]) ? $ans[$row['id']][$crow['id']] : 0;
                                    $average = number_format($score/$ccount,2,'.','');
                                    $taverage += $average;
                                    $c++;
                                    if(!isset($ave[$crow['id']]))
                                    $ave[$crow['id']] = 0;
                                    $ave[$crow['id']] += $average;
                                ?>
                                    <td class="text-center alert-warning text-danger"><?php echo $score ?></td>
                                    <td class="text-center"><?php echo $average ?></td>
                                <?php endforeach; ?>
                                <td class="text-center"><?php echo $taverage/$c ?></td>
                           </tr>
                           <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-primary text-white">
                            <tr>
                                <th>Mean Score</th>
                                <?php 
                                        $i--;
                                        $total = 0;
                                        $ti = 0;
                                        foreach($criteria->result_array() as $row): 
                                            $ti++;
                                            $total += number_format($ave[$row['id']]/$i,5,'.','');
                                    ?>
                                        <th></th>
                                        <th class="text-center"><?php echo number_format($ave[$row['id']]/$i,5) ?></th>
                                <?php endforeach; ?>
                                <th class="text-center"><?php echo number_format($total/$ti,5) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                <label for="" class="control-label"><b>Evaluation Result Average Summary</b></label>
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
                <hr>
                <label for="" class="control-label"><b>Evaluation Comments</b></label>
                <?php 
                $ci = 1;
                $comments = $this->db->query("SELECT c.* FROM comments c inner join restriction_list r on r.id = c.restriction_id where c.evaluation_id= {$e_arr['id']} and c.restriction_id = $rid and r.curriculum_id = $cl_id and r.subject_id = $sid ");
                ?>
                <table class="table table-bordered" id="comments">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th class="text-center" width="5%">#</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comments->result_array() as $row): ?>
                            <tr>
                                <td class="text-center"><?php echo $ci++; ?></td>
                                <td><?php echo $row['comment'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<div id="print-header" >
<div class="row justify-content-center">
        <div><img src="<?php echo base_url('assets/img/chmsc_logo.gif') ?>" width="65px" height="65px" alt=""></div>
        <div class="text-center">
            <p>Republic of the Philippines</p>
            <p><b>CARLOS HILADO MEMORIAL STATE COLLEGE</b></p>
            <p>Talis City, Negros Occidental</p>
            <?php if(isset($dname)): ?>
            <p><b><?php echo strtoupper($dname) ?></b></p>
            <?php endif; ?>
        </div>
        <?php //if(isset($dlogo) && !empty($dlogo)): ?>
        <!-- <div><img src="<?php echo base_url('assets/img/').$dlogo ?>" width="65px" height="65px" alt=""></div> -->
        <?php //endif; ?>
</div>
<h4 class="text-center"><b>STUDENT'S EVALUATION OF FACULTY</b></h4>
<table width="100%" class='noborder'>
<tr>
<td width="50%">
<p>Name of Faculty: <b><?php echo $fname ?></b></p>
<p>Subject: <b><?php echo $subject ?></b></p>
</td>
<td width="50%">
<p>Sem: <b><?php echo $e_arr['semester'] ?></b></p>
<p>S.Y.: <b><?php echo $e_arr['school_year'] ?></b></p>
</td>
</tr>
</table>
</div>
<style>
#print-header{
    display:none
}
</style>
<noscript>
<style>
 p {
    /* display:none */
    margin:unset
}
#print-header img{
    margin:.5em
}
.text-center{
    text-align:center
}
.text-right{
    text-align:right
}
table{
    width:100%;
    border-collapse:collapse;
}
table tr,table td,table th{
    border: 1px solid
}
table.noborder tr,table.noborder td,table.noborder th{
    border: unset
}
.row {
    display: flex;
    flex-wrap: wrap;
   
}
.justify-content-center {
    -ms-flex-pack: center!important;
    justify-content: center!important;
}
</style>
</noscript>
<script>
$('#print').click(function(){
    
    var ns = $('noscript').clone()
    var _header = $('#print-header').clone()
    var table = $('#criteria-list').clone()
    var table2 = $('#comments').clone()
    var _div = $('<div></div')
    _div.append(table)
    _div.append('<br>')
    _div.append(table2)
    var nw = window.open("","_blank","width=900,height=700");
    nw.document.write(ns.html())
    nw.document.write(_header.html())
    nw.document.write(_div.html())
    nw.document.close()
    nw.print()
    setTimeout(() => {
    nw.close()
    }, 500);
})
var criteria = '<?php echo json_encode($criteria_arr) ?>';
    var ans = '<?php echo json_encode($ave) ?>';
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
            var ave = ans[criteria[k].id] / parseInt(<?php echo $i ?>);
            oa = parseFloat(oa)  + parseFloat(ans[criteria[k].id] != undefined ? ave : 0);
            var tr = $('<tr class="text-dark" data-id="'+criteria[k].id+'" data-parent_id="'+criteria[k].parent_id+'" data-level="'+level+'"></tr>')
            var interpretation;
            if(ave > 0)
                interpretation = 'Poor';
            else if(ave > 1 )
                interpretation = 'Fair';
            else if(ave > 2 )
                interpretation = 'Satisfactory';
            else if(ave > 3 )
                interpretation = 'Ver Satisfactory';
            else if(ave > 3 )
                interpretation = 'Outstanding';
            else
                interpretation = 'N/A';
            tr.append('<td><p style="margin-left:'+margin+'px;display: list-item;list-style: square;" class="text-dark"><b>'+criteria[k].criteria+'</b></p></td>')
            tr.append('<td class="text-center">'+(ans[criteria[k].id] != undefined ? parseFloat(ave).toLocaleString("en-US",{style:"decimal",maximumFractionDigits:5,minimumFractionDigits:5}) : '')+'</td>')
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
            if((parseFloat(oa) / parseFloat(i)) > 1.79 )
                interpretation = 'Fair';
            if((parseFloat(oa) / parseFloat(i)) > 2.59 )
                interpretation = 'Satisfactory';
            if((parseFloat(oa) / parseFloat(i)) > 3.93 )
                interpretation = 'Ver Satisfactory';
            if((parseFloat(oa) / parseFloat(i)) > 4.19 )
                interpretation = 'Outstanding';
        $('#oa').text(parseFloat(<?php echo $total/$ti ?>).toLocaleString("en-US",{style:"decimal",maximumFractionDigits:5,minimumFractionDigits:5}))
        $('#interpretation').text(interpretation)
    }

$('.class_btn').click(function(){
    start_load()
    location.href = '<?php echo base_url('evaluation/result_student/'.$fid.'?rid=') ?>'+$(this).attr('data-rid')+'&cl_id='+$(this).attr('data-cl_id')+'&sid='+$(this).attr('data-sid')
})
</script>
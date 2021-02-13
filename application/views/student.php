<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo ucwords($title) ?></title>

  <?php include 'header.php' ?>
  
  <style>
    .sidebar-fixed{
      z-index:1040
    }
    div#load_modal {
    background: #00000059;
    }
    .map-container{
    overflow:hidden;
    padding-bottom:56.25%;
    position:relative;
    height:0;
    }
    .map-container iframe{
    left:0;
    top:0;
    height:100%;
    width:100%;
    position:absolute;
    }
    #dynamic_toast{
      position: absolute;
    width: 20.2rem;
    right: 10px;
    }
    #dynamic_toast.show{
      z-index:9999
    }
    .col-md-12.question-text:before {
    content: "";
    font-weight: bolder;
}
.question-item.mb-2 {
    border-top: 1px solid #00000036;
}
#faculties .btn-rounded{
  border-radius:10em !important
}
  </style>
</head>

<body class="grey lighten-3">
   <!-- Toast -->
  <div role="alert" aria-live="assertive" aria-atomic="true" class="toast"  id="dynamic_toast">
  
  <div class="toast-body badge-success badge-type">
    <span class="mr-2"><i class="fa fa-check badge-success badge-type icon-place"></i></span>
    <span class="msg-field"></span>
  </div>
</div>
<!-- toast -->
  <!--Main Navigation-->
  <header>

     <?php include 'top_bar.php' ?>

    

  </header>
  <!--Main Navigation-->


  <!--Main layout-->
  <main class="pt-5" style="padding-left:unset">
    <div class="container-fluid mt-5">
    <div id="faculties">
      <?php 
      $evaluated = $this->db->query("SELECT distinct(restriction_id) from answers where evaluation_id= '".$_SESSION['sy_id']."' and student_id = {$_SESSION['login_id']} ");
      $evaluated_arr= array_column($evaluated->result_array(),"restriction_id","restriction_id");
      $fid =isset($_GET['fid']) && !in_array($_GET['fid'],$evaluated_arr) ? $_GET['fid'] : '';
      $sid =isset($_GET['sid']) && !in_array($_GET['sid'],$evaluated_arr) ? $_GET['sid'] : '';
      $rid =isset($_GET['rid']) && !in_array($_GET['rid'],$evaluated_arr) ? $_GET['rid'] : '';
      $fname_arr = array();
        $qry = $this->db->query("SELECT r.*,s.subject as class,f.lastname,f.name_pref,f.firstname FROM restriction_list r  inner join curriculum_level_list cl on cl.id = r.curriculum_id inner join subjects s on s.id = r.subject_id inner join courses co on co.id = cl.course_id inner join faculty_list f on f.id = r.faculty_id where r.evaluation_id = '{$_SESSION['sy_id']}' and r.curriculum_id = '{$_SESSION['login_cl_id']}' ".(count($evaluated_arr) > 0 ? " and r.id not in (".(implode(',',$evaluated_arr)).") " : "").($_SESSION['login_user_type'] != 1 ? " and cl.department_id = '{$_SESSION['login_department_id']}' ":""));
        if($qry->num_rows() <= 0){
          $fid = '';
          $sid = '';
          $rid = '';
        }
        foreach($qry->result_array() as $row):
          $fname_arr[$row['faculty_id']] = ucwords($row['firstname']. ' '. $row['lastname'].' '.$row['name_pref']);
      ?>
        <button type="button" class="btn btn-primary btn-rounded <?php echo isset($_GET['fid']) && isset($_GET['fid']) && $_GET['fid'] == $row['faculty_id'] && $_GET['sid'] == $row['subject_id'] ? "active" : empty($fid) ? "active" : ""; ?>" data-id='<?php echo $row['faculty_id'] ?>'  data-sid='<?php echo $row['subject_id'] ?>'><?php echo ucwords($row['firstname']. ' '. $row['lastname'].' '.$row['name_pref'].' - '.$row['class']) ?></button>
        <?php 
        if(empty($fid)){
          $fid = $row['faculty_id'];
        }
        if(empty($sid)){
          $sid = $row['subject_id'];
        }
        if(empty($rid)){
          $rid = $row['id'];
        }
        endforeach; 
        if(!empty($fid)):
        $criteria_arr = array();
        $criteria = $this->db->query("SELECT * FROM criteria where status = 1 and id in (SELECT criteria_id from question_list where evaluation_id = {$_SESSION['sy_id']} and question_for = 1 ) and status = 1 order by order_by asc");
        foreach($criteria->result_array() as $row):
            $criteria_arr[]=$row;
        endforeach; 
        $subject = $this->db->query("SELECT * FROM subjects where id=$sid");
        $subject_id = $subject->num_rows() > 0 ? $subject->row()->id : '';
        $subject = $subject->num_rows() > 0 ? $subject->row()->subject : '';
      endif;
        ?>
    </div>
    <?php if(!empty($fid) && $qry->num_rows() > 0): ?>
    <form id="answer-frm"> 
      <div class="card mb-4">
        <div class="card-body">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="md-form col-sm-12">
                      <input type="hidden" name="eid" value="<?php echo $_SESSION['sy_id'] ?>">
                      <input type="hidden" name="faculty_id" value="<?php echo $fid ?>">
                      <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>">
                      <input type="hidden" name="restriction_id" value="<?php echo $rid ?>">
                        <input type="text" class="form-control" name="other_details['name']" id="name" value="<?php echo $_SESSION['login_lastname'].', '.$_SESSION['login_firstname'].' '.$_SESSION['login_middlename'] ?>" readonly>
                        <label for="name" class="control-label">Name</label>
                        </div>
                    </div>
                    <div class="row">
                      <div class="md-form col-sm-12">
                        <input type="text" class="form-control" name="other_details['cls']" id="cid" value="<?php echo $_SESSION['login_cls'] ?>" readonly>
                        <label for="cid" class="control-label">Curriculum Level/Section</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                  <div class="row">
                      <div class="md-form col-sm-12">
                        <input type="text" class="form-control" name="other_details['faculty']" value="<?php echo $fname_arr[$fid] ?>" id="faculty" readonly>
                        <label for="faculty" class="control-label">Faculty</label>
                      </div>
                      <div class="md-form col-sm-12">
                        <input type="text" class="form-control" name="other_details['subject']" id="subject" value="<?php echo $subject ?>" readonly>
                        <label for="subject" class="control-label">Subject</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
        <div class="text-center"><h4><b><?php echo "SY : ".$_SESSION['sy_school_year']." ".$_SESSION['sy_semester']. " SEMESTER" ?></b></h4></div>
        <hr>
        <div>
        <b>Rating Scale: 5 = Outstanding, 4 = Very Satisfactory, 3 = Satisfactory, 2 = Fair, 1 = Poor</b>
        <hr>
        </div>
            <ul class="" id="evaluation-field">
                


            </ul>
            <hr>
            <div class="form-group">
            <label for="" class="control-label">Comment</label>
            <textarea name="comment" id="comment" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <button  class="btn btn-primary btn-block">Submit</button>
        </div>
      </div>

    </form>
     <?php elseif($qry->num_rows() == 0 && $evaluated->num_rows() == 0): ?>
    <div class="container-fluid">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <center><h4><b>No Faculty assigned to your class for SY <?php echo $_SESSION['sy_school_year'].' '.$_SESSION['sy_semester'] ?> SEMESTER yet. Thank you</b></h4></center>
            
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="container-fluid">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <center><h4><b>You are done evaluating your Teachers for SY <?php echo $_SESSION['sy_school_year'].' '.$_SESSION['sy_semester'] ?> SEMESTER. Thank you</b></h4></center>
            
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    </div>
  </main>
  <div id="rating_clone" style="display:none">
<div class="question-item mb-2">
    <div class=" question-item-row">
    <div class="col-md-12 question-text"><strong></strong></div>
        <div class="rating-field">
        <input type="hidden" name="qid[]">
        <input type="hidden" name="question[]">
        <input type="hidden" name="type[]">
        
            <span class="opt-group">
            </span>
        </div>
    </div>
</div>
</div>
<div id="textare_clone" style="display:none">
<div class="question-item mb-2">
                    <div class=" question-item-row">
                        
        <input type="hidden" name="qid[]">
        <input type="hidden" name="question[]">
        <input type="hidden" name="type[]">
                    <div class="col-md-12 question-text"><strong></strong></div>
                        <div class="textarea-field mt-3">
                            <div class="md-form" style="padding:1em">
                                <textarea id="question" class="md-textarea form-control bg-light" rows="4"  placeholder="Write your answer here."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
</div>
  <!--Main layout-->
<!--Footer-->
  <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn" style="padding-left:unset">



    <!--Copyright-->
    <div class="footer-copyright py-3">
      © 2020 All Rights Reserved
    </div>
    <!--/.Copyright-->

  </footer>

  <!-- //Modals -->
  <div id="load_modal">
      <div class="card">
        <div class="card-body">
        <center><div class="spinner-border text-info" role="status">
        <span class="sr-only">Loading...</span>
      </div>  <br>
      <small><b>Please wait...</b></small>
        
      </center>
        </div>
      </div>
  </div>
  <div class="modal fade" id="frm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
        <form action=""></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <!-- <pre>
      <?php var_dump($_SESSION) ?>
  </pre> -->
</body>
<script>
$('input').trigger('focus').trigger('blur')
$(document).ready(function(){
  load_criteria();
 
  $('#answer-frm').submit(function(e){
    e.preventDefault()
    start_load()
    $.ajax({
      url:"<?php echo base_url("student/save_student_evaluation") ?>",
      method:"POST",
      data:$(this).serialize(),
      error:err=>{
        console.log(err)
        Dtoast("An error occured.","danger")
        end_load()
      },
      success:function(resp){
        if(resp == 1){
     Dtoast("Evaluation successfully submitted",'success')
          setTimeout(function(){
            location.reload()
          },1000)
        }
      }
    })
  })

})
$('#faculties button').click(function(){
  start_load()
  location.href ='<?php echo base_url('student') ?>?fid='+$(this).attr('data-id')+'&sid='+$(this).attr('data-sid')
})

window.load_criteria = function(){
  if('<?php echo empty($fid) ?>' == 1){
    return false;
  }
      var criteria = <?php echo json_encode($criteria_arr) ?>;
      Object.keys(criteria).map(function(k){
          var li=$('<li class="criteria-item"></li>')
          li.attr('data-id',criteria[k].id)
          li.append('<b>'+criteria[k].criteria+'</b>')
          li.append('<div class="qf"></div>')
          if($('#evaluation-field li[data-id="'+criteria[k].parent_id+'"]').length > 0){
              var ul = $('<ul></ul>');
              ul.append(li)
              $('#evaluation-field').append(ul)
          }else{
            $('#evaluation-field').append(li)
          }
      })
    load_questions();

  }

window.start_load = function(){

      $('#load_modal').css({display:'flex'})

}
window.end_load = function(){

  $('#load_modal').hide()


}
  window.frmModal =function($frm_name='',$title='',$url='',$params={}){
      start_load()
      $.ajax({
        url:$url,
        method:'POST',
        data:$params,
        error:err=>console.log(err),
        success:function(content){
          $('#frm_modal .modal-body form').html(content)
          $('#frm_modal .modal-body form').attr('id',$frm_name)
          $('#frm_modal .modal-title').html($title)
          $('#frm_modal #submit').attr('onclick','$("#'+$frm_name+'").submit()')
          $('#frm_modal').modal('show')
          end_load()
        }
      })
  }
  function delete_data(msg = '',cfunc = '',parameters= []){
    
    parameters = parameters.join(",");
    $('#delete_modal #submit').html('Continue')
      $('#delete_modal #submit').removeAttr('disabled')
    $('#delete_modal #delete_content').html(msg);
    $('#delete_modal #submit').attr('onclick','this_go("'+cfunc+'",['+parameters+'])');
    $('#delete_modal').modal('show')
  
  }
  function this_go(cfunc = '',parameters= []){
    console.log(cfunc)
    parameters = parameters.join(",");
      $('#delete_modal #submit').html('Please wait...');
      $('#delete_modal #submit').attr('disabled',true);
      window[cfunc](parameters)
    }
    window.load_questions = function(){
      start_load();
      $.ajax({
          url:'<?php echo base_url('student/load_evaluation') ?>',
          method:'POST',
          data:{},
          error:err=>{
                  console.log(err)
                  Dtoast('An error occured','error');
                  end_load();
              },
        success:function(resp){
          if(typeof resp != undefined){
                resp= JSON.parse(resp)
                if(Object.keys(resp).length >0){
                    Object.keys(resp).map(k=>{
                        var q = resp[k].question;
                        var t = resp[k].type;
                        var id = resp[k].id;
                        var c = resp[k].criteria_id;

                        var item = '';
                        var item_count = $('#evaluation-field .question-item').length + 1;
                        if(t == 1){
                            item =  $('#rating_clone .question-item').clone()
                            for( var i = 1 ; i <= 5; i++ ){
                                //   console.log(i)
                                item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-'+i+'-'+item_count+'" name="answer['+id+']" value="'+i+'" readonly/><label for="rating-'+i+'-'+item_count+'"> '+i+'</label></span>')
                            }
                                
                        }else{
                            item =  $('#textare_clone .question-item').clone()
                        }
                                item.find('[name="qid[]"]').val(id)
                                item.find('[name="question[]"]').val(q)
                                item.find('[name="type[]"]').val(t)
                                item.find('[name="criteria_id[]"]').val(c)
                                item.find('.question-text strong').html(q)
                                console.log(c)
                                $('#evaluation-field li[data-id="'+c+'"] .qf').append(item)

                    })
                }

                end_load();
            }
            },
            complete:function(){
            }
        })
    }
  window.Dtoast = ($message='',type='success')=>{
    // console.log('toast');
    $('#dynamic_toast .msg-field').html($message);
    if(type == 'info'){
      var badge = 'badge-info';
      var ico = 'fa-info';
    }else if(type == 'success'){
      var badge = 'badge-success';
      var ico = 'fa-check';
    }else  if(type == 'error'){
      var badge = 'badge-danger';
      var ico = 'fa-exclamation-triangle';
    }else  if(type == 'warning'){
      var badge = 'badge-warning';
      var ico = 'fa-exclamation-triangle';
    }
    $("#dynamic_toast .badge-type").removeClass('badge-success')
    $("#dynamic_toast .badge-type").removeClass('badge-warning')
    $("#dynamic_toast .badge-type").removeClass('badge-danger')
    $("#dynamic_toast .badge-type").removeClass('badge-info')

    $("#dynamic_toast .icon-place").removeClass('fa-check')
    $("#dynamic_toast .icon-place").removeClass('fa-info')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')
    $("#dynamic_toast .icon-place").removeClass('fa-exclamation-triangle')

    $('#dynamic_toast .badge-type').addClass(badge)
    $('#dynamic_toast .icon-place').addClass(ico)

    
    $('#dynamic_toast .msg-field').html($message)
    // $('#dynamic_toast').show()
    $('#dynamic_toast').toast({'delay':2000}).toast('show');
  }
</script>
</html>
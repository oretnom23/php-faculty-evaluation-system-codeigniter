<link rel="stylesheet" href="<?php echo base_url('assets/sortable') ?>/jquery-ui.css">
<script src="<?php echo base_url('assets/sortable') ?>/jquery-ui.js"></script>
<?php
$criteria_arr = array();
$criteria = $this->db->query("SELECT * FROM criteria where status = 1 order by order_by asc");
foreach($criteria->result_array() as $row):
    $criteria_arr[]=$row;
endforeach; 
?>
<div class="col-md-12 card card-cascade narrower">
    <div class="view view-cascade gradient-card-header blue-gradient">
        <h2 class="card-header-title text-center text-light"><strong><?php echo "SY ".$meta['school_year'] ?>-<?php echo $meta['semester']." Sem" ?></strong></h2>
        <center>
        <button class="btn btn-floating btn-primary" id="new_question"><i class="fa fa-plus"></i> New Question</button>
        <button class="btn btn-floating btn-primary" onclick="$('#questionaire-frm').submit()"><i class="fa fa-save"></i> Save</button>
        </center>
    </div>
    <div class="card-body">
        <form id="questionaire-frm"> 
            <input type="hidden" name="id" value="<?php echo $meta['id'] ?>">
            <input type="hidden" name="question_for" value="<?php echo $for ?>">
            <ul class="" id="evaluation-field">
                
            </ul>
       </form>
    </div>
</div>
<div class="modal fade" id="manage_question" role='dialog' tabindex="-1" role="dialog" aria-modal="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
    
      <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">
                New Question
            </div>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <form id="question-frm">
                <input type="hidden" name="item_id" value="">
                <div class="md-form">
                    <textarea id="question" class="md-textarea form-control" rows="4" name="question" required></textarea>
                    <label for="question">Question</label>
                </div>
                <div class="form-group">
                <label for="">Criteria</label>
                <input type="hidden" name="criteria_id" value="" >
                <div id="criteria-tree"></div>
                </div>
                <input type="hidden" id="qtype" name="qtype" value="1"/>

                <!-- <div class=" mt-3">
                <div class="row">
                    <div class="col-md-8">
                        <label for="qtype" >Question Type</label>
                      
                        <select type="text" id="qtype" name="qtype" class="browser-default custom-select" required>
                            <option value="1">Rating</option>
                            <option value="2">Text Area / Text Field</option>
                        </select>
                    </div>
                </div>
            </div> -->
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="$('#question-frm').submit()">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>    
      </div>
    </div>
  </div>

<div id="rating_clone" style="display:none">
<div class="question-item mb-2">
    <a href="javascript:void(0)" class="btn btn-danger btn-sm remove-field"><i class="fa fa-trash"></i></a>
    <div class="ui-state-default question-item-row">
    <div class="col-md-12 question-text"><strong></strong></div>
        <div class="rating-field">
        <input type="hidden" name="qid[]">
        <input type="hidden" name="question[]">
        <input type="hidden" name="type[]">
        <input type="hidden" name="criteria_id[]">
            <span class="opt-group">
            </span>
        </div>
    </div>
</div>
</div>
<div id="textare_clone" style="display:none">
<div class="question-item mb-2">
    <a href="javascript:void(0)" class="btn btn-danger btn-sm remove-field"><i class="fa fa-trash"></i></a>
                    <div class="ui-state-default question-item-row">
                        
        <input type="hidden" name="qid[]">
        <input type="hidden" name="question[]">
        <input type="hidden" name="type[]">
        <input type="hidden" name="criteria_id[]">
                    <div class="col-md-12 question-text"><strong></strong></div>
                        <div class="textarea-field mt-3">
                            <div class="md-form" style="padding:1em">
                                <textarea id="question" class="md-textarea form-control bg-light" rows="4"  placeholder="Write your answer here."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
</div>

  <script>
  $(document).ready(function(){
    load_list();
    load_criteria();
    $('#criteria-tree').on("select_node.jstree", function (e, data) { $('[name="criteria_id"]').val(data.node.id);});
      $('#new_question').click(function(){
          $('#manage_question').modal('show')
      })

      $('#question-frm').submit(function(e){
          e.preventDefault();
          start_load()
          var q = $(this).find('[name="question"]').val();
          var t = $(this).find('[name="qtype"]').val();
          var c = $(this).find('[name="criteria_id"]').val();
          var item;
          var item_count = $('#evaluation-field .question-item').length + 1;
          if(t == 1){
              item =  $('#rating_clone .question-item').clone()
              for( var i = 1 ; i <= 5; i++ ){
                    //   console.log(i)
                    item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-'+i+'-'+item_count+'" name="rating['+item_count+'][]" value="'+i+'" readonly/><label for="rating-'+i+'-'+item_count+'"> '+i+'</label></span>')
                }
                
          }else{
             item =  $('#textare_clone .question-item').clone()
          }
                item.find('[name="question[]"]').val(q)
                item.find('[name="type[]"]').val(t)
                item.find('[name="criteria_id[]"]').val(c)
                item.find('.question-text strong').html(q)
                $('#evaluation-field li[data-id="'+c+'"] .qf').append(item)
                $('#question-frm').get(0).reset()
                end_load();
                $('.modal').modal('hide')
                
        rem_func();

      })
      function createJSTrees(jsonData) {
		$("#criteria-tree").jstree('destroy');
		$('#criteria-tree').jstree({
			plugins: ["table","dnd","contextmenu", "crrm","search"],
			
			"table": {
				columns: [{width: 300, header: "Name"}],
				resizable: false,
			},core: {
				"animation" : 0,
				"check_callback" : true,
				"themes" : { "stripes" : true },
				data: jsonData
			},
		}).on('loaded.jstree', function() {
			$("#criteria-tree").jstree('open_all');
			$('.jstree-table-cell').css('margin','unset !important');
			var jsonNodes = $('#criteria-tree').jstree(true).get_json('#', { flat: false });
			$.each(jsonNodes, function (i, val) {
				// if($(val).attr('id') != vtype){
				// 	// console.log($(val).attr('id'));
				// }
			})

		});
	}  
    function load_list(){
		
		$.ajax({
			async : true,
			type : "GET",
			url : "<?php echo base_url(); ?>criteria/load_list",
			dataType : "json",    
	
			success : function(json) {
				createJSTrees(json);
			},    
	
			error : function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
      $('#questionaire-frm').submit(function(e){
          e.preventDefault()
          start_load()
          $.ajax({
              url:'<?php echo base_url('evaluation/save_questionaire') ?>',
              method:'POST',
              data:$(this).serialize(),
              error:err=>{
                  console.log(err)
                  Dtoast('An error occured','error');
                  end_load();
              },
              success:function(resp){
                  if(typeof resp != undefined){
                      resp = JSON.parse(resp);
                      if(resp.status == 1){
                        Dtoast(resp.msg,'success');
                      }else{
                        Dtoast(resp.msg,'failed');
                      }
                      end_load();
                  }
              }
          })
      })
  })
  window.load_criteria = function(){
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
  window.load_questions = function(){
      start_load();
      $.ajax({
          url:'<?php echo base_url('evaluation/load_questions') ?>',
          method:'POST',
          data:{id:'<?php echo $meta['id'] ?>',for:'<?php echo $for ?>'},
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
                                item.find('.opt-group').append('<span class="mx-2"><input type="radio" id="rating-'+i+'-'+item_count+'" name="rating['+item_count+'][]" value="'+i+'" readonly/><label for="rating-'+i+'-'+item_count+'"> '+i+'</label></span>')
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
                rem_func();
            }
        })
    }
    function rem_func(){
        $('.remove-field').each(function(){
            $(this).click(function(){
                $(this).parent().remove()
            })
        })
    }
  </script>
  
<script>
  $( function() {
    $( ".qf" ).sortable();
    $( ".qf" ).disableSelection();
  } );
  </script>
  
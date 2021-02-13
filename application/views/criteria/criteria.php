    <div class="row">
	<div class="col-lg-4">
		<div class="card">
		<div class="card-header">
			<b>Criteria Form</b>
		</div>
			<div class="card-body">
				<form id="manage-criteria">
				<input type="hidden" name="id">
					<div class="form-group">
						<label for="criteria" class="control-label">Criteria</label>
						<input type="text" class="form-control" name='criteria' required>
					</div>
					<div class="form-group">
						<label for="parent_id" class="control-label">Parent</label>
						<select name="parent_id" id="parent_id" class="custom-select select2">
							<option value="0">Root</option>
							<?php 
								$criteria = $this->db->get_where('criteria',array('status'=>1));
								foreach($criteria->result_array() as $row):
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['criteria'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-secondary float-right" form="manage-criteria" type='reset'>Clear</button>
						<button class="btn btn-primary float-right" form="manage-criteria">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
        <div class="card">
            <div class="card-body">
				<div>
					<large><b>Evaluation Criteria</b></large>
					<span><button class="btn btn-primary btn-sm float-right" id="save-order">Save Order</button></span>
				</div>
                <div id="criteria-tree"></div>
            </div>
        </div>
    </div>
	</div>
	

<script>
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
			contextmenu: {
				'items' : customMenu
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
    window.load_list = function (){
		
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
	$(document).ready(function(){
		load_list()
		if('<?php echo (!!$this->session->flashdata('action_criteria')) ? $this->session->flashdata('action_criteria') : '' ?>' == 1){
			Dtoast("Data successfully saved.",'success')
		}
	})
	$('#save-order').click(function(){
		start_load()
			var treeData = $('#criteria-tree').jstree(true).get_json('#', {no_state:true,flat:true});
			// set flat:true to get all nodes in 1-level json
			var jsonData = JSON.stringify(treeData );
			$.ajax({
				method: "POST",
				url: "<?php echo base_url(); ?>criteria/save_order",
				data: { 'jsonData': jsonData },
				success:(resp)=>{
					Dtoast('Order successfully updated.','success');
					end_load()
				}
				});
	})
	function customMenu(node)
	{
		var is_parent = node.original.is_parent;
		if(is_parent == 1)
			return false;
		var id = node.original.id;
		// var material = material_select();
	    var items = {
	        'item1' : {
	            'label' : 'Edit',
	            'action' : ()=>{ 
					console.log(node.original)
					$('[name="id"]').val(node.original.id)
					$('[name="criteria"]').val(node.original.text)
					$('[name="parent_id"]').val(node.original.parent).trigger('change')
	             }
	        },
	        'item2' : {
	            'label' : 'Delete',
	            'action' :()=>{
	            	delete_data('Are you sure you want to continue deleting this data? This process cannot be undone.','remove_citeria',[id]);
	            }
	        }
	    }

	    // if (node.type === 'level_1') {
	    //     delete items.item2;
	    // } else if (node.type === 'level_2') {
	    //     delete items.item1;
	    // }
		// if('<?php echo isset($_SESSION['fa_arr']['ce_btn']) ? 1 : 0 ?>' == 0)
		// 	delete items.item1
		// 	if('<?php echo isset($_SESSION['fa_arr']['cd_btn']) ? 1 : 0 ?>' == 0)
		// 	delete items.item2

	    return items;
	}
	function remove_citeria($id=''){
    $.ajax({
        url:'<?php echo base_url() ?>criteria/remove',
        method:'POST',
        data:{id:$id},
        error:err=>{
            console.log(err)
            Dtoast('An error occured.','error')
        },
        success:function(resp){
            if(resp == 1){
             Dtoast('Data successfully deleted.','success')
			 load_list()
             $('.modal').modal('hide')
            }
        }
    })
}
	$('#manage-criteria').on('reset',function(){
		$('input:hidden').val('')
	})
	$('#manage-criteria').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'<?php echo base_url('criteria/save') ?>',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					location.reload()
				}
			}
		})
	})

</script>
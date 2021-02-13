<div class="conteiner-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <b>System Logs</b>
                </span>
            </div>
            <div class="card-body">
                
                <table class="table-bordered table" id="tbl-logs">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Acton Made</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.load_logs = function(){
        start_load()
        $.ajax({
            url:'<?php echo base_url('cogs/system_logs') ?>',
            success:function(resp){
                if(typeof resp != undefined){
                    resp= JSON.parse(resp)
                    if(Object.keys(resp).length <= 0 ){
                        $('#tbl-logs tbody').html('')
                    }else{
                        var i = 1 ;
                        Object.keys(resp).map(k=>{
                            var tr = $("<tr></tr>")
                            tr.append("<td>"+(i++)+"</td>")
                            tr.append("<td>"+resp[k].date_created+"</td>")
                            tr.append("<td>"+resp[k].uname+"</td>")
                            tr.append("<td>"+resp[k].action_made+"</td>")
                            tr.append("<td>"+resp[k].log_msg+"</td>")
                            $('#tbl-logs tbody').append(tr)
                        })
                    }
                }
            },
            complete:function(){
                $('#tbl-logs').dataTable()
                end_load()
            }
        })
    }
    $(document).ready(function(){
        load_logs()
    })
</script>
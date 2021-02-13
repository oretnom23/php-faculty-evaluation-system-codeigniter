<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Login</title>

  <?php include 'header.php' ?>
  
  <style>
    body{
        height:calc(100%);
        width:calc(100%);
    }
    #login-left{
        height:calc(100%);
        width:calc(60%);
        position:absolute;
        left:0;
        background:blue;
        top:0;
        background: linear-gradient(40deg,#45cafc,#303f9f)!important;
    }
    #login-right{
        top:0;
        height:calc(100%);
        width:calc(42%);
        position:absolute;
        right:0;
        background:white;

    }
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
    z-index: 9999;
    width: 20.2rem;
    right: 10px;
    }
    #load_modal{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    height: 100%;
    width: 100%;
    
    }
    #load_modal .card{
        margin:auto
    }
    div#logo-field {
    background: white;
    border-radius: 50%;
    padding: 3em;
    height: 84vh;
    width: 50vw;
}
#logo-field img {
    width: calc(100%);
    height: calc(100%);
}
  </style>
</head>

<body class="grey lighten-3">
   
 

  <!--Main layout-->
<body class="grey lighten-3">
   
 

  <!--Main layout-->
  <main class="" id="login-main">
    <div class="container-fluid mt-5">

       <div id="login-left" class="row align-items-center justify-content-center">
                <div id="logo-field" class="align-self-center">
                    <img src="<?php echo base_url('assets/img/chmsc_logo.gif') ?>" alt="">
                </div>
       </div>

       <div id="login-right" class="row align-items-center justify-content-center">
            <div class="col-md-10  align-self-center">
                <div class="card card-cascade narrower">

                    <div class="view view-cascade gradient-card-header blue-gradient">
                        <h2 class="card-header-title text-center text-light"><strong>Login</strong></h2>
                    </div>

                    <div class="card-body card-body-cascade">
                        <div class="container-fluid">
                            <div id="msg-field"></div>
                            <div class="progress md-progress" id="login-progress">
                                <div class="progress-bar" role="progressbar" style="width: 5%" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <form action="" id="login-frm">
                                <div class="md-form">
                                    <i class="fas fa-user prefix"></i>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                    <label for="username">Username</label>
                                </div>
                                <div class="md-form">
                                    <i class="fas fa-key prefix"></i>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <label for="password">Password</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="contro-label">Type</label>
                                    <select name="user_type" id="user_type" class="custom-select">
                                        <option value="2">Student</option>
                                        <option value="3">Chairperson</option>
                                        <option value="1">Admin/Dean/Staff</option>
                                    </select>
                                </div>
                                <div class="col-md-12 text-center">
                                <button class="btn btn-sm btn-primary btn-block">Login</button>

                                </div>
                            </form>
                        </div>
                        

                    </div>
            </div>
       </div>
      

    </div>
  </main>
 
</body>

<script>
    $('#login-frm').submit(function(e){
        e.preventDefault()
        $('input button').attr('disabled',true)
        $('#login-frm button').html('Please wait...')
        $('#login-main #msg-field').html('')
            $('#login-progress .progress-bar').css({'width':'5%'})
        $('#login-progress').css({'display':'flex'})
        var i  = 5;
        var prog = setInterval(function(){
            $('#login-progress .progress-bar').css({'width':i+'%'})

            if(i == 80)
                clearInterval(prog)

                i += 5
            },1700)
        $.ajax({
            url:'<?php echo base_url('login/login') ?>',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                alert('An error occured');
            },
            success:function(resp){
                if(typeof resp != undefined){
                    resp = JSON.parse(resp)
                    if(resp.status == 1){
                        clearInterval(prog)
                    $('#login-progress .progress-bar').css({'width':'95%'})
                    setTimeout(function(){
                        if($('#user_type').val() == 1)
                        location.replace('<?php echo base_url('admin') ?>');
                        else if($('#user_type').val() == 2)
                        location.replace('<?php echo base_url('student') ?>');
                        else
                        location.replace('<?php echo base_url('chairperson') ?>');
                    },2000)
                        
                    }else{
                        clearInterval(prog)
                        $('#login-progress .progress-bar').css({'width':'95%'})
                        setTimeout(function(){
                            $('input button').removeAttr('disabled')
                            $('#login-progress').hide();
                            $('#login-frm button').html('Login')
                            $('#login-main #msg-field').html('<div class="alert alert-danger">'+resp.msg+'</div>')
                        },2000)
                    }
                }
            }
        })
    })
</script>

</html>
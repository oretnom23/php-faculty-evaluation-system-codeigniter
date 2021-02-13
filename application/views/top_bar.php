<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      <div class="container-fluid">

       <!-- Collapse -->
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="./"><strong>Teachers Evaluation System</strong></a>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="navbar-nav mr-auto"></div>
          <!-- Left -->
         <!--  <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="" href="./"><strong>Teachers Evaluation System</strong>
              </a>
            </li>
          </ul> -->

          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user btn-ronded"></span> <?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_lastname']) ?> </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_myaccount">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo isset($_SESSION['login_user_type']) && $_SESSION['login_user_type'] ==1 ? "My Account" : "Change Password" ?>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo base_url('login/logout') ?>" >
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
              </a>
            </div>
            </li>
          </ul>

        

      </div>
    </nav>
    <!-- Navbar -->
    <script>
      $(document).ready(function(){
        $('#manage_myaccount').click(function(){
        frmModal("manage-users","Manage My Account","<?php echo base_url("cogs/manage_users/").$_SESSION['login_id'] ?>")

        })
      })
    </script>
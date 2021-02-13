<!-- Sidebar -->

  <?php
    $home = (strtolower($title) == 'home' ) ? "active" : '';
    $department = (strtolower($title) == 'add department' || strtolower($title) == 'edit department' || strtolower($title) == 'department' ) ? "active" : '';
    $course = (strtolower($title) == 'add course' || strtolower($title) == 'edit course' || strtolower($title) == 'course' ) ? "active" : '';
    $criteria = (strtolower($title) == 'add criteria' || strtolower($title) == 'edit criteria' || strtolower($title) == 'criteria' ) ? "active" : '';
    $subject = (strtolower($title) == 'add subject' || strtolower($title) == 'edit subject' || strtolower($title) == 'subject' ) ? "active" : '';
    $student = (strtolower($title) == 'add student' || strtolower($title) == 'edit student' || strtolower($title) == 'student' ) ? "active" : '';
    $chair = (strtolower($title) == 'add chair' || strtolower($title) == 'edit chair' || strtolower($title) == 'chair' ) ? "active" : '';
    $faculty = (strtolower($title) == 'add faculty' || strtolower($title) == 'edit faculty' || strtolower($title) == 'faculty' ) ? "active" : '';
    $curriculum = (strtolower($title) == 'add curriculum' || strtolower($title) == 'edit curriculum' || strtolower($title) == 'curriculum' ) ? "active" : '';
    $evaluation = (strtolower($title) == 'add evaluation' || strtolower($title) == 'edit evaluation' || strtolower($title) == 'evaluation' ) ? "active" : '';
    $result = (strtolower($title) == 'add result' || strtolower($title) == 'edit result' || strtolower($title) == 'result' ) ? "active" : '';
    $users = (strtolower($title) == 'add users' || strtolower($title) == 'edit users' || strtolower($title) == 'users' ) ? "active" : '';

  
  ?>


    <div class="sidebar-fixed position-fixed">

      <center><a class="logo-wrapper waves-effect">
        <img src="<?php echo base_url('assets/img/chmsc_logo.gif') ?>" class="" alt=""  style="max-width:100%;max-height : 15vh !important">
      </a>
      </center>
      <div class="list-group list-group-flush">
        <a href="<?php echo base_url('admin') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $home ?>">
          <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
        </a>
        <?php if($_SESSION['login_user_type'] == 1): ?>

        <a href="<?php echo base_url('department') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $department ?>">
        <i class="fas fa-building mr-3"></i>Department</a>
        <?php endif; ?>

        <a href="<?php echo base_url('subject') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $subject ?>">
        <i class="fas fa-th-list mr-3"></i>Subjects</a>
        <a href="<?php echo base_url('course') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $course ?>">
        <i class="fas fa-scroll mr-3"></i>Courses</a>
          <a href="<?php echo base_url('faculty') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $faculty ?>">
          <i class="fas fa-user-tie mr-3"></i>Faculty</a>
          <a href="<?php echo base_url('criteria') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $criteria ?>">
          <i class="fas fa-list mr-3"></i>Criteria</a>
          <a href="<?php echo base_url('chairperson/list') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $chair ?>">
          <i class="fas fa-user-tie mr-3"></i>Chairperson</a>
          <a href="<?php echo base_url('student/list') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $student ?>">
          <i class="fas fa-user mr-3"></i>Student</a>
          <a href="<?php echo base_url('curriculum') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $curriculum ?>">
          <i class="fas fa-graduation-cap mr-3"></i>Level & Section</a>
         
          <a href="<?php echo base_url('evaluation') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $evaluation ?>">
          <i class="fas fa-star mr-3"></i>Evaluation</a>
          <a href="<?php echo base_url('evaluation/result') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $result ?>">
          <i class="fas fa-list-alt mr-3"></i>Result</a>
          <?php if($_SESSION['login_user_type'] == 1): ?>
          <a href="<?php echo base_url('cogs/users') ?>" class="list-group-item list-group-item-action waves-effect <?php echo $users ?>">
          <i class="fas fa-user-friends mr-3"></i>Users</a>
        <?php endif; ?>
      </div>

    </div>
    <style>
    #sidebar-list a{
      min-height:7vh
    }
    #sidebar-list{
      height: calc(100% - 10rem);
      overflow:auto
    }
    </style>
    <!-- Sidebar -->
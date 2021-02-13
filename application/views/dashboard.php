<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
        <div class="card card-cascade cascading-admin-card">
        <div class="card-body">
          <div class="admin-up">
            <div class="data">
              <p class="text-uppercase">Total Students</p>
              <span class="float-left dash-sum-icon"><i class="fa fa-users "></i></span>
              <h4 class="font-weight-bold dark-grey-text text-right"> <?php   echo $this->db->query("SELECT * FROM student_list where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?></h4>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class='col-md-12'>
            <a href="<?php echo base_url('student/list') ?>" class="row justify-content-between"><span>View</span><span class="fa fa-angle-right"></span></a>
          </div>
        </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
        <div class="card card-cascade cascading-admin-card">
        <div class="card-body">
          <div class="admin-up">
            <div class="data">
              <p class="text-uppercase">Total Faculty</p>
              <span class="float-left dash-sum-icon"><i class="fa fa-user-tie "></i></span>
              <h4 class="font-weight-bold dark-grey-text text-right"><?php   echo $this->db->query("SELECT * FROM faculty_list where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?></h4>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class='col-md-12'>
            <a href="<?php echo base_url('faculty') ?>" class="row justify-content-between"><span>View</span><span class="fa fa-angle-right"></span></a>
          </div>
        </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
        <div class="card card-cascade cascading-admin-card">
        <div class="card-body">
          <div class="admin-up">
            <div class="data">
              <p class="text-uppercase">Total Courses</p>
              <span class="float-left dash-sum-icon"><i class="fa fa-scroll "></i></span>
              <h4 class="font-weight-bold dark-grey-text text-right"><?php   echo $this->db->query("SELECT * FROM courses where status = 1 ".($_SESSION['login_user_type'] != 1? " and department_id = {$_SESSION['login_department_id']} " : ''))->num_rows(); ?></h4>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class='col-md-12'>
            <a href="<?php echo base_url('course') ?>" class="row justify-content-between"><span>View</span><span class="fa fa-angle-right"></span></a>
          </div>
        </div>
        </div>
      </div>

      </div>
    </div>
  </div>
</div>
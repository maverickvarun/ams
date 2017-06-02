<li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
               <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
               <?php
                if($role!="employee"){
                  echo'<li><a href="javascript:;" id="remote_checkin_popup" onclick="div_show_remote_checkin()"><i class="fa fa-desktop fa-fw" ></i>Remote Checkin</a>
                  </li>';
                }
              ?>
               <li><a href="javascript:;" id="change_password_popup" onclick="div_show()"><i class="fa fa-gear fa-fw" ></i>Change Password</a>
               </li>
               <li class="divider"></li>
               <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
               </li>
            </ul>
           <!-- /.dropdown-user -->
         </li>          <!-- /.dropdown -->
                
      </ul>
            <!-- /.navbar-top-links -->
      <div class="navbar-default sidebar " role="navigation"  >
         <div class="sidebar-nav navbar-collapse" >
            <ul class="nav" id="side-menu">
               <li><a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>  
               <li><a href="#"><i class="fa fa-male fa-fw"></i>Employee<span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level">
                         <?php if ($role=='admin'){
                                       echo '<li><a href="addemployee.php">Add Employee</a></li>';
                                       echo '<li><a href="modifyemployee.php">Modify Employee</a></li>';
                                   }
                         ?>
                  <li class="active"><a href="viewsigninout.php" >View Attendance</a></li>
                     
                     <?php if($role!="employee"){ 
                         echo '<li><a href="viewemployeedetails.php">View Employee Details</a></li>';
                        
                       }
                     ?>
                  </ul>
               </li>

               <li>
                  <a href="#"><i class="fa fa-briefcase fa-fw"></i>Leave<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                   <?php if($role != "admin"){
                     echo '<li><a href="javascript:;" onclick="div_leave_request_show();">Leave Request</a></li>';
                      } 
                        if($role != "employee") {
                         echo'<li><a href="leavedetails.php">Leave Details</a></li>';
                        } 
                     ?>
                    <li ><a href="availableleaves.php">Available Leaves</a></li>
              </ul>
            </li>

             <!-- team menu .......................................... -->
               <?php if($role =='admin'){
                  echo'<li>
                    <a href="#"><i class="fa fa-rocket fa-fw"></i>Team<span class="fa arrow"></span></a>
                      <ul class="nav nav-second-level">
                        <li><a href="javascript:;" onclick="div_add_team_show();">Add New Team</a></li>
                        <li><a href="javascript:;" onclick="div_show_modify_team();">Modify Team</a></li>
                      </ul>
                  </li>';
                }
               ?>
               
            <!-- /.nav-third-level........................................................................ -->          
               <li class="active">
                   <a href="#"><i class="fa fa-tasks fa-fw"></i>Shift<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role=='admin'){
                            echo '<li><a href="javascript:;" onclick="div_show_add_new_shift();">Add Shift</a></li>';
                         }

                       if($role != "employee"){
                           echo'<li><a href="javascript:;" onclick="div_show_change_shift();">Modify Shift</a></li>';
                       }
                     ?>
                     <li class="active">
                       <?php include('connection.php');
                         $d=date('d');
                         // below if is used for date 1 to 9 and else is used for date is greater than 9 else query is executed 
                         if($d < 10){
                           $d2 = 2*$d-$d;
                          // $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date($d2.'-M-y')."' ");
                         }
                         else{
                        //   $query = mysqli_query($con,"SELECT ".$user." from monthly_shift_table WHERE date='".date('d-M-y')."' ");
                         }
                      echo   $count =mysqli_fetch_row($query);
                         if($count) {
                           echo'<a href="monthlyshift.php">Monthly Shift</a>
                           <ul class="nav nav-second-level">
                              <li>
                                <div class="col-lg-12 "> 
                                   <div class="form-group">
                                      <label>By date</label>
                                      <div class="radio">
                                          <label>
                                            <input type="radio" name="date" id="single_date" value="single date">Single Date
                                          </label>
                                      </div>
                                      <div class="radio">
                                          <label>
                                            <input type="radio" name="date" id="multiple_dates" value="multiple dates">Multiple Dates
                                          </label>
                                      </div>
                                   </div> 
                                </div>
                                <div class="col-sm-12 hidden filter_top" id="li_one_date_filter">
                                  <input type="date" placeholder=" Single date" class="example1 form-control input-sm " id="onedate" onchange="filtration_checkin();">
                                </div>
                                <div class="col-sm-12 filter_top hidden" id="li_from_date_filter">
                                <input type="date" placeholder="From Date" class="example1 form-control input-sm" id="fromdate" onchange="filtration_checkin();">
                                </div>
                                <div class="col-sm-12 filter_top hidden " id="li_to_date_filter">
                                <input  type="date" placeholder="To Date"  class="example1 form-control input-sm" id="todate" onchange="filtration_checkin();">
                               </div>
                               </li>';
                               if($role != "employee") { 
                                echo'<li><div class="col-lg-12 filter_top"> 
                                      <div class="form-group">
                                      <label>View Others</label>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="choice_filter" id="shift_filter" value="shift">Shift
                                          </label>
                                        </div>';
                                        if($role =='admin') {
                                          echo'<div class="radio">
                                           <label>
                                             <input type="radio" name="choice_filter" id="team_filter" value="team">Team
                                            </label>
                                          </div>';
                                        }
                                      echo'<div class="radio">
                                        <label>
                                          <input type="radio" name="choice_filter" id="id_filter" value="employee">Search By Id
                                        </label>
                                      </div>
                                      <div class="radio">
                                        <label>
                                          <input type="radio" name="choice_filter" id="name_filter" value="name">Search By Name
                                        </label>
                                      </div>
                                    </div> 
                                  </div>

                                <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_shift">
                                  <select class="form-control input-sm myselect" style="width:100%;"  id="filter_by_shift">
                                    <option value="">-filter by shift-</option>';
                                   $query = mysqli_query($con,"SELECT DISTINCT shift from emp_table where employeerole != 'admin'");
                                  while($result=mysqli_fetch_array($query)) {
                                    echo'<option value="'.$result['shift'].'">'.$result['shift'].'</option>';
                                  } 
                                  echo'</select></div>
                                  <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_team">
                                  <select class = "form-control input-sm myselect" style="width:100%;"  id="filter_by_team" >
                                  <option value="">-filter by team-</option>';
                                  $query = mysqli_query($con,"SELECT DISTINCT workunderteam from emp_table where employeerole != 'admin' ");
                                  while($result = mysqli_fetch_array($query)) {
                                    echo '<option value="'.$result["workunderteam"].'">'. $result["workunderteam"].'</option>';
                                  }
                                  echo '</select></div>
                                  <div class="col-sm-12 filter_bottom hidden" id="li_filter_by_choice_team">
                                    <select class = "form-control input-sm myselect" style="width:100%;"  id="filter_by_choice_team" onchange="filtration_monthlyshift();">
                                    </select>
                                  </div></li></ul>';
                              }
                         }
                         else {
                           echo'<a href="javascript:void(0)" onclick="showdialogshift()">Monthly Shift</a>';
                         }
                       ?>
                     </li>
                   </ul>
               </li>

           <!-- /.nav-fourth-level.................................................................... -->

               <li>
                   <a href="#"><i class="fa fa-clock-o fa-spin fa-fw"></i>Calendar<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role=='admin'){
                           echo '<li><a href="addroster.php">Add Monthly Roster</a></li>';
                       }?>
                     
                     <li>
                         <a href="holiday.php">Holiday</a>
                     </li>
                   </ul>
               </li>

              <!-- /.nav-fifth-level......................................................................... -->

              <?php if($role!='employee'){
                echo'<li><a href="report.php"><i class="fa fa-bar-chart-o fa-fw"></i>Report</a></li>';
              }
              ?>

           <!-- /.nav-sixth-level....................................................................... -->        
           <li>
               <a href="manual.php"><i class="fa fa-bar-chart-o fa-fw"></i>Manual & FAQ</a>
           </li>
                    <!-- /.nav-seven-level....................................................................... -->
           <?php if($role == 'admin') {
             echo '<li>
                   <a href="machine-connection.php"><i class="fa fa-bar-chart-o fa-fw"></i>Connection</a>
                 </li>';}?>
         </ul>
         </div>
         <!-- /.sidebar-collapse -->
         </div> 
          <!-- /.navbar-static-side -->
         </nav> 
<div id="page-wrapper">
 <div class="row">
      <div class="col-lg-4"> <h2 >Monthly Shift</h2></div>
      <div class="col-lg-4">  
        <h6><a href="monthlyshift.php"><i class="fa fa-calendar" ></i></a> <?php echo $title."-".$year;?></h6>
      </div>
      <div class="col-lg-4">
      <a href="pdf/actionpdf.php" class="pdfbutton"><input type="button" value=" Download as PDF"></a>
      </div>
    </div>
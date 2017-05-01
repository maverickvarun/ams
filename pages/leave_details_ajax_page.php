<?php session_start();

  include('connection.php');
	
if(!isset($_REQUEST['approved-status'])) {
      $user = $_SESSION['user'];
      $status = $_REQUEST['rejected-status'];
      $emp_id = $_REQUEST['emp_id'];
      $onedate = $_REQUEST['onedate'];
      $fromdate = $_REQUEST['fromdate'];
      $todate = $_REQUEST['todate'];
      if($emp_id !=""){
        $user_one = $emp_id; 
      } 
      else {
        $user_one =$user;
      } 
      echo '<table width="100%" class="table table-striped table-bordered table-hover common-table" id="table_leave_details">
      <tbody>';
      $_SESSION['pdf']='';
      $_SESSION['pdf'] .= '<tr><td></td><td>EMP ID</td>
      <td>LEAVE TYPE</td>
      <td>SUBMISSION DATE</td>
      <td>FROM DATE</td>
      <td>TO DATE</td>
      <td>DESCRIPTION</td></tr>';
      include('connection.php');
      if($onedate != '') {
        $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user_one."' and status ='".$status."' and date ='".$onedate."' ORDER BY date DESC ");
      }
      elseif($fromdate !='' && $todate !='') {
        $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user_one."' and status ='".$status."' and date BETWEEN '".$todate."' AND '".$fromdate."' ORDER BY date DESC ");
      }
      elseif($user_one !='' && $onedate !='') {
        $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user."' and status ='".$status."' and empid ='".$user_one."' and date ='".$onedate."' ORDER BY date DESC ");
      }
      elseif($user_one !='' && $todate !='' && $fromdate !='') {
        $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user."' and status ='".$status."' and date BETWEEN '".$todate."' AND '".$fromdate."' and empid='".$user_one."' ORDER BY date DESC ");
      }
      else {
        $query = mysqli_query($con,"SELECT * from leave_history_table where approvedby='".$user_one."' AND status ='".$status."' ORDER BY date DESC ");
      }
      while($row = mysqli_fetch_row($query)) {
          $_SESSION['pdf'] .= "<tr><td><form action='leavedetails.php' method='GET'><input type='hidden' value='".$row[0]."' name='req_id'/><input type='submit' class='btn-xs leave-grant-deny-button' name='grant-leave-ajax' value='grant' style='background:#f0ad4e;'/></form></td><td>".$row[1]."</td> <td>".$row[6]."</td> <td>".$row[3]."</td> <td>".$row[4].'</td>'; 
           $_SESSION['pdf'] .= " <td>".$row[5]."</td>"." <td>".$row[7]."</td> </tr>";
        }
        echo $_SESSION['pdf'];
        echo '</tbody></table></div></div></div></div>';
  }
  else {
    $user = $_SESSION['user'];
    $status = $_REQUEST['approved-status'];
    $emp_id = $_REQUEST['emp_id'];
    $onedate = $_REQUEST['onedate'];
    $fromdate = $_REQUEST['fromdate'];
    $todate = $_REQUEST['todate'];
    if($emp_id !=""){
        $user_one = $emp_id; 
    } 
    else {
        $user_one =$user;
    } 
    echo '<table width="100%" class="table table-striped table-bordered table-hover common-table" id="table_leave_details">
    <tbody>';
    $_SESSION['pdf']='';
    $_SESSION['pdf'] .= '<tr><td></td><td>EMP ID</td>
    <td>LEAVE TYPE</td>
    <td>SUBMISSION DATE</td>
    <td>FROM DATE</td>
    <td>TO DATE</td>
    <td>DESCRIPTION</td></tr>';
    include('connection.php');
    if($onedate != '') {
      $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user_one."' and status ='".$status."' and date ='".$onedate."' ORDER BY date DESC ");
    }
    elseif($fromdate !='' && $todate !='') {
      $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user_one."' and status ='".$status."' and date BETWEEN '".$todate."' AND '".$fromdate."' ORDER BY date DESC ");
    }
    elseif($user_one !='' && $onedate !='') {
      $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user."' and status ='".$status."' and empid ='".$user_one."' and date ='".$onedate."' ORDER BY date DESC ");
    }
    elseif($user_one !='' && $todate !='' && $fromdate !='') {
      $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user."' and status ='".$status."' and date BETWEEN '".$todate."' AND '".$fromdate."' and empid='".$user_one."' ORDER BY date DESC ");
    }
    else {
      $query = mysqli_query($con,"SELECT * from leave_history_table where approvedby='".$user_one."' AND status ='".$status."' ORDER BY date DESC ");
    }
    // $query = mysqli_query($con,"select * from leave_history_table where approvedby='".$user."' and status ='".$status."' ORDER BY date DESC ");
    if($query) {
      while($row = mysqli_fetch_row($query)) {
        $_SESSION['pdf'] .= "<tr><td><form action='leavedetails.php' method='GET'><input type='hidden' value='".$row[0]."' name='req_id'/><input type='submit' class='btn-xs leave-grant-deny-button' name='deny-leave-ajax' value='deny' style='background:#f0ad4e;'></form></td><td>".$row[1]."</td> <td>".$row[6]."</td> <td>".$row[3]."</td> <td>".$row[4].'</td>'; 
         $_SESSION['pdf'] .= " <td>".$row[5]."</td>"." <td>".$row[7]."</td> </tr>";
      } 
    }
       
        echo $_SESSION['pdf'];
        echo '</tbody></table></div></div>';
  }
    /**
    * // code is used for the fetching the data from the database
    */

       
    ?>       
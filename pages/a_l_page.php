<?php session_start();
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  include('connection.php');
  echo'<table width="100%" class="table table-striped table-bordered table-hover common-table" id="tableleavehistory">
      <tbody>';
  $_SESSION['pdf'] = '';
  $_SESSION['pdf'] .= '<tr><td>Submission Date</td><td>From </td><td>To</td><td>Type</td><td>Description</td>
    <td>Status</td><td>Approved By</td></tr>';

  $onedate = $_REQUEST['one_date'];
  $fromdate = $_REQUEST['from_date'];
  $todate = $_REQUEST['to_date'];
  if($role !='employee') {
    $choice_id = $_REQUEST['choice_id'];
    if($choice_id !='') {
      $user = $choice_id;
    }
  }  
  else {
    $user = $user;
  }
  if($role !='employee') {
    if($onedate =='' and $fromdate =='' and $todate =='' and $choice_id =='') {
     $query = mysqli_query($con,"select * from leave_history_table WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
    }
  }
  else {
    if($onedate =='' and $fromdate =='' and $todate =='' ) {
     $query = mysqli_query($con,"select * from leave_history_table WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
    }
  }

  if($onedate !='') {
    $query = mysqli_query($con,"select * from leave_history_table WHERE date = '".$onedate."' and emp_id = '".$user."'");
  }
  if($onedate =='') {
    $query = mysqli_query($con,"select * from leave_history_table WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
  }
  if($fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from leave_history_table where date BETWEEN '".$fromdate."' and '".date('Y-m-d')."'and emp_id ='".$user."'");
  }
  if($todate !='' and $fromdate =='') {
   $query = mysqli_query($con,"select * from leave_history_table WHERE date BETWEEN '".date('Y-m-d')."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
  else if($todate !='' and $fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from leave_history_table WHERE date BETWEEN '".$fromdate."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
  if($query) {
    while($row=mysqli_fetch_row($query)) {
    $_SESSION['pdf'] .= "<tr> <td>".$row[3]."</td> <td>".$row[4]."</td> <td>".$row[5]."</td> <td>".$row[6]."</td> <td>".$row[7]."</td> <td>".$row[8]."</td> <td>".$row[9]."</td>";
  }  
  }
  
  
  echo $_SESSION['pdf'];
  echo'</tbody></table></div></div></div></div>';
?>
                

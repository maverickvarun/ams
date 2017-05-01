<?php session_start();
  $role=$_SESSION['role'];
  $user=$_SESSION['user'];
  $firstname=$_SESSION['firstname'];
  $lastname=$_SESSION['lastname'];
  include('connection.php');
  echo'<table width="100%" class="table table-striped table-bordered table-hover common-table" id="tablemonthlyshift">
    <thead><tbody>';
  $_SESSION['pdf'] = '';
  
  $onedate = $_REQUEST['one_date'];
  $fromdate = $_REQUEST['from_date'];
  $todate = $_REQUEST['to_date'];
  if($role !='employee') {
    $choice_id = $_REQUEST['choice_id'];
    if($choice_id !='') {
      $val = $choice_id;
    }
  }  
  else {
    $val = $user;
  }
   $_SESSION['pdf'] .= '<tr><td>DATE</td><td>DAYS OF WEEK</td><td>'.$val.'</td></tr>';
  if($role !='employee') {
    if($onedate =='' and $fromdate =='' and $todate =='' and $choice_id =='') {
     $query = mysqli_query($con,"select date,day_of_week,".$val." from monthly_shift_table ORDER BY date DESC");
    }
  }
  else {
    if($onedate =='' and $fromdate =='' and $todate =='' ) {
     $query = mysqli_query($con,"select date,day_of_week,".$val." from monthly_shift_table ORDER BY date DESC");
    }
  }

  if($onedate !='') {
    $query = mysqli_query($con,"select date,day_of_week,".$val." from monthly_shift_table WHERE date = '".$onedate."'");
  }
  if($onedate =='') {
    $query = mysqli_query($con,"select date,day_of_week,".$val." from monthly_shift_table WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."'  ORDER BY date DESC");
  }
  if($fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from emp_checks where date BETWEEN '".$fromdate."' and '".date('Y-m-d')."'and emp_id ='".$user."'");
  }
  if($todate !='' and $fromdate =='') {
   $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".date('Y-m-d')."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
  else if($todate !='' and $fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".$fromdate."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
  if($query) {
    while($row = mysqli_fetch_row($query)) {
      $_SESSION['pdf'] .= "<tr> <td>".$row[0]."</td> <td>".$row[1]."</td> <td>".$row[2]."</td> </tr>";
    }
  }
 
  echo $_SESSION['pdf'];
  echo'</table></div>';
?>
                

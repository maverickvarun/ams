<?php session_start();
  $role = $_SESSION['role'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $user =$biomatric_id;
  $date = strtotime(date("Y-m-d"));
  $day = date('d', $date);
  $month = date('m', $date);
  $year = date('Y', $date);
  include('connection.php');
  echo'<table width="100%" class="table table-striped table-bordered table-hover common-table" id="tablecheckinout">
      <tbody>';
  $_SESSION['pdf'] = '';
  $_SESSION['pdf'] .= '<tr>
  <td>Day</td>
      <td>DATE</td>
      <td>SIGN IN</td>
      <td>SIGN OUT</td>';
        if($role != "employee") {
          $_SESSION['pdf'] .= ' <td>WORKING HOURS</td>';
        }
        $_SESSION['pdf'] .= '<td>Particulars</td><td>Remarks</td>';
        if($role == "admin") {
          $_SESSION['pdf'] .= ' <td>Action</td>';
        }
        $_SESSION['pdf'].='</tr>';
  /**
  * below code is used for filteration on From date to To date ........................................
  */
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
    $user = $biomatric_id;
  }
  if($role !='employee') {
    if($onedate =='' and $fromdate =='' and $todate =='' and $choice_id =='') {
     $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
    }
  }
  else {
    if($onedate =='' and $fromdate =='' and $todate =='' ) {
     $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
    }
  }
  
  if($onedate !='') {
    $query = mysqli_query($con,"select * from emp_checks WHERE date = '".$onedate."' and emp_id = '".$user."'");
  }
  if($onedate =='') {
    $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".date('Y-m-'.'01')."' AND '".date('Y-m-d')."' and emp_id = '".$user."' ORDER BY date DESC");
  }
  if($fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from emp_checks where date BETWEEN '".$fromdate."' and '".date('Y-m-d')."'and emp_id ='".$user."' ORDER by date ASC");
  }
  if($todate !='' and $fromdate =='') {
   $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".date('Y-m-d')."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
  else if($todate !='' and $fromdate !='' and $onedate =='') {
    $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".$fromdate."' AND '".$todate."' and emp_id = '".$user."' ORDER BY date ASC");
  }
 
  
  if($query) {
      while($row = mysqli_fetch_array($query)) {
          if($row['check_in']!=''){
            $check_in = date('g:i A', strtotime($row['check_in']));
          }else {
            $check_in = $row['check_in'];
          }
          if($row['check_out']!=''){
            $check_out = date('g:i A',strtotime($row['check_out']));
          }
          else{
            $check_out=$row['check_out'];
          }
          $dayname = date('l',strtotime($row['date']));
          $query_holiday = mysqli_query($con,"SELECT * from holiday_table where Date ='".$row['date']."'");
          if(mysqli_num_rows($query_holiday)){
            while($result_holiday = mysqli_fetch_array($query_holiday)){
              $_SESSION['pdf'] .= "<tr style='background:#f0f02e80;'><td>".$dayname." (".$result_holiday['Festival'].")</td>";
            }
          }
          else{
                $_SESSION['pdf'] .= "<tr><td>".$dayname."</td> ";
           }
          
           
          $_SESSION['pdf'] .= "<td>".$row['date']."</td> <td>".$check_in."</td> <td>".$check_out.'</td>'; 
          if($role != "employee") {
            $_SESSION['pdf'] .= " <td>".$row['working_hrs'].'</td>';
          }
          $_SESSION['pdf'] .= " <td>".$row['particulars']."</td><td>".$row['remarks']."</td>";
          if($role =="admin") {
            $_SESSION['pdf'].="<td ><a href='javascript:;' onclick='div_edit_attendance_show($row[0],$row[1])' class='".$row[0]."'>Edit</a></td>";
          }
        }
        $_SESSION['pdf'].="</tr>";
    echo $_SESSION['pdf'];
    echo '</tbody></table>';
  }

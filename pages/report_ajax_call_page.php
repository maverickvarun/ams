<?php session_start();
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  $date = strtotime(date("Y-m-d"));
  $day = date('d', $date);
  $month = date('m', $date);
  $year = date('Y', $date);
  include('connection.php');
  echo'<table width="100%" class="table table-striped table-bordered table-hover common-table" id="tablecheckinout">
      <thead><tbody>';
  $_SESSION['pdf'] = '';
  $_SESSION['pdf'] .= ' <tr>
  <td>EMP ID</td>
  <td>DATE</td>
  <td >CHECK IN</td>
  <td>CHECK OUT</td>';
  if($role != "employee") {
    $_SESSION['pdf'] .= ' <td>WORKING HOURS</td>';
  }
  $_SESSION['pdf'] .= '<td>REMARKS</td></tr>';
  /**
  * below code is used for filteration on From date to To date ........................................
  */
  if(isset($_REQUEST['to_date'])) {
    $v1 = $_REQUEST['to_date'];
    $v2 = $_REQUEST['from_date'];
    if($role != 'employee') {
      $emp_id = $_REQUEST['emp-id'];
      $emp_name = $_REQUEST['emp-name'];
      
      if($emp_id != '') {
        $val = $emp_id;
      }
      elseif($emp_name != '') {
        $val = $emp_name;
      }
      elseif($emp_id == '' && $emp_name == '') {
        $val = $user; 
      }
      if($role != 'employee') {
        $choice_id = $_REQUEST['choice-id'];
        if( $choice_id != '') {
          $val = $choice_id;
        }
      }
      if($v1 == '' && $v2 == '') {
         $query = mysqli_query($con,"select * from emp_checks where MONTH(date)=$month AND YEAR(date)=$year AND emp_id = '".$val."' ORDER BY date DESC");  
      }  
      else {
        $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".$v2."' AND '".$v1."' and emp_id = '".$val."' ORDER BY date ASC");
      }  
    }
    else {
      $query = mysqli_query($con,"select * from emp_checks WHERE date BETWEEN '".$v2."' AND '".$v1."' and emp_id = '".$user."' ORDER BY date ASC");
    }      
  }             
  /**
  * below code is used for filteration on one date........................................
  */

  if(isset($_REQUEST['one_date'])) {
    $v3 = $_REQUEST['one_date'];
    if($role != 'employee') {
      $emp_id = $_REQUEST['emp-id'];
      $emp_name = $_REQUEST['emp-name'];
      if($emp_id != '') {
        $val = $emp_id;
      }
      elseif($emp_name != '') {
        $val = $emp_name;
      }
      else {
        $val = $user; 
      }
      if($role != 'employee') {
          $choice_id = $_REQUEST['choice-id'];
          if( $choice_id != '') {
             $val = $choice_id;
          }
      }
        $query = mysqli_query($con,"select * from emp_checks WHERE date = '".$v3."' and emp_id = '".$val."'");
    }
    else {
      $query = mysqli_query($con,"select * from emp_checks WHERE date = '".$v3."' and emp_id = '".$user."'");
    }  
  }
  
  if($query) {
    while($row=mysqli_fetch_row($query)){
    $_SESSION['pdf'] .= "<tr><td>".$row[0]."</td> <td>".$row[1]."</td> <td>".$row[2]."</td> <td>".$row[3].'</td>'; 
    
    if($role != "employee") {
      $_SESSION['pdf'] .= " <td>".$row[4].'</td>';
    }
    $_SESSION['pdf'] .= " <td>".$row[6]."</td> </tr>";
  }  
  }
  

echo $_SESSION['pdf'];
echo '</table></div></div>';



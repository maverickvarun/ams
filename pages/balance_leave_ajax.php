<?php 
  include('connection.php');
  session_start();
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  if($role !='employee') {
    $choice_id =$_REQUEST['choice_id'];
    if($choice_id !="") {
      $val = $choice_id;
    }
    else {
      $val = $user;
    }
  }
  $query = mysqli_query($con,"select leaves from emp_table where empid='".$val."'" );
  echo'<table width="100%" class="table table-striped table-bordered table-hover common-table" id="balance_leave">
      <tbody>
      <tr><td>Leave</td></tr>';
      if($query) {
        while($row=mysqli_fetch_row($query)) {
          print "<tr> <td>"; echo $row[0];
          print "</td>";
        }  
      }
      
      echo'</tbody></table></div></div></div></div>';



?>

<?php

include('connection.php');
if(isset($_POST['id'])){
  session_start();
  $user=$_POST['id'];
  $q=mysqli_query($con,"SELECT * from emp_table where empid='".$user."'");
  while($res=mysqli_fetch_row($q)){
    $workunderteam=$res[20];
    $role = $_SESSION['role'];
    $name=$res[3]." ".$res[4];
  }
}else{
  $user = $_SESSION['user'];

  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  $workunderteam = $_SESSION['workunderteam'];
}
  date_default_timezone_set('Asia/Kolkata');

/* Set the default timezone */


/* Set the date */
date_default_timezone_set('Asia/Kolkata');
$date = strtotime(date("Y-m-d"));
$day = date('d', $date);
$month = date('m', $date);
$year = date('Y', $date);
$firstDay = mktime(0,0,0,$month, 1, $year);
$title = strftime('%B', $firstDay);
$dayOfWeek = date('D', $firstDay);
$daysInMonth = cal_days_in_month(0, $month, $year);
/* Get the name of the week days */
$timestamp = strtotime('next Sunday');
$weekDays = array();
for ($i = 0; $i < 7; $i++) {
    $weekDays[] = strftime('%a', $timestamp);
    $timestamp = strtotime('+1 day', $timestamp);
}
$blank = date('w', strtotime("{$year}-{$month}-01"));

if($role!='employee'){
echo'
<form action="" method="post" autocomplete="on">
<div class="row">
  <div class="col-sm-6 col-sm-offset-5">
  <h3><span>'.$name.'</span></h3><input style="border:none" type="text" class="form-control input-col-rest hidden" name="userid" value='.$user.'>
  </div>
  <div class="col-sm-1">
  <button name ="submit" data-rel="back" class="btn btn-primary btn-xs" type="submit" ><i class="fa fa-save"></i> Save</button>
  </div>
</div>

';
}

echo'
<div class="panel panel-default table-responsive">
  <table width="100%" class="table table-bordered table-hover common-table" id="calendar-view">
    <tr>
    ';
       foreach($weekDays as $key => $weekDay) {
     echo' <th class="text-center" >'.strtoupper($weekDay).'</th>';
        }
        echo'
    </tr>
    <tr>';
       for($i = 0; $i < $blank; $i++){
        echo'
        <td valign="middle"></td>';
         }
         for($i = 1; $i <= $daysInMonth; $i++){
           if($i == $day){
               include('connection.php');
              $datefatch=date('d-M-y');
              $q = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_roster_table where date='".$datefatch."'");
                $count=0;
              if($q){
                 $count=mysqli_num_rows($q);
              }

                 if($count>0) {
                    while($row=mysqli_fetch_array($q)) {
                      if($role!="employee"){
                        echo "<td  class='bg-warning'><center style='color:gray;'> ".$i." "."<br/><input class=\"form-control input-col-rest" . "\" type=\"text\" tabindex=\"".$i."\" name=\"input".$i."\" value=\"" . $row[0] . "\"></center></td>";
                      }
                      else{
                        echo "<td  class='bg-warning'><center style='color:gray;'> ".$i." "."<br/><span>". $row[0]. "</span></center></td>";
                      }
                    }
                  }
                 else {
                   // echo"<td class='bg-warning'><center style='color:gray;'> ".$i."<br/></center></td>";
                   if($role=="employee"){
                   $query3=mysqli_query($con,"SELECT * from template_roster_table where emp_id='".$user."' ");
                         $result1=mysqli_fetch_array($query3);


                   $date_fetch = date($i.'-M-y');
                     $dayName = strtolower(date("l",strtotime($date_fetch)));
                   if($dayName==strtolower($result1['firstweekoff'])||strtolower($dayName)==strtolower($result1['secondweekoff'])){
                         echo  "<td class='bg-warning'>".$i."<br/><span>"."WO"."</span></td>";
                      }
                     else {
                      echo  "<td class='bg-warning'>".$i."<br/><span>".$result1['shift']."</span></td>";
                     }
                   }   else{
                      echo  "<td class='bg-info'>".$i."<br/><input class=\"form-control input-col-rest" . "\" type=\"text\" tabindex=\"".$i."\" name=\"input".$i."\" value=\" \"></td>";
                    }
                  }

                }else{
                if($i<10){
                  $date_fetch = date('0'.$i.'-M-y');
                 }else{
                  $date_fetch = date($i.'-M-y');
                 }

                  $dayName = strtolower(date("l",strtotime($date_fetch)));
                  $query = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_roster_table where date='".$date_fetch."'");
                  // if($query){
                  //   $count = mysqli_num_rows($query);
                  // }
                   if($role=="employee"){
                 $query4=mysqli_query($con,"SELECT * from template_roster_table where emp_id= '".$user."' ");
                  $result=mysqli_fetch_array($query4);
                }
                  $count1=0;
                  if($query){
                   $count1=mysqli_num_rows($query);
                  }
                  if($count1>0) {
                    while($row = mysqli_fetch_array($query)) {
                      if($role!='employee'){
                      echo "<td><center> ".$i." "."<br/> <input class=\"form-control input-col-rest" . "\" type=\"text\" tabindex=\"".$i."\" name=\"input".$i."\" value=\"" . $row[0] . "\"></center></td>";
                       $recordcnt=$i;

                      }
                      else{
                       echo "<td><center> ".$i." "."<br/><span>". $row[0]. "</span></center></td>";
                      }
                    }
                    echo"</form>";
                  }
                  else{
                  if($i <= date('d')) {
                  //$query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-'.$i)."','','','0','A','Absent','0')");
                    if($role=='employee')
                     {
                      if($dayName==strtolower($result['firstweekoff'])||strtolower($dayName)==strtolower($result['secondweekoff'])){
                         echo  "<td >".$i."<br/><span>"."WO"."</span></td>";
                      }
                     else{
                      echo  "<td >".$i."<br/><span>".$result['shift']."</span></td>";
                     }
                    }
                    else{
                     echo  "<td class='bg-info'>".$i."<br/><input class=\"form-control input-col-rest" . "\" type=\"text\" tabindex=\"".$i."\" name=\"input".$i."\" value=\" \"></td>";
                   }
                  }else{
                    if($role=='employee')
                     {
                      if($dayName==strtolower($result['firstweekoff'])||strtolower($dayName)==strtolower($result['secondweekoff'])){
                         echo  "<td >".$i."<br/><span>"."WO"."</span></td>";
                      }
                     else {
                      echo  "<td >".$i."<br/><span>".$result['shift']."</span></td>";
                     }
                    }
                    else{
                     echo  "<td class='bg-info'>".$i."<br/><input class=\"form-control input-col-rest" . "\" type=\"text\" tabindex=\"".$i."\" name=\"input".$i."\" value=\" \"></td>";
                   }
                  }
              }
            }

             if(($i + $blank) % 7 == 0){
             echo  "</tr><tr>";
            }
        }for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++){
           echo'<td></td>';
        }
        echo'
    </tr>
</table>

</div>';
?>

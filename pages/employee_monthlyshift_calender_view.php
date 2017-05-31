<?php
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  $workunderteam = $_SESSION['workunderteam'];
  date_default_timezone_set('Asia/Kolkata');         

/* Set the default timezone */
include('connection.php');
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
?>
<div class=" page-header"><h1  class="text-center" valign="middle" > <?php echo strtoupper($title); ?> <?php echo $year ?> </h1></div>
<div class="panel panel-default table-responsive">    
  <table width="100%" class="table table-bordered table-hover common-table" id="calendar-view">
    
    <tr>
              <?php foreach($weekDays as $key => $weekDay) : ?>
                  <th class="text-center" ><?php echo strtoupper($weekDay); ?></th>
              <?php endforeach ?>
    </tr>
    <tr>
        <?php for($i = 0; $i < $blank; $i++): ?>
            <td valign="middle"></td>
            <?php endfor; ?>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php if($i == $day): ?>

              <?php include('connection.php');
                $q = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_table where date='".date('d-M-y')."'");
                // if($q){
                //  $count = mysqli_num_rows($q);                
                //   }
                  $query3=mysqli_query($con,"SELECT * from template_roster where emp_id= '".$user."' ");
                  $result1=mysqli_fetch_array($query3);
                 if($q) {
                    while($row=mysqli_fetch_array($q)) {
                      echo "<td  class='bg-warning'><center style='color:gray;'> ".$i." "."<br/><span>".$row[0]."</span></center></td>";
                    }
                }
                else {
                   // echo"<td class='bg-warning'><center style='color:gray;'> ".$i."<br/></center></td>";
                   if($dayName==strtolower($result['firstweekoff'])||strtolower($dayName)==strtolower($result['secondweekoff'])){
                         echo  "<td class='bg-warning'>".$i."<br/><span>"."WO"."</span></td>";
                      }  
                     else {
                      echo  "<td class='bg-warning'>".$i."<br/><span>".$result['shift']."</span></td>";
                     }
                 }
              ?>
            <?php else: ?>
            
            <?php
            // if($i<10){
            // $date_fetch = date('0'.$i.'-M-y');
            // }else{
             $date_fetch = date($i.'-M-y');
             $dayName = strtolower(date("l",strtotime($date_fetch)));
            // }
              $query = mysqli_query($con,"SELECT ".$user." from ".$workunderteam."_table where date='".$date_fetch."'");
              // if($query){
              //   $count = mysqli_num_rows($query);
              // }
               
               $query4=mysqli_query($con,"SELECT * from template_roster where emp_id= '".$user."' ");
                $result=mysqli_fetch_array($query4);
              if($query) { 
                while($row = mysqli_fetch_array($query)) { 
                  echo "<td><center> ".$i." "."<br/> <span>".$row[0]."</span></center></td>";    
                }                    
              }
              else{
                  if($i <= date('d')) { 
                  //$query = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$biomatric_id."', '".date('Y-m-'.$i)."','','','0','A','Absent','0')");
                      
                      if($dayName==strtolower($result['firstweekoff'])||strtolower($dayName)==strtolower($result['secondweekoff'])){
                         echo  "<td >".$i."<br/><span>"."WO"."</span></td>";
                      }
                      else{
                      echo  "<td >".$i."<br/><span>".$result['shift']."</span></td>";
                       } 
                   } else{  
                      if($dayName==strtolower($result['first_week_off'])||strtolower($dayName)==strtolower($result['second_week_off'])){
                         echo  "<td >".$i."<br/><span>"."WO"."</span></td>";
                      }  
                     else {
                      echo  "<td >".$i."<br/><span>".$result['shift']."</span></td>";
                     }
                  }
                }  

            ?>          
            <?php endif; ?>
            <?php if(($i + $blank) % 7 == 0): ?>
                </tr><tr>
            <?php endif; ?>
        <?php endfor; ?>
        <?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
            <td></td>
        <?php endfor; ?>
    </tr>
</table>

</div>
<?php 
session_start();
$role = $_SESSION['role'];
$biomatric_id=$_SESSION['biomatric_id'];
include('connection.php');
  $m1 = $_REQUEST['p-month'];
  $y1 = $_REQUEST['p-year'];
  if($role!='employee') {
    $emp_id = $_REQUEST['emp_id'];
    if($emp_id!='') {
      $query_bioId = mysqli_query($con,"SELECT biomatric_id from emp_table where empid = '".$emp_id."'");
      while($result_bioId=mysqli_fetch_array($query_bioId)){
        $biomatric_id = $result_bioId['biomatric_id'];
      }
    }
  }
  /* Set the default timezone */
  date_default_timezone_set('Asia/Kolkata');
  /* Set the date */
  $date = strtotime(date($y1."-".$m1."-d"));
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
  <table width="100%" class="table table-bordered table-hover common-table" id="calendar-view">
    
    <tr>
    <?php foreach($weekDays as $key => $weekDay) : ?>
        <th class="text-center bg-warning" ><?php echo strtoupper($weekDay); ?></th>
    <?php endforeach ?>
    </tr>
    <tr>
    <?php for($i = 0; $i < $blank; $i++): ?>
        <td valign="middle"></td>
    <?php endfor; 
     for($i = 1; $i <= $daysInMonth; $i++): 
       if($i == $day): 
          $q = mysqli_query($con,"select * from emp_checks where emp_id='".$biomatric_id."' AND date='".date($y1.'-'.$m1.'-d')."'");
        $checks = '';
        $working_hrs = '';
        $count = mysqli_num_rows($q);
        if($count != 0) {
          while($row=mysqli_fetch_array($q)) {
                    if($row['particulars']=='Leave' and $row['remarks'] !=''){
                      echo "<td class='leave_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Leave' and $row['remarks'] ==''){
                      echo "<td class='leave_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] !=''){
                      echo "<td class='half_day'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] ==''){
                      echo "<td class='half_day'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] !=''){
                      echo "<td class='weekly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] ==''){
                      echo "<td class='weekly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='A'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='P'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] !=''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] ==''){
                      echo "<td ><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] !=''){
                      echo "<td class='monthly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] ==''){
                      echo "<td class='monthly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] !=''){
                      echo "<td class='holiday_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] ==''){
                      echo "<td class='holiday_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['checks']=='R' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>R</span></center></td>";
                    }
                    elseif($row['checks']=='A' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['checks']=='P' and $row['particulars'] ==''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>P</span></center></td>";
                    }
                    else{
                      echo "<td><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>".$row['checks']."</span></center></td>";
                    }
          }
        }
        else {
          echo"<td class='bg-warning'><center> ".$i." </center></td>";
        }
      ?>
      <?php else: 
        $query = mysqli_query($con,"select * from emp_checks where DAY(date)='".$i."' and YEAR(date)='".$year."' and MONTH(date)='".$month."' and emp_id='".$biomatric_id."'");
        $count = mysqli_num_rows($query);
        if($count!=0) {
          while($row = mysqli_fetch_array($query)) { 
                   if($row['particulars']=='Leave' and $row['remarks'] !=''){
                      echo "<td class='leave_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Leave' and $row['remarks'] ==''){
                      echo "<td class='leave_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>L</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Absent' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] !=''){
                      echo "<td class='half_day'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='Half Day' and $row['remarks'] ==''){
                      echo "<td class='half_day'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>HD</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] !=''){
                      echo "<td class='weekly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='WO' and $row['remarks'] ==''){
                      echo "<td class='weekly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>WO</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='A'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['particulars']=='' and $row['remarks'] =='P'){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] !=''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='NA' and $row['remarks'] ==''){
                      echo "<td ><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>NA</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] !=''){
                      echo "<td class='monthly_off_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='MO' and $row['remarks'] ==''){
                      echo "<td class='monthly_off_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>MO</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] !=''){
                      echo "<td class='holiday_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Holiday' and $row['remarks'] ==''){
                      echo "<td class='holiday_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>H</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] !=''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['particulars']=='Present' and $row['remarks'] ==''){
                      echo "<td class='absent_checks'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>P</span></center></td>";
                    }
                    elseif($row['checks']=='R' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>R</span></center></td>";
                    }
                    elseif($row['checks']=='A' and $row['particulars'] ==''){
                      echo "<td class='absent_checks'  data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks fa fa-comment'>A</span></center></td>";
                    }
                    elseif($row['checks']=='P' and $row['particulars'] ==''){
                      echo "<td data-toggle='tooltip' title='".$row['remarks']."'><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>P</span></center></td>";
                    }
                    else{
                      echo "<td><center style='color:gray;'> ".$i." "."  <span class='working_hrs'>".$row['working_hrs']."</span><span class='working_checks'>".$row['checks']."</span></center></td>";
                    }
            
          }
        }
        else {
          echo  "<td >"."<b style='color:gray;'>".$i."</td>";
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
</div>
<?php
?> 

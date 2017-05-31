<?php /* session_start();
 include('checksession.php');
  include('popupform.php');
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  date_default_timezone_set('Asia/Kolkata');*/           
?>
<!-- calendar view .................................. ..................................................................................-->
    
<?php
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
                
                <?php include('connection.php');
                 $q = mysqli_query($con,"select ".$firstname." from sale_table ");
                 $count = mysqli_num_rows($q);
                 if($count != 0) {
                  while($row=mysqli_fetch_array($q)) {
                  
                    if($row['sale_tableId']==$i)
                    {
                    
                echo  "<td >"."<b style='color:gray;'>".$i."<br><br>". $row[$firstname]."</td>";
                 }
                           
                  }
                }
             
            ?>          
            
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
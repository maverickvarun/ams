<?php
  if(isset($_POST['get_attendance_data'])){
    include('connection.php');
    $year = '17';
    $month = $_POST['choose_month_csv'];
    $year1 = date_create_from_format('y', $year);
    $changed_year = $year1->format('Y') ; 
    $changed_month= date('m',strtotime($month.'-'.$changed_year));
    $loop=cal_days_in_month(CAL_GREGORIAN,$changed_month,$changed_year);
    $query = mysqli_query($con,"SELECT * FROM `emp_table`");
    //count if data is selected or not
    $countEmployee = mysqli_num_rows($query);
    if($countEmployee!=0){
      while($employee = mysqli_fetch_array($query)){
        $Emp_id = $employee['biomatric_id'];
        $workunderteam = $employee['workunderteam'];
        $dateofjoining = $employee['dateofjoining'];
        $date_of_joining = date("Y-m-d",strtotime($dateofjoining));
        // below code for chat team employee
        if($workunderteam=='Chat'){
          //  for($i=1;$i<=$loop;$i++) {
          //   //generate date
          //   $date = $i.'-'.$month.'-'.$year;
          //   $converted_date = date("Y-m-d", strtotime($date));
          //   $yesterday = date('Y-m-d',strtotime("-1 day",strtotime($converted_date)));
          //   //seldata according date or emp_id
          //   $query1 = mysqli_query($con,"SELECT * FROM `csv_table` WHERE Emp_id='".$Emp_id."' AND Date ='".$date."'");
          //   $count = mysqli_num_rows($query1);
          //   if($count!=0){
          //     while($result = mysqli_fetch_array($query1)){
          //       $query5 = mysqli_query($con,"SELECT emp_id,date,check_in,check_out,remarks,status from emp_checks where emp_id = '".$Emp_id."' and date='".$yesterday."'");
          //       $count1 = mysqli_num_rows($query5);
          //       if($count1!=0) {
          //         while($row = mysqli_fetch_array($query5)) {
          //             if($row['check_in']=='0'){
          //                mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."', '".$result['Time']."','0','','P','','1')");
          //             }
          //             else{
          //                 // below code is used to calculate the working hours of employee
          //               $checkTime = strtotime($row[2]);
          //               $newtimestamp = strtotime("+19 hours", $checkTime);
          //               $checkout = strtotime($result['Time']);
          //               $diff = $checkTime - $checkout;
          //               $init = abs($diff);
          //               $hours = floor($init / 3600);
          //               $minutes = floor(($init / 60) % 60);
          //               $seconds = $init % 60;
          //               $d = $hours.':'.$minutes.':'.$seconds;
          //               if($checkout<$newtimestamp){
          //                 mysqli_query($con,"UPDATE emp_checks set check_out = '".$result['Time']."', working_hrs ='".$d."',status='0' where date = '".$yesterday."' and emp_id='".$Emp_id."' ");
          //               }
          //             }
                      
          //         }
          //       }                    
          //     } 
          //   }
          //   elseif(strtotime($date_of_joining) <= strtotime($converted_date)){
          //     mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."', '0','0','','A','Absent','0')");
          //   }
          // }
        }
        // below code for other than chat team employee
        else{
          for($i=1;$i<=22;$i++) {
            //generate date
            if($i<=9){
            echo '</br>'.$date = '0'.$i.'-'.$month.'-'.$year;

            }
            else{
            echo '</br>'.$date = $i.'-'.$month.'-'.$year;

            }
            $converted_date = date("Y-m-d", strtotime($date));
            //seldata according date or emp_id
            $query1 = mysqli_query($con,"SELECT * FROM `csv_table` WHERE Emp_id='".$Emp_id."' AND Date ='".$date."'");
            $count = mysqli_num_rows($query1);
            if($count!=0){
              while($result = mysqli_fetch_array($query1)){
                $query5 = mysqli_query($con,"SELECT emp_id,date,check_in from emp_checks where emp_id = '".$Emp_id."' and date ='".$converted_date."' ");
                $count1 = mysqli_num_rows($query5);
                if($count1 !='0') {
                  while($row = mysqli_fetch_array($query5)) {
                    // below code is used to calculate the working hours of employee
                    $checkTime = strtotime($row[2]);
                    $newtimestamp = strtotime("+16 hours", $checkTime);
                    $checkout = strtotime($result['Time']);
                    $diff = $checkTime - $checkout;
                    $init = abs($diff);
                    $hours = floor($init / 3600);
                    $minutes = floor(($init / 60) % 60);
                    $seconds = $init % 60;
                    $d = $hours.':'.$minutes.':'.$seconds;
                    if($checkout<$newtimestamp) {
                      mysqli_query($con,"UPDATE emp_checks set check_out = '".$result['Time']."', working_hrs ='".$d."',status='0' where date = '".$converted_date."' and emp_id='".$Emp_id."' ");
                    }
                  }
                } 
                else {
                  $query3 = mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."', '".$result['Time']."','','','P','','1')");
                }
              }
            }
            else if(strtotime($date_of_joining) <= strtotime($converted_date)){
              mysqli_query($con,"INSERT INTO  emp_checks (emp_id, date, check_in,check_out,working_hrs,checks,remarks,status) VALUES ('".$Emp_id."', '".$converted_date."', '','','','A','Absent','0')");
            }
          }
        }
      }
    }
    if($query){
      echo "<script type='text/javascript'>mscAlert({title: 'Done',subtitle: '".$month."-".$changed_year." Month csv data is successfully uploaded.',  // default: ''
        okText: 'Close',    // default: OK
        });</script>";
    }
  }
?>
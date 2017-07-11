<?php session_start();
  include('checksession.php');
  include('popupform.php');
  $role = $_SESSION['role'];
  $user = $_SESSION['user'];
  $biomatric_id = $_SESSION['biomatric_id'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $flag = $_SESSION['flag'];
  $workunderteam = $_SESSION['workunderteam'];
  $check_in_out = $_SESSION['check_in_out'];
  $last_swipe = $_SESSION['last_swipe'];
  date_default_timezone_set('Asia/Kolkata');
  $date = strtotime(date("Y-m-d"));
  $day = date('d', $date);
  $month = date('m', $date);
  $year = date('Y', $date);
  $firstDay = mktime(0,0,0,$month, 1, $year);
  $title = strftime('%B', $firstDay);

  if($role!='employee'){
      define("SDFE_CSVSeparator", ",");           // Separator
      define("SDFE_CSVLineTerminator", "\n");     // Line termination
      define("SDFE_CSVFolder", "csv");            // The folder for csv files. Must exist!
      define("SDFE_CSVFolderBackup", "csvbackup"); // The folder for backup files. Must exist!
      define("SDFE_CSVFileExtension", "csv");     // The csv file extension

      // opening csv files ........................................

      // Get array of CSV files
      $csvpath = SDFE_CSVFolder . "/";
      $files = scandir($csvpath); // this is all files in dir
       // clean up file list (to exclude)should only include csv files
        $csvfiles = array();
        foreach ($files as $basename) {
          if(substr($basename, -3)==SDFE_CSVFileExtension) {
              array_push($csvfiles, $basename);
          }
        }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AMS DASHBOARD</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- own css is imported here-->
    <link href="custom-css/sheet.css" rel="stylesheet">

    <link href="custom-css/datepicker.css" rel="stylesheet">

    <link href="custom-css/timeline.css" rel="stylesheet">

    <link href="Timepicki/css/timepicki.css" rel="stylesheet">

   <link rel="stylesheet" href="custom-css/popup.css">

    <link href="custom-css/select2.min.css" rel="stylesheet" />





    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      #calview{
        padding: 40px;
       }
    </style>

</head>

<body>
<div id="wrapper">
  <!-- Navigation -->
   <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;margin-top:5px;">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="dashboard.php"><img src="dls_logo.png"></a>
      </div>
      <!-- /.navbar-header -->
      <ul class="nav navbar-top-links navbar-left">
         <li style="margin-top:10px;"><?php echo'&nbsp;Welcome '.$firstname.' '.$lastname.' ('.$role.')';?></li>
      </ul>
      <ul class="nav navbar-top-links navbar-right">
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?php echo $last_swipe.':';?> <?php include('connection.php');
               $q4 = mysqli_query($con,"select date from emp_checks where checks='p' and emp_id = '".$biomatric_id."' order by date desc limit 1");
               while ($row=mysqli_fetch_array($q4)) {
                  echo $row[0];
               }
            ?>
            </a>
         </li>
                <!-- /.dropdown -->
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?php include('connection.php');
               if($flag == 'remote') {
                  $date = date("Y-m-d");
                  $status = '';
                  // below query is used to hide the checking button if user checkout then button is disabled.....
                  $query5 = mysqli_query($con,"SELECT status from emp_checks where emp_id = '".$biomatric_id."' and date = '".$date."'");
                  while($result = mysqli_fetch_array($query5)){
                     $status = $result[0];
                  }
                  if($status == '0') {
                  }
                  else {
                     echo '<span class="fa fa-sign-in check-in" name="checking" id="checking" value="'.$check_in_out.'" > '.$check_in_out.'</span>';
                  }
               }
            ?>
            </a>
         <!-- /.dropdown-tasks -->
         </li>

         <!-- /.dropdown -->
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
               <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
               <?php
                if($role!="employee"){
                  echo'<li><a href="javascript:;" id="remote_checkin_popup" onclick="div_show_remote_checkin()"><i class="fa fa-desktop fa-fw" ></i>Remote Checkin</a>
                  </li>';
                }
              ?>
               <li><a href="javascript:;" id="change_password_popup" onclick="div_show()"><i class="fa fa-gear fa-fw" ></i>Change Password</a>
               </li>
               <li class="divider"></li>
               <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
               </li>
            </ul>
           <!-- /.dropdown-user -->
         </li>          <!-- /.dropdown -->

      </ul>
            <!-- /.navbar-top-links -->
      <div class="navbar-default sidebar " role="navigation"  >
         <div class="sidebar-nav navbar-collapse" >
            <ul class="nav" id="side-menu">
               <li><a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
               <li><a href="#"><i class="fa fa-male fa-fw"></i>Employee<span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level">
                         <?php if ($role=='admin'){
                                       echo '<li><a href="addemployee.php">Add Employee</a></li>';
                                       echo '<li><a href="modifyemployee.php">Modify Employee</a></li>';
                                   }
                         ?>
                  <li class="active"><a href="viewsigninout.php" >View Attendance</a></li>

                     <?php if($role!="employee"){
                         echo '<li><a href="viewemployeedetails.php">View Employee Details</a></li>';

                       }
                     ?>
                  </ul>
               </li>

               <li>
                  <a href="#"><i class="fa fa-briefcase fa-fw"></i>Leave<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level">
                   <?php if($role != "admin"){
                     echo '<li><a href="javascript:;" onclick="div_leave_request_show();">Leave Request</a></li>';
                      }
                        if($role != "employee") {
                         echo'<li><a href="leavedetails.php">Leave Details</a></li>';
                        }
                     ?>
                    <li ><a href="availableleaves.php">Available Leaves</a></li>
              </ul>
            </li>

             <!-- team menu .......................................... -->
               <?php if($role =='admin'){
                  echo'<li>
                    <a href="#"><i class="fa fa-rocket fa-fw"></i>Team<span class="fa arrow"></span></a>
                      <ul class="nav nav-second-level">
                        <li><a href="javascript:;" onclick="div_add_team_show();">Add New Team</a></li>
                        <li><a href="javascript:;" onclick="div_show_modify_team();">Modify Team</a></li>
                      </ul>
                  </li>';
                }
               ?>

            <!-- /.nav-third-level........................................................................ -->
               <li class="active">
                   <a href="#"><i class="fa fa-tasks fa-fw"></i>Shift<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php

                       if($role == "admin"){
                           echo'<li><a href="javascript:;" onclick="div_show_change_shift();">Modify Shift</a></li>';
                       }
                     ?>
                     <li class="active">
                      <?php
                       echo'<a href="monthlyshift.php">Monthly Shift</a>';

                           if($role != "employee") {
                           echo'
                           <ul class="nav nav-second-level">
                             <li><div class="navbar-form" role="search">
                                   <div class="input-group">
                                     <input class="form-control searchbox" placeholder="Search Name, Id" id="search_term" type="text" list="filter_by_choice_team" onchange="filtration_employee_shift();">

                                     <div class="input-group-btn" >
                                       <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-arrow-right"></i></button>
                                     </div>
                                   </div>
                                   <input class="form-control hidden" type="text" id="selectedemp">

                                 </div>
                               </li>
                             <datalist id="filter_by_choice_team" style="width:100%">
                             </datalist>
                           </ul>
                          ';
                      }
                      ?>
                     </li>
                   </ul>
               </li>

           <!-- /.nav-fourth-level.................................................................... -->

               <li>
                   <a href="#"><i class="fa fa-clock-o fa-spin fa-fw"></i>Calendar<span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level">
                     <?php if ($role!='employee'){
                           echo '<li><a href="addroster.php">Add Monthly Roster</a></li>';
                       }?>

                     <li>
                         <a href="holiday.php">Holiday</a>
                     </li>
                   </ul>
               </li>

              <!-- /.nav-fifth-level......................................................................... -->

              <?php if($role!='employee'){
                echo'<li><a href="report.php"><i class="fa fa-bar-chart-o fa-fw"></i>Report</a></li>';
              }
              ?>

           <!-- /.nav-sixth-level....................................................................... -->
           <li>
               <a href="manual.php"><i class="fa fa-bar-chart-o fa-fw"></i>Manual & FAQ</a>
           </li>
                    <!-- /.nav-seven-level....................................................................... -->
           <?php if($role == 'admin') {
             echo '<li>
                   <a href="machine-connection.php"><i class="fa fa-bar-chart-o fa-fw"></i>Connection</a>
                 </li>';}?>
         </ul>
         </div>
         <!-- /.sidebar-collapse -->
         </div>
          <!-- /.navbar-static-side -->
         </nav>
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-4"> <h2 >Monthly Shift</h2></div>
      <div class="col-lg-4">
        <h6><a href="monthlyshift.php"><i class="fa fa-calendar" ></i></a> <?php echo $title."-".$year;?></h6>
      </div>
      <div class="col-lg-4">
      <a href="pdf/actionpdf.php" class="pdfbutton"><input type="button" value=" Download as PDF"></a>
      </div>
    </div>
<!--
     <div class="row hidden">
        <div class="col-lg-12">
          <div class="panel ">

              <div class="row">
                <div class="col-sm-4 hidden" id="fi_onedate"></div>
                <div class="col-sm-4 hidden" id="fi_fromdate"></div>

                <div class="col-sm-4 hidden" id="fi_todate"></div>
              
              </div>

          </div>
        </div>
      </div> -->
 <div id="shiftcalview">
<?php
//............................for handling csv files..........................
if($role!='employee')
{
  // Set first csv file as default csv file to display in edit mode
       if(sizeof($csvfiles)>0) {
        $csv = $csvfiles[0];

        // Override default csv file if a csv file is provided
        if(isset($_GET["file"])) {
          $csv = $_GET["file"];
        }
        // Open CSV file
        if($role =='admin'){
          $filename = SDFE_CSVFolder . "/" . $csv;
        }else{
          $csv_name = $workunderteam.'.csv';
          $filename = SDFE_CSVFolder . "/". $csv_name;
          $csv=$csv_name;
        }
        if (file_exists($filename)) {
              $fp = fopen($filename, "r");
              $content = fread($fp, filesize($filename));
              $lines = explode("\n", $content);
              fclose($fp);


            //<!-- Edit CSV content -->
            echo'<div class="col-lg-6">';

            if(!isset($csv)) {

            }
            else{
                // CSV file is not empty, let's show the content
                $row = explode(SDFE_CSVSeparator, $lines[0]);
                $columns = sizeof($row);

                  if($role=='admin'){
                   // listing csv files in dropdown...................................
                   echo'<div class="dropdown col-lg-4">
                          <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">choose team wise roaster
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu " style="padding:0">';
                            foreach ($csvfiles as $basename) {
                             echo  makeCSVFileLink($basename, $csv);
                             }
                     echo'
                    </ul>
                  </div>
                 ';

                }
                $csvstartname= explode(".", $csv);
               echo'<div class="col-lg-4"> '.$csvstartname[0].' monthly shift'.'</div>';
            }
  } else{
   echo' <div class="alert alert-danger col-sm-4">
  <center><strong>File not found!</strong></center>
</div>';
$lines=0;
  }
}
else{
   echo' <div class="alert alert-danger col-sm-4">
  <center><strong>File not found!</strong></center>
</div>';
  }
}
  ?>

  </div>
   <?php if($role !='employee'){

      echo'<div class="text-right col-xs-offset-8">
            <a href="#" id="addcol" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add new col</a>
            <a href="#" id="addrow" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add new row</a>
            <a href="#" id="save" name ="save" class="btn btn-primary btn-xs" ><i class="fa fa-save"></i> Save</a>
           </div>
        <div style="margin-top:1 0px;" id="message"></div>
          <div class="row" style="margin-top:10px;">
            <div class="col-lg-12 panel ">
              <form class="form-inline" style="overflow-x:scroll;height:450px;overflow-y:scroll;">
                <table class="table" id="csvtable">
                 <tbody>';
                    // Show content

                     for ($lineCnt=0; $lineCnt<sizeof($lines); $lineCnt++) {
                         $row = explode(SDFE_CSVSeparator, $lines[$lineCnt]);
                         echo makeTableRow($lineCnt, $row, $columns);
                     }


             echo'</tbody>
                </table>
              </form>
           </div>
         </div>';
    }
    else{
        echo'<div  class="panel-default" id="calview">';
        include('employee_monthlyshift_calender_view.php');
        echo'</div>';
    }

?>
</div>
<div class="validate_check_roles" style="display:none";><?php echo $_SESSION["role"]; ?></div>
</div> <!-- page  wrapper div is closed here........................................-->
</div><!-- /#wrapper.....................................................................................-->

<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>

    <script src="../vendor/morrisjs/morris.min.js"></script>

    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- jQuery datepicker-->

    <script src="custom-js/bootstrap-datepicker.js"></script>

    <script src="custom-js/filteration-button.js"></script>

    <script type="text/javascript" src="custom-js/filtration_method.js"></script>

    <script type="text/javascript" src="custom-js/check_in_button.js"></script>

    <script src="custom-js/popup.js"></script>

    <script src="Timepicki/js/timepicki.js"></script>

    <script src="custom-js/select2.min.js"></script>

    <script type="text/javascript">
     $(".myselect").select2();
  </script>
    <script type="text/javascript">
      // When the document is ready
      $(document).ready(function () {
        $('.example1').datepicker({
          format: "yyyy-mm-dd"
        });
      });
    </script>
    <script>
      $('#timepicker1').timepicki();
      $('#custom-time').click(function() {
        $('#timepicker1').show();
      });
      $('#current-time').click(function() {
        $('#timepicker1').hide();
      });
    </script>
     <script type="text/javascript">
    /**
      * below two function is used to show the dialog box on the menu bar and monthly shift panel if monthly shift is not updated for the month or no data is avaiable in the monthly shift
    */
     function showdialogshift() {
        mscAlert({title: 'CSV not found',subtitle: 'Please Update Roster.',// default: ''
        okText: 'Close',    // default: OK
        });

      }

     </script>
     <!-- display and managing content of csv -->
  <script>
    var csvfile = "<?php echo $csv;?>";
    // Add row
    var addedcol=0;
    var addedrow=0;
    // Add row
   $("#addrow").click(function(e) {
        e.preventDefault();
        // get linenumber of last row
         addedrow=addedrow+1;
         var lastline = parseInt($("#csvtable tbody tr:last").attr("id").split("-")[1]);
         var linenum = $("#csvtable tbody").find("tr:last td").length;
        $("#csvtable tbody ").append(makeTableRow(lastline+1, linenum, true));
    });
    $("#addcol").click(function(e){
      e.preventDefault();
     // var linenum = parseInt($("#csvtable tbody tr:last").attr("id").split("-")[1]);
     var linenum = $("#csvtable tbody").find("tr").length;
      var cols = $("#csvtable tbody").find("tr:first td").length;
      $("#csvtable thead tr").append("<td ><input class=\"form-control" + "\" type=\"text\" value=\"\"></td>");
      for( var cnt=0;cnt<=linenum;cnt++)
      {
      $("#csvtable tbody #row-"+cnt).append(makeTableColumn(cnt,cols,true));
      }
    });
    // Cancel (reload page)
    // $("#cancel").click(function(e) {
    //     e.preventDefault();
    //     location.reload(true);
    // });

    // Save csv...................................
    $("#save").click(function(e) {
        e.preventDefault();

        var csvlines = {};

        var columncnt = 0;
        var linecnt = 0;
        // Loop through all (visible only) table rows and make data
        $("[rel=row]:visible").each(function() {
            var linenum = this.id.split("-")[1];
            var thisline = {};
            columncnt = 0;

            $("input[rel=input-"+ linenum + "]").each(function() {
                thisline['col-'+columncnt] = $(this).val();
                columncnt++;
            });

            csvlines['line-'+linecnt] = thisline;
            linecnt++;
        });
        var csvdata = {csvfile: csvfile, lines: linecnt, columns: columncnt, data: csvlines};
        //alert(JSON.stringify(csvdata));

        // Write data to file and show result to user
        $.ajax({
            url: "savetocsv.php",
            method: "POST",
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            data: JSON.stringify(csvdata),
            cache: false,
            success: function(response) {
                makeMessage("<h4>" + response.responseText + "</h4>CSV updated Successfully!", "success", "message");
                // reload page in 3 sec
              //  setTimeout(function(){location.reload();}, 2500);

            },
            error: function(response) {
                makeMessage("<h4>Ups</h4>" + response.status + " " + response.statusText, "danger", "message");
            }
        });
         var csvname=csvfile;
         var csv=csvname.split(".");
            // csv=csvname.split("_");
             csvname=csv[0];
         var csvdata = {csvfile: csvfile, csvname: csvname};
        $.ajax({
            url: "monthly-csv.php",
            method: "POST",
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            data: JSON.stringify(csvdata),
            cache: false,
            success: function(response) {
                makeMessage("<h2>" + response.responseText + "</h2>tables are upadated", "success", "message");
                // reload page in 3 sec
                setTimeout(function(){location.reload();}, 2500);

            },
            error: function(response) {
                makeMessage("<h4>Ups</h4>" + response.status + " " + response.statusText, "danger", "message");
                 setTimeout(function(){location.reload();}, 2500);
            }
        });
    });


    function makeMessage(messagetext, messagetype, messageid){
        var h = "<div class=\"alert alert-" + messagetype + " alert-dismissible\" role=\"alert\">"
            + "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"
            + messagetext + "</div>";
        $("#"+messageid).html(h);
        return;
    }

      function makeTableRow(linenum, columns, isenabled) {

        var h = "<tr rel=\"row\" id=\"row-" + linenum + "\" class=\"" + (isenabled===true ? "success" : "") + "\">";
        for (var columncnt=0; columncnt<columns; columncnt++) {
            h += "<td><input class=\"form-control input-col-rest" + "\" rel=\"input-" + linenum + "\"" + " type=\"text\" value=\"\"></td>";
        }
        h += "</tr>";
        return h;
    }
    function makeTableColumn(rowcnt,colnum,isenabled)
    {
     var r;
            //r="<td ><input class=\"form-control" + " rel=\"input-" + rowcnt + "\"" +(is) type=\"text\" value=\"\"></td>";
            r = "<td ><input class=\"form-control input-col-rest" + "\" rel=\"input-" + rowcnt + "\"" + " type=\"text\" value=\"\"></td>";
      return r ;
    }


 </script>

<?php
function makeTableRow($lineCnt, $row, $columns) {
   $flag=0;
    $h = "<tr rel=\"row\" id=\"row-" . $lineCnt . "\">";
    for ($columnCnt=0; $columnCnt<$columns; $columnCnt++) {
      if(!empty($row[$columnCnt])){
        $flag++;
        $h .= "<td><input class=\"form-control input-col-rest" . "\" rel=\"input-" . $lineCnt . "\"  type=\"text\" value=\"" . $row[$columnCnt] . "\"></td>";
        }
      }

    $h .= "</tr>";
    if($flag>0){
    return $h;
    }
}
function makeCSVFileLink($basename, $activebasename) {
    // Include CSV files only (defined by extension)
      $linkname=explode(".", $basename);
    if(substr($basename, -3)==SDFE_CSVFileExtension) {
        $h = "<a href=\"?file=" . $basename . "\" ";
        $h .= "class=\"list-group-item csvlink" . ($basename==$activebasename ? " active" : "") . "\">";
        $h .= $linkname[0] . "</a>";
    }
    return $h;
}

// updating employee data in table...............
if(isset($_POST['submit'])) {
  $q1=mysqli_query($con,'SELECT workunderteam from emp_table where empid="'.$_POST['userid'].'"');
  while($r1=mysqli_fetch_array($q1)){
    $team=$r1[0];
  }
  $q2=mysqli_query($con,'SELECT * from '.$team.'_roster_table ');
  $numrows=mysqli_num_rows($q2);

  $userid=$_POST['userid'];
  $table=$team."_roster_table";

  $q4= mysqli_query($con,"SELECT ".$userid." from ".$table."");
  if($q4){

  }else{

  //$q3=mysqli_query($con,"ALTER TABLE ".$table." ADD ".$userid." varchar(50) ");
      $q3=mysqli_query($con,"ALTER TABLE ".$table." ADD COLUMN ".$userid." VARCHAR(55) ");
      if($q3){

     }else{
       echo'<script type="text/javascript">
         alert("alter not working);
      </script>';
     }
  }
  for($i=1;$i<=$numrows;$i++){
   if($i<10){
      $date_fetch = date('0'.$i.'-M-y');
     }else{
      $date_fetch = date($i.'-M-y');
    }
// include('connection.php');
  $value=$_POST['input'.$i];
  $q=mysqli_query($con,"UPDATE ".$table." SET ".$userid." = '".$value."' WHERE  date= '".$date_fetch."' ");
     if($q){
    $response=1;
     }
     else{
     $response=0;
      }
   }
           if($response==0){
             echo'<script type="text/javascript">
               alert("faild to update");
            </script>';
           }
           else{
             echo'<script type="text/javascript">
               alert("successfully updated");
            </script>';
           }
   //updating csv data......................................
$db_record = $table;
$columnname=$table."Id";

//removing auto generated columns
mysqli_query($con,"ALTER TABLE ".$table." DROP COLUMN ".$columnname." ");

// optional where query
$where = 'WHERE 1 ORDER BY 1';
// filename for export
$filename=explode('_', $db_record);
$csv_filename = $team.'.csv';
// create empty variable to be filled with export data
$csv_export ="";

// query to get data from database
$query = mysqli_query($con,"SELECT * FROM ".$db_record." ".$where);
$field = mysqli_num_fields($query);

// create line with field names
$q=mysqli_query($con,"SELECT COLUMN_NAME
FROM Information_schema.columns
WHERE Table_name LIKE '".$team."_roster_table';");
$i=0;
while($result=mysqli_fetch_array($q)){
 $csv_export.= $result[0];
if($i<$field-1){
	$csv_export.=SDFE_CSVSeparator;
}
$i++;
}
// newline (seems to work both on Linux & Windows servers)

 echo $csv_export.= SDFE_CSVLineTerminator;
 // loop through database query and fill export variable
 $count=mysqli_num_rows($query);
 $counter=0;
 while($row = mysqli_fetch_array($query)) {
   // create line with field values
  for($i = 0; $i < $field; $i++) {
    $csv_export.= $row[$i];
    if($i<$field-1){
    	$csv_export.=SDFE_CSVSeparator;
    }
  }
  if($counter<$count-1){
   $csv_export.=SDFE_CSVLineTerminator;
  }
 $counter++	;
 }

 // write line content
         $csvfile=$csv_filename;
         $csvfileorg = SDFE_CSVFolder . "/" . $csvfile;
         $csvfilebackup = SDFE_CSVFolderBackup . "/" . $csvfile;
         if($csvfileorg){
         	copy($csvfileorg, $csvfilebackup);
         }

         // Delete existing data in current CSV file and Write new content
        $newcsvfile = fopen($csvfileorg, "w") or die("Unable to open file!");
        fwrite($newcsvfile, $csv_export);
        fclose($newcsvfile);

        echo "<script>
                     window.history.go(-1);
             </script>";

       }


?>

</body>
</html>

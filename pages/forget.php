<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forget password page</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="custom-css/login.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
  <div class="container">
  <div class="row" id="pwd-container">
    <div class="col-md-4 col-md-offset-4">
        <section class="login-form">
        <form  method='post' name="loginform" role="login">
          <img src="dls_logo.png" class="img-responsive" alt="DLS Logo">
            
                <input type="text" class="form-control" placeholder="Enter  Login ID" name="login_id" id="login_id"  onblur="loginid()"  ><span id='lspan'></span>
                <input type="email" class="form-control" placeholder="Enter Email ID" name="email_id" id="email_id"  onblur="loginid()"         ><span id='espan'></span>
              
              <div class="control-group">
                <span><a class="inline_block" href="index.php">Back to login page</a></span>
              </div>
             <!-- Change this to a button or input when using this as a form -->
              <input type="submit" name="login_submit"  value="Submit" id="login_submit"  
                  class="btn btn-lg btn-success btn-block" />
            
          </form>
       <div class="form-links" id="msg"></div>
      </section>  
      </div>
      
  </div>
</div>


    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script type="text/javascript" src="custom-js/validation_method.js"></script>

</body>

</html>

<?php                    
if(isset($_POST['login_submit'])) {
  include('connection.php');
  $login_id = $_POST['login_id'];
  $email_id = $_POST['email_id'];
  $qur3 = mysqli_query($con,"select reportedmanagerid from emp_table where empid ='".$login_id."'");
  while($row3 = mysqli_fetch_array($qur3)){
     $reportedmanagerid = $row3['reportedmanagerid'];
  }
  $qur2 = mysqli_query($con, "select emailid from emp_table where empid ='0013'");
  if($qur2) {
    while($row = mysqli_fetch_array($qur2)) {
      $emailid2 = $row['emailid'];
    }
    $qur = mysqli_query($con, "select * from emp_table where empid='".$login_id."'");
    if($qur) {
      while($row = mysqli_fetch_array($qur)) {
        $id = $row['empid'];
        $firstname = $row['firstname'];
        $lastname =  $row['lastname'];
        $emailid = $row['emailid'];
        $password=base64_decode($row['password']);
      }
      if(isset($login_id)) {
        if($id == $login_id and $email_id == $emailid) {        
          include("Mail.php");
          $from = "Development Logics <".$emailid2.">";
          $to = $emailid2;
          $subject =  "".$firstname ." ". $lastname." forgotted their password";
          $body = "Password is :- ".$password;
   
          $host = "mail.vayudoot.co.in";
          $port = "26";
          $username = "hello@vayudoot.co.in";
          $password = "zJp8-D2;G#X4";
   
          $headers = array ('From' => $from,
          'To' => $to,
          'Subject' => $subject);
          $smtp = Mail::factory('smtp',
            array ('host' => $host,
            'port' => $port,
            'auth' => true,
            'username' => $username,
            'password' => $password));
   
            $mail = $smtp->send($to, $headers, $body);
   
         if (PEAR::isError($mail)) {
            echo("<p>" . $mail->getMessage() . "</p>");
          } else {
              echo "<div  style='text-align:center;color:white;height:3px;'>password is send to your admin  please ask admin for the password.</div>";
            }
        }
        if($id == $login_id && $email_id != $emailid)
          echo "<div  style='text-align:center;color:white; height:3px;'>Email ID is wrong, please enter the correct Email ID</div>";
        if($id != $login_id && $email_id == $emailid)
          echo "<div  style='text-align:center;color:white; height:3px;'>Login ID is wrong, please enter the correct Login ID</div>";
      }
    }
    else {
     echo "<div  style='text-align:center;color:red;height:3px;'>Login Id is not matched</div>";
    }
  }
}
?>
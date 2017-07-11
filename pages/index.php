<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Page</title>

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
        <form method="post" action='index.php' method='post' name="loginform" onsubmit="return(validate())"role="login">
          <img src="dls_logo.png" class="img-responsive" alt="DLS Logo">
            <input placeholder="Enter the Login ID" name="login_id" id="login_id" required class="form-control input-lg"  /><i class=""></i>

          <input type="password" placeholder="Password" name="login_password"  id="login_password" class="form-control input-lg" required="" />
           <div class="control-group">
                <span><a class="inline_block" href="forget.php">Forget Password? Click here</a></span>
          </div>

          <button type="submit" id="login_submit" name="login_submit"  class="btn btn-lg btn-primary btn-block" onclick="return onlogin()">Login</button>

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
session_start();
if(isset($_POST['login_submit'])) {
  include('connection.php');
  $login_id = $_POST['login_id'];
  $password = base64_encode($_POST['login_password']);
  date_default_timezone_set('Asia/Kolkata');
  $date = date("Y-m-d");
  $qur = mysqli_query($con, "select empid,biomatric_id,firstname,lastname,reportedmanagerid,password,flag,employeerole,workunderteam,status from emp_table where empid='".$login_id."' and password='".$password."'");
  $result = mysqli_num_rows($qur);
  if($result == 1) {
    while($row = mysqli_fetch_array($qur)) {
      $id=$row['empid'];
      $biomatric_id = $row['biomatric_id'];
      $firstname=$row['firstname'];
      $lastname=$row['lastname'];
      $pass=$row['password'];
      $flag=$row['flag'];
      $role=$row['employeerole'];
      $workunderteam = $row['workunderteam'];
      $reportedmanagerid = $row['reportedmanagerid'];
      $status=$row['status'];
    }
    if(isset($id) && isset($pass)) {
      if($id == $login_id && $pass == $password && $status==1) {
        $_SESSION['user'] = $id;
        $_SESSION['biomatric_id'] = $biomatric_id;
        $_SESSION['role'] = $role;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['flag'] = $flag;
        $_SESSION['workunderteam'] = $workunderteam;
        $_SESSION['reportedmanagerid'] = $reportedmanagerid;
        header("Location:dashboard.php");
      }
    }
    if(isset($login_id)) {
      if($pass == $password && $id != $login_id)
        echo "<script type='text/javascript'>
                document.getElementById('msg').innerHTML='Login Id is wrong, please enter the correct Login ID';
        </script>";
      if($id == $login_id && $pass != $password)
        echo "<script type='text/javascript'>
                document.getElementById('msg').innerHTML='Password is wrong, please enter the correct password';
        </script>";
      }
  }
  else {
     echo "<script type='text/javascript'>
                document.getElementById('msg').innerHTML='Login Id or Password is Incorrect.';
        </script>";

  }
  $_SESSION['check_in_out'] = 'Sign In';
  $_SESSION['last_swipe'] = 'Last Swipe';
  $query5 = mysqli_query($con,"SELECT status from emp_checks where emp_id='".$biomatric_id."' and date='".$date."'");
  while($result = mysqli_fetch_array($query5)) {
    $status = $result[0];
      if($status == '1') {
        $_SESSION['check_in_out'] = 'Sign Out';
        $_SESSION['last_swipe'] = 'Latest Sign In';

      }

  }
}
?>

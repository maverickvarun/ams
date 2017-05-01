

function cp1() {
  <?php 
    include('connection.php');
    $query5 = mysqli_query($con,"select password from emp_table where empid='".$user."'");
      while($row = mysqli_fetch_array($query5)) {
        $pass1 = $row[0];
      }
  ?>
  document.getElementById("msg3").innerHTML = '';
  a = document.getElementById("currentpassword").value;
  b = <?php echo $pass1 ?>;
  if(a == b) {
    document.getElementById("msg1").innerHTML = "";
    $("#newpassword").show();
    $("#confirmpassword").show();
    $("#submitpassword").show();    
  }
  else {
    alert("wrong password");
    document.getElementById("msg1").innerHTML = "wrong password";
    $("#newpassword").hide();
    $("#confirmpassword").hide();
    $("#submitpassword").hide();
  }
}

function cp3() {
    c = document.getElementById("newpassword").value;
    d = document.getElementById("confirmpassword").value;
    if(c == d) {
      document.getElementById("msg3").innerHTML = "";
      confirm("Are You Really want to change the password then press OK");
      $("#submitpassword").show();
    }
    else {
      document.getElementById("msg3").innerHTML = "confirm password is not matched";    
      $("#submitpassword").hide();
    }
}
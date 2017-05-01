<?php session_start();
$role = $_SESSION['role'];
$user = $_SESSION['user'];
include('connection.php');
$id = $_REQUEST['emp-id'];
  if($id !='') {
    $user = $id;
  }
  else {
    $user = $user;
  }
echo'
<div id="view_details">  
  <div class="row" >
    <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-body">';
          $query = mysqli_query($con,"select empid,biomatric_id,firstname,lastname,dateofbirth,emercontactno,mobilenumber,emailid,dateofjoining,bloodgroup,permanentaddress,tempaddress,parents from emp_table where empid = '".$user."' ");
          while($row = mysqli_fetch_array($query)) {
          echo'<form class="form-horizontal"  role="form" enctype="multipart/form-data" >
                <fieldset><legend>Personal Details:</legend>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Employee ID</label>
                        <input class="form-control" id="empid" name="empid" value="'.$row['empid'].'" >
                  </div>
                </div>
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Biomatric Id</label>
                        <input class="form-control" type="text"  id="biomatric_id"  name="biomatric_id" value="'.$row['biomatric_id'].'">
                  </div>
                </div>
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Employee Name</label>
                        <input class="form-control" type="text"  id="firstname"  name="firstname" value="'.$row['firstname']." ".$row['lastname'].'">
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Date of Birth</label>
                        <input class="form-control" type="text" id="dateofbirth"  name="dateofbirth" value="'.$row['dateofbirth'].'">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Mobile Number</label>
                        <input class="form-control"  value="'.$row['mobilenumber'].'">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Emer. Contact No.</label>
                        <input class="form-control"  value="'.$row['emercontactno'].'">
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Email Id</label>
                        <input class="form-control" type="text"   value="'.$row['emailid'].'">
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Date Of Joining</label>
                        <input class="form-control" type="text" value="'.$row['dateofjoining'].'">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Blood Group</label>
                        <input class="form-control"  value="'.$row['bloodgroup'].'">
                  </div>
                </div> 
                <div class="col-lg-6"> 
                  <div class="form-group">
                    <label>Permanent Address</label>
                        <input class="form-control" type="text"   value="'.$row['permanentaddress'].'">
                  </div>
                </div> 
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Temp. Address</label>
                        <input class="form-control" type="text" value="'.$row['tempaddress'].'">
                  </div>
                </div>
                <div class="col-lg-6">  
                   <div class="form-group">
                    <label>Parents/Gardian</label>
                        <input class="form-control" type="text" value="'.$row['parents'].'">
                  </div>
                </div>
                  </fieldset></form>';
          }
    echo'        
      </div> 
    </div>
  </div> 

<div class="col-lg-6">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">';
        $query = mysqli_query($con,"select bankacdetails,bankacnumber,nameinbank,accounttype,ifsccode from emp_table where empid = '".$user."' ");
          while($row = mysqli_fetch_array($query)) {
          echo'
          <form class="form-horizontal"  role="form" enctype="multipart/form-data" >
          <fieldset><legend>Bank Details:</legend>
          <div class="col-lg-4">
            <div class="form-group">
              <label>Name Of Bank</label>
                  <input class="form-control" value="'.$row['bankacdetails'].'">
            </div>
          </div> 
          <div class="col-lg-4"> 
            <div class="form-group">
              <label>Account Number</label>
                  <input class="form-control" type="text"  value="'.$row['bankacnumber'].'">
            </div>
          </div> 
          <div class="col-lg-4">  
             <div class="form-group">
              <label>Name In Bank</label>
                  <input class="form-control" type="text" value="'.$row['nameinbank'].'"  >
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label>Account Type</label>
                  <input class="form-control"  value="'.$row['accounttype'].'" >
            </div>
          </div> 
          <div class="col-lg-4"> 
            <div class="form-group">
              <label>IFSC Code</label>
                  <input class="form-control" type="text"   value="'.$row['ifsccode'].'" >
            </div>
          </div> 
      </fieldset>
      </form>';
    }
  echo'  
    </div> 
    </div>
  </div> 
</div>     
<div class="col-lg-6">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
           <form class="form-horizontal"  role="form" enctype="multipart/form-data" >
        <fieldset><legend>Document Details:</legend>';
        $dir = 'uploaded_images/'.$user;
        $files = glob($dir."/*.*");
        for ($i=0; $i<count($files); $i++) {
          $image = $files[$i];
          $supported_file = array('gif','jpg','jpeg','png');
          $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
          if(in_array($ext, $supported_file)) {
             $image ."<br />";
             echo '<img src="'.$image.'"style="width:150px;height:150px;margin-left:10px;box-shadow:0px 0px 4px 5px #fff;"/>';
          }
          else{
            continue;
          }
        }  
   echo' </fieldset></form>
 </div>
</div> 
</div>
</div> 
</div>  
</div>';   

                

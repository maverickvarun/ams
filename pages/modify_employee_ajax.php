  <?php session_start();
$user = $_SESSION['user'];
include('connection.php');
$emp_id = $_REQUEST['emp_id'] ;
if($emp_id != '') {
  $user = $emp_id;
}
else {
  $user = $user;
}
$query = mysqli_query($con," select * from emp_table where empid='".$user."'");
  while($row = mysqli_fetch_array($query)) {
    $id=$row['id'];
    $empid = $row['empid'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $gender = $row['gender'];
    $dateofbirth = $row['dateofbirth'];
    $mobilenumber = $row['mobilenumber'];
    $emercontactno = $row['emercontactno'];
    $biomatric_id = $row['biomatric_id'];
    $emailid = $row['emailid'];
    $dateofjoining = $row['dateofjoining'];
    $bloodgroup = $row['bloodgroup'];
    $parents = $row['parents'];
    $permanentaddress = $row['permanentaddress'];
    $tempaddress = $row['tempaddress'];
    $shift = $row['shift'];
    $status = $row['status'];
    $flag = $row['flag'];
    $employeerole = $row['employeerole'];
    $workunderteam = $row['workunderteam'];
    $reportedmanagerid = $row['reportedmanagerid'];
    $refecontactno = $row['refecontactno'];
    $bankacdetails = $row['bankacdetails'];
    $bankacnumber = $row['bankacnumber'];
    $nameinbank = $row['nameinbank'];
    $accounttype = $row['accounttype'];
    $ifsccode = $row['ifsccode'];
    if($status==1)
    {
      $statusopt="Active";
    }
    else{
      $statusopt="Inactive";
    }
  }
   $query1 = mysqli_query($con," select * from template_roster where emp_id='".$user."'");
  while($row1 = mysqli_fetch_array($query1)) {
    $firstweekoff=$row1['firstweekoff'];
    $secondweekoff=$row1['secondweekoff'];
  }
  echo' <div class="row">
   <form class="form-horizontal"  role="form" method="post" enctype="multipart/form-data" id="modify_employee_div">
    <div class="col-lg-6">
      <div class="panel panel-default">
      <div class="panel-body">
      <fieldset><legend>Personal Details:</legend>
    
          <input type="hidden" name="id" value="'.$id.'">
            
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Employee ID</label>
                 <input class="form-control" placeholder="Enter employee id" id="empid" name="empid" value="'.$empid.'">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Biomatric Id</label>
                <input class="form-control" type="number" value="'.$biomatric_id.'" id="bmi"  name="bmi" >
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group required">
              <label class="control-label">First Name</label>
                <input class="form-control" type="text"  id="firstname"  name="firstname" value="'.$firstname.'" >
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Last Name</label>
                <input class="form-control" type="text" id="last_name" name="last_name"  value="'.$lastname.'">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Email ID</label>
                <input class="form-control" type="text" value="'.$emailid.'" name="emailid" id="email">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Mobile Number</label>
                <input class="form-control" type="text" value="'.$mobilenumber.'" id="mobilenumber"  name="mobilenumber">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Emergency Contact No.</label>
                <input class="form-control" type="text" value="'.$emercontactno.'" id="ecn"  name="ecn">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Reference Cont No.</label>
                <input class="form-control" type="text"id="rcn" name="rcn" value="'.$refecontactno.'" >
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Gender</label>
                <input class="form-control" type="text" name="gender"  value="'.$gender.'">
            </div>
          </div>
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Check IN</label>
                <select class="form-control" name="flag">
                  <option value="'.$flag.'">'.$flag.'</option>
                  <option value="manual">manual</option>
                  <option value="remote">remote</option>
                </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Birth</label>
                <input class="example1 form-control" type="text" id="dateofbirth" name="dateofbirth"  value="'.$dateofbirth.'">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Blood Group</label>
              <select class="form-control" name="bloodgroup" id="bloodgroup"
                  onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=="Other") { 
                var opt = prompt("Specify option, please","");
                  if (opt) {
                    this.options[this.selectedIndex]=new Option(opt,opt);
                    this.options[this.options.length]=new Option("Other","Other");
                    this.selectedIndex=idx;
                  }
                }" >
                <option value="'.$bloodgroup.'">'.$bloodgroup.'</option>
                <option value="A+">A+</option> <option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="O+">O+</option>
                <option value="O-">O-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="HH">HH</option>
                <option value="Other">Other</option></select>
              </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Date of Joining</label>
                <input class="form-control" type="date" id="dateofjoining" name="dateofjoining" value="'.$dateofjoining.'">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Parents/Guardians</label>
                <input class="form-control" type="text" id="parents" name="parents" value="'.$parents.'">
            </div>
          </div> 
          <div class="col-lg-6">
            <div class="form-group">
              <label class="control-label">Parment Address</label>
                <input class="form-control" type="text"  id="parmentaddress" name="parmentaddress" value="'.$permanentaddress.'">
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="form-group">
              <label class="control-label">Temporary Address</label>
                <input class="form-control" type="text" id="tempaddress" name="tempaddress"  value="'.$tempaddress.'">
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group required">
              <label class="control-label">Employee Role</label>
              <select class="form-control" id="employeerole" name="employeerole">
                <option value="'.$employeerole.'">'.$employeerole.'</option>
                <option value="employee">Employee</option> <option value="manager">Manager</option><option value="admin">Admin</option>
              </select>
              
            </div>
          </div>
          <div class="col-lg-6"> 
             <div class="form-group">
              <label class="control-label">Working Team</label>
              <select class="form-control" id="workingteam" name="workingteam">
              <option value="'.$workunderteam.'">'.$workunderteam.'</option>';
                $query = mysqli_query($con,"select team_name from team_table");
                  while($result = mysqli_fetch_array($query)) {
                    $team_name = $result['team_name'];
                    echo '<option value='.$team_name.'>'.$team_name.'</option>';
                  }
                 
              echo'</select>
              
            </div>
          </div> 
          <div class="col-lg-6">  
             <div class="form-group">
              <label class="control-label">Shift</label>
              <select class="form-control myselect" name="shift" id="shift" >
                <option value="'.$shift.'">'.$shift.'</option>';
                  $query = mysqli_query($con,"select shift_name from shift_table");
                  while($result = mysqli_fetch_array($query)) {
                    $shift_name = $result["shift_name"];
                    echo "<option value=".$shift_name.">".$shift_name."</option>";
                  }
                echo'
              </select>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Reportee</label>
              <input class="form-control" type="text"  id="rmi" name="rmi" value="'.$reportedmanagerid.'">
            </div>
          </div> 
            <div class="col-lg-6"> 
           <div class="form-group">
              <label class="control-label">Status</label>
              <select class="form-control myselect " id="team" name="status" >';
                   echo '<option value="'.$status.'">'.$statusopt.'</option>';
                   echo '<option value="1">Active</option>';
                   echo '<option value="0">Inactive</option>';
             echo'</select>
            </div>
          </div> 

           <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">First Week Off</label>
              <select class="form-control" name="firstweekoff" >
                <option value='.$firstweekoff.'> '.$firstweekoff.'</option>
                <option value="sunday">Sunday</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>                 
              </select>
            </div>
          </div>

          
           <div class="col-lg-6">
            <div class="form-group required">
              <label class="control-label">Second Week Off</label>
              <select class="form-control" name="secondweekoff" >
                <option value='.$secondweekoff.'> '.$secondweekoff.'</option>
                <option value="sunday">Sunday</option>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
                <option value="saturday">Saturday</option>                 
              </select>
            </div>
          </div>

      </fieldset>         
    </div>
    </div>
  </div> 
<!-- /col-lg-6 
   below code is for the bank details panel of employeee...........
  -->
  <div class="col-lg-6">
    <div class="panel panel-default">
    <div class="panel-body">
    <fieldset><legend>Bank Details:</legend>
      <div class="col-lg-6">
       <div class="form-group">
          <label class="control-label">Name in Bank</label>
            <input class="form-control" type="text" id="nib" name="nib" value="'.$nameinbank.'">
        </div>
      </div> 
      <div class="col-lg-6"> 
        <div class="form-group">
          <label class="control-label">Bank A/C Details</label>
          <select class="form-control" name="bankacdetails" id="bankacdetails"
      onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=="Other") { 
                var opt = prompt("Specify option, please","");
                  if (opt) {
                    this.options[this.selectedIndex]=new Option(opt,opt);
                    this.options[this.options.length]=new Option("Other","Other");
                    this.selectedIndex=idx;
                  }
                }">
            <option value="'.$bankacdetails.'">'.$bankacdetails.'</option>
            <option value="state bank of india">State Bank Of India</option>
            <option value="punjab nataional bank">Punjab National Bank</option>
            <option value="hdfc">HDFC</option>
            <option value="Other">Other</option>
          </select>
         </div>
      </div>
      <div class="col-lg-6">  
       <div class="form-group">
        <label class="control-label">Account Type</label>
        <select class="form-control" name="accounttype"id="accounttype"
          onChange="idx = this.selectedIndex;val = this.options[idx].value;if (val=="Other") { 
          var opt = prompt("Specify option, please","");
            if (opt) {
              this.options[this.selectedIndex]=new Option(opt,opt);
              this.options[this.options.length]=new Option("Other","Other");
              this.selectedIndex=idx;
            }
          }">
          <option value="'.$accounttype.'">'.$accounttype.'</option>
          <option value="saving account">Saving Account</option>
          <option value="current account">Current Account</option>
          <option value="Other">Other</option>
        </select>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label class="control-label">Bank A/C Number</label>
            <input class="form-control" type="text" id="ban"  name="ban" value="'.$bankacnumber.'" >
        </div>
      </div> 
      <div class="col-lg-6"> 
         <div class="form-group">
          <label class="control-label">IFSC Code</label>
            <input class="form-control" type="text" id="ifsc"  name="ifsc" value="'.$ifsccode.'">
        </div>
      </div> 
    </fieldset>
    </div>
    </div> 
  </div>     
<!-- /col-lg-6
            below code is for the document details panel of employeee...........
  -->

    <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <fieldset><legend>Document Details:</legend>
            <div class="col-lg-7">
              <div class="form-group">
                <label class="control-label">Photo</label>
                  <input type="file" id="emp_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-5"> 
              <div class="form-group">
                <label class="control-label">Documentation Modification</label>
                <div class="radio">
                  <label>
                    <input type="radio" name="document" value="yes" id="yes" checked>Yes
                  </label>
                  <label>
                    <input type="radio" name="document" value="no" id="no" >No
                  </label>
                </div>
              </div>
            </div> 
             
            <div class="col-lg-7">
              <div class="form-group visible" id="matric_snap_div">
                  <label class="control-label">Matric Snap</label>
                      <input type="file" id="matric_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
                </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group visible" id="intermediate_snap_div" >
                <label>Intermediate Snap</label>
                <input type="file" id="intermediate_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-7"> 
              <div class="form-group  visible" id="graduation_snap_div">
                <label class="control-label">Graduation Snap</label>
                    <input type="file" id="graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5">  
               <div class="form-group  visible" id="post_graduation_snap_div">
                <label class="control-label">Post Graduation Snap</label>
                    <input type="file" id="post_graduation_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>  
            </div>

            <div class="col-lg-7">
              <div class="form-group  visible" id="address_proof_snap_div">
                <label class="control-label">Address proof  Snap</label>
                  <input type="file" id="address_proof_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div> 
            <div class="col-lg-5"> 
              <div class="form-group  visible" id="pan_card_snap_div">
                <label class="control-label">Pan Card Snap</label>
                    <input type="file" id="pan_card_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-7">  
               <div class="form-group  visible" id="experience_snap_div">
                <label class="control-label">Experience(if any) Snap</label>
                    <input type="file" id="experience_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
            <div class="col-lg-5">  
               <div class="form-group visible " id="relv_snap_div">
                <label class="control-label">Relv. Letter(if any) Snap</label>
                  <input type="file" id="relv_letter_snap" name="file[]" accept="image/*" onchange="loadFile(event)">
              </div>
            </div>
             <div class="col-lg-12">  
              <div class="form-group " id="preview_snap_div">
                <label><b>Preview after selection of photo</b></label>
                    <img id="output"/ class="image_preview">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <input type="submit" name="submit_preview" class="btn btn-lg btn-success btn-block" value="Submit">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <button type="reset" class="btn btn-block btn-primary btn-lg ">Reset</button>
              </div>
          </div>  
        </fieldset>
        </div>
      </div> 
    </div>
    <!-- /col-lg-6 -->
  </form>
 </div>
         ';
?>
    

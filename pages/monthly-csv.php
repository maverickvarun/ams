<?php session_start();
  $user = $_SESSION['user'];
  $role = $_SESSION['role'];
  $workunderteam = $_SESSION['workunderteam'];
  include('connection.php');
// moving upload files to csv foler
   $json = json_decode(file_get_contents('php://input'), true);
    
    // Backup file by moving it to csvbackup folder. If file exists it will be overwritten!
    $target_dir = "csv/";
 if(isset($json)){
    $csvfile = $json["csvfile"];
    $csvname= $json["csvname"];
   
    $target_file = $target_dir . $csvfile;
   
  }
  else{
        if($role=='manager'){
          $ext = explode('.', basename($_FILES['csv_file']['name']));   // Explode file name from dot(.)
          $file_extension = end($ext); // Store extensions in the variable.
          $filename = $workunderteam;
          $name = $filename.'.'.$file_extension;
          $target_file = $target_dir .$name;   
        }else{
          $target_file = $target_dir . basename($_FILES['csv_file']["name"]);
          }
          $filename=$_FILES['csv_file']["name"];
          $csv=explode('.',$filename);
          $csvname=$csv[0];
           move_uploaded_file ($_FILES['csv_file'] ['tmp_name'],$target_file);
            if (isset($_SERVER["HTTP_REFERER"])) {
             header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
  }
   $message = array("responseText" => "Successfully Updated!");
 //table Name
if($role=='manager'){
    $tableName = $workunderteam."_table" ;    
}else{
    $tableName = $csvname."_table";
}


//database name
$dbName = "vayudoot_amsdb";
//get the first row fields 
$fields = "";
$fieldsInsert = "";
if (($handle = fopen($target_file, "r")) !== FALSE) {
    if(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $fieldsInsert .= '(';
        for ($c=0; $c < $num; $c++) {
            $fieldsInsert .=($c==0) ? '' : ', ';
            $fieldsInsert .="`".$data[$c]."`";
            $fields .="`".$data[$c]."` varchar(500) DEFAULT NULL,";
        }
        $fieldsInsert .= ')';
    }
    //drop table if exist
    if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '".$tableName."'"))>=1)
     {
      mysqli_query($con,'DROP TABLE IF EXISTS `'.$tableName.'`');
    }
    //create table
    $sql = mysqli_query($con,"CREATE TABLE `".$tableName."` (
              `".$tableName."Id` int(100) unsigned NOT NULL AUTO_INCREMENT,
              ".$fields."
              PRIMARY KEY (`".$tableName."Id`)
            ) ");
      while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $fieldsInsertvalues="";
                //get field values of each row
                for ($c=0; $c < $num; $c++) {
                    $fieldsInsertvalues .=($c==0) ? '(' : ', ';
                    $fieldsInsertvalues .="'".$data[$c]."'";
                }
                $fieldsInsertvalues .= ')';
                //insert the values to table
                $sql = mysqli_query($con,"INSERT INTO ".$tableName." ".$fieldsInsert."  VALUES  ".$fieldsInsertvalues);
                   
        }
      
    }

    echo json_encode($message);
    fclose($handle);

?>
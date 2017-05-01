<?php
    
    move_uploaded_file ($_FILES['csv_file'] ['tmp_name'],
    "{$_FILES['csv_file'] ['name']}");
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 //table Name
$tableName = "csv_table";
//database name

 include('connection.php') ;
//get the first row fields 
$fields = "";
$fieldsInsert = "";
if (($handle = fopen("holiday.csv", "r")) !== FALSE) {
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
    
                $fieldsInsertvalues="";
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
                for ($c=0;$c<$num; $c++) {
                    $fieldsInsertvalues .=($c==0) ? '(' : ', ';
                    $fieldsInsertvalues .="'".$data[$c]."'";
                }
                $fieldsInsertvalues .= ')';
                //insert the values to table
                $sql = mysqli_query($con,"INSERT INTO ".$tableName." ".$fieldsInsert."  VALUES  ".$fieldsInsertvalues);
                   
        }
       
    }
    echo 'success';
    fclose($handle);
    
    if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE 'holiday_table'"))>=1)
     {
      mysqli_query($con,'TRUNCATE TABLE `holiday_table`');
    }
    $query = mysqli_query($con,"SELECT * FROM `csv_table`");
    while($result = mysqli_fetch_array($query)){
        $converted_date = date("Y-m-d", strtotime($result[3]));
        mysqli_query($con,"INSERT INTO  holiday_table(Sr_no, Festival,Date,Day,Comments) VALUES ('".$result[1]."', '".$result[2]."', '".$converted_date."','".$result[4]."','".$result[5]."')");
    }
?>
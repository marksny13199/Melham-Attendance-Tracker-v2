<?php
	
	include("db/dbconnection.php");
    
    $sql = "SELECT * FROM user_acc where usertype='Intern' AND permission='1'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      
      $response['data'] = array();
      // output data of each row
      
      while($row = $result->fetch_array()) {
		  $view_user = array();
		  $view_user["ID"] = $row["user_acc_id"];
          $view_user["Name"] = $row["firstname"]." ".$row["middle_name"]." ".$row["lastname"];
		  $view_user["Username"] = $row["username"];
		  $view_user["Password"] = $row["passwd"];
          $view_user["User Type"] = $row["usertype"];
		  
		  
          array_push($response['data'], $view_user);

          
	  }
      echo json_encode($response);
     
      
    } else {
      echo json_encode(array('data'=>''));
    }
    $conn->close();
?>
<?php	header('Access-Control-Allow-Origin: *');    header('Conten-Type: application/json');    include('db/dbconnection.php');	date_default_timezone_set('Asia/Manila');	$currentTime = date('H:i');	$currentDate = date('Y-m-d');			$sql = "SELECT * FROM attendance,user_acc,intern_info WHERE intern_info.username=user_acc.username AND user_acc.user_acc_id=attendance.user_acc_id ORDER BY attendance.att_id DESC";	$result = $conn->query($sql);	if (!$result) {        trigger_error('Invalid query: ' . $conn->error);    }	if ($result->num_rows > 0) {    $response['data'] = array();	while($row = $result->fetch_array()) {          $listitem = array();		  		  $date_in = date("F j, Y", strtotime($row["date_in"]));		  $date_out = date("F j, Y", strtotime($row["date_out"]));		  $yesterday = date("Y-m-d", strtotime("yesterday")); 		  		  		  if($row["date_in"] == $currentDate)		  {			  $date_in = "Today";		  }else if($row["date_in"] == $yesterday){			  $date_in = "Yesterday";			  		  }		            $listitem["Att ID"] = $row["att_id"];                    $listitem["User ID"] = $row["user_acc_id"];                		  $listitem["Date In"] = $date_in;		            $listitem["Time In"] = date("g:i A", strtotime($row["time_in"]));		  $listitem["Fullname"] = $row["firstname"]." " .$row["middle_name"]." ".$row["lastname"];		  $listitem["Time In Remark"] = $row["remark_time_in"];		  $listitem["Status"] = $row["remark"];		  $listitem["Shift"] = $row["start_shift"]." - ".$row["end_shift"];		  		  $listitem["Hrs left"] =  $row["hrs_left"]." hrs";		  		  		  if($row["time_out"]=="" || $row["date_out"]=="")		  {			  if($currentTime <= "12:00")			  {				  $today_hrs = round((strtotime($currentTime) - strtotime($row["time_in"]))/3600, 1);				  			  }else{                  if($row["shift"] == 3)                  {     				$today_hrs4 = round((strtotime($currentTime) - strtotime($row["time_in"]))/3600, 1);				    $today_hrs = $today_hrs4;                                   }else{				    $today_hrs3 = round((strtotime("12:00") - strtotime($row["time_in"]))/3600, 1);				    $today_hrs2 = round((strtotime($currentTime) - strtotime("13:00"))/3600, 1);				    $today_hrs = $today_hrs3 + $today_hrs2;                  }  				  			  }			  $listitem["Time Out"] = "00:00";			  $listitem["Date Out"] =  "00-00-0000";			  if($row["date_in"] != $currentDate){				  				 $listitem["Hrs today"] = "0 hrs"; 			  }else{			      if($today_hrs > 8)			      {			          if($row["shift"]==5)			          {			            $listitem["Hrs today"] = $today_hrs." hrs";			          }else{			            $listitem["Hrs today"] = "8 hrs";			          }			      }else{				    $listitem["Hrs today"] = $today_hrs." hrs";			      }			  }		  		  }else{  			  if($row["date_out"] == $currentDate)			  {				$date_out = "Today";			  }else if($row["date_out"] == $yesterday){				$date_out = "Yesterday";			  		      }				  			  $listitem["Date Out"] =  $date_out;			  $listitem["Time Out"] = date("g:i A", strtotime($row["time_out"]));			  $listitem["Hrs today"] = $row["hrs_today"]." hrs";			  		  		  }		  if($row["hrs_added"] == "")		  {			$listitem["Hrs added"] = "0 hrs";		  }else{		    			$listitem["Hrs added"] =  $row["hrs_added"]." hrs";			  }		            array_push($response["data"], $listitem);	}		 echo json_encode($response);	} else {	     echo json_encode(array('data'=>''));	}	$conn->close();?>
<?php    header("Content-Type: application/json; charset=UTF-8");    date_default_timezone_set('Asia/Manila');    include("db/dbconnection.php");    $user_name = $conn->real_escape_string($_POST['user_name']);    $pwd = md5($conn->real_escape_string($_POST['pwd']));        $check_email = mysqli_query($conn, "SELECT username FROM user_acc where username = '$user_name'");    if(mysqli_num_rows($check_email) <= 0){                die("6");            }                                $time=time()+1000;    $currentTime = date('Y-m-d H:i:s');       $sql = "SELECT * FROM user_acc WHERE BINARY username = '$user_name' AND BINARY passwd = '$pwd'";    $result = $conn->query($sql);    $response = array();        if ($result->num_rows > 0) {	  // output data of each row	  if($row = $result->fetch_assoc()) {            if($row["permission"] == 1)            {                        if($row["usertype"] == 'Intern')                        {                            $sql1 = "SELECT * FROM intern_info WHERE BINARY username='$user_name' AND BINARY username = '".$row['username']."'";                            $result1 = $conn->query($sql1);                                                        if ($result1->num_rows > 0)                             {                            // output data of each row                                if($row1 = $result1->fetch_assoc())                                 {                                                                                                            if($row1["intern_status"] == 'Terminated')                                    {                                        array_push($response, 2);                                    }                                    else if($row1["intern_status"] == 'Completed')                                    {                                        array_push($response, 3);                                    }                                    else if($row1["intern_status"] == 'Multiple Reports')                                    {                                        array_push($response, 4);                                    }                                    else                                    {                                        $sql2 = "UPDATE user_acc SET last_login = '$time' , time_login = '$currentTime' WHERE username = '$user_name'";                                                                                if (mysqli_query($conn, $sql2)) {                                            array_push($response, $row);                                        }                                    }                                                                    }                            }                        }                        else                        {                            array_push($response, "Access Denied");                        }            }else{                array_push($response, "Access Denied");                $conn->close();            }	  }	} else {	  array_push($response, "Access Denied");	}	$conn->close();	echo json_encode($response);?>
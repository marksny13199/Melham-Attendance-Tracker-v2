<?php    $user_acc_id = $_GET['id']; 		include("db/dbconnection.php");        $sql = "SELECT * FROM team, user_acc where team.co_leader_id=user_acc.user_acc_id  AND team.co_leader_id='".$user_acc_id."'";        $result = $conn->query($sql);        if ($result->num_rows > 0) {                     while($row = $result->fetch_array())         {                   $sql1 = "SELECT * FROM team, user_acc where team.leader_id=user_acc.user_acc_id AND team.co_leader_id='".$row["co_leader_id"]."'";                $result1 = $conn->query($sql1);                        while($row1 = $result1->fetch_array())                 {                                        echo'<table  class="content-table" style="width:100%">';                        echo'<thead>';                        echo'<tr >';                        echo'<th colspan="4" class="text-center">'.$row["team_name"].'</th>';                        echo'</tr>';                        echo'</thead>';                        echo'<tr>';                        echo'<th colspan="2" class="text-center" style="background-color: #d3d3d3;">Team Leader</th>';                        echo'<th colspan="2" class="text-center" style="background-color: #d3d3d3;">Co Leader</th>';                        echo'</tr>';                        echo'<tr>';                        echo'<td  rowspan="2" class="text-center" style="width: 50%;">'.$row1["firstname"].' '.$row1["middle_name"].' '.$row1["lastname"].'</td>';                                              echo'</tr> ';                        echo'<tr>';                        echo'<td  colspan="2" class="text-center">'.$row["firstname"].' '.$row["middle_name"].' '.$row["lastname"].'</td>';                                            echo'</tr>';                        echo'<tr>';                        echo'<th  colspan="4" class="text-center" style="background-color: #d3d3d3;">Members</th>';                                            echo'</tr>';                        $sql2 = "SELECT * FROM team_members, user_acc where team_members.user_acc_id=user_acc.user_acc_id AND team_members.team_name_id='".$row["team_id"]."' ORDER BY memb_id DESC LIMIT 5";                                    $result2 = $conn->query($sql2);                        while($row3 = $result2->fetch_array())                         {                                                                                                                        echo'<tr>';                                echo'<td  colspan="4" class="text-center">'.$row3["firstname"].' '.$row3["middle_name"].' '.$row3["lastname"].'</td>';                                                          echo'</tr>';                                                                                     }                        echo'<tr>';                         echo'<td  colspan="4" class="text-center"><a href="team.html" style="text-decoration: none"><button class="badge badge-success">VIEW TEAM ORGANIZATIONAL CHART</button></a></td>';                                                  echo'</tr>';                                         echo'</table>';                               }        }           }    else {       echo "0 results";     }    $conn->close();?>
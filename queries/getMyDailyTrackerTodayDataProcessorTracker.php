<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../sql_connect.php");

$result = $mysqli->query("SELECT `data_processor_id`, `daily_task`, `task_status`
						FROM `data_processor_tracker` 
						WHERE `track_date` = CURDATE() AND `account_id`=1"); /*$_SESSION['account_id']*/

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {
        $outp .= ",";
    }
    $outp .= '{"DataProcessorId":"'  . $rs["data_processor_id"] . '",';
    $outp .= '"DailyTask":"'   . $rs["daily_task"]        . '",';
    $outp .= '"TaskStatus":"'   . $rs["task_status"]        . '"}';
}
$outp ='{"records":['.$outp.']}';
$mysqli->close();

echo($outp);
?>
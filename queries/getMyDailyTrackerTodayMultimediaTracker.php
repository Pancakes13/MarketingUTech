<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../functions/sql_connect.php");
session_start();

$val = $_SESSION['user_id'];
$result = $mysqli->query("SELECT `multimedia_id`, `featured_image_cnt`, `graphic_designing_cnt`, `banner_cnt`,
                         `misc_cnt` 
						FROM `multimedia_tracker` 
						WHERE `track_date` = CURDATE() AND `user_id`=$val");

$rs = $result->fetch_array(MYSQLI_ASSOC);
$outp = "";
    $outp .= '{"MultimediaId":"'  . $rs["multimedia_id"] . '",';
    $outp .= '"FeaturedImageCnt":"'   . $rs["featured_image_cnt"]        . '",';
    $outp .= '"GraphicDesigningCnt":"'   . $rs["graphic_designing_cnt"]        . '",';
    $outp .= '"BannerCnt":"'   . $rs["banner_cnt"]        . '",';
    $outp .= '"MiscCnt":"'   . $rs["misc_cnt"]        . '"}';
    $outp ='{"records":['.$outp.']}';
$mysqli->close();

echo($outp);
?>
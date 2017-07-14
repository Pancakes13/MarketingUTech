<?php 
  require("../sql_connect.php");
  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata, true);
  if(count($request>0)){
    $curated_cnt = (isset($request['curatedCnt'])? $request['curatedCnt']:0);
    $drafted_cnt = (isset($request['draftedCnt'])? $request['draftedCnt']:0);
    $pictures_cnt = (isset($request['pictureCnt'])? $request['pictureCnt']:0);
    $videos_cnt = (isset($request['videoCnt'])? $request['videoCnt']:0);
    $misc_cnt = (isset($request['miscCnt'])? $request['miscCnt']:0);


    $query = "INSERT INTO `content_marketing_assistant_tracker`(`curated_cnt`, `drafted_cnt`, `pictures_cnt`, 
        `videos_cnt`, `misc_cnt`, `track_date`, `entry_time`, `account_id`) 
        VALUES ($curated_cnt, $drafted_cnt, $pictures_cnt, $videos_cnt, $misc_cnt,
        CURDATE(),NOW(),1)";
    $result = mysqli_query($mysqli, $query);
  }else{
      echo "error";
  }
?>
<?php
  require ("../dashboard/dashboard.php");
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Time Keeper
        <small>UniversalTech</small>
      </h1>

    <!-- Main content -->
    <section class="content">

    <div class="col-md-6">
      <div id="alertMsg">
        <?php
          if (isset($_GET['succ'])){
              echo '<div class="alert alert-success" role="alert">'.$_SESSION['alertMsg'].'</div>';
          }
          if (isset($_GET['err'])){
              echo '<div class="alert alert-danger" role="alert">'.$_SESSION['alertMsg'].'</div>';
          }
        ?>
      </div>

      <div class="col-md-12">
        <br><br>
        <p class="timestamp" id="time"></p>
        <p class="timestamp" id="date"></p>
        <br><br>
      </div>

      <div id="time-btns">
        <?php
          $query = "SELECT `timeIn`, `timeOut`, `lunchIn`, `lunchOut`
                FROM `timetable`
                WHERE DATE(`date`) = DATE(CURRENT_TIMESTAMP) AND user_id = ".$_SESSION["user_id"];
          $result = mysqli_query($mysqli, $query);
          if ($result->num_rows == 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['timeIn'] == 0) {
              echo '<div class="col-md-12 text-center">';
              echo '<button type="button" class="btn btn-success timeBtn" id="btnTimeIn">Time In</button>';
              echo '</div>';
            } else if ($row['timeIn'] != 0 && $row['timeOut'] == 0 && $row['lunchIn'] == 0 && $row['lunchOut'] == 0) {
              echo '<div class="col-md-6 text-center">';
              echo '<button type="button" class="btn btn-danger timeBtn" id="btnTimeOut">Time Out</button>';
              echo '</div>';
              echo '<div class="col-md-6 text-center">';
              echo '<button type="button" class="btn btn-warning timeBtn" id="btnLunchIn">Lunch Time In</button>';
              echo '</div>';
            } else if ($row['timeIn'] != 0 && $row['timeOut'] == 0 && $row['lunchIn'] != 0 && $row['lunchOut'] == 0) {
              echo '<div class="col-md-6 text-center">';
              echo '<button type="button" class="btn btn-danger timeBtn" id="btnTimeOut">Time Out</button>';
              echo '</div>';
              echo '<div class="col-md-6 text-center">';
              echo '<button type="button" class="btn btn-warning timeBtn" id="btnLunchOut">Lunch Time Out</button>';
              echo '</div>';
            } else if ($row['timeIn'] != 0 && $row['timeOut'] == 0 && $row['lunchIn'] != 0 && $row['lunchOut'] != 0) {
              echo '<div class="col-md-12 text-center">';
              echo '<button type="button" class="btn btn-danger timeBtn" id="btnTimeOut">Time Out</button>';
              echo '</div>';
            } else if ($row['timeIn'] != 0 && $row['timeOut'] != 0) {
              echo '<div class="col-md-12 text-center">';
              echo '<button type="button" class="btn btn-success timeBtn disabled">Time In</button>';
              echo '</div>';
            }
          } else {
            header("location:../../functions/timeInOut.php?newDays");
            exit();
          }
        ?>
      </div>
    </div>

    <div class="container">
      <div class="col-md-6 div-table">
        <h2>Time History Today</h2>
          <table class="table table-condensed">
            <tbody id="timeToday-tbody">
              <?php displayTimetableToday(); //generalDBFunctions.php ?>
            </tbody>
          </table>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar Start-->
  <?php include '../dashboard/control_sidebar.php'; ?>

</div>
<!-- ./wrapper -->

<script>
  document.getElementById("homeTab").setAttribute("class", "active");

  $(document).ready(function(){
      setInterval(timestamp, 1000);
  });

  function timestamp() {
      $.ajax({
          url: "../../functions/timestamp.php?time",
          success: function(data) {
              $('#time').html(data);
          },
      });    

      $.ajax({
          url: "../../functions/timestamp.php?date",
          success: function(data) {
              $('#date').html(data);
          },
      });
  }

  $(document).on('click', '#btnTimeIn', function(event){
    ajax("timeIn", "Time in?", "", "Time IN Successful!", "Time in");
  });

  $(document).on('click', '#btnTimeOut', function(event){
    ajax("timeOut", "Time Out?", "", "Time OUT Successful!", "Time out");
  });

  $(document).on('click', '#btnLunchIn', function(event){
    ajax("lunchTimeIn", "Lunch in?", "", "Lunch IN Successful!", "Lunch in");
  });

  $(document).on('click', '#btnLunchOut', function(event){
    ajax("lunchTimeOut", "Lunch out?", "", "Lunch OUT Successful!", "Lunch out");
  });

  function ajax(action, titleText, textText, successText, confirmBtnText){
      var request;
      event.preventDefault();

      if (request) {
          request.abort();
      }

      var $btn = $(this);

      $btn.prop("disabled", true);

      swal({
        title: titleText,
        text: textText,
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: confirmBtnText,
        cancelButtonText: "Cancel",
        cancelButtonClass: "btn-danger",
        closeOnConfirm: false,
        showLoaderOnConfirm: true
      },
      function (isConfirm) {
          if (isConfirm) {
            setTimeout(function(){
              request = $.ajax({
                url: "../../functions/timeInOut.php",
                data: {action: action},
                type: "POST"
              });

              // Callback handler that will be called on success
              request.done(function (response, textStatus, jqXHR){
                  var parts = response.split('|');
                  if(parts[1] == "fail"){
                    swal("Error!", "An error has occurred", "error");
                  }else{
                    swal(successText, "", "success");
                    //document.getElementById("alertMsg").innerHTML=parts[0];
                    document.getElementById("time-btns").innerHTML=parts[0];
                    document.getElementById("timeToday-tbody").innerHTML=parts[1];
                  }       
              });

              // Callback handler that will be called on failure
              request.fail(function (jqXHR, textStatus, errorThrown){
                  swal("Error!", "An error has occurred", "error");
                  // Log the error to the console
                  console.error(
                      "The following error occurred: "+
                      textStatus, errorThrown
                  );
              });

              // Callback handler that will be called regardless
              // if the request failed or succeeded
              request.always(function () {
                  // Reenable the inputs
                  $btn.prop("disabled", false);
              });
            }, 500);
          }
      });
  }
</script>
<?php
  include("../dashboard/dashboard.php");

  // $testJobTitle = 'Trackimo Customer Support';
  // if($_SESSION['jobTitle'] != $testJobTitle && !isOfJobTitle($_SESSION['user_id'], $testJobTitle)) {
  //   header("Location:../home/home.php");
  // }
?>
<head>
  <style>
    .addTaskBtn{
        background-color: #00d200;
        color:white;
    }
  </style>
</head>

<body ng-app="taskFieldsApp" >
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Trackimo Customer Support
        <small>UniversalTech</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div ng-cloak ng-controller="taskFieldsController" data-ng-init="init()">
          <md-content>
            <md-tabs md-dynamic-height md-border-bottom>
              <md-tab label="daily tracker">
                <md-content class="md-padding">
                  <span class="md-display-2" >Daily Tracker </span>
                  <md-button class="md-warn md-raised" ng-if="exists==true" ng-click="modal()" data-target="#optionModal" data-toggle="modal">Edit <span class="fa fa-edit"></span></md-button>
                  <md-card>
                    <md-card-content>
                        <div>{{today[0].DailyTask}}</div>
                    </md-card-content>
                  </md-card>
                  <!--Edit Modal-->
                      <div id="optionModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <form ng-submit="editData()">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h2 id="modalHeaderEditDelete">Task</h2>
                                </div>
                                <div class="modal-body">
                                  <input ng-model="modalcustomersupportId" hidden>
                                  <textarea ng-model="modaldailytask" rows="15" ng-model="obj.dailyTask" id="comment_text" cols="40" class="area ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" maxlength="2500" required></textarea>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-warning" onclick="$('#optionModal').modal('hide');">Edit <span class="fa fa-edit"></span></button>
                                </div>
                              </div>
                          </form>
                        </div>
                      </div>
                      <!--END of Edit <Modal--></Modal-->
                </md-content>         
              </md-tab>

                    <md-tab label="add tasks">
                        <md-content class="md-padding" >
                            <form ng-submit="submitData()">
                                <div id="taskHolderOjt" class="container" style="max-width:100%;">
                                    <div class="jumbotron" ng-if="exists==false">
                                        <p style="font-size:30px;">Tasks for today</p>
                                        <div class="task-group">
                                            <textarea placeholder="Task Description 

                        Ex: I did this today..." rows="15" ng-model="obj.dailyTask" id="comment_text" cols="40" class="area ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" maxlength="2500" required></textarea>
                                            <div class="footer" align="center">
                                                <md-button id="submitBtn" type="submit" class=" md-raised md-primary" ng-model="submitBtn" style="width:60%; margin-right:10%">Submit</md-button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jumbotron" ng-if="exists==true">
                                      <h2>You have already created a Task today</h2>
                                    </div>
                                </div>
                            </form>
                        </md-content>
                        
              </md-tab>
            </md-tabs>
          </md-content>
        </div>  

      <!-- Your Page Content Here -->
      </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  
  <!-- Control Sidebar Start-->
  <?php include '../dashboard/control_sidebar.php'; ?>
  
</div>
<!-- ./wrapper -->


<script>
  document.getElementById("taskTracker").setAttribute("class", "active");

  var app = angular.module('taskFieldsApp', ['ngMaterial']);
  var x=0;
  app.config(['$qProvider', function ($qProvider) {
    $qProvider.errorOnUnhandledRejections(false);
  }]);
  app.controller('taskFieldsController', function($scope, $http, $mdDialog) {
    $scope.obj = {
      $dailytask: "",
    };
     $scope.init = function () {
        $http.get("../../queries/getMyDailyTrackerTodayCustomerSupportTracker.php").then(function (response) {
          $scope.today = response.data.records;
          if($scope.today[0].CustomerSupportId==""){
            $scope.exists=false;
          }else{
            $scope.exists=true;
          }
        });
      };
      
      $scope.showAlert = function(ev) {
        $mdDialog.show(
          $mdDialog.alert()
          .parent(angular.element(document.querySelector('#popupContainer')))
          .clickOutsideToClose(true)
          .title('Successful Insertion!')
          .textContent('You have successfully ADDED a Task.')
          .ariaLabel('Alert Dialog Demo')
          .ok('Got it!')
          .targetEvent(ev)
        );
      }

      
      $scope.showEdit = function(ev) {
        $mdDialog.show(
          $mdDialog.alert()
          .parent(angular.element(document.querySelector('#popupContainer')))
          .clickOutsideToClose(true)
          .title('Successful Edit!')
          .textContent('You have successfully EDITED your Task.')
          .ariaLabel('Alert Dialog Demo')
          .ok('Got it!')
          .targetEvent(ev)
        );
      }

      $scope.submitData = function() {
        $http.post('../../insertFunctions/insertTrackimoCsTracker.php', {
            'dailyTask': $scope.obj.dailyTask
            }).then(function(data, status){
              $scope.init();
              $scope.showAlert();
            })
      };

      $scope.editData = function() {
        $http.post('../../editFunctions/editDailyTaskCustomerSupport.php', {
          'id': $scope.modalcustomersupportId,
          'dailytask': $scope.modaldailytask
        }).then(function(data, status){
              $scope.init();
              $scope.showEdit();
        })
      };

      $scope.modal = function() {
          $scope.modalcustomersupportId = $scope.today[0].CustomerSupportId;
          $scope.modaldailytask = $scope.today[0].DailyTask;
      };
  });
</script>

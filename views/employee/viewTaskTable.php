<?php
  require ("../../functions/php_globals.php");
  require ("../dashboard/dashboard.php");
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Task Table
        <small>UniversalTech</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content" ng-app="taskFieldsApp" ng-cloak ng-controller="taskFieldsController as ctrl">
      <form ng-submit="search()">
        <div>
        <input ng-model="userJob" ng-init="userJob = '<?php echo $_SESSION['jobTitle']?>'" hidden>
        <input ng-model="userId" ng-init="userId = '<?php echo $_SESSION['user_id']?>'" hidden>
          <md-content layout-padding ng-cloak>
            <div layout-gt-xs="row" data-ng-init="init()">
              <div flex-gt-xs>
                <md-datepicker ng-model="ctrl.startDate" md-placeholder="Start date" required></md-datepicker>
                <md-datepicker ng-model="ctrl.endDate" md-placeholder="End date" required></md-datepicker>
                <md-button class="md-accent md-raised md-hue-2" type="submit">Search</md-button>
              </div>
            </div>
          </md-content>
        </form>
      <div align="center">
        <h2 ng-show="empty" style="text-align:center;">Your task tracker is empty!</h2>
        <div id="grid1" ui-grid="{ data: tracker }" ui-grid-pagination class="grid"></div>
        <br>
        <div id="grid2" ui-grid="{ data: todayAdditional }" ui-grid-pagination class="grid" ng-show="show"></div>
      </div>
      <div style="margin-bottom:30%;"></div> <!--Used because of visual bug-->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar Start-->
  <?php include '../dashboard/control_sidebar.php'; ?>
  
</div>
<!-- ./wrapper -->


<script>
    var app = angular.module('taskFieldsApp', ['ngMaterial', 'ui.grid', 'ui.grid.pagination']);
    var x=0;
    app.config(['$qProvider', function ($qProvider) {
      $qProvider.errorOnUnhandledRejections(false);
    }]);
    app.controller('taskFieldsController', function($scope, $http, $mdDialog) {
      $scope.show=false;

      $scope.grid1 = {
        paginationPageSizes: [25],
        paginationPageSize: 25,
      };

      $scope.grid2 = {
        paginationPageSizes: [25],
        paginationPageSize: 25,
      };
        $scope.init = function () {
          if($scope.userJob=="Writer"){
            $http.get('../../queries/filter/getFilterWriter.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
              $scope.tracker = response.data.records;

              if($scope.tracker.length<=0){
                $scope.empty = true;
              }
            });
          }else if($scope.userJob=="Editor"){
            $http.get('../../queries/filter/getFilterEditor.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
              $scope.tracker = response.data.records;

              if($scope.tracker.length<=0){
                $scope.empty = true;
              }
            });
          }else if($scope.userJob=="Marketing" 
          || $scope.userJob=="Trackimo Customer Support"
          || $scope.userJob=="SEO Specialist"){
            if($scope.userJob=="Marketing"){
              $http.get('../../queries/filter/getFilterMarketing.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
              });
            }else if($scope.userJob=="Trackimo Customer Support"){
              $http.get('../../queries/filter/getFilterCustomer.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;
                
                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
              });
              
            }else if($scope.userJob=="SEO Specialist"){
              $http.get('../../queries/filter/getFilterSEO.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
              });
            }
          }else if($scope.userJob=="Social Media Specialist"){
            $http.get('../../queries/filter/getFilterSocial.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;
                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
            
          }else if($scope.userJob=="Multimedia Specialist"){
            $http.get('../../queries/filter/getFilterMultimedia.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="Data Processor"){
            $http.get('../../queries/filter/getFilterData.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="Wordpress Developer"){
            $http.get('../../queries/filter/getFilterWordpress.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="Content Marketing Assistant"){
            $http.get('../../queries/filter/getFilterContent.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="OJT Web Development"){
            $http.get('../../queries/filter/getFilterOJTWeb.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
              $scope.tracker = response.data.records;
              
              if($scope.tracker.length<=0){
                $scope.empty = true;
              }
            });
          }else if($scope.userJob=="OJT SEO"){
            $http.get('../../queries/filter/getFilterOJTSEO.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="OJT Developer for Automated Data System"){
            $http.get('../../queries/filter/getFilterOJTDeveloper.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }else if($scope.userJob=="OJT Researcher"){
            $http.get('../../queries/filter/getFilterOJTResearcher.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response){
                $scope.tracker = response.data.records;

                if($scope.tracker.length<=0){
                  $scope.empty = true;
                }
            });
          }

          $http.get('../../queries/getAdditionalTasksAdmin.php?userId="'+$scope.userId+'"&startDate="0000-00-00"&endDate="9999-12-31"').then(function (response) {
            $scope.todayAdditional = response.data.records;
            if($scope.todayAdditional.length>0){
              $scope.show=true;

              if($scope.tracker.length<=0){
                  $scope.empty = true;
              }
            }
          }); 
        };

        $scope.search = function(){
          $scope.date1 = moment($scope.ctrl.startDate).format('YYYY-MM-DD');
          $scope.date2 = moment($scope.ctrl.endDate).format('YYYY-MM-DD');
          if($scope.userJob=="Writer"){
            $http.get('../../queries/filter/getFilterWriter.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
            

          }else if($scope.userJob=="Editor"){
            $http.get('../../queries/filter/getFilterEditor.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="Marketing" 
          || $scope.userJob=="Trackimo Customer Support"
          || $scope.userJob=="SEO Specialist"){
            if($scope.userJob=="Marketing"){
              $http.get('../../queries/filter/getFilterMarketing.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
                $scope.tracker = response.data.records;
              });
            }else if($scope.userJob=="Trackimo Customer Support"){
              $http.get('../../queries/filter/getFilterCustomer.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
                $scope.tracker = response.data.records;
            });
            }else{
              $http.get('../../queries/filter/getFilterSEO.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
                $scope.tracker = response.data.records;
            });
            }
          }else if($scope.userJob=="Social Media Specialist"){
            $http.get('../../queries/filter/getFilterSocial.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="Multimedia Specialist"){
            $http.get('../../queries/filter/getFilterMultimedia.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="Data Processor"){
            $http.get('../../queries/filter/getFilterData.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="Wordpress Developer"){
            $http.get('../../queries/filter/getFilterWordpress.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="Content Marketing Assistant"){
            $http.get('../../queries/filter/getFilterContent.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="OJT Web Development"){
            $http.get('../../queries/filter/getFilterOJTWeb.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="OJT SEO"){
            $http.get('../../queries/filter/getFilterOJTSEO.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="OJT Developer for Automated Data System"){
            $http.get('../../queries/filter/getFilterOJTDeveloper.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }else if($scope.userJob=="OJT Researcher"){
            $http.get('../../queries/filter/getFilterOJTResearcher.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response){
              $scope.tracker = response.data.records;
            });
          }
          $http.get('../../queries/getAdditionalTasksAdmin.php?userId="'+$scope.userId+'"&startDate="'+$scope.date1+'"&endDate="'+$scope.date2+'"').then(function (response) {
            $scope.todayAdditional = response.data.records;
            if($scope.todayAdditional.length>0){
              $scope.show=true;
            }
          }); 
        }
    });
</script>




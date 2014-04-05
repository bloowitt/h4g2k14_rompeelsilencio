'use strict';

angular.module('clientApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    $scope.mainContent='login';
    $scope.usuario={};
    $scope.chargeMainContent=function(mainContent){
    	$scope.mainContent=mainContent;
    };
    $scope.meterPass=function(cosa){
    	console.log(cosa);
    	if(cosa==='passVerdadera')
    		{
    		$scope.mainContent='verdad';
    		}
    	if(cosa==='passFalsa')
    		{
    		$scope.mainContent='mentira';
    		}
    };
  });

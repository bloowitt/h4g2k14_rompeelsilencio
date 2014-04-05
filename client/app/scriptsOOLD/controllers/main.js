'use strict';

angular.module('clientApp')
  .controller('MainCtrl', function ($scope,caller) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    $scope.mainContent='cosa';
    $scope.chargeMainContent=function(mainContent){
			console.log($scope.mainContent);
			$scope.mainContent=mainContent;
			console.log($scope.mainContent);
		};

  });

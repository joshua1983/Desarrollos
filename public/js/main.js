var IP_SERVIDOR = '172.16.200.181';
var inventarioApplication = angular.module('inventario',
	['ngRoute','ngResource','appConf','inventarioApp','ingenieros','funcionales','modulos','informes','capacidades'])
.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/loginPop',{
		templateUrl: 'templates/login.html',
		controller: 'LoginCtrl'
	});
}])
.controller('LoginCtrl',['$scope','$location', '$rootScope','AuthService', function($scope, $location, $rootScope,AuthService){
	$scope.usuario = "admin";
	$scope.password = "";
	
	$scope.autenticar = function(){
		if ($scope.usuario == "admin" && $scope.password == "123"){
			AuthService.setAdmin(true);
			$location.path('/homeCap');
		}else{
			AuthService.setAdmin(false);
			alert("Constraseña invalida");
		}
	}

	$scope.isAdmin = function(){
		if (AuthService.esAdmin() == null ) return false;
		return AuthService.esAdmin();
	}

	$scope.salir = function(){
		AuthService.setAdmin(false);
		location.reload();
	}

}])
.service('AuthService', function ($window) {
	
	
	var authService = {};

	authService.esAdmin = function(){
		return $window.sessionStorage.getItem('isAdmin');
	}
	authService.setAdmin = function(val){
		if (val){
			$window.sessionStorage.setItem('isAdmin', val);
		}else{
			$window.sessionStorage.removeItem('isAdmin');
		}
		
	}

 
	return authService;
});
angular.module('capacidades',['ngRoute','ngResource', 'inventarioApp','modulos'])
.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/homeCap',{
		templateUrl: 'templates/canvascap.html',
		controller: 'HomeCtrlCap'
	})
	.when('/editAppCaract/:id/:nivel/:idCap', {
		templateUrl: 'templates/editAppCat.html',
		controller: 'CambiarAppCar'
	})
	.when('/editModCaract/:id/:nivel/:idCap', {
		templateUrl: 'templates/editModCat.html',
		controller: 'CambiarModCar'
	})
	.when('/addAppCaract',{
		templateUrl: 'templates/addAppCar.html',
		controller: 'AddAppCar'
	})
	.when('/addModCaract',{
		templateUrl: 'templates/addModCar.html',
		controller: 'AddModCar'
	});
}])

.controller('HomeCtrlCap',['$scope','$http', '$location','CapacidadesApp', '$route','AuthService', 
	function($scope, $http, $location, CapacidadesApp, $route, AuthService){
	
	CapacidadesApp.get(function(data){
		$scope.capacidades = data.caps;
	});

	$scope.isAdmin = function(){
		if (AuthService.esAdmin() == null ) return false;
		return AuthService.esAdmin();
	}
	
	$scope.borrarApp = function(idApp, idCap){
		$http.delete('http://'+IP_SERVIDOR+'/inventario/index.php/capacidades/del/'+idApp+'/'+idCap).

			success(function(data, status, headers, config) {
				if(status== 200){
    				$location.path('/homeCap');
    			}
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});
	}

	$scope.borrarMod = function(idMod, idCap){
		$http.delete('http://'+IP_SERVIDOR+'/inventario/index.php/capmod/del/'+idMod+'/'+idCap).

			success(function(data, status, headers, config) {
				if(status== 200){
    				$location.path('/homeCap');
    			}
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});
	}
	
}])
.controller('AddModCar',['$scope','$http', '$routeParams', '$location','InventarioApp', 'CapacidadesApp', 'ModuloFact',
	function($scope, $http, $routeParams, $location, InventarioApp, CapacidadesApp, ModuloFact){

	$scope.idAplicacion = 0;
	$scope.idCaracteriza = 0;
	$scope.idModulo = 0;
	$scope.nivel = 0;

	InventarioApp.get(function(data){
		$scope.InventarioApp = data.apps;
	});

	CapacidadesApp.get(function(data){
		$scope.capacidades = data.caps;
	});

	ModuloFact.get(function(data){
		$scope.modulos = data.mods;
	});

	$scope.cambiaApp=function(){
		ModuloFact.get({id:$scope.idAplicacion},function(dataMods){
			$scope.modulos = dataMods.modulos;
		});
	};


	$scope.guardar=function(){

		$http.post('http://'+IP_SERVIDOR+'/inventario/index.php/capmod/'+$scope.idModulo, 
			{"nivel": $scope.nivel, "caracteriza": $scope.idCaracteriza, "aplicacion": $scope.idAplicacion}).

			success(function(data, status, headers, config) {
    			$location.path('/homeCap');
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});
	}
}])
.controller('AddAppCar',['$scope','$http', '$routeParams', '$location','InventarioApp', 'CapacidadesApp', 
	function($scope, $http, $routeParams, $location, InventarioApp, CapacidadesApp){

	$scope.idAplicacion = 0;
	$scope.idCaracteriza = 0;
	$scope.nivel = 0;

	InventarioApp.get(function(data){
		$scope.InventarioApp = data.apps;
	});

	CapacidadesApp.get(function(data){
		$scope.capacidades = data.caps;
	});


	$scope.guardar=function(){

		$http.post('http://'+IP_SERVIDOR+'/inventario/index.php/capacidades/'+$scope.idAplicacion, 
			{"nivel": $scope.nivel, "caracteriza": $scope.idCaracteriza}).

			success(function(data, status, headers, config) {
    			$location.path('/homeCap');
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});
	}
}])
.controller('CambiarModCar',['$scope','$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location){
	$scope.nivel = $routeParams.nivel;
	$scope.idMod = $routeParams.id;
	$scope.idCap = $routeParams.idCap;

	$scope.guardarCambio = function(){

		$http.put('http://'+IP_SERVIDOR+'/inventario/index.php/capmod/'+$scope.idMod, {"nivel": $scope.nivel, "capacidad": $scope.idCap}).
			success(function(data, status, headers, config) {
    			$location.path('/homeCap');
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});

		
	}
}])

.controller('CambiarAppCar',['$scope','$http', '$routeParams', '$location', function($scope, $http, $routeParams, $location){
	$scope.nivel = $routeParams.nivel;
	$scope.idApp = $routeParams.id;
	$scope.idCap = $routeParams.idCap;

	$scope.guardarCambio = function(){

		$http.put('http://'+IP_SERVIDOR+'/inventario/index.php/capacidades/'+$scope.idApp, {"nivel": $scope.nivel, "capacidad": $scope.idCap}).
			success(function(data, status, headers, config) {
    			$location.path('/homeCap');
  			}).
  			error(function(data, status, headers, config) {
    			console.log(status);
  			});

		
	}
}])

.factory('CapacidadesApp',function($q,$resource){
	$_token = "{{ csrf_token() }}";
	return $resource("http://"+IP_SERVIDOR+"/inventario/index.php/capacidades/:id",{id: "@_id"},{
		update: {method: "PUT", params: {id: "@id", _token: $_token}}
	})
});

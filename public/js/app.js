angular.module('inventarioApp',['ngRoute', 'ngResource','appConf', 'inventario'])

.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/homeApp',{
		templateUrl: 'templates/listApp.html',
		controller: 'HomeCtrl'
	})
	.when('/editApp/:id',{
		templateUrl: 'templates/editarApp.html',
		controller: 'EditCtrl'
	})
	.when('/createApp',{
		templateUrl: 'templates/nuevoApp.html',
		controller: 'CreateCtrl'
	})
	.when('/',{
		redirectTo: '/homeApp'
	})
	.otherwise({redirectTo: '/homeApp'});
}])

.controller('HomeCtrl',['$scope','InventarioApp', '$route', '$rootScope','AuthService', function($scope, InventarioApp, $route, $rootScope, AuthService){
	InventarioApp.get(function(data){
		$scope.InventarioApp = data.apps;

	});

	$scope.isAdmin = function(){
		if (AuthService.esAdmin() == null ) return false;
		return AuthService.esAdmin();
	}

	$scope.remove= function(id){
		InventarioApp.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload(); 
			}
		});
	}


}])
.controller('EditCtrl',['$scope','InventarioApp' ,'Configuraciones','ModuloFact','IngenieroFact', '$routeParams', '$route',
 function($scope, InventarioApp, Configuraciones,ModuloFact,IngenieroFact, $routeParams, $route){
	$scope.settings = {
		pageTitle: "Editar Aplicación",
		action: "Guardar",
		edicion: true
	}

	var idAplicacion = $routeParams.id;
	
	
	InventarioApp.get({id:idAplicacion},function(data){
		IngenieroFact.get(function(datosIng){
			$scope.ingenieros = datosIng.ings;
		});
		
		ModuloFact.get({id:idAplicacion},function(dataMods){
			$scope.aplicacion.Modulos = dataMods.modulos;
		});
	
		Configuraciones.get({id:0,idApp: idAplicacion}, function(dataConf){
			$scope.aplicacion.Configuraciones = dataConf.config
		});

		$scope.aplicacion = data.aplicacion;
		
		var dba = $scope.aplicacion.dba_id;
		var tec = $scope.aplicacion.tec_id;		
		
		IngenieroFact.get({id:dba},function(datosIng){
			$scope.aplicacion.dba = datosIng.ingeniero;
		});
		IngenieroFact.get({id:tec},function(datosIng){
			$scope.aplicacion.tec = datosIng.ingeniero;
		});	
		
	});

	$scope.actualizarCapacidad=function(idCap){

	}
	
	$scope.borrarConfiguracion= function(id){
		Configuraciones.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload(); 
			}
		});
	}
	
	$scope.borrarModulo= function(id){
		ModuloFact.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload(); 
			}
		});
	}

	$scope.submit = function(){
		InventarioApp.update({id: $scope.aplicacion.id}, $scope.aplicacion).$promise.then(function(data){
			if (data.msg){
				//angular.copy({},$scope.aplicacion);
				$scope.settings.success = "Aplicación editada correctamente";
				window.history.back();
			}
		});
	}
}])
.controller('CreateCtrl',['$scope', 'InventarioApp','IngenieroFact', '$location', function($scope, InventarioApp, IngenieroFact, $location){
	$scope.settings = {
		pageTitle: "Agregar Aplicación",
		action: "Crear",
		edicion: false
	}
	
	IngenieroFact.get(function(datosIng){
		$scope.ingenieros = datosIng.ings;
	});
	

	$scope.aplicacion = {
		codigo_aplicacion: "",
		nombre_aplicacion: "",
		dba_id: "",
		tec_id: "",
		estado: ""
	};

	$scope.submit = function(){
		
		InventarioApp.save($scope.aplicacion).$promise.then(function(data){
			if (data.msg){
				angular.copy({},$scope.aplicacion);
				$scope.settings.success = "Aplicación guardada correctamente";
				$location.path('homeApp');
			}
		});
	}
}])
.factory('InventarioApp',function($resource){
	$_token = "{{ csrf_token() }}";
	return $resource("http://"+IP_SERVIDOR+"/inventario/index.php/aplicaciones/:id",{id: "@_id"},{
		update: {method: "PUT", params: {id: "@id", _token: $_token}}
	})
});

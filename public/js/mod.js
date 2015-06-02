angular.module('modulos',['ngRoute', 'ngResource'])

.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/homeMod/:id',{
		templateUrl: 'templates/listMod.html',
		controller: 'HomeModCtrl'
	})
	.when('/editMod/:id',{
		templateUrl: 'templates/editMod.html',
		controller: 'EditModCtrl'
	})
	.when('/addMod/:id',{
		templateUrl: 'templates/nuevoMod.html',
		controller: 'CreateModCtrl'
	})
	.otherwise({redirectTo: '/homeApp'});
}])

.controller('HomeModCtrl',['$scope','ModuloFact', '$routeParams', '$route', function($scope, ModuloFact, $routeParams,$route){
	
	var idApp = $routeParams.id;
	
	ModuloFact.get({id:id},function(data){
		$scope.Modulos = data.mods;
	});

	$scope.remove= function(id){
		ModuloFact.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload(); 
			}
		});
	}
}])
.controller('EditModCtrl',['$scope','ModuloFact','IngenieroFact', 'FuncionalFact', '$routeParams','$http', '$route', 
	function($scope, ModuloFact, IngenieroFact, FuncionalFact, $routeParams, $http, $route){
	$scope.settings = {
		pageTitle: "Editar Funcional",
		action: "Guardar",
		editar: true
	}

	var app_id = $routeParams.id;
	ModuloFact.get({id:0,idApp:app_id},function(data){		
		$scope.modulo = data.modulo;
	});
	
	IngenieroFact.get({id:0,idApp:app_id},function(dataIng){
		$scope.ingenieros = dataIng.ingeniero;
	})
	
	FuncionalFact.get({id:0,idApp:app_id},function(dataFuncs){
		$scope.funcionales = dataFuncs.funcionales;
	});
	
	$scope.borrarIngeniero = function(id){
		console.log(id + '-' + app_id);
		var req = {
			 method: 'POST',
			 url: "http://"+IP_SERVIDOR+"/inventario/index.php/ingenieros/remove/"+id+"/"+app_id,
			 data: { test: 'test' }
			}
		$http(req).success(function(){
			$route.reload(); 
		}).error(function(){
			alert('error');
		});
	}
	
	$scope.borrarFuncional = function(id){
		console.log(id + '-' + app_id);
		var req = {
			 method: 'POST',
			 url: "http://"+IP_SERVIDOR+"/inventario/index.php/funcionales/remove/"+id+"/"+app_id,
			 data: { test: 'test' }
			}
		$http(req).success(function(){
			$route.reload(); 
		}).error(function(){
			alert('error');
		});
	}
	
	$scope.submit = function(){
	
		ModuloFact.update({id: $scope.modulo.id}, $scope.modulo).$promise.then(function(data){
			if (data.msg){
				//angular.copy({},$scope.aplicacion);
				$scope.settings.success = "Ingeniero editado correctamente";
				window.history.back();
			}
		});
	}
}])
.controller('CreateModCtrl',['$scope', 'ModuloFact', '$routeParams','$location', 
	function($scope, ModuloFact, $routeParams, $location){
	$scope.settings = {
		pageTitle: "Agregar Funcional",
		action: "Crear",
		editar: false
	}

	$scope.modulo = {
		nombre_modulo: "",
		formularios: "",
		procesos: "",
		reportes: "",
		tablas: "",
		estado: "",
		tipomodulo: "",
		aplicacion_id: ""
	};

	$scope.submit = function(){
		$scope.modulo.aplicacion_id = $routeParams.id;
		ModuloFact.save($scope.modulo).$promise.then(function(data){
			if (data.msg){
				angular.copy({},$scope.modulo);
				$scope.settings.success = "Modulo guardado correctamente";
				$location.path('editApp/'+$routeParams.id);
			}
		});
	}
}])

.factory('ModuloFact',function($resource){
	$_token = "{{ csrf_token() }}";
	return $resource("http://"+IP_SERVIDOR+"/inventario/index.php/modulos/:id/:idApp",{id: "@_id",idApp:"@_idApp"},{
		update: {method: "PUT", params: {id: "@id", _token: $_token}}
	})
});

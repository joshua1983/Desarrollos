angular.module('appConf',['ngRoute', 'ngResource'])

.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/homeConf',{
		templateUrl: 'templates/listConf.html',
		controller: 'HomeConfCtrl'
	})
	.when('/editConf/:id',{
		templateUrl: 'templates/editarConf.html',
		controller: 'EditConfCtrl'
	})
	.when('/createConf/:idApp',{
		templateUrl: 'templates/nuevoConf.html',
		controller: 'CreateConfCtrl'
	})
	.otherwise({redirectTo: '/homeConf'});
}])

.controller('HomeConfCtrl',['$scope','Configuraciones', '$route', function($scope, Configuraciones,$route){
	Configuraciones.get(function(data){
		$scope.Configuraciones = data.config;
	});

	$scope.remove= function(id){
		Configuraciones.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload(); 
			}
		});
	}
}])
.controller('EditConfCtrl',['$scope','Configuraciones', '$routeParams', function($scope, Configuraciones, $routeParams){
	$scope.settings = {
		pageTitle: "Editar Configuracion",
		action: "Guardar"
	}

	var id = $routeParams.id;
	
	Configuraciones.get({id:id},function(data){
		$scope.Configuracion = data.config;
	}); 
	
	$scope.submit = function(){
		Configuraciones.update({id: $scope.Configuracion.id}, $scope.Configuracion).$promise.then(function(data){
			if (data.msg){
				//angular.copy({},$scope.Configuracion);
				$scope.settings.success = "Configuracion editada correctamente";
				window.history.back();
			}
		});
	}
}])
.controller('CreateConfCtrl',['$scope', 'Configuraciones', '$routeParams', '$location', function($scope, Configuraciones, $routeParams, $location){
	$scope.settings = {
		pageTitle: "Agregar Configuracion",
		action: "Crear"
	}
	var id_aplicacion = $routeParams.idApp
	
	$scope.Configuracion = {
		aplicacion: id_aplicacion,
		servidor: "",
		ip: "",
		usuario: "",
		password: "",
		nota: ""
	};

	$scope.submit = function(){
		
		Configuraciones.save($scope.Configuracion).$promise.then(function(data){
			if (data.msg){
				angular.copy({},$scope.Configuracion);
				$scope.settings.success = "Configuracion guardada correctamente";
				$location.path('editApp/'+id_aplicacion);
			}
		});
	}
}])
.factory('Configuraciones',function($resource){
	$_token = "{{ csrf_token() }}";
	return $resource("http://"+IP_SERVIDOR+"/inventario/index.php/configuraciones/:id/:idApp",{id: "@_id",idApp: "@_idApp"},{
		update: {method: "PUT", params: {id: "@id", _token: $_token}}
	})
});

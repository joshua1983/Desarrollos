var app = angular.module('oracionesApp',['ngRoute', 'ngResource'])

.config(['$routeProvider', function($routeProvider){
	$routeProvider.when('/home',{
		templateUrl: 'templates/list.html',
		controller: 'HomeCtrl'
	})
	.when('/edit/:id',{
		templateUrl: 'templates/editar.html',
		controller: 'EditCtrl'
	})
	.when('/create',{
		templateUrl: 'templates/nuevo.html',
		controller: 'CreateCtrl'
	})
	.otherwise({redirectTo: '/home'});
}])

.controller('HomeCtrl',['$scope','Oraciones', '$route', function($scope, Oraciones,$route){
	Oraciones.get(function(data){
		$scope.oraciones = data.orac;
	});

	$scope.remove= function(id){
		Oraciones.delete({id: id}).$promise.then(function(data){
			if (data.msg){
				$route.reload();
			}
		});
	}
}])
.controller('EditCtrl',['$scope','Oraciones', '$routeParams', function($scope, Oraciones, $routeParams){
	$scope.settings = {
		pageTitle: "Editar Oracion",
		action: "Guardar"
	}

	var id = $routeParams.id;
	Oraciones.get({id:id},function(data){
		$scope.Oracion = data.oracion;
	});

	$scope.submit = function(){
		Oraciones.update({id: $scope.Oracion.id}, $scope.Oracion).$promise.then(function(data){
			if (data.msg){
				angular.copy({},$scope.Oracion);
				$scope.settings.success = "Oracion editada correctamente";
			}
		});
	}
}])
.controller('CreateCtrl',['$scope', 'Oraciones', function($scope, Oraciones){
	$scope.settings = {
		pageTitle: "Agregar Oracion",
		action: "Crear"
	}

	$scope.Oracion = {
		categoria: "",
		titulo: "",
		oracion: ""
	};

	$scope.submit = function(){
		
		Oraciones.save($scope.Oracion).$promise.then(function(data){
			if (data.msg){
				angular.copy({},$scope.Oracion);
				$scope.settings.success = "Oracion guardada correctamente";
			}
		});
	}
}])

.factory('Oraciones',function($resource){
	$_token = "{{ csrf_token() }}";
	return $resource("http://127.0.0.1/rosario/index.php/oraciones/:id",{id: "@_id"},{
		update: {method: "PUT", params: {id: "@id", _token: $_token}}
	})
});

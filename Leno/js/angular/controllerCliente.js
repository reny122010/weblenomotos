angular.module('leno',[])
 .controller('controllerCliente', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {

 	var serverRouting =  {
		"link" : "http://127.0.0.1/apisisstc/",
		"addUser" 		: "addCliente.php",
		"getUsers" 		: "listCliente.php",
		"getAllUsers"	: "listAllCliente.php"
	};

	var countClient = 0;

	$scope.user;

	$scope.clientes = [];
	$scope.listClientes = [];
	var pageCliente = 0;

	$scope.incrementCountUsers = function(){
		countClient++;
		return countClient;
	};

 	$scope.addUser = function(){

 		if($scope.user.limite == "" || $scope.user.limite == undefined ){
 			$scope.user.limite = -1;
 		}
 		
		$http({
		    url: serverRouting.link+serverRouting.addUser,
		    method: "GET",
		    params: $scope.user  
		})
		.success(function(response){
			console.log(response);
			pageCliente= 0;
			$scope.getUsers();
			$scope.getAllUsers();
			$scope.user = {};
	        $window.alert(response.menssagem);
	    })
	    .error(function(response){
	    	console.log(response);
	        $window.alert(response.menssagem);
	    });
 	};

 	$scope.getUsers = function(){
 		$scope.clientes = [];
		$http({
	     	url: serverRouting.link+serverRouting.getUsers,
	     	method: "GET",
	     	params: { 
				"pagina" : pageCliente 
			} 
		})
		.success(function(response){
			if(response.length == 0){
				$window.alert("A lista de clientes está completa!");
			}else{
				Array.prototype.push.apply($scope.clientes, response);
				pageCliente++;
			}
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
 	};

 	$scope.getAllUsers = function(){
 		$scope.listClientes = [];
		$http({
	     	url: serverRouting.link+serverRouting.getAllUsers,
	     	method: "GET"
		})
		.success(function(response){
			if(response.length == 0){
				$window.alert("A lista de clientes está vazia!");
			}else{
				Array.prototype.push.apply($scope.listClientes, response);
			}
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
 	};

 	$scope.showClient = function(cpf){
 		$window.location = "ver_cliente.html?cpf="+cpf;
 	};
 	$scope.showClientSelect = function(){
 		$scope.showClient(document.getElementById("mySelect").value);
 	}

 	//Inicialize
 	$scope.getUsers();
 	$scope.getAllUsers();
 }]); 
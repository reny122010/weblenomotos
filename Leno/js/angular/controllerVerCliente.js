angular.module('leno',[])

 .controller('controllerVerCliente', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {
 		$scope.user;
 		$scope.alterar = true;

 		var serverRouting =  {
			"link" : "http://127.0.0.1/apisisstc/",
			"updateUser"	: "alterarCliente.php",
			"getUsers" 		: "listCliente.php",
			"deleteUser" 	: "desativarCliente.php",
			"addPagamento"	: "addPagamento.php"
		};

 		var QueryString = function () {
		  var query_string = {};
		  var query = $window.location.search.substring(1);
		  var vars = query.split("&");
		  for (var i=0;i<vars.length;i++) {
		    var pair = vars[i].split("=");
		        // If first entry with this name
		    if (typeof query_string[pair[0]] === "undefined") {
		      query_string[pair[0]] = decodeURIComponent(pair[1]);
		        // If second entry with this name
		    } else if (typeof query_string[pair[0]] === "string") {
		      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
		      query_string[pair[0]] = arr;
		        // If third or later entry with this name
		    } else {
		      query_string[pair[0]].push(decodeURIComponent(pair[1]));
		    }
		  } 
		  return query_string;
		}();



		var cpf = QueryString.cpf;
		var getClient =  function(){
			$http({
			     url: serverRouting.link+serverRouting.getUsers,
			     method: "GET",
			     params: {"cpf" : cpf} 
			})
			.success(function(response){

				console.log(response);
				$scope.user = response[0];
		    })
		    .error(function(response){
		    	console.log(response);
		        $window.alert(response.menssagem);
		    });
		};


		$scope.editar = function(){
			$scope.alterar = false;
		};

		$scope.salvar = function(user){
			$scope.alterar = true;
			console.log(user);
 			$http({
		     url: serverRouting.link+serverRouting.updateUser,
		     method: "GET",
		     params: user 
			})
			.success(function(response){
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
			
		};

		$scope.deleteUser = function(){
			$scope.alterar = true;
			console.log("teste");
 			$http({
		     url: serverRouting.link+serverRouting.deleteUser,
		     method: "GET",
		     params: {"cpf" : $scope.user.cpf}
			})
			.success(function(response){
				$window.location = "cliente.html";
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
			
		};
		$scope.showVendas = function(){
	 		$window.location = "index.html?cpf="+cpf;
	 	};
		$scope.addPagamento = function(){

	 		var valor = document.getElementById('valor').value;
	 		console.log(valor);
			$http({
		     	url: serverRouting.link+serverRouting.addPagamento,
		     	method: "GET",
		     	params: {"valor" : valor, "cpf" : $scope.user.cpf} 
			})
			.success(function(response){
				$scope.user.debito = parseFloat($scope.user.debito) - parseFloat(valor);
				console.log(response);
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

		getClient();
 		
 }]); 
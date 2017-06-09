angular.module('leno',[])
 .controller('controllerVender', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {
 		$scope.user;
 		$scope.compra = {};
 		$scope.listClientes = [];
 		$scope.listProdutos = [];
 		$scope.listMyProdutos = [];
 		$scope.quantidade = 1;

 		$scope.finishValorTotal;
 		$scope.finishLimite;
 		$scope.finishDebito;
 		$scope.pagamentoNome;
 		$scope.stylePagamento;

 		$scope.userStatus = false;
 		$scope.valorTotal = 0.00;

 		$scope.state =  {
 			"realizarCompra" 	: true,
 			"cancelarCompra"	: true,
 			"selectCliente"		: true,
 			"btnSelectCliente"	: true,
 			"selectProduto"		: true,
 			"btnSelectProduto"	: true,
 			"inputQuantidade"	: true
 		};

 		var serverRouting =  {
			"link" 				: "http://127.0.0.1/apisisstc/",
			"getCompra" 		: "buscaCompra.php",
			"getUsers" 			: "listCliente.php",
			"getAllUsers"		: "listAllCliente.php",
			"getAllProduto"		: "listAllProduto.php",
			"createCompra"		: "criarCompra.php",
			"cancelarCompra"	: "cancelarCompra.php",
			"realizarCompra"	: "finalizarCompra.php",
			"addProduto"		: "addProdutoCompra.php",
			"getProdutoCompra"	: "listProdutoCompra.php",
			"cancelarProduto"	: "removerItem.php",
			"addPagamento"		: "addPagamento.php"
		};

 		var atualState =  function(state){
 			if(state == 0){
 				$scope.listMyProdutos = [];
 				$scope.userStatus = false;
 				$scope.valorTotal = 0.00;
 				$scope.state =  {
		 			"realizarCompra" 	: true,
		 			"cancelarCompra"	: true,
		 			"selectCliente"		: false,
		 			"btnSelectCliente"	: false,
		 			"selectProduto"		: true,
		 			"btnSelectProduto"	: true,
		 			"inputQuantidade"	: true
		 		};
		 		$scope.stylePagamento = {
				    "color" : "#2A3F54"
				}

 			}
 			if(state == 1){
 				console.log("teste");
 				$scope.userStatus = true;
 				$scope.state =  {
		 			"realizarCompra" 	: false,
		 			"cancelarCompra"	: false,
		 			"selectCliente"		: true,
		 			"btnSelectCliente"	: true,
		 			"selectProduto"		: false,
		 			"btnSelectProduto"	: false,
		 			"inputQuantidade"	: false
		 		};
 			}
 		};

 		var switchFloatPoint = function(str){
			return str.replace(",",".");
		};

 		var select = function (val) {
 			console.log(val);
		    var selectCliente = document.getElementById('mySelectCliente');
		    for(var i = 0, j = selectCliente.options.length; i < j; ++i) {
		    	console.log(selectCliente.options[i].innerHTML);
		        if(selectCliente.options[i].innerHTML == val) {
		        	selectCliente.options[i].selected = true;
		        	console.log(selectCliente);
		        	console.log("Foi");
		           selectCliente.model = "10654222452";
		           console.log(selectCliente.selectedIndex);
		           break;
		        }
		    }
		}

		var getClient =  function(cpf){
			$http({
			     url: serverRouting.link+serverRouting.getUsers,
			     method: "GET",
			     params: {"cpf" : cpf} 
			})
			.success(function(response){
				console.log(response);
				$scope.user = response[0];
				$scope.pagamentoNome = response[0].nome+" "+response[0].sobrenome;
		    })
		    .error(function(response){
		    	console.log(response);
		        $window.alert(response.menssagem);
		    });
		};

		var getProdutoCompra = function(){
			$http({
		     	url: serverRouting.link+serverRouting.getProdutoCompra,
		     	method: "GET",
		     	params: {
     				"idcompra" 	: $scope.compra.id
     			} 
			})
			.success(function(response){
				if(response.length == 0){
					$window.alert("Lista de produtos vazia!");
				}else{
					$scope.listMyProdutos = [];
					Array.prototype.push.apply($scope.listMyProdutos, response.lista);
					$scope.valorTotal = response.valortotal;
					console.log(response);
				}
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

 		$scope.getCompra = function(){
			$http({
			    url: serverRouting.link+serverRouting.getCompra,
			    method: "GET" 
			})
			.success(function(response){
				if(response.retorno == 1){
					$window.alert(response.menssagem);
				}
				if(response.retorno == 2){
					console.log(response);
					getClient(response.compra.cpfcliente);
					$scope.compra.id = response.compra.idcompra;
					atualState(1);
					getProdutoCompra();
					//document.getElementById("mySelectCliente").value = $scope.user.cpf+" -"+$scope.user.nome+$scope.user.sobrenome;
				}else{
					atualState(0);
				}

			    
			})
			.error(function(response){
				console.log(response);
			    $window.alert(response.menssagem);
			});
		};

		$scope.getAllUsers = function(){
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

	 	$scope.getAllProduto = function(){
			$http({
		     	url: serverRouting.link+serverRouting.getAllProduto,
		     	method: "GET"
			})
			.success(function(response){
				if(response.length == 0){
					$window.alert("A lista de produtos está vazia!");
				}else{
					Array.prototype.push.apply($scope.listProdutos, response);
				}
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
		};

	 	$scope.addProdutoCompra = function(idproduto){
	 		console.log("teste");
			$http({
		     	url: serverRouting.link+serverRouting.addProduto,
		     	method: "GET",
		     	params: {
		     				"idcompra" 	: $scope.compra.id,
		     				"idproduto"	: idproduto,
		     				"quantidade": $scope.quantidade
		     			} 
			})
			.success(function(response){
				if(response.retorno == 1){
					$window.alert(response.menssagem);
				}else{
					console.log(response);
					getProdutoCompra();
				}
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

	 	$scope.createCompra = function(cpf){
			$http({
		     	url: serverRouting.link+serverRouting.createCompra,
		     	method: "GET",
		     	params: {"cpf" : cpf} 
			})
			.success(function(response){
				$window.alert("A compra foi iniciada!");
				console.log(response);
				$scope.compra.id = response.idcompra;
				getClient(cpf);
				atualState(1);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};
		$scope.cancelarProduto = function(id){
	 		console.log($scope.compra.id);
			$http({
		     	url: serverRouting.link+serverRouting.cancelarProduto,
		     	method: "GET",
		     	params: {"idcompraproduto" : id, "idcompra" : $scope.compra.id} 
			})
			.success(function(response){
				console.log(response);
				getProdutoCompra();
				atualState(1);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};
	 	$scope.cancelarCompra = function(){
	 		console.log($scope.compra.id);
			$http({
		     	url: serverRouting.link+serverRouting.cancelarCompra,
		     	method: "GET",
		     	params: {"idcompra" : $scope.compra.id} 
			})
			.success(function(response){
				$window.alert("A compra foi cancelada!");
				atualState(0);
				$scope.compra = {};
				$scope.user = {};
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

	 	$scope.realizarCompra = function(){
	 		$('#modalPagamento').modal({
			    show: 'false'
			}); 
	 		console.log($scope.compra.id);
	 		console.log($scope.listMyProdutos);
	 		if (typeof $scope.listMyProdutos === 'undefined' || $scope.listMyProdutos.length < 1) {
			    $window.alert("Não é possível realizar uma venda sem produtos!");
			}else{
				$http({
			     	url: serverRouting.link+serverRouting.realizarCompra,
			     	method: "GET",
			     	params: {"idcompra" : $scope.compra.id} 
				})
				.success(function(response){
					console.log(response);
					
					if(response.retorno == 0){
						$window.alert(response.menssagem);
						$('#modalPagamento').modal('hide');
						atualState(0);
					}
					if(response.retorno == 1){
						$scope.stylePagamento = {
						    "color" : "red"
						}
						$window.alert(response.menssagem+", o valor não pode ficar em débito, é necessário pagar algum valor para que a compra possa ser aprovada!");
						$('#modalPagamento').modal('show.bs.modal');
					}
			    })
			    .error(function(response){
			        $window.alert(response.menssagem);
			    });
			}
			
	 	};

	 	$scope.checkPagamento = function(){
			$scope.finishValorTotal = "O valor total da compra: "+$scope.valorTotal;
			$scope.finishLimite = "Seu limite é de:"+$scope.user.limite;
			$scope.finishDebito = "Seu débito é de:"+$scope.user.debito;
			$('#modalPagamento').modal('show');
	 	}

	 	$scope.addPagamento = function(){
	 		var valor = document.getElementById('valor').value;
	 		console.log(valor);
	 		valor = switchFloatPoint(valor);
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
				$scope.realizarCompra();
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

	 	$scope.showClientSelect = function(){
	 		$scope.createCompra(document.getElementById("mySelectCliente").value);
	 	};

	 	$scope.showProdutoSelect = function(){
	 		if($scope.quantidade < 1){
	 			$window.alert("A quantidade de itens que você está adicionando à compra, é menor que 1, verifique-a! ");
	 		}else{
	 			$scope.addProdutoCompra(document.getElementById("mySelectProduto").value);
	 		}
	 		
	 	};

	 	
		$scope.getCompra ();
		$scope.getAllUsers();
		$scope.getAllProduto();
 	}]);
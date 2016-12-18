angular.module('leno',[])

 .controller('controllerProduto', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {
 		$scope.produto;

 		$scope.listProdutos = [];
 		$scope.produtos = [];
		var pageProdutos = 0;

 		var serverRouting =  {
			"link" : "http://127.0.0.1/apisisstc/",
			"addProduto"	: "addProduto.php",
			"getProduto"	: "listProduto.php",
			"getAllProduto"	: "listAllProduto.php"
		};
		var switchFloatPoint = function(str){
			return str.replace(",",".");;
		};

 		$scope.addProduto = function(){
 			if($scope.produto.quantidade == "" || $scope.produto.quantidade == undefined ){
	 			$scope.produto.quantidade = -1;
	 		}

	 		$scope.produto.preco  = switchFloatPoint($scope.produto.preco);
			$scope.produto.custo  = switchFloatPoint($scope.produto.custo);
 			$http({
			     url: serverRouting.link+serverRouting.addProduto,
			     method: "GET",
			     params: $scope.produto  
			})
			.success(function(response){
				console.log(response);
				$scope.produto = {};
				$scope.produtos = [];
				$scope.listProdutos = [];
				pageProdutos = 0;
				$scope.getProdutos();
				$scope.getAllProduto();
		        $window.alert(response.menssagem);
		    })
		    .error(function(response){
		    	console.log(response);
		        $window.alert(response.menssagem);
		    });
	 	};

	 	$scope.getProdutos = function(){
			$http({
		     	url: serverRouting.link+serverRouting.getProduto,
		     	method: "GET",
		     	params: { 
					"pagina" : pageProdutos 
				} 
			})
			.success(function(response){
				console.log(response);
				if(response.length == 0){
					$window.alert("A lista de produtos está completa!");
				}else{
					Array.prototype.push.apply($scope.produtos, response);
					pageProdutos++;
					console.log(pageProdutos);
				}
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

	 	$scope.showProduto = function(codigo){
	 		$window.location = "ver_produto_servico.html?codigo="+codigo;
	 	};

	 	$scope.getAllProduto = function(){
			$http({
		     	url: serverRouting.link+serverRouting.getAllProduto,
		     	method: "GET"
			})
			.success(function(response){
				if(response.length == 0){
					$window.alert("A lista de clientes está vazia!");
				}else{
					Array.prototype.push.apply($scope.listProdutos, response);
				}
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};


	 	$scope.showProdutoSelect = function(){
	 		$scope.showProduto(document.getElementById("mySelect").value);
	 	}

	 	$scope.getProdutos();
	 	$scope.getAllProduto();
 	}]);
angular.module('leno',[])

 .controller('controllerVerProduto', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {
 		$scope.produto;
 		$scope.alterar = true;

 		var serverRouting =  {
			"link" : "http://127.0.0.1/apisisstc/",
			"updateProduto"	: "alterarProduto.php",
			"getProduto" 	: "listProduto.php",
			"deleteProduto"	: "desativarProduto.php",
			"addQntProduto"	: "addQuantidadeProduto.php"
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

		var switchFloatPoint = function(str){
			return str.replace(",",".");;
		};



		var codigodebarras = QueryString.codigo;
		var getProduto =  function(){
			$http({
			     url: serverRouting.link+serverRouting.getProduto,
			     method: "GET",
			     params: {"codigodebarras" : codigodebarras} 
			})
			.success(function(response){

				console.log();
				$scope.produto = response[0];
		    })
		    .error(function(response){
		    	console.log(response);
		        $window.alert(response.menssagem);
		    });
		};

		$scope.editar = function(){
			$scope.alterar = false;
		};

		$scope.salvar = function(){
			$scope.alterar = true;
			$scope.produto.preco  = switchFloatPoint($scope.produto.preco);
			$scope.produto.custo  = switchFloatPoint($scope.produto.custo);
			console.log($scope.produto.custo);
 			$http({
		     url: serverRouting.link+serverRouting.updateProduto,
		     method: "GET",
		     params: $scope.produto 
			})
			.success(function(response){
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
			
		};

		$scope.deleteProduto = function(){
			$scope.alterar = true;
			console.log("teste");
 			$http({
		     url: serverRouting.link+serverRouting.deleteProduto,
		     method: "GET",
		     params: {"codigodebarras" : $scope.produto.codigodebarras}
			})
			.success(function(response){
				$window.location = "produtos_servicos.html";
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
			
		};


	 	$scope.adicionarQuantProduto = function(){
	 		var quantidade = document.getElementById('quantidade').value;
	 		console.log(quantidade);
			$http({
		     	url: serverRouting.link+serverRouting.addQntProduto,
		     	method: "GET",
		     	params: {"idproduto" : $scope.produto.Idproduto, "quantidade" : quantidade} 
			})
			.success(function(response){
				$scope.produto.quantidade = parseInt($scope.produto.quantidade) + parseInt(quantidade);
				console.log(response);
				$window.alert(response.menssagem);
		    })
		    .error(function(response){
		        $window.alert(response.menssagem);
		    });
	 	};

		getProduto();
		console.log("teste");
 		
 }]); 
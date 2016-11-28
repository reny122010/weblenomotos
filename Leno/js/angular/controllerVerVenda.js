angular.module('leno',[])
 .controller('controllervervenda', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {

 	var serverRouting =  {
		"link" : "http://127.0.0.1/apisisstc/",
		"cancelarCompra": "cancelarCompra.php",
		"getUsers" 		: "listCliente.php",
		"allVendas" 	: "listallVendas.php",
		"getProdutoCompra"	: "listProdutoCompra.php"
	};

	$scope.venda = {};
	$scope.nome = "Todas as vendas";
	$scope.listMyProdutos = [];

	var getProdutoCompra = function(){
		$http({
	     	url: serverRouting.link+serverRouting.getProdutoCompra,
	     	method: "GET",
	     	params: {
 				"idcompra" 	: idcompra
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

	Array.prototype.removeValue = function(name, value){
	   var array = $.map(this, function(v,i){
	      return v[name] === value ? null : v;
	   });
	   this.length = 0; //clear original array
	   this.push.apply(this, array); //push all elements except the one we want to delete
	}

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
	var idcompra = QueryString.idcompra;

	var getClient =  function(){
		$http({
		     url: serverRouting.link+serverRouting.getUsers,
		     method: "GET",
		     params: {"cpf" : cpf} 
		})
		.success(function(response){
			$scope.nome = response[0].nome +" "+ response[0].sobrenome;
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
	};

 	$scope.vendaCliente = function(cpf){
		$http({
		    url: serverRouting.link+serverRouting.allVendas,
		    method: "GET",
		    params: {"cpf" : cpf }
		})
		.success(function(response){
			console.log(response);
			var i = 0;

			while(response.length != i){
				if(response[i].idcompra == idcompra){
					$scope.venda = response[i];
				}
				i++;
			}
			console.log($scope.venda);
			console.log(idcompra+"  "+response[i]+"  "+response);
			
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
 	};
 	if(cpf != "undefined" && idcompra != "undefined" && cpf != undefined && idcompra != undefined ){
 		$scope.vendaCliente(cpf);
 		getProdutoCompra(idcompra)
 		getClient();
 	}
 }]); 
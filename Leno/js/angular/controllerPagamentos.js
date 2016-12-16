angular.module('leno',[])
 .controller('controllerpagamentos', ['$scope','$http','$location','$window',
 	function ($scope,$http,$location,$window) {

 	var serverRouting =  {
		"link" : "http://127.0.0.1/apisisstc/",
		"cancelarCompra": "cancelarPagamento.php",
		"getUsers" 		: "listCliente.php",
		"allPagamentos" : "listPagamento.php"
	};

	$scope.pagamentos = [];
	$scope.nome = "Todas as vendas";

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

	$scope.cancelarPagamento = function(id){
		$http({
	     	url: serverRouting.link+serverRouting.cancelarCompra,
	     	method: "GET",
	     	params: {"idpagamento" : id} 
		})
		.success(function(response){
			$scope.pagamentos.removeValue('idpagamento', id);
			$window.alert("Pagamento cancelado!");
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
 	};

 	$scope.allPagamentos = function(){
		$http({
		    url: serverRouting.link+serverRouting.allPagamentos,
		    method: "GET" ,
		    params: {"cpf" : cpf }
		})
		.success(function(response){
			$scope.pagamentos = response;
	    })
	    .error(function(response){
	        $window.alert(response.menssagem);
	    });
 	};
 	if(cpf == undefined){
 		$window.alert("Operação inválida!");
 	}
 	$scope.allPagamentos();
 	getClient();
 }]); 
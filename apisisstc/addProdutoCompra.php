<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );

if(!isset($_GET['idcompra']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Compra não informada');
	echo json_encode($arr);
	die();
}

if(!isset($_GET['idproduto']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Produto não informado');
	echo json_encode($arr);
	die();
}

if(!isset($_GET['quantidade']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Quantidade não informada');
	echo json_encode($arr);
	die();
}


$idcompra =$_GET['idcompra'];
$quantidade =$_GET['quantidade'];
$idproduto =$_GET['idproduto'];

$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{

$sql = "SELECT * FROM  tbcompra where idcompra = ".$idcompra;
    $resposta = $conn->query($sql);

    if (($resposta->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Compra Não encontrada');
        echo json_encode($arr);
        die();
    }

 $sql = "SELECT * FROM tbproduto where idproduto = ".$idproduto;
    $resposta = $conn->query($sql);


	if ($resposta->num_rows > 0) {
    	while($row = $resposta->fetch_assoc()) {
        	if (($row["quantidade"] >= $quantidade)or ($row["quantidade"]  == -1))

        	{
        		$valor = $row["preco"]*$quantidade;	
        	}
        	else
        	{
        		$arr = array('retorno' => 1,'menssagem' =>'Quantidade indisponível, temos '.$row["quantidade"] ." desse atuamente no estoque.");
        		echo json_encode($arr);
        		die();
        	}  		
		}
	}
	else
	{
        $arr = array('retorno' => 1,'menssagem' =>'Produto não encontrada');
        echo json_encode($arr);
        die();
    }  


    
 if ( $stmt = $conn->prepare("INSERT INTO tbprodutosparacompra (idcompra,idproduto,quantidade,valor) VALUES (?,?,?,?);")) 
 {
 	$stmt->bind_param("iiid",$idcompra,$idproduto,$quantidade,$valor);


	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao comprar o produto.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0,'menssagem' =>'Produto comprado com sucesso', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();	
	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro ao criar a compra.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

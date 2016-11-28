<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );

if(!isset($_GET['idcompraproduto']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Item não informado');
	echo json_encode($arr);
	die();
}

if(!isset($_GET['idcompra']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Compra não informada');
	echo json_encode($arr);
	die();
}


$idcompraproduto =$_GET['idcompraproduto'];
$idcompra =$_GET['idcompra'];

$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{
    
 if ( $stmt = $conn->prepare("DELETE FROM tbprodutosparacompra WHERE id = ? and idcompra = ?")) 
 {
 	$stmt->bind_param("ii",$idcompraproduto,$idcompra);


	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao remover o item.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0,'menssagem' =>'Produto removido com sucesso');
		echo json_encode($arr);
		die();	
	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro ao remover o item.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

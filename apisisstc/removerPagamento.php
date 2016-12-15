<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );

if(!isset($_GET['idpagamento']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Id pagamento não informado');
	echo json_encode($arr);
	die();
}

$idpagamento =$_GET['idpagamento'];


$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{
    
 if ( $stmt = $conn->prepare("DELETE FROM tbpagamento WHERE id = ? ")) 
 {
 	$stmt->bind_param("i",$idpagamento);


	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao remover o pagamento.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0,'menssagem' =>'Pagamento removido com sucesso');
		echo json_encode($arr);
		die();	
	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro ao remover o pagamento.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

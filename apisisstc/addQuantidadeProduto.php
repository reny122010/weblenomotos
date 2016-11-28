<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );

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
else
{
	if ($_GET['quantidade'] <= 0 )
	{
		$arr = array('retorno' => 1,'menssagem' =>'Quantidade inválida');
		echo json_encode($arr);
		die();	
	}
}

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

$sql = "SELECT * FROM  tbproduto where idproduto = ".$idproduto;
    $resposta = $conn->query($sql);

    if (($resposta->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'produto não encontrado');
        echo json_encode($arr);
        die();
    }


    
 if ( $stmt = $conn->prepare("UPDATE tbproduto SET quantidade = quantidade + ? WHERE idproduto = ?;")) 
 {
 	$stmt->bind_param("ii",$quantidade,$idproduto);


	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao atualizar o estoque.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0,'menssagem' =>'Estoque atualizado', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();	
	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro ao atualizar o estoque.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );
// Create connection




if(!isset($_GET['idcompra']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Compra não informada');
	echo json_encode($arr);
	die();
}


$idcompra =$_GET['idcompra'];

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
 if ( $stmt = $conn->prepare("DELETE FROM tbprodutosparacompra where idcompra = ?;")) 
 {
 	$stmt->bind_param("i",$idcompra);

 
	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao cancelar a compra.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		
		if ( $stmt = $conn->prepare("DELETE FROM tbcompra where idcompra = ?;")) 
		{
			$stmt->bind_param("i",$idcompra);
			$stmt->execute();
			if (!empty($stmt->error)) 
			{
			 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao cancelar a compra.', 'erro'=> $stmt->error);
				echo json_encode($arr);
				die();
			}
			else
			{
				$arr = array('retorno' => 0, 'menssagem' =>'Compra cancelada com sucesso.','idcompra' => $conn->insert_id);
				echo json_encode($arr);	
			}	

		}


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

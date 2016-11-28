<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );

if(!isset($_GET['cpf']))
{
	$arr = array('retorno' => 1,'menssagem' =>'Cpf não informado');
	echo json_encode($arr);
	die();
}

if(!isset($_GET['valor']))
{
	$arr = array('retorno' => 1,'menssagem' =>'valor não informado');
	echo json_encode($arr);
	die();
}


$cpf =$_GET['cpf'];
$valor =$_GET['valor'];

$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{

$sql = "SELECT * FROM  tbcliente where cpf = ".$cpf;
    $resposta = $conn->query($sql);

    if (($resposta->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Cliente não encontrado');
        echo json_encode($arr);
        die();
    }

    
 if ( $stmt = $conn->prepare("INSERT INTO tbpagamento (cpfcliente,valor,data) VALUES (?,?,now());")) 
 {
 	$stmt->bind_param("id",$cpf,$valor);


	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro realizar o pagamento.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0,'menssagem' =>'Pagamento realizado com sucesso', 'erro'=> $stmt->error, 'valorpago'=>$valor);
		echo json_encode($arr);
		die();	
	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro realizar o pagamento.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );
// Create connection

function validaCPF($cpf = null) {
 
    // Verifica se um número foi informado
    if(empty($cpf)) {
        return false;
    }
 
    // Elimina possivel mascara
    $cpf = ereg_replace('[^0-9]', '', $cpf);
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
     
    // Verifica se o numero de digitos informados é igual a 11 
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências invalidas abaixo 
    // foi digitada. Caso afirmativo, retorna falso
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        return false;
     // Calcula os digitos verificadores para verificar se o
     // CPF é válido
     } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
 
        return true;
    }
}


if(!isset($_GET['cpf']))
{
	$arr = array('retorno' => 1,'menssagem' =>'CPF não informado!', 'erro'=> 'not cpf');
	echo json_encode($arr);
	die();
}
else
{
	if (! validaCPF($_GET['cpf']))
	{
		$arr = array('retorno' => 1,'menssagem' =>'CPF inválido!', 'erro'=> 'cpf invalido');
		echo json_encode($arr);
		die();
	}
}

$cpf =$_GET['cpf'];

$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{

    $sql = "SELECT cpf FROM tbcliente WHERE cpf=".$_GET['cpf'];
    $result = $conn->query($sql);

    if (($result->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Cliente não cadastrado.');
        echo json_encode($arr);
        die();
    }

	
$sql = "SELECT * FROM  tbcompra where data is null ";
    $resposta = $conn->query($sql);

    if (!($resposta->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Existe uma compra aberta');
        echo json_encode($arr);
        die();
    }
 if ( $stmt = $conn->prepare("INSERT INTO tbcompra (cpfcliente) VALUES (?)")) 
 {
 	$stmt->bind_param("i",$cpf);

 
	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao criar a compra.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0, 'menssagem' =>'Compra criada com sucesso.','idcompra' => $conn->insert_id);
		echo json_encode($arr);		


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

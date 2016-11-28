<?php
include_once ('setting.php');



header ( "Access-Control-Allow-Origin: *" );

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
        $arr = array('retorno' => 1,'menssagem' =>'Cliente não encontrado');
        echo json_encode($arr);
        die();
    }

   



$sql = "SELECT * FROM  tbcompra where cpfcliente = ".$_GET['cpf']." and data is null";
    $resposta = $conn->query($sql);

if ($resposta->num_rows > 0) {
    // output data of each row
    while($row = $resposta->fetch_assoc()) {
        
    $idcompra = $row["Idcompra"];

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

}

}



 if ( $stmt = $conn->prepare("UPDATE tbcliente SET ativo = 0 WHERE cpf = ?")) 
 {
    $stmt->bind_param("i",$_GET['cpf']);

 
    $stmt->execute();

    if (!empty($stmt->error)) 
    {
        $arr = array('retorno' => 1,'menssagem' =>'Erro ao desativar o cliente.', 'erro'=> $stmt->error);
        echo json_encode($arr);
        die();
    }
    else
    {
        $arr = array('retorno' => 0, 'menssagem' =>'Cliente desativar com sucesso.');
        echo json_encode($arr);     


    }
    $stmt->close();
 }
else
{
    $arr = array('retorno' => 1,'menssagem' =>'Erro ao desativar o cliente.','erro'=>'not $conn->prepare');
    echo json_encode($arr); 
    die();
}


$conn->close();

}
?>

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



class Cliente {
    public $cpf;
    public $nome;
    public $sobrenome;
    public $logradouro;
    public $cidade;   
    public $bairro;
    public $telefone;
    public $limite;
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


if(!isset($_GET['nome']) or empty($_GET['nome']))
{
    $arr = array('retorno' => 1,'menssagem' =>'Nome não informado!','erro'=> 'not nome');
    echo json_encode($arr);
    die();
}

function celular($telefone = null){
  $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

    $regexTelefone = "^[0-9]{11}$";

    $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
    if (preg_match($regexCel, $telefone)) {
        return true;
    }else{
        return false;
    }
}

if(isset($_GET['telefone']) and !empty($_GET['telefone']))
{
    $telefone = $_GET['telefone'];
    if (!celular($telefone))
    {
        $arr = array('retorno' => 1,'menssagem' =>'Telefone inválido!');
        echo json_encode($arr);
        die();  
    }
}

if(!isset($_GET['limite']) or empty($_GET['limite']))
{
    $_GET['limite'] = 0;
}




$Cliente = new Cliente();
$Cliente->cpf =  $_GET['cpf'];
$Cliente->nome = utf8_decode($_GET['nome']);
$Cliente->sobrenome = utf8_decode(@$_GET['sobrenome']);
$Cliente->logradouro = utf8_decode(@$_GET['logradouro']);
$Cliente->cidade = utf8_decode(@$_GET['cidade']);
$Cliente->bairro = utf8_decode(@$_GET['bairro']);
$Cliente->telefone = utf8_decode(@$_GET['telefone']);
$Cliente->limite = @$_GET['limite'];


$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
    echo json_encode($arr); 
}
else
{
    $sql = "SELECT cpf FROM tbcliente WHERE cpf=".$Cliente->cpf;
    $result = $conn->query($sql);

    if (($result->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Cliente não encontrado');
        echo json_encode($arr);
        die();
    }

 if ( $stmt = $conn->prepare("UPDATE tbcliente SET bairro=?,cidade=?,limite = ?,logradouro = ?,nome = ?,sobrenome= ?, telefone = ? WHERE cpf = ?")) 
 {
    $stmt->bind_param("ssdssssi",$Cliente->bairro,$Cliente->cidade,$Cliente->limite,$Cliente->logradouro,$Cliente->nome,$Cliente->sobrenome,$Cliente->telefone,$Cliente->cpf);

 
    $stmt->execute();

    if (!empty($stmt->error)) 
    {
        $arr = array('retorno' => 1,'menssagem' =>'Erro ao alterar o cliente.', 'erro'=> $stmt->error);
        echo json_encode($arr);
        die();
    }
    else
    {
        $arr = array('retorno' => 0, 'menssagem' =>'Cliente alterado com sucesso.');
        echo json_encode($arr);     


    }
    $stmt->close();
 }
else
{
    $arr = array('retorno' => 1,'menssagem' =>'Erro ao alterar o cliente.','erro'=>'not $conn->prepare');
    echo json_encode($arr); 
    die();
}


$conn->close();

}
?>

<?php
include_once ('setting.php');



header ( "Access-Control-Allow-Origin: * " );
// Create connection


class Produto {
    public $codigodebarras;
}


if(!isset($_GET['codigodebarras']))
{
    $arr = array('retorno' => 1,'menssagem' =>'Codigo de barra não informado!', 'erro'=> 'not Codigo de barras');
    echo json_encode($arr);
    die();
}

$Produto = new Produto();
$Produto->codigodebarras = $_GET['codigodebarras'];


$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
    echo json_encode($arr); 
}
else
{
    $sql = "SELECT codigodebarras FROM tbproduto WHERE codigodebarras=".$Produto->codigodebarras;
    $result = $conn->query($sql);

    if (($result->num_rows === 0)) {
        $arr = array('retorno' => 1,'menssagem' =>'Produto não encontrado');
        echo json_encode($arr);
        die();
    }

 if ( $stmt = $conn->prepare("UPDATE tbproduto SET ativo = 0 WHERE codigodebarras = ?")) 
 {
    $stmt->bind_param("i",$Produto->codigodebarras);

 
    $stmt->execute();

    if (!empty($stmt->error)) 
    {
        $arr = array('retorno' => 1,'menssagem' =>'Erro ao desativar o produto.', 'erro'=> $stmt->error);
        echo json_encode($arr);
        die();
    }
    else
    {
        $arr = array('retorno' => 0, 'menssagem' =>'Produto desativar com sucesso.');
        echo json_encode($arr);     


    }
    $stmt->close();
 }
else
{
    $arr = array('retorno' => 1,'menssagem' =>'Erro ao desativar o produto.','erro'=>'not $conn->prepare');
    echo json_encode($arr); 
    die();
}


$conn->close();

}
?>

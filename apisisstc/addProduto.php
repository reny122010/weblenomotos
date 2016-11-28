<?php
include_once ('setting.php');

header ( "Access-Control-Allow-Origin: * " );
// Create connection




class Produto {
    public $codigodebarras;
    public $nome;
    public $preco;
    public $custo;
    public $quantidade;   
    public $unidade;
}


if(!isset($_GET['preco']))
{
    $arr = array('retorno' => 1,'menssagem' =>'Preco não informado!', 'erro'=> 'not preco');
    echo json_encode($arr);
    die();
}

if(!isset($_GET['codigodebarras']))
{
    $arr = array('retorno' => 1,'menssagem' =>'Codigo de barra não informado!', 'erro'=> 'not Codigo de barras');
    echo json_encode($arr);
    die();
}

if(!isset($_GET['nome']))
{
    $arr = array('retorno' => 1,'menssagem' =>'Nome não informado!', 'erro'=> 'not Nome');
    echo json_encode($arr);
    die();
}

$Produto = new Produto();
$Produto->codigodebarras = $_GET['codigodebarras'];
$Produto->nome = utf8_decode($_GET['nome']);
$Produto->preco = $_GET['preco'];
$Produto->custo = @$_GET['custo'];
$Produto->quantidade = @$_GET['quantidade'];
$Produto->unidade = utf8_decode(@$_GET['unidade']);




$conn = new mysqli($server, $user, $pass,$db);

// Check connection
if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
	echo json_encode($arr);	
}
else
{
	$sql = 'SELECT codigodebarras FROM tbproduto WHERE codigodebarras= "'.$Produto->codigodebarras.'"';
	$result = $conn->query($sql);

	if (!($result->num_rows === 0)) {
    	$arr = array('retorno' => 1,'menssagem' =>'Produto já cadastrado.');
		echo json_encode($arr);
		die();
	}


 if ( $stmt = $conn->prepare("INSERT INTO tbproduto (codigodebarras,nome,preco,custo,quantidade,unidade) VALUES (?,?,?,?,?,?)")) 
 {
 	$stmt->bind_param("isddis",$Produto->codigodebarras,$Produto->nome,$Produto->preco,$Produto->custo,$Produto->quantidade,$Produto->unidade);

 
	$stmt->execute();

	if (!empty($stmt->error)) 
	{
	 	$arr = array('retorno' => 1,'menssagem' =>'Erro ao inserir o produto.', 'erro'=> $stmt->error);
		echo json_encode($arr);
		die();
	}
	else
	{
		$arr = array('retorno' => 0, 'menssagem' =>'Produto adicionado com sucesso.');
		echo json_encode($arr);		


	}
	$stmt->close();
 }
else
{
	$arr = array('retorno' => 1,'menssagem' =>'Erro ao inserir o produto.','erro'=>'not $conn->prepare');
	echo json_encode($arr);	
	die();
}


$conn->close();

}
?>

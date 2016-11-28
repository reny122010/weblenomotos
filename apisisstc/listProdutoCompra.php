<?php
include_once ('setting.php');


header ( "Access-Control-Allow-Origin: * " );
// Create connection

function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}


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


if ( $stmt = $conn->prepare("SELECT c.id,p.idproduto, p.codigodebarras, p.nome,  c.quantidade, p.preco, c.valor  from tbprodutosparacompra c inner join tbproduto p on c.idproduto = p.idproduto WHERE c.idcompra = ?")) 
    {
		$myArray = array();
    	$stmt->bind_param("i",$idcompra);

        $stmt->execute();
        $result = $stmt->get_result();     
           while($row = $result->fetch_array(MYSQL_ASSOC)) {

           	 array_push($myArray,$row);
           
          
        }
        $valortotal = 0;

		$sql = "SELECT COALESCE(sum(valor),0)  as valortotal FROM tbprodutosparacompra where idcompra = ".$idcompra;
    	$resposta = $conn->query($sql);
		
    	while($row = $resposta->fetch_assoc()) {
        	
        	
        		$valortotal = $row["valortotal"];
        }	
        	


         $arr = array('retorno' => 0,'menssagem' =>'Produtos listados com sucesso','valortotal'=>$valortotal, 'lista'=>utf8ize($myArray));
    	 echo json_encode($arr); 
        
		$conn->close();

	}
}
?>

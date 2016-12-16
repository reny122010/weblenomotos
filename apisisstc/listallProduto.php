<?php
include_once ('setting.php');

header ( "Access-Control-Allow-Origin: * " );

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





$conn = new mysqli($server, $user, $pass,$db);


if ($conn->connect_error) {
    $arr = array('retorno' => 1,'menssagem' =>'Erro deconexao com o banco de dados.','erro' => $conn->connect_error);
    echo json_encode($arr); 
}
else
{  


$myArray = array();   

$rows= array();
    if ( $stmt = $conn->prepare("SELECT idproduto,codigodebarras, nome FROM tbproduto where ativo = 1 order by codigodebarras") )
    {

        $stmt->execute();
        $result = $stmt->get_result();
       
           while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
         }
        
    
        echo json_encode(utf8ize($myArray));
        
    }
    else
    {
      $arr = array('retorno' => 1,'menssagem' =>'Erro ao consultar os dados.','erro' => $stmt->erro);
      echo json_encode($arr);    
    }


    $stmt->close();
    $conn->close();
}

?>

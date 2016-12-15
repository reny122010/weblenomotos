<?php
include_once ('setting.php');

header ( "Access-Control-Allow-Origin: * " );

$contac  = "";


if(isset($_GET['cpf']))
{
    $contac  =" where cpf = ".$_GET['cpf'];
}

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
    if ( $stmt = $conn->prepare("SELECT id, nome, valor, data FROM tbpagamento INNER JOIN tbcliente on cpfcliente = cpf".$contac)) 
    {
        $stmt->execute();
        $result = $stmt->get_result();
       
         
           while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
    }
  
    echo json_encode(utf8ize($myArray));

        
    }


    $stmt->close();
    $conn->close();
}

?>

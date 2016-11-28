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

$myArray;  

$rows= array();
    if ( $stmt = $conn->prepare("SELECT idcompra, cpfcliente FROM tbcompra where data is null limit 1")) 
    {
        $stmt->execute();

        $result = $stmt->get_result();
       $count= 0;  
           while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray = $row;
            $count = $count + 1;
        }

    if ($count > 0 ){
        

         $arr = array('retorno' => 2,'menssagem' =>'Existe uma compra em aberto','compra'=>utf8ize($myArray));
    echo json_encode($arr); 
    }
    else
    {



        $arr = array('retorno' => 0,'menssagem' =>'Não há compras em aberto.');
    echo json_encode($arr); 
    die();

    }
  
     $stmt->close();

        
    }
    else
    {
      $arr = array('retorno' => 1,'menssagem' =>'Erro ao buscar c');
    echo json_encode($arr); 
    die();   
    }


   
    $conn->close();
}

?>

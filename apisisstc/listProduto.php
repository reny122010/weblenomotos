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

$concat = " WHERE ativo = 1 "; 
if(isset($_GET['codigodebarras']))
{
   $concat .= " and codigodebarras = ".$_GET['codigodebarras']." order by quantidade asc"; 
}
else
{
    if(!isset($_GET['pagina']))
    {
        $concat .= " order by quantidade asc limit 0,10"; 
    }
    else
    {
        $pagina= $_GET['pagina'];
        $limite = (int) $pagina*10;
        $concat .= " order by quantidade asc limit ".$limite.",10";  
    }
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
    if ( $stmt = $conn->prepare("SELECT * FROM tbproduto". $concat)) 
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

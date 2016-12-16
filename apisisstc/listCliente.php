<?php
include_once ('setting.php');

header ( "Access-Control-Allow-Origin: * " );

$concat = " WHERE ativo = 1"; 

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

if(isset($_GET['cpf']))
{
   $concat .= " and cpf = ".$_GET['cpf']." order by nome"; 
}
else
{
    if(!isset($_GET['pagina']))
    {
        $concat .= " order by nomelimit 0,10"; 
    }
    else
    {
        $pagina= $_GET['pagina'];
        $limite = (int) $pagina*10;
        $concat .= " order by nome limit ".$limite.",10";  
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
    if ( $stmt = $conn->prepare("SELECT * FROM tbcliente ". $concat)) 
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

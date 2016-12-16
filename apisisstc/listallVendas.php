<?php
include_once ('setting.php');

header ( "Access-Control-Allow-Origin: * " );

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

if(!isset($_GET['cpf']))
{
   if ( $stmt = $conn->prepare("SELECT compra.cpfcliente,compra.idcompra,compra.data,
    (select sum(quantidade) from tbprodutosparacompra as produtocomprados
    where produtocomprados.idcompra = compra.idcompra) as itens,cliente.nome,compra.valor
    from tbcompra as compra inner join tbcliente as cliente
    on compra.cpfcliente = cliente.cpf where not(compra.data is null) order by compra.data desc;")) 
    {
        $stmt->execute();
        $result = $stmt->get_result();
       
         
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }
  
         echo json_encode(utf8ize($myArray));
    }
}
else
{
    if (!validaCPF($_GET['cpf']))
    {
        $arr = array('retorno' => 1,'menssagem' =>'CPF inválido!', 'erro'=> 'cpf invalido');
        echo json_encode($arr);
        die();
    }else{
        if ( $stmt = $conn->prepare("SELECT compra.cpfcliente,compra.idcompra,compra.data,
        (select sum(quantidade) from tbprodutosparacompra as produtocomprados
        where produtocomprados.idcompra = compra.idcompra ) as itens,cliente.nome,compra.valor
        from tbcompra as compra inner join tbcliente as cliente
        on compra.cpfcliente = cliente.cpf where not(compra.data is null) and cliente.cpf = ?;"))  
        {   
            $stmt->bind_param("i",$_GET['cpf']);
            $stmt->execute();
            $result = $stmt->get_result();
           
             
            while($row = $result->fetch_array(MYSQL_ASSOC)) {
                $myArray[] = $row;
            }
      
             echo json_encode(utf8ize($myArray));
        }
    }
}
    


    $stmt->close();
    $conn->close();
}

?>

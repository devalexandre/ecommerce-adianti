<?php
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

require_once 'init.php';

try{

    $pg = new PPagSeguro('pagseguro',true);
    $pg->setSandbox(true);

    $obj = $pg->getNotificacao();

// implemente aqui

    }catch (Exception $e)
        {
            $e->getMessage();exit;
        }  

?>
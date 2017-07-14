<?php


require_once 'init.php';


 try
        {
            TTransaction::open('sample');
  
  // tratar duplicidade
  
                $custumers = new custumers();
                $custumers->email = $_POST['email'];
                $custumers->password = md5($_POST['password']);
                $custumers->store();

         
            TTransaction::close();
        }
        catch (Exception $e)
        {
           echo $e->getMessage();
        }

?>
<?php


require_once 'init.php';


try
        {
            TTransaction::open('sample');
          
          $criteria = new TCriteria();
          $filter = new TFilter('email','=',$_POST['email']);
          $filter2 = new TFilter('password','=',md5($_POST['password']));
          $criteria->add($filter);
          $criteria->add($filter2);

            $user = custumers::load($criteria);


            if (!$user)
            {
                $custumers = new custumers();
                $custumers->email = $p_POSTaram['email'];
                $custumers->password = md5($_POST['password']);
                $custumers->store();
               
               
            }else{

                  TApplication::gotoPage('Home'); // reload
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
           echo $e->getMessage().' '.$e->getLine();
        }

?>
<?php


require_once 'init.php';

try{


  $cli_id = TSession::getValue('userid'); // cli_id 

  echo $cli_id;

  $filter  = new TFilter('custumers_id','=',$cli_id);
  $criteria = new TCriteria();
  $criteria->setProperty('limit', 1);
  $criteria->setProperty('direction', 'desc');
  $criteria->add($filter);
  $req = requests::getObjects($criteria);

  foreach ($req as $requests) {
    $requests->transation_id = $_REQUEST['transation_id'];
    $requests->store();

  }
  
AdiantiCoreApplication::loadPage('Home','onReload');

    }catch (Exception $e)
        {
            $e->getMessage();exit;
        }

?>

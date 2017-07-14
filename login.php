<?php


require_once 'init.php';
 TSession::setValue('user',NULL);

try
        {

	TTransaction::open('sample');
	$criteria = new TCriteria();
	$filter = new TFilter('email','=',$_REQUEST['email']);
	$filter2 = new TFilter('password','=',md5($_REQUEST['password']));
    $criteria->add($filter);
    $criteria->add($filter2);
	
	$custumers = custumers::getObjects($criteria );


  

	$id = 0 ;
	if($custumers){


        foreach($custumers as $f):
        $id = $f->id;
        endforeach;
   echo $id;
    }


	TTransaction::close();
}
catch (Exception $e)
        {
	echo $e->getMessage();
}

?>
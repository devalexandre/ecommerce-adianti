<?php
/**
 * LoginForm Registration
 * @author  <your name here>
 */
class ClienteLogin extends TPage
{

    /**
     * Authenticate the User
     */
    public function autenticar($param)
    {
        try
        {
            TTransaction::open('sample');
          
          $criteria = new TCriteria();
          $filter = new TFilter('email','=',$param['email']);
          $filter2 = new TFilter('password','=',md5($param['password']));
          $criteria->add($filter);
          $criteria->add($filter2);

            $user = custumers::getObjects($criteria);

            if ($user)
            {
                TSession::regenerate();

                foreach ($user as $key) {
                     TSession::setValue('userid', $key->id);
                }                
              TApplication::gotoPage('Home','destaque'); // reload

            }else{

                  TApplication::gotoPage('Home','login'); // reload
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error',$e->getMessage());
            TSession::setValue('logged', FALSE);
            TTransaction::rollback();
        }
    }
    
        public function cadastrar($param)
    {
        try
        {
            TTransaction::open('sample');
          
          $criteria = new TCriteria();
          $filter = new TFilter('email','=',$param['email']);
          $filter2 = new TFilter('password','=',md5($param['password']));
          $criteria->add($filter);
          $criteria->add($filter2);

            $user = custumers::load($criteria);

            if (!$user)
            {
                $custumers = new custumers();
                $custumers->email = $param['email'];
                $custumers->password = md5($param['password']);
                $custumers->store();

                $this->autenticar($param);
               
            }else{

                  TApplication::gotoPage('Home'); // reload
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
           echo $e->getMessage();
        }
    }

  
}

<?php
/**
 * custumers Active Record
 * @author  Alexandre E Souza 
 * 
 */
class custumers extends TRecord
{
    const TABLENAME = 'custumers';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id');
        parent::addAttribute('name');
        parent::addAttribute('email');
        parent::addAttribute('avatar');
        parent::addAttribute('password');
    }

    
    /**
     * Method getrequestss
     */
    public function getrequestss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('custumers_id', '=', $this->id));
        return requests::getObjects( $criteria );
    }
    
 

}

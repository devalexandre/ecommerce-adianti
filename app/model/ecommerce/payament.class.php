<?php
/**
 * payament Active Record
 * @author  Alexandre E Souza 
 * 
 */
class payament extends TRecord
{
    const TABLENAME = 'payament';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id');
        parent::addAttribute('email');
        parent::addAttribute('token');
    }


}

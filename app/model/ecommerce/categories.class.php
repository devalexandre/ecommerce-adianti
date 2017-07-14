<?php
/**
 * categories Active Record
 * @author  Alexandre E Souza 
 * 
 */
class categories extends TRecord
{
    const TABLENAME = 'categories';
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
        parent::addAttribute('description');
    }

    
    /**
     * Method getproductss
     */
    public function getproductss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categories_id', '=', $this->id));
        return products::getObjects( $criteria );
    }
    


}

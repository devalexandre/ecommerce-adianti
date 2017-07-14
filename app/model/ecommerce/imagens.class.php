<?php
/**
 * imagens Active Record
 * @author  Alexandre E Souza 
 * 
 */
class imagens extends TRecord
{
    const TABLENAME = 'imagens';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $products;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id');
        parent::addAttribute('position');
        parent::addAttribute('src');
        parent::addAttribute('products_id');
    }

    
    /**
     * Method set_products
     * Sample of usage: $imagens->products = $object;
     * @param $object Instance of products
     */
    public function set_products(products $object)
    {
        $this->products = $object;
        $this->products_id = $object->id;
    }
    
    /**
     * Method get_products
     * Sample of usage: $imagens->products->attribute;
     * @returns products instance
     */
    public function get_products()
    {
        // loads the associated object
        if (empty($this->products))
            $this->products = new products($this->products_id);
    
        // returns the associated object
        return $this->products;
    }
    


}

<?php
/**
 * products_requests Active Record
 * @author  Alexandre E Souza 
 * 
 */
class products_requests extends TRecord
{
    const TABLENAME = 'products_requests';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $products;
    private $requests;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('qty');
        parent::addAttribute('products_id');
        parent::addAttribute('requests_id');
    }

    
    /**
     * Method set_products
     * Sample of usage: $products_requests->products = $object;
     * @param $object Instance of products
     */
    public function set_products(products $object)
    {
        $this->products = $object;
        $this->products_id = $object->id;
    }
    
    /**
     * Method get_products
     * Sample of usage: $products_requests->products->attribute;
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
    
    
    /**
     * Method set_requests
     * Sample of usage: $products_requests->requests = $object;
     * @param $object Instance of requests
     */
    public function set_requests(requests $object)
    {
        $this->requests = $object;
        $this->requests_id = $object->id;
    }
    
    /**
     * Method get_requests
     * Sample of usage: $products_requests->requests->attribute;
     * @returns requests instance
     */
    public function get_requests()
    {
        // loads the associated object
        if (empty($this->requests))
            $this->requests = new requests($this->requests_id);
    
        // returns the associated object
        return $this->requests;
    }
    


}

<?php

/**
* requests Active Record
 * @author  Alexandre E Souza
 *
 */
class requests extends TRecord
{
	const TABLENAME = 'requests';
	const PRIMARYKEY= 'id';
	const IDPOLICY =  'max';

	private $custumers;
	private $products = array();
	
	
	/**
	* Constructor method
	     */
	    public function __construct($id = NULL, $callObjectLoad = TRUE)
	    {
		parent::__construct($id, $callObjectLoad);
		parent::addAttribute('id');
		parent::addAttribute('total');
		parent::addAttribute('status');
		parent::addAttribute('custumers_id');
		parent::addAttribute('transaction_id');
	}
	
	
	
	/**
	* Method set_custumers
	     * Sample of usage: $requests->custumers = $object;
	* @param $object Instance of custumers
	     */
	    public function set_custumers(custumers $object)
	    {
		$this->custumers = $object;
		$this->custumers_id = $object->id;
	}
	
	
	/**
	* Method get_custumers
	     * Sample of usage: $requests->custumers->attribute;
	* @returns custumers instance
	     */
	    public function get_custumers()
	    {
		// 		loads the associated object
		        if (empty($this->custumers))
		            $this->custumers = new custumers($this->custumers_id);
		
		// 		returns the associated object
		        return $this->custumers;
	}
	
	
	
	
	/**
	* Method getproducts_requestss
	     */
	    public function getproducts_requestss()
	    {
		$criteria = new TCriteria;
		$criteria->add(new TFilter('requests_id', '=', $this->id));
		return products_requests::getObjects( $criteria );
	}
	
	public function addProducts($products){
		$this->products[] = $products;
		
	}
	

	
}

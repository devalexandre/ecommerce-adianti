<?php
/**
 * products Active Record
 * @author  Alexandre E Souza 
 * 
 */
class products extends TRecord
{
    const TABLENAME = 'products';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    private $categories;
    private $imagem;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('id');
        parent::addAttribute('name');
        parent::addAttribute('description');
        parent::addAttribute('price');
        parent::addAttribute('categories_id');
    }

    
    /**
     * Method set_categories
     * Sample of usage: $products->categories = $object;
     * @param $object Instance of categories
     */
    public function set_categories(categories $object)
    {
        $this->categories = $object;
        $this->categories_id = $object->id;
    }
    
    /**
     * Method get_categories
     * Sample of usage: $products->categories->attribute;
     * @returns categories instance
     */
    public function get_categories()
    {
        // loads the associated object
        if (empty($this->categories))
            $this->categories = new categories($this->categories_id);
    
        // returns the associated object
        return $this->categories;
    }
    

    
    /**
     * Method getimagenss
     */
    public function getimagenss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('products_id', '=', $this->id));
        return imagens::getObjects( $criteria );
    }
    
    
    /**
     * Method getproducts_requestss
     */
    public function getproducts_requestss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('products_id', '=', $this->id));
        return products_requests::getObjects( $criteria );
    }
    
    public function get_imagem(){
    $imagem = '';
    TTransaction::open('sample');
    foreach($this->getimagenss() as $img){
    $imagem = $img->src;
    }
    TTransaction::close();
    return $imagem;
    
    }


}

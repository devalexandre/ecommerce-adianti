<?php
/**
 * productsForm Master/Detail
 * @author  <your name here>
 */
class productsForm extends TPage
{
    protected $form; // form
    protected $table_details;
    protected $detail_row;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct($param);
        
        // creates the form
        $this->form = new TForm('form_products');
        $this->form->class = 'tform'; // CSS class
        
        $table_master = new TTable;
        $table_master->width = '100%';
        
        $table_master->addRowSet( new TLabel('products'), '', '')->class = 'tformtitle';
        
        // add a table inside form
        $table_general = new TTable;
        $table_general->width = '100%';
        
        $frame_general = new TFrame;
        $frame_general->class = 'tframe tframe-custom';
        $frame_general->setLegend('products');
        $frame_general->style = 'background:whiteSmoke';
        $frame_general->add($table_general);
        
        $frame_details = new TFrame;
        $frame_details->class = 'tframe tframe-custom';
        $frame_details->setLegend('imagens');
        
        $table_master->addRow()->addCell( $frame_general )->colspan=2;
        $row = $table_master->addRow();
        $row->addCell( $frame_details );
        
        $this->form->add($table_master);
        
        // master fields
        $id = new TEntry('id');
        $name = new TEntry('name');
        $description = new TText('description');
        $price = new TEntry('price');
        $categories_id = new TEntry('categories_id');

        // sizes
        $id->setSize('100');
        $name->setSize('200');
        $description->setSize('200');
        $price = new TEntry('price');
        $price->setNumericMask(2,',','.',true);
        $categories_id = new TDBCombo('categories_id','sample','categories','id','name','name');

        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        // add form fields to be handled by form
        $this->form->addField($id);
        $this->form->addField($name);   
        $this->form->addField($categories_id);    
        $this->form->addField($price);
        $this->form->addField($description);
        
        // add form fields to the screen
        $table_general->addRowSet( new TLabel('Id'), $id );
        $table_general->addRowSet( new TLabel('Name'), $name );
         $table_general->addRowSet( new TLabel('Categories Id'), $categories_id );
         $table_general->addRowSet( new TLabel('Price'), $price );
        $table_general->addRowSet( new TLabel('Description'), $description );
        
       
        
        // detail
        $this->table_details = new TTable;
        $this->table_details-> width = '100%';
        $frame_details->add($this->table_details);
        
        $this->table_details->addSection('thead');
        $row = $this->table_details->addRow();
        
        // detail header
        $row->addCell( new TLabel('Position') );
        $row->addCell( new TLabel('Src') );
        
        // create an action button (save)
        $save_button=new TButton('save');
        $save_button->setAction(new TAction(array($this, 'onSave')), _t('Save'));
        $save_button->setImage('ico_save.png');

        // create an new button (edit with no parameters)
        $new_button=new TButton('new');
        $new_button->setAction(new TAction(array($this, 'onClear')), _t('New'));
        $new_button->setImage('ico_new.png');
        
        // define form fields
        $this->form->addField($save_button);
        $this->form->addField($new_button);
        
        $table_master->addRowSet( array($save_button, $new_button), '', '')->class = 'tformaction'; // CSS class
        
        $this->detail_row = 0;
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    /**
     * Executed whenever the user clicks at the edit button da datagrid
     */
    function onEdit($param)
    {
        try
        {
            TTransaction::open('sample');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new products($key);
                $this->form->setData($object);
                
                $items  = imagens::where('products_id', '=', $key)->load();
                
                $this->table_details->addSection('tbody');
                if ($items)
                {
                    foreach($items  as $item )
                    {
                        $this->addDetailRow($item);
                    }
                    
                    // create add button
                    $add = new TButton('clone');
                    $add->setLabel('Add');
                    $add->setImage('fa:plus-circle green');
                    $add->addFunction('ttable_clone_previous_row(this)');
                    
                    // add buttons in table
                    $this->table_details->addRowSet([$add]);
                }
                else
                {
                    $this->onClear($param);
                }
                
                TTransaction::close(); // close transaction
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Add detail row
     */
    public function addDetailRow($item)
    {
        $uniqid = mt_rand(1000000, 9999999);
        
        // create fields
        $position = new TEntry('position[]');
        $src = new TFile('src[]');

        // set id's
        $position->setId('position_'.$uniqid);
        $src->setId('src_'.$uniqid);

        // set sizes
        $position->setSize('100');
        $src->setSize('200');
        
        // set row counter
        $position->{'data-row'} = $this->detail_row;
        $src->{'data-row'} = $this->detail_row;

        // set value
        if (!empty($item->position)) { $position->setValue( $item->position ); }
        if (!empty($item->src)) { $src->setValue( $item->src ); }
        
        // create delete button
        $del = new TImage('fa:trash-o red');
        $del->onclick = 'ttable_remove_row(this)';
        
        $row = $this->table_details->addRow();
        // add cells
        $row->addCell($position);
        $row->addCell($src);
        
        $row->addCell( $del );
        $row->{'data-row'} = $this->detail_row;
        
        // add form field
        $this->form->addField($position);
        $this->form->addField($src);
        
        $this->detail_row ++;
    }
    
    /**
     * Clear form
     */
    public function onClear($param)
    {
        $this->table_details->addSection('tbody');
        $this->addDetailRow( new stdClass );
        
        // create add button
        $add = new TButton('clone');
        $add->setLabel('Add');
        $add->setImage('fa:plus-circle green');
        $add->addFunction('ttable_clone_previous_row(this)');
        
        // add buttons in table
        $this->table_details->addRowSet([$add]);
    }
    
    /**
     * Save the products and the imagens's
     */
    public static function onSave($param)
    {
        try
        {
            TTransaction::open('sample');
            
            $id = (int) $param['id'];
            $master = new products;
            $master->fromArray( $param);
            $master->price = str_replace('.','',$master->price );
            $master->price = str_replace(',','.',$master->price );
         
            $master->store(); // save master object
            
            // delete details
            imagens::where('products_id', '=', $master->id)->delete();
            
            if( !empty($param['position']) AND is_array($param['position']) )
            {
                foreach( $param['position'] as $row => $position)
                {
                    if (!empty($position))
                    {
                        $detail = new imagens;
                        $detail->products_id = $master->id;
                        $detail->position = $param['position'][$row];
                        $detail->src = $param['src'][$row];
                        $detail->store();
                    }
                }
            }
            
            $data = new stdClass;
            $data->id = $master->id;
            TForm::sendData('form_products', $data);
            TTransaction::close(); // close the transaction
            
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}

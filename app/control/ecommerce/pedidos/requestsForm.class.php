<?php
/**
 * requestsForm Master/Detail
 * @author  <your name here>
 */
class requestsForm extends TWindow
{
    protected $form; // form
    protected $formFields;
    protected $detail_list;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TForm('form_requests');
        $this->form->class = 'tform'; // CSS class
        $this->form->style = 'max-width:700px'; // style
        parent::include_css('app/resources/custom-frame.css');
        
        $table_master = new TTable;
        $table_master->width = '100%';
        
        $table_master->addRowSet( new TLabel('requests'), '', '')->class = 'tformtitle';
        
        // add a table inside form
        $table_general = new TTable;
        $table_detail  = new TTable;
        $table_general-> width = '100%';
        $table_detail-> width  = '100%';
        
        $frame_general = new TFrame;
        $frame_general->setLegend('requests');
        $frame_general->style = 'background:whiteSmoke';
        $frame_general->add($table_general);
        
        $table_master->addRow()->addCell( $frame_general )->colspan=2;
        $row = $table_master->addRow();
        $row->addCell( $table_detail );
        
        $this->form->add($table_master);
        
        // master fields
        $id = new TEntry('id');
         $id->setEditable(FALSE);
         
        $total = new TEntry('total');
         $total->setEditable(FALSE);
         
        $status = new TEntry('status');
         $status->setEditable(FALSE);
         
        $custumers_id = new TEntry('custumers_id');
         $custumers_id->setEditable(FALSE);
        
    
           
        
        
        // detail fields
        $detail_id = new THidden('detail_id');
        $detail_products_id = new TEntry('detail_products_id');
        $detail_qty = new TEntry('detail_qty');

        /** samples
         $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( 100, 40 ); // set size
         **/
        
        // master
        $table_general->addRowSet( new TLabel('Id'), $id );
        $table_general->addRowSet( new TLabel('Total'), $total );
        $table_general->addRowSet( new TLabel('Status'), $status );
        $table_general->addRowSet( new TLabel('Custumers Id'), $custumers_id );
        
         // detail
        $frame_details = new TFrame();
        $frame_details->setLegend('products_requests');
        $row = $table_detail->addRow();
        $row->addCell($frame_details);
        

        
        $table_details = new TTable;
      $frame_details->add($table_details);
        
        $table_details->addRowSet( '', $detail_id );
        $table_details->addRowSet( new TLabel('Products Id'), $detail_products_id );
        $table_details->addRowSet( new TLabel('Qty'), $detail_qty );
        
        $table_details->addRowSet( $btn_save_detail );
        
        $this->detail_list = new TQuickGrid;
        $this->detail_list->setHeight( 175 );
        $this->detail_list->makeScrollable();
        $this->detail_list->disableDefaultClick();
   
        // items
        $this->detail_list->addQuickColumn('Products Id', 'products_id', 'left', 100);
        $this->detail_list->addQuickColumn('Qty', 'qty', 'left', 100);
        $this->detail_list->createModel();
        
        $row = $table_detail->addRow();
        $row->addCell($this->detail_list);
        

        
        // define form fields
        $this->formFields   = array($id,$total,$status,$custumers_id,$detail_products_id,$detail_qty);
        $this->formFields[] = $detail_id;
        $this->form->setFields( $this->formFields );
        
  
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    
    /**
     * Clear form
     * @param $param URL parameters
     */
    public function onClear($param)
    {
        $this->form->clear(TRUE);
        TSession::setValue(__CLASS__.'_items', array());
        $this->onReload( $param );
    }
    

    
    /**
     * Load an item from session list to detail form
     * @param $param URL parameters
     */
    public function onEditDetail( $param )
    {
        $data = $this->form->getData();
        
        // read session items
        $items = TSession::getValue(__CLASS__.'_items');
        
        // get the session item
        $item = $items[ $param['item_key'] ];
        
        $data->detail_id = $item['id'];
        $data->detail_products_id = $item['products_id'];
        $data->detail_qty = $item['qty'];
        
        // fill detail fields
        $this->form->setData( $data );
    
        $this->onReload( $param );
    }
    
    /**
     * Delete an item from session list
     * @param $param URL parameters
     */
    public function onDeleteDetail( $param )
    {
        $data = $this->form->getData();
        
        // reset items
            $data->detail_products_id = '';
            $data->detail_qty = '';
        
        // clear form data
        $this->form->setData( $data );
        
        // read session items
        $items = TSession::getValue(__CLASS__.'_items');
        
        // delete the item from session
        unset($items[ $param['item_key'] ] );
        TSession::setValue(__CLASS__.'_items', $items);
        
        // reload items
        $this->onReload( $param );
    }
    
    /**
     * Load the items list from session
     * @param $param URL parameters
     */
    public function onReload($param)
    {
        // read session items
        $items = TSession::getValue(__CLASS__.'_items');
        
        $this->detail_list->clear(); // clear detail list
        $data = $this->form->getData();
        
        if ($items)
        {
            $cont = 1;
            foreach ($items as $list_item_key => $list_item)
            {
                $item_name = 'prod_' . $cont++;
                $item = new StdClass;
                
                // create action buttons
                $action_del = new TAction(array($this, 'onDeleteDetail'));
                $action_del->setParameter('item_key', $list_item_key);
                
                $action_edi = new TAction(array($this, 'onEditDetail'));
                $action_edi->setParameter('item_key', $list_item_key);
                
                $button_del = new TButton('delete_detail'.$cont);
                $button_del->class = 'btn btn-default btn-sm';
                $button_del->setAction( $action_del, '' );
                $button_del->setImage('fa:trash-o red fa-lg');
                
                $button_edi = new TButton('edit_detail'.$cont);
                $button_edi->class = 'btn btn-default btn-sm';
                $button_edi->setAction( $action_edi, '' );
                $button_edi->setImage('fa:edit blue fa-lg');
                
                $item->edit   = $button_edi;
                $item->delete = $button_del;
                
                $this->formFields[ $item_name.'_edit' ] = $item->edit;
                $this->formFields[ $item_name.'_delete' ] = $item->delete;
                
                // items
                $item->id = $list_item['id'];
                $item->products_id = $list_item['products_id'];
                $item->qty = $list_item['qty'];
                
                $row = $this->detail_list->addItem( $item );
                $row->onmouseover='';
                $row->onmouseout='';
            }

            $this->form->setFields( $this->formFields );
        }
        
        $this->loaded = TRUE;
    }
    
    /**
     * Load Master/Detail data from database to form/session
     */
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('sample');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new requests($key);
                $items  = products_requests::where('requests_id', '=', $key)->load();
                
                $session_items = array();
                foreach( $items as $item )
                {
                    $item_key = $item->id;
                    $session_items[$item_key] = $item->toArray();
                    $session_items[$item_key]['id'] = $item->id;
                    $session_items[$item_key]['products_id'] = $item->products_id;
                    $session_items[$item_key]['qty'] = $item->qty;
                }
                TSession::setValue(__CLASS__.'_items', $session_items);
                
                $this->form->setData($object); // fill the form with the active record data
                $this->onReload( $param ); // reload items list
                TTransaction::close(); // close transaction
            }
            else
            {
                $this->form->clear(TRUE);
                TSession::setValue(__CLASS__.'_items', null);
                $this->onReload( $param );
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Save the Master/Detail data from form/session to database
     */
    public function onSave()
    {
        try
        {
            // open a transaction with database
            TTransaction::open('sample');
            
            $data = $this->form->getData();
            $master = new requests;
            $master->fromArray( (array) $data);
            $this->form->validate(); // form validation
            
            $master->store(); // save master object
            // delete details
            $old_items = products_requests::where('requests_id', '=', $master->id)->load();
            
            $keep_items = array();
            
            // get session items
            $items = TSession::getValue(__CLASS__.'_items');
            
            if( $items )
            {
                foreach( $items as $item )
                {
                    if (substr($item['id'],0,1) == 'X' ) // new record
                    {
                        $detail = new products_requests;
                    }
                    else
                    {
                        $detail = products_requests::find($item['id']);
                    }
                    $detail->products_id  = $item['products_id'];
                    $detail->qty  = $item['qty'];
                    $detail->requests_id = $master->id;
                    $detail->store();
                    
                    $keep_items[] = $detail->id;
                }
            }
            
            if ($old_items)
            {
                foreach ($old_items as $old_item)
                {
                    if (!in_array( $old_item->id, $keep_items))
                    {
                        $old_item->delete();
                    }
                }
            }
            TTransaction::close(); // close the transaction
            
            // reload form and session items
            $this->onEdit(array('key'=>$master->id));
            
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback();
        }
    }
    
    /**
     * Show the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR $_GET['method'] !== 'onReload') )
        {
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }
}

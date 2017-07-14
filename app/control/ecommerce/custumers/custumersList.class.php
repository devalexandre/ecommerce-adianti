<?php
/**
 * custumersList Listing
 * @author  <your name here>
 */
class custumersList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    protected $transformCallback;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('sample');            // defines the database
        parent::setActiveRecord('custumers');   // defines the active record
        parent::setDefaultOrder('id', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

        parent::addFilterField('name', 'like', 'name'); // filterField, operator, formField
        parent::addFilterField('email', 'like', 'email'); // filterField, operator, formField
        
        // creates the form
        $this->form = new TQuickForm('form_search_custumers');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        $this->form->setFormTitle('custumers');
        

        // create the form fields
        $name = new TEntry('name');
        $email = new TEntry('email');


        // add the fields
        $this->form->addQuickField('Name', $name,  200 );
        $this->form->addQuickField('Email', $email,  200 );

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('custumers_filter_data') );
        
        // add the search form actions
        $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
     
        // creates a DataGrid
        $this->datagrid = new TDataGrid;
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'right');
        $column_name = new TDataGridColumn('name', 'Name', 'left');
        $column_email = new TDataGridColumn('email', 'Email', 'left');
  
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_name);
        $this->datagrid->addColumn($column_email);


  

        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        


        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Title', $this->form));
        $container->add($this->datagrid);
        $container->add($this->pageNavigation);
        
        parent::add($container);
    }
    

}

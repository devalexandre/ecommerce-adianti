<?php
/**
 * categoriesForm Registration
 * @author  Alexandre E. Souza
 */
class categoriesForm extends TWindow
{
    protected $form; // form
    
    use Adianti\Base\AdiantiStandardFormTrait; // Standard form methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('sample');              // defines the database
        $this->setActiveRecord('categories');     // defines the active record
        parent::setSize(800,600);
        
        
        // creates the form
        $this->form = new TQuickForm('form_categories');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormWrapper($this->form);
        $this->form->style = 'display: table;width:100%'; // change style
        
        // define the form title
        $this->form->setFormTitle('Cadastro de Categorias');
        


        // create the form fields
        $id = new TEntry('id');
        $id->setEditable(FALSE);
        $name = new TEntry('name');
        $description = new THtmlEditor('description');


        // add the fields
        $this->form->addQuickField('Id', $id,  100 );
        $this->form->addQuickField('Name', $name,  200 );
        $this->form->addQuickField('Description', $description,  200 );

$description->setSize('100%',200);

         
        // create the form actions
        $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $this->form->addQuickAction(_t('New'),  new TAction(array($this, 'onEdit')), 'bs:plus-sign green');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('Title', $this->form));
        
        parent::add($container);
    }
}

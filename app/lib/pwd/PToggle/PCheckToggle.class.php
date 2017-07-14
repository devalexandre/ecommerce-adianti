<?php


class PCheckToggle extends TField implements AdiantiWidgetInterface
{
    private $indexValue = 0;
    
    /**
     * Define the index value for check button
     * @index Index value
     */
    public function setIndexValue($index)
    {        
        $this->indexValue = $index;
    }
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
    
  			  TPage::include_css('app/lib/pwd/pcomponents.min.css');

         // base64 
         $base = new TElement('label');
         $base->{'class'} = 'switch';
         
         $slimder = new TElement('div');
         $slimder->{'class'} = 'slider round';
         
        
         
        // define the tag properties for the checkbutton
        $this->tag->{'name'}  = $this->name;    // tag name
        $this->tag->{'type'}  = 'checkbox';     // input type
        $this->tag->{'value'} = $this->indexValue;   // value
        $this->tag->{'class'} = '';
        
        // compare current value with indexValue
        if ($this->indexValue == $this->value)
        {
            $this->tag->{'checked'} = '1';
        }
        
        // check whether the widget is non-editable
        if (!parent::getEditable())
        {
            // make the widget read-only
            //$this->tag-> disabled   = "1"; // the value don't post
            $this->tag->{'onclick'} = "return false;";
            $this->tag->{'style'}   = 'pointer-events:none';
        }
        
        $base->add($this->tag);
        $base->add($slimder);
        
        // shows the tag
        $base->show();
    }
    }
    ?>
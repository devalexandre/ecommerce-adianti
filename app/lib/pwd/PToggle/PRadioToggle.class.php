<?php


class PRadioToggle extends TField implements AdiantiWidgetInterface
{
    private $checked;
   
    /**
     * Show the widget at the screen
     */
    public function show()
    {
    
          TPage::include_css('app/lib/pwd/pcomponents.min.css');
  
         // base64 
         $base = new TElement('label');
         $base->{'class'} = 'switch';
         
         $slimder = new TElement('div');
         $slimder->{'class'} = 'slider round';
         
 
        
        // define the tag properties
        $this->tag->{'name'}  = $this->name;
        $this->tag->{'value'} = $this->value;
        $this->tag->{'type'}  = 'radio';
        $this->tag->{'class'} = '';
        
        // verify if the field is not editable
        if (!parent::getEditable())
        {
            // make the widget read-only
            //$this->tag-> disabled   = "1"; // the value don't post
            $this->tag->{'onclick'} = "return false;";
            $this->tag->{'style'}   = 'pointer-events:none';
        }
        // show the tag
            $base->add($this->tag);
        $base->add($slimder);
        
        // shows the tag
        $base->show();
    }
}



<?php
use Adianti\Widget\Form\TSelect;
use Adianti\Widget\Base\TScript;

class BSelectCheck extends TSelect
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->id   = 'bselectcheck_' . mt_rand(1000000000, 1999999999);
    }
    
    public function show()
    {
        // define the tag properties
        $this->tag->{'name'}  = $this->name.'[]';    // tag name
        $this->tag->{'id'}    = $this->id;
        
        $this->setProperty('style', (strstr((string) $this->size, '%') !== FALSE)   ? "width:{$this->size}"    : "width:{$this->size}px",   false); //aggregate style info
        
        if (!empty($this->height))
        {
            $this->setProperty('style', (strstr($this->height, '%') !== FALSE) ? "height:{$this->height}" : "height:{$this->height}px", false); //aggregate style info
        }
        
        // verify whether the widget is editable
        if (parent::getEditable())
        {
            if (isset($this->changeAction))
            {
                if (!TForm::getFormByName($this->formName) instanceof TForm)
                {
                    throw new Exception(AdiantiCoreTranslator::translate('You must pass the ^1 (^2) as a parameter to ^3', __CLASS__, $this->name, 'TForm::setFields()') );
                }
                
                $string_action = $this->changeAction->serialize(FALSE);
                $this->setProperty('changeaction', "__adianti_post_lookup('{$this->formName}', '{$string_action}', '{$this->id}', 'callback')");
                $this->setProperty('onChange', $this->getProperty('changeaction'));
            }
            
            if (isset($this->changeFunction))
            {
                $this->setProperty('changeaction', $this->changeFunction, FALSE);
                $this->setProperty('onChange', $this->changeFunction, FALSE);
            }
        }
        else
        {
            // make the widget read-only
            $this->tag->{'onclick'} = "return false;";
            $this->tag->{'style'}  .= ';pointer-events:none';
            $this->tag->{'class'}   = 'tselect_disabled'; // CSS
        }

        $this->tag->{'role'} = 'bselectcheck';

        // shows the widget
        $this->renderItems( $this->withTitles );
        $this->tag->show();
        
        $search_word = !empty($this->getProperty('placeholder'))? $this->getProperty('placeholder') : AdiantiCoreTranslator::translate('Select');
        
        TScript::create("tselectcheck_start('#{$this->id}', '{$search_word}');");
    }
}

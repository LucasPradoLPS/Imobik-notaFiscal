<?php
/**
  * TLabelIcon
  * @autor Adriano Louzada infobitsolucoes.com
  * @melhorias JLeonel
  */

class TLabelIcon extends TLabel
{
    public function __construct($icon, $text,  $color = NULL, $mess = NULL)
    {
        $text = '<font color = "' . $color . '">' . $text . '</font>';
        $arr_aviso = array('exclamation' => "<i class = 'fa fa-exclamation red' > </i>",
                           'etriangle'   => "<i class = 'fa fa-exclamation-triangle red' > </i>",
                           'ecircle'     => "<i class = 'fa fa-exclamation-circle red' > </i>",
                           'question'    => "<i class = 'fa fa-question green' > </i>",
                           'qcircle'     => "<i class = 'fa fa-question-circle green' > </i>" );
        $text_label = $arr_aviso[$icon] . ' ' . $text;
        parent::__construct($text_label);
        
        if(is_null($mess) )
            parent::setTip('<b>Campo Requerido</b>');
        else
            parent::setTip($mess);
                                   
    } // Fim Construct
    
    public function show()
    {
        parent::show(); 
    } // Fim show
} // Fim Classe
<?php

class VistoriaHistoricoCortinaTimeLine extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriahistorico';
    private static $primaryKey = 'idvistoriahistorico';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null )
    {
        try
        {
            parent::__construct();

            TTransaction::open(self::$database);

            if(!empty($param['target_container']))
            {
                $this->adianti_target_container = $param['target_container'];
            }

            $this->timeline = new TTimeline;
            $this->timeline->setItemDatabase(self::$database);
            $this->timelineCriteria = new TCriteria;

            if(!empty( $param['idvistoria']))
        {
            TSession::setValue(__CLASS__.'load_filter_idvistoria',  $param['idvistoria']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_idvistoria');
            $this->timelineCriteria->add(new TFilter('idvistoria', '=', $filterVar));

            $limit = 0;

            $this->timelineCriteria->setProperty('limit', $limit);
            $this->timelineCriteria->setProperty('order', 'createdat desc');

            $objects = Vistoriahistorico::getObjects($this->timelineCriteria);

            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $object->createdat = call_user_func(function($value, $object, $row) 
                    {
                        if(!empty(trim((string) $value)))
                        {
                            try
                            {
                                $date = new DateTime($value);
                                return $date->format('d/m/Y');
                            }
                            catch (Exception $e)
                            {
                                return $value;
                            }
                        }
                    }, $object->createdat, $object, null);

                    $object->idvistoria = call_user_func(function($value, $object, $row)
                    {
                        //code here
                        return str_pad($value, 6, '0', STR_PAD_LEFT);

                    }, $object->idvistoria, $object, null);

                    $id = $object->idvistoriahistorico;
                    $title = "{titulo} - {createdat}";
                    $htmlTemplate = "Vistoria:  {idvistoria} <hr>
 {historico}";
                    $date = $object->createdat;
                    $icon = 'fa:arrow-left bg-green';
                    $position = 'left';

                    if(empty($positionValue[$object->idvistoriahistorico]))
                    {
                        $lastPosition = (empty($lastPosition) || $lastPosition == 'right') ? 'left' : 'right';
                        $bg = ($lastPosition == 'left') ? 'bg-green' : 'bg-blue';

                        $positionValue[$object->idvistoriahistorico]['position'] = $lastPosition;
                        $positionValue[$object->idvistoriahistorico]['bg'] = $bg;
                        $position = $positionValue[$object->idvistoriahistorico]['position'];
                        $icon = "fa:arrow-{$lastPosition} {$bg}";
                    }
                    else
                    {
                        $position = $positionValue[$object->idvistoriahistorico]['position'];
                        $lastPosition = $position;
                        $icon = "fa:arrow-{$lastPosition} {$positionValue[$object->idvistoriahistorico]['bg']}";
                    }

                    $this->timeline->addItem($id, $title, $htmlTemplate, $date, $icon, $position, $object);

                }
            }

            $this->timeline->setUseBothSides();
            $this->timeline->setTimeDisplayMask('dd/mm/yyyy H:i');
            $this->timeline->setFinalIcon( 'fas:flag-checkered #ffffff #9400D3' );

            $action_VistoriaHistoricoCortinaTimeLine_onCopy = new TAction(['VistoriaHistoricoCortinaTimeLine', 'onCopy'], ['key'=> '{idvistoriahistorico}']);

            $action_VistoriaHistoricoCortinaTimeLine_onCopy->setProperty('btn-class', 'btn btn-primary');
            $this->timeline->addAction($action_VistoriaHistoricoCortinaTimeLine_onCopy, "Cópia do Original", 'fas:copy #FFFFFF','VistoriaHistoricoCortinaTimeLine::onToCopy'); 

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';

            parent::setTargetContainer('adianti_right_panel');
            $container->style .= '; padding: 0 15px';
            $div = new TElement('div');
            $div->style = 'margin-top: 20px; margin-right: 20px; float: right';

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';

            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $div->add($btnClose);
            $container->add($div);
            $container->add($this->timeline);

            $style = new TStyle('right-panel > .container-part[page-name=VistoriaHistoricoCortinaTimeLine]');
            $style->width = '50% !important';   
            $style->show(true);

            TTransaction::close();

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public  static  function onCopy($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $vistoriahistorico = new Vistoriahistorico($param['key']);
            $documento = new Documento($vistoriahistorico->iddocumento);

            $window = TWindow::create('Cópia de Documento  ', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $documento->originalfile;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            // parent::add($object);
            $window->show();            

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onToCopy($object)
    {
        try 
        {
            if($object->iddocumento)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {

    } 

    public static function onGenerate($param)
    {
        // 

    }

}


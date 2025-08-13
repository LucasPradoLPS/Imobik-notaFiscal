<?php

class FaturaeventoTimeLine extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturaevento';
    private static $primaryKey = 'idfaturaevento';

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

            if(!empty( $param['key']))
        {
            TSession::setValue(__CLASS__.'load_filter_idfatura',  $param['key']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_idfatura');
            $this->timelineCriteria->add(new TFilter('idfatura', '=', $filterVar));

            $limit = 0;

            $this->timelineCriteria->setProperty('limit', $limit);
            $this->timelineCriteria->setProperty('order', 'idfaturaevento desc');

            $objects = Faturaevento::getObjects($this->timelineCriteria);

            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $object->dtevento = call_user_func(function($value, $object, $row)
                    {
                        if(!empty(trim((string) $value)))
                        {
                            try
                            {
                                $date = new DateTime($value);
                                return $date->format('d/m/Y H:i');
                            }
                            catch (Exception $e)
                            {
                                return $value;
                            }
                        }
                    }, $object->dtevento, $object, null);

                    $id = $object->idfaturaevento;
                    $title = "{evento}";
                    $htmlTemplate = "Ref.: {idevento} <br />
Tipo:  {event} <br />
Em: {dtevento} <br />
 <b>{eventodescricao}</b> ";
                    $date = $object->dtevento;
                    $icon = 'fa:arrow-left bg-green';
                    $position = 'left';

                    if(empty($positionValue[$object->idfaturaevento]))
                    {
                        $lastPosition = (empty($lastPosition) || $lastPosition == 'right') ? 'left' : 'right';
                        $bg = ($lastPosition == 'left') ? 'bg-green' : 'bg-blue';

                        $positionValue[$object->idfaturaevento]['position'] = $lastPosition;
                        $positionValue[$object->idfaturaevento]['bg'] = $bg;
                        $position = $positionValue[$object->idfaturaevento]['position'];
                        $icon = "fa:arrow-{$lastPosition} {$bg}";
                    }
                    else
                    {
                        $position = $positionValue[$object->idfaturaevento]['position'];
                        $lastPosition = $position;
                        $icon = "fa:arrow-{$lastPosition} {$positionValue[$object->idfaturaevento]['bg']}";
                    }

                    $this->timeline->addItem($id, $title, $htmlTemplate, $date, $icon, $position, $object);

                }
            }

            $this->timeline->setUseBothSides();
            $this->timeline->setTimeDisplayMask('dd/mm/yyyy H:i:s');
            $this->timeline->setFinalIcon( 'fas:flag-checkered #ffffff #de1414' );

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

            $style = new TStyle('right-panel > .container-part[page-name=FaturaeventoTimeLine]');
            $style->width = '75% !important';   
            $style->show(true);

            TTransaction::close();

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {

    } 

}


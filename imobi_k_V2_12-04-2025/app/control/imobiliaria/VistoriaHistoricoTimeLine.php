<?php

class VistoriaHistoricoTimeLine extends TPage
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

            $limit = 50;

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

                    $id = $object->idvistoriahistorico;
                    $title = "{titulo} - {createdat}";
                    $htmlTemplate = " {historico} ";
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

            $container = new TVBox;

            $container->style = 'width: 100%';
            $container->class = 'form-container';
            if(empty($param['target_container']))
            {    
                $container->add(TBreadCrumb::create(["Imobiliária","Histórico de Vistorias"]));
            }
            $container->add($this->timeline);

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

    public static function onGenerate($param)
    {
        // 

    }

}


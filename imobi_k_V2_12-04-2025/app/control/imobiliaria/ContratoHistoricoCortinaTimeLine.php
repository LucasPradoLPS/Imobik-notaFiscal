<?php

class ContratoHistoricoCortinaTimeLine extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Historico';
    private static $primaryKey = 'idhistorico';

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

            if(!empty( $param['idcontrato']))
        {
            TSession::setValue(__CLASS__.'load_filter_idcontrato',  $param['idcontrato']);
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_idcontrato');
            $this->timelineCriteria->add(new TFilter('idcontrato', '=', $filterVar));

            $limit = 0;

            $this->timelineCriteria->setProperty('limit', $limit);
            $this->timelineCriteria->setProperty('order', 'idhistorico desc');

            $objects = Historico::getObjects($this->timelineCriteria);

            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $object->dtalteracao = call_user_func(function($value, $object, $row) 
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
                    }, $object->dtalteracao, $object, null);

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

                    $object->idcontrato = call_user_func(function($value, $object, $row)
                    {
                        //code here
                        return str_pad($value, 6, '0', STR_PAD_LEFT);

                    }, $object->idcontrato, $object, null);

                    $id = $object->idhistorico;
                    $title = "{dtalteracao}";
                    $htmlTemplate = "Contrato: {idcontrato} <br />
Atendente: {fk_idatendente->name} <br />
Histórico: {historico}";
                    $date = $object->dtalteracao;
                    $icon = 'fa:arrow-left bg-green';
                    $position = 'left';

                    if(empty($positionValue[$object->idhistorico]))
                    {
                        $lastPosition = (empty($lastPosition) || $lastPosition == 'right') ? 'left' : 'right';
                        $bg = ($lastPosition == 'left') ? 'bg-green' : 'bg-blue';

                        $positionValue[$object->idhistorico]['position'] = $lastPosition;
                        $positionValue[$object->idhistorico]['bg'] = $bg;
                        $position = $positionValue[$object->idhistorico]['position'];
                        $icon = "fa:arrow-{$lastPosition} {$bg}";
                    }
                    else
                    {
                        $position = $positionValue[$object->idhistorico]['position'];
                        $lastPosition = $position;
                        $icon = "fa:arrow-{$lastPosition} {$positionValue[$object->idhistorico]['bg']}";
                    }

                    $this->timeline->addItem($id, $title, $htmlTemplate, $date, $icon, $position, $object);

                }
            }

            $this->timeline->setUseBothSides();
            $this->timeline->setTimeDisplayMask('dd/mm/yyyy');
            $this->timeline->setFinalIcon( 'fas:flag-checkered #ffffff #9400D3' );

            $action_ContratoAlteracaoForm_onEdit = new TAction(['ContratoAlteracaoForm', 'onEdit'], ['key'=> '{idhistorico}']);
            $action_ContratoAlteracaoForm_onEdit->setParameter('key', '{index}');
            $action_ContratoAlteracaoForm_onEdit->setProperty('btn-class', 'btn btn-default');
            $this->timeline->addAction($action_ContratoAlteracaoForm_onEdit, "Visualizar", 'fas:eye #9400D3','ContratoHistoricoCortinaTimeLine::onToView'); 

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

            $style = new TStyle('right-panel > .container-part[page-name=ContratoHistoricoCortinaTimeLine]');
            $style->width = '70% !important';   
            $style->show(true);

            TTransaction::close();

            parent::add($container);
        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onToView($object)
    {
        try 
        {
            if( $object->tabeladerivada == 'contratoalteracao')
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

}


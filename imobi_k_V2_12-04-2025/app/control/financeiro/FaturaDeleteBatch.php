<?php

class FaturaDeleteBatch extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaDeleteBatch';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Fatura Excluir o Lote");

        $criteria_faturas = new TCriteria();

        $filterVar = TSession::getValue('FaturaListbuilder_datagrid_check');
        $criteria_faturas->add(new TFilter('idfatura', 'in', $filterVar)); 

        $systemuser = new TEntry('systemuser');
        $faturas = new TCheckList('faturas');


        $systemuser->setSize('calc(81% - 120px)');
        $systemuser->setEditable(false);
        $systemuser->setValue(TSession::getValue("username"));
        $faturas->setValue(TSession::getValue('FaturaListbuilder_datagrid_check'));

        $faturas->setIdColumn('idfatura');

        $column_faturas_idfatura_transformed = $faturas->addColumn('idfatura', "Fatura", 'left' , '10%');
        $column_faturas_idcontrato_transformed = $faturas->addColumn('idcontrato', "Contrato", 'left' , '10%');
        $column_faturas_referencia_transformed = $faturas->addColumn('referencia', "Referência", 'left' , '15%');
        $column_faturas_fk_idpessoa_pessoa = $faturas->addColumn('fk_idpessoa->pessoa', "Pessoa", 'left' , '14%');
        $column_faturas_dtvencimento_transformed = $faturas->addColumn('dtvencimento', "Vencimento", 'center' , '10%');
        $column_faturas_es_transformed = $faturas->addColumn('es', "Tipo", 'center' , '10%');
        $column_faturas_valortotal_transformed = $faturas->addColumn('valortotal', "Total", 'right' , '10%');

        $column_faturas_idfatura_transformed->setTransformer(function($value, $object, $row)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_faturas_idcontrato_transformed->setTransformer(function($value, $object, $row)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_faturas_referencia_transformed->setTransformer(function($value, $object, $row)
        {
            //code here
            $conteudo = htmlspecialchars($row);
            // Adicione qualquer formatação HTML desejada
            $conteudo = $value;
            return $conteudo;

        });

        $column_faturas_dtvencimento_transformed->setTransformer(function($value, $object, $row) 
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
        });

        $column_faturas_es_transformed->setTransformer(function($value, $object, $row)
        {
            //code here
            if($value == 'E')
                return 'A Receber';
            if($value == 'S')
                return 'A Pagar';

        });

        $column_faturas_valortotal_transformed->setTransformer(function($value, $object, $row)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }

        });        

        $faturas->setHeight(500);
        $faturas->makeScrollable();

        $faturas->fillWith('imobi_producao', 'Fatura', 'idfatura', 'idfatura asc' , $criteria_faturas);


        $row1 = $this->form->addFields([new TLabel("Responsável pela exclusão:", null, '14px', null),$systemuser]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$faturas]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_ondelete = $this->form->addAction("Excluir Lote", new TAction([$this, 'onDelete']), 'far:trash-alt #FFFFFF');
        $this->btn_ondelete = $btn_ondelete;
        $btn_ondelete->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=FaturaDeleteBatch]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onDelete($param = null) 
    {
        try
        {
            $this->form->validate();

            $data = $this->form->getData();

            if($data->faturas)
            {
                TTransaction::open('imobi_producao');

                foreach ($data->faturas as $fatura_id)
                {
                    $object = new Fatura($fatura_id, FALSE);

                    if ( $object )
                    {
                        $object->idsystemuser = TSession::getValue('userid');
                        $object->store();

                        // Excluir boleto
                        if( $object->es == 'E')
                        {
                            $asaasService = new AsaasService;
                            $asaasService->deleteCobanca($object);
                            Fatura::where('referencia', '=', "{$object->referencia}RM")
                                  ->where('dtpagamento', 'IS', null)
                                  ->delete();
                        } // if( $object->es == 'E')

                        if ( $object->idcontrato )
                        {
                            $historico = new Historico();
                            $historico->idcontrato = $object->idcontrato;
                            $historico->idatendente = TSession::getValue('userid');
                            $historico->tabeladerivada = 'Contas Pag/Rec - Exclusão em lote';
                            $historico->dtalteracao = date("Y-m-d");
                            $historico->historico = "FATURA EXCLUÍDA EM LOTE- " . date("d/m/Y H:i:s") .
                                                    "<br />Código da fatura: " . str_pad($object->idfatura, 6, '0', STR_PAD_LEFT).
                                                    " | Referência: {$object->referencia}".
                                                    "<br />Valor: R$ " . number_format($object->valortotal, 2, ',', '.').
                                                    " | Vencimento: " . TDate::date2br($object->dtvencimento);
                            $historico->store();
                        }                        

                        $object->delete();

                    } // if ( $object)

                } // foreach ($data->faturas as $fatura_id)

                TTransaction::close();
                TSession::setValue('FaturaListbuilder_datagrid_check', null);

                new TMessage('info', 'Contas excluidas com sucesso!', new TAction(['FaturaList', 'onShow']) );
            } // if($data->faturas)
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onShow($param = null)
    {               

    } 

}


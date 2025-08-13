<?php

class FaturaPrintBoletoBatch extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaPrintBoletoBatch';

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
        $this->form->setFormTitle("Impressão em lote de Boletos");

        $criteria_faturas = new TCriteria();

        $filterVar = TSession::getValue('FaturaListbuilder_datagrid_check');
        $criteria_faturas->add(new TFilter('idfatura', 'in', $filterVar)); 
        $filterVar = "E";
        $criteria_faturas->add(new TFilter('es', '=', $filterVar)); 

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


        $row1 = $this->form->addFields([new TLabel("Responsável pela Impressão:", null, '14px', null),$systemuser]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$faturas]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Imprimir o Lote", new TAction([$this, 'onPrint']), 'fas:print #FFFFFF');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=FaturaPrintBoletoBatch]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onPrint($param = null) 
    {
        try
        {
            $this->form->validate();

            $data = $this->form->getData();

            if($data->faturas)
            {
                TTransaction::open('imobi_producao');
                $config = new Config(1);
                $externaltoken = "https://{$config->system}.asaas.com/boleto/downloadListByExternalToken?externalTokens=";

                foreach ($data->faturas as $row => $fatura)
                {
                    $boleto = new Faturafull($fatura);
                    if($boleto) { $externaltoken .= $row > 0 ? ',' . $boleto->externaltoken : $boleto->externaltoken; }
                    //  echo $externaltoken . '<br>';
                } // foreach ($data->faturas as $fatura)

                TScript::create("window.open('$externaltoken', '_blank');");
                TTransaction::close();
                TSession::setValue('FaturaListbuilder_datagrid_check', null);

                new TMessage('info', 'Solicitação encaminhada.', new TAction(['FaturaList', 'onShow']) );

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


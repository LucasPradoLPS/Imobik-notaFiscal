<?php

class FaturaPayBatch extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaPayBatch';

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
        $this->form->setFormTitle("Fatura Quitar o Lote");

        $criteria_faturas = new TCriteria();

        $filterVar = TSession::getValue('FaturaListbuilder_datagrid_check');
        $criteria_faturas->add(new TFilter('idfatura', 'in', $filterVar)); 

        $faturas = new TCheckList('faturas');


        $faturas->setValue(TSession::getValue('FaturaListbuilder_datagrid_check'));

        $faturas->setIdColumn('idfatura');

        $column_faturas_idfatura_transformed = $faturas->addColumn('idfatura', "Fatura", 'left' , '10%');
        $column_faturas_idcontrato_transformed = $faturas->addColumn('idcontrato', "Contrato", 'left' , '10%');
        $column_faturas_referencia = $faturas->addColumn('referencia', "Referência", 'left' , '15%');
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


        $row1 = $this->form->addFields([new TLabel("Forma de Pagamanto:", null, '14px', null, '100%')],[]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([$faturas]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_ondelete = $this->form->addAction("Quitar Lote", new TAction([$this, 'onDelete']), 'fas:cash-register #FFFFFF');
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

        $style = new TStyle('right-panel > .container-part[page-name=FaturaPayBatch]');
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
                    // code...
                    // echo '<pre>' ; print_r($fatura_id);echo '</pre>';
                }

                TTransaction::close();
                TSession::setValue('FaturaListbuilder_datagrid_check', null);

                new TMessage('info', 'Contas excluidas com sucesso!', new TAction(['FaturaList', 'onShow']) );

            }

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


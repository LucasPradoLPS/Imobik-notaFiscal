<?php

class VistoriaResetForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoria';
    private static $primaryKey = 'idvistoria';
    private static $formName = 'form_VistoriaResetForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Reset de Vistoria");


        $endereco = new TEntry('endereco');
        $idvistoria = new THidden('idvistoria');
        $resets = new TCheckGroup('resets');


        $endereco->setEditable(false);
        $resets->addItems(["1"=>"Contestação","2"=>"Inconformidade","3"=>"Ambiente/Item (+ Laudo fotográfico)","4"=>"Fotos do Laudo (+ Legendas)","5"=>"Legenda das Fotos","6"=>"Tipo de Vistoria (Entrada)","7"=>"Status da Vistoria (Solicitada)","8"=>"Contrato"]);
        $resets->setLayout('horizontal');
        $resets->setBreakItems(1);
        $resets->setSize('100%');
        $idvistoria->setSize(200);
        $endereco->setSize('100%');

        if( isset($param['key']))
            $lbl_idvistoria = str_pad($param['key'], 6, '0', STR_PAD_LEFT);
        else
            $lbl_idvistoria = '';        
        $row1 = $this->form->addFields([new TLabel(new TImage('fas:undo-alt #F44336')."Vistoria #{$lbl_idvistoria} - Selecione os Itens a Redefinir:", '#9400D3', '21px', 'B', '100%'),$endereco,$idvistoria]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([$resets]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onreset = $this->form->addAction("Resetar", new TAction([$this, 'onReset']), 'fas:undo-alt #FFFFFF');
        $this->btn_onreset = $btn_onreset;
        $btn_onreset->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onReset($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $data = $this->form->getData(); // get form data as array

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            if(isset($param['resets']))
            {
                $detalhes = Vistoriadetalhe::where('idvistoria', '=', $param['idvistoria']) ->load();
                $historico = "Vistoria Redefinida: <ul>";

                foreach ($param['resets'] as $reset)
                {
                    if($reset == 1)
                    {
                        $historico .= '<li>Contestação</li>';
                        foreach($detalhes AS $detalhe)
                        {
                            $detalhe->dtcontestacao = null;
                            $detalhe->contestacaoargumento = null;
                            $detalhe->contestacaoresposta = null;
                            if($detalhe->contestacaoimg)
                            {
                                unlink($detalhe->contestacaoimg);
                                $detalhe->contestacaoimg = null;
                            } // if($detalhe->contestacaoimg)
                            $detalhe->store();
                        } // foreach($detalhes AS $detalhe)
                    } // if($reset == 1)

                    if($reset == 2)
                    {
                        $historico .= '<li>Inconformidade</li>';
                        foreach($detalhes AS $detalhe)
                        {
                            $detalhe->dtinconformidade = null;
                            $detalhe->inconformidade = null;
                            $detalhe->inconformidadevalor = null;
                            if($detalhe->inconformidadeimg)
                            {
                                unlink($detalhe->inconformidadeimg);
                                $detalhe->inconformidadeimg = null;
                            } // if($detalhe->contestacaoimg)
                            $detalhe->store();
                        } // foreach($detalhes AS $detalhe)
                    } // if($reset == 2)

                    if($reset == 3)
                    {
                        $historico .= '<li>Ambiente/Item</li>';
                        $vistoriadetalheimgs = Vistoriadetalheimg::where('idvistoria', '=', $param['idvistoria']) ->load();
                        foreach($vistoriadetalheimgs AS $vistoriadetalheimg)
                        {
                            unlink($vistoriadetalheimg->vistoriadetalheimg);
                            $vistoriadetalheimg->delete();
                        } // foreach($detalhes AS $detalhe)
                        Vistoriadetalhe::where('idvistoria', '=', $param['idvistoria'])->delete();
                    } // if($reset == 3)

                    if($reset == 4)
                    {
                        $historico .= '<li>Fotos do Laudo</li>';
                        $vistoriadetalheimgs = Vistoriadetalheimg::where('idvistoria', '=', $param['idvistoria']) ->load();
                        foreach($vistoriadetalheimgs AS $vistoriadetalheimg)
                        {
                            unlink($vistoriadetalheimg->vistoriadetalheimg);
                            $vistoriadetalheimg->delete();
                        } // foreach($detalhes AS $detalhe)
                    } // if($reset == 4)

                    if($reset == 5)
                    {
                        $historico .= '<li>Legendas das Fotos</li>';
                        $vistoriadetalheimgs = Vistoriadetalheimg::where('idvistoria', '=', $param['idvistoria']) ->load();
                        foreach($vistoriadetalheimgs AS $vistoriadetalheimg)
                        {
                            $vistoriadetalheimg->legrenda = null;
                            $vistoriadetalheimg->store();
                        }
                    } // if($reset == 5)

                    if($reset == 6)
                    {
                        $historico .= '<li>Tipo de Vistoria</li>';
                        Vistoria::where('idvistoria', '=', $param['idvistoria']) ->set('idvistoriatipo', 1) ->update();
                    } // if($reset == 6)

                    if($reset == 7)
                    {
                        $historico .= '<li>Status de Vistoria</li>';
                        Vistoria::where('idvistoria', '=', $param['idvistoria']) ->set('idvistoriastatus', 9) ->update();
                    } // if($reset == 7)

                    if($reset == 8)
                    {
                        $historico .= '<li>Contrato</li>';
                        Vistoria::where('idvistoria', '=', $param['idvistoria']) ->set('idcontrato', null) ->update();
                    } // if($reset == 8)

                } //foreach ($param['resets'] as $reset)

                $vistoriahistorico = new Vistoriahistorico();
                $vistoriahistorico->idvistoria   = $param['idvistoria'];
                $vistoriahistorico->idsystemuser = TSession::getValue('userid');
                $vistoriahistorico->titulo       = 'Reset';
                $vistoriahistorico->historico    = "{$historico}</ul> Executada por {$vistoriahistorico->fk_idsystemuser->name} em " . date("d/m/Y H:i");
                $vistoriahistorico->store();

                // exit();

                TToast::show("success", "Os Itens selecionados foram redefinidos.", "topRight", "fas:undo-alt");
            }
            else
            TToast::show("error", "Não houveram itens a serem Redefinidos.", "topRight", "fas:times");

            TScript::create("Template.closeRightPanel();");
            AdiantiCoreApplication::loadPage('VistoriaList', 'onShow');

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Vistoria($key); // instantiates the Active Record 
                $imovelfull = new Imovelfull($object->idimovel);
                $object->endereco = "Imóvel: #{$imovelfull->idimovelchar} - End. {$imovelfull->endereco}";

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


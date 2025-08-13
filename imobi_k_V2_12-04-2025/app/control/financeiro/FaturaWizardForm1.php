<?php

class FaturaWizardForm1 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaWizardForm1';

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
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 1");

        $criteria_idpessoa = new TCriteria();

        $pageStep_66b514c3be866 = new TPageStep();
        $idcontrato = new TSeekButton('idcontrato');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $melhordia = new TEntry('melhordia');
        $button_editar_contrato = new TButton('button_editar_contrato');
        $aluguelgarantido = new TEntry('aluguelgarantido');
        $aluguel = new TNumeric('aluguel', '2', ',', '.' );
        $comissaocalculada = new TNumeric('comissaocalculada', '2', ',', '.' );
        $repasse = new TNumeric('repasse', '2', ',', '.' );
        $imovel = new TEntry('imovel');
        $inquilino = new TEntry('inquilino');
        $locador = new TEntry('locador');
        $idimovel = new THidden('idimovel');
        $juros = new THidden('juros');
        $multa = new THidden('multa');
        $multafixa = new THidden('multafixa');
        $comissaofixa = new THidden('comissaofixa');
        $comissao = new THidden('comissao');
        $video = new TElement('iframe');
        $idpessoa = new TDBUniqueSearch('idpessoa', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoa','pessoalead asc' , $criteria_idpessoa );
        $button_ = new TButton('button_');

        $idpessoa->setChangeAction(new TAction([$this,'onChangeIdPessoa']));

        $idcontrato->setExitAction(new TAction([$this,'onChangeContrato']));

        $aluguel->setAllowNegative(false);
        $idpessoa->setMinLength(0);
        $button_->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button_editar_contrato->setAction(new TAction([$this, 'onContratoEdit']), "Editar Contrato");

        $button_->addStyleClass('btn-default');
        $button_editar_contrato->addStyleClass('btn-default');

        $button_->setImage('fas:plus-circle #2ECC71');
        $button_editar_contrato->setImage('fas:file-signature #2ECC71');

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');

        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $idpessoa->setMask('{idpessoa} - {pessoalead}');

        $dtfim->setEditable(false);
        $imovel->setEditable(false);
        $aluguel->setEditable(false);
        $repasse->setEditable(false);
        $locador->setEditable(false);
        $dtinicio->setEditable(false);
        $melhordia->setEditable(false);
        $inquilino->setEditable(false);
        $dtcelebracao->setEditable(false);
        $aluguelgarantido->setEditable(false);
        $comissaocalculada->setEditable(false);

        $juros->setSize(200);
        $multa->setSize(200);
        $dtfim->setSize('100%');
        $idimovel->setSize(200);
        $comissao->setSize(200);
        $imovel->setSize('100%');
        $multafixa->setSize(200);
        $aluguel->setSize('100%');
        $repasse->setSize('100%');
        $locador->setSize('100%');
        $dtinicio->setSize('100%');
        $melhordia->setSize('100%');
        $inquilino->setSize('100%');
        $comissaofixa->setSize(200);
        $idcontrato->setSize('100%');
        $dtcelebracao->setSize('100%');
        $aluguelgarantido->setSize('100%');
        $comissaocalculada->setSize('100%');
        $idpessoa->setSize('calc(100% - 50px)');

        $video->width = '100%';
        $video->height = '470px';
        $video->src = "https://www.youtube.com/embed/fpquRxCoZLk?si=Do3gelQAg5tgAn0j";

        $pageStep_66b514c3be866->addItem("Contrato/Avulsa");
        $pageStep_66b514c3be866->addItem("Fatura");
        $pageStep_66b514c3be866->addItem("Taxas");
        $pageStep_66b514c3be866->addItem("Instruções");
        $pageStep_66b514c3be866->addItem("Discriminação");
        $pageStep_66b514c3be866->addItem("Conferir/Processar");

        $pageStep_66b514c3be866->select("Contrato/Avulsa");

        $this->pageStep_66b514c3be866 = $pageStep_66b514c3be866;
        $this->video = $video;

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $idcontrato_seekAction = new TAction(['WizardBuscaContrato', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'idcontrato', 'column'=>'{idcontrato}'],
            ['name'=> 'dtcelebracao', 'column'=>'{idcontrato}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $idcontrato_seekAction->setParameter('_seek_fields', $seekFields);
        $idcontrato_seekAction->setParameter('_seek_filters', $seekFilters);
        $idcontrato_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $idcontrato->setAction($idcontrato_seekAction);

        $row1 = $this->form->addFields([$pageStep_66b514c3be866]);
        $row1->layout = [' col-sm-12'];

        $tab_65d65a9d2638a = new BootstrapFormBuilder('tab_65d65a9d2638a');
        $this->tab_65d65a9d2638a = $tab_65d65a9d2638a;
        $tab_65d65a9d2638a->setProperty('style', 'border:none; box-shadow:none;');

        $tab_65d65a9d2638a->appendPage("Faturar Pelo Contrato");

        $tab_65d65a9d2638a->addFields([new THidden('current_tab_tab_65d65a9d2638a')]);
        $tab_65d65a9d2638a->setTabFunction("$('[name=current_tab_tab_65d65a9d2638a]').val($(this).attr('data-current_page'));");

        $row2 = $tab_65d65a9d2638a->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Data Celebração:", null, '14px', null),$dtcelebracao],[new TLabel("Data Inicio:", null, '14px', null),$dtinicio],[new TLabel("Data Fim:", null, '14px', null, '100%'),$dtfim],[new TLabel("Melhor Dia:", null, '14px', null),$melhordia],[new TLabel(" ", null, '14px', null, '100%'),$button_editar_contrato]);
        $row2->layout = [' col-sm-2','col-sm-2','col-sm-2','col-sm-2',' col-sm-2','col-sm-2'];

        $bcontainer_66b3d47d34032 = new BContainer('bcontainer_66b3d47d34032');
        $this->bcontainer_66b3d47d34032 = $bcontainer_66b3d47d34032;

        $bcontainer_66b3d47d34032->setTitle("Valores Contratuais do Aluguel", '#333', '18px', '', '#fff');
        $bcontainer_66b3d47d34032->setBorderColor('#c0c0c0');

        $row3 = $bcontainer_66b3d47d34032->addFields([new TLabel("Aluguel Garantido:", null, '14px', null),$aluguelgarantido],[new TLabel("Aluguel (R$):", null, '14px', null, '100%'),$aluguel]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $bcontainer_66b3d47d34032->addFields([new TLabel("Taxa Administrativa:", null, '14px', null, '100%'),$comissaocalculada],[new TLabel("Repasse:", null, '14px', null, '100%'),$repasse]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $bcontainer_66b3e10534043 = new BContainer('bcontainer_66b3e10534043');
        $this->bcontainer_66b3e10534043 = $bcontainer_66b3e10534043;

        $bcontainer_66b3e10534043->setTitle("Partes", '#333', '18px', '', '#fff');
        $bcontainer_66b3e10534043->setBorderColor('#c0c0c0');

        $row5 = $bcontainer_66b3e10534043->addFields([new TLabel("Imóvel:", null, '14px', null, '100%'),$imovel]);
        $row5->layout = [' col-sm-12'];

        $row6 = $bcontainer_66b3e10534043->addFields([new TLabel("<strong>Sacado</strong> <small>(Inquilino / Locatário)</small>", null, '14px', null),$inquilino],[new TLabel("Locador(es):", null, '14px', null),$locador]);
        $row6->layout = [' col-sm-6','col-sm-6'];

        $row7 = $tab_65d65a9d2638a->addFields([$bcontainer_66b3d47d34032],[$bcontainer_66b3e10534043]);
        $row7->layout = ['col-sm-6',' col-sm-6'];

        $row8 = $tab_65d65a9d2638a->addFields([$idimovel],[$juros],[$multa],[$multafixa],[$comissaofixa],[$comissao]);
        $row8->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        $tab_65d65a9d2638a->appendPage("<i class=\"fab fa-youtube\" style=\"color: #FF0000;\"></i> Tutorial Como Fazer");
        $row9 = $tab_65d65a9d2638a->addFields([],[$video],[]);
        $row9->layout = [' col-sm-2',' col-sm-8',' col-sm-2'];

        $tab_65d65a9d2638a->appendPage("Fatura Avulsa Por Pessoa");
        $row10 = $tab_65d65a9d2638a->addFields([new TLabel("Pessoa (Sacado): <font size=\"-3\"><i><u>não pode ser lead</u></i></font>", null, '14px', null, '100%'),$idpessoa,$button_]);
        $row10->layout = ['col-sm-12'];

        $row11 = $this->form->addFields([$tab_65d65a9d2638a]);
        $row11->layout = [' col-sm-12'];

        // create the form actions
        $btn_onadvance = $this->form->addAction("Avançar", new TAction([$this, 'onAdvance']), 'fas:hand-point-right #FFFFFF');
        $this->btn_onadvance = $btn_onadvance;
        $btn_onadvance->addStyleClass('full_width'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 1"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChangeContrato($param = null) 
    {
        try 
        {
            //code here
            if(isset($param['idcontrato']) )
            {
                // Código gerado pelo snippet: "Enviar dados para campo"
                $object = new stdClass();
                $object->idpessoa = null;
                TForm::sendData(self::$formName, $object);

                TDBUniqueSearch::disableField(self::$formName, 'idpessoa');
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onChangeIdPessoa($param = null) 
    {
        try 
        {
            //code here
            if($param['idpessoa'] > 0 )
            {
                TTransaction::open('imobi_producao'); // open a transaction
                $pessoa = new Pessoa($param['idpessoa'], false);
                TTransaction::close();
                if($pessoa)
                {
                    if($pessoa && !$pessoa->cnpjcpf)
                        throw new Exception("{$pessoa->pessoa} é um lead. Não é possível emitir faturas para Leads!"); 
                }
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
            $object = new stdClass();
            $object->idpessoa = null;
            TForm::sendData(self::$formName, $object);

        }
    }

    public static function onContratoEdit($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            if(!$param['idcontrato'])
            {
                throw new Exception('Contrato Não Informado!');
            }

            AdiantiCoreApplication::loadPage( 'ContratoForm', 'onEdit', ['key' => $param['idcontrato'], 'idcontrato' => $param['idcontrato'], 'adianti_open_tab' => '1', 'adianti_tab_name' => 'Contratos']);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onAdvance($param = null) 
    {
        try 
        {
            //code here
            sleep(2);

            if( !$param['idcontrato'] && !$param['idpessoa'])
            {
               throw new Exception('É requerido um Contrato ou uma Pessoa (Sacado)!');
            }

            TSession::setValue('wizard_contrato_1', (array) $param);

            AdiantiCoreApplication::loadPage('FaturaWizardForm2', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        TSession::setValue('wizard_contrato_1', null);
        TSession::setValue('wizard_fatura_2', null);
        TSession::setValue('wizard_taxas_3', null);
        TSession::setValue('wizard_instrucoes_4', null);
        TSession::setValue('wizard_discriminacao_5', null);

        if(TSession::getValue('faturar_contrato_idcontrato'))
        {
            TTransaction::open('imobi_producao');
            $object = Contratofull::find(TSession::getValue('faturar_contrato_idcontrato'));
            TTransaction::close();

            if (empty($object))
            {
                throw new Exception('Contrato não encontrado!');
            }
            else
            {
                if($object->comissaofixa)
                {
                    $comissaocalculada = $object->comissao;
                }
                else 
                {
                    $comissaocalculada = $object->aluguel * $object->comissao / 100;
                }
                $repasse = $object->aluguel - $comissaocalculada;
                $send = new StdClass;
                $send->idcontrato        = $object->idcontratochar;
                $send->idimovel          = $object->idimovel;
                $send->dtcelebracao      = TDate::date2br($object->dtcelebracao);
                $send->dtinicio          = TDate::date2br($object->dtinicio);
                $send->dtfim             = TDate::date2br($object->dtfim);
                $send->imovel            = $object->imovel . ', ' . $object->bairro . ', ' . $object->cidadeuf . ', ' . Uteis::mask($object->cep,'##.###-###');
                $send->aluguel           = number_format($object->aluguel, 2, ',', '.');
                $send->comissao          = $object->comissao;
                $send->comissaocalculada =  number_format($comissaocalculada, 2, ',', '.');
                $send->comissaofixa      = $object->comissaofixa;
                $send->repasse           = number_format($repasse, 2, ',', '.');
                $send->juros             = number_format($object->jurosmora, 2, ',', '.');
                $send->multa             = number_format($object->multamora, 2, ',', '.');
                $send->multafixa         = $object->multafixa;
                $send->taxa              = $object->comissaofixa == true ? 'R$ ' . number_format($object->comissao, 2, ',', '.') : number_format($object->comissao, 2, ',', '.') . '%';
                $send->locador           = $object->locador;
                $send->inquilino         = $object->inquilino;
                $send->melhordia         = $object->melhordia;
                $send->aluguelgarantido  = $object->aluguelgarantido == 'N' ? 'Não' : 'Sim';
                TForm::sendData(self::$formName, $send);
                TSession::setValue('faturar_contrato_idcontrato', null);
            }
        } // if(TSession::getValue('faturar_contrato_idcontrato'))

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->idcontrato))
            {
                $value = $object->idcontrato;

                $obj->idcontrato = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->idcontrato))
            {
                $value = $object->idcontrato;

                $obj->idcontrato = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

}


<?php

class PessoaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'idpessoa';
    private static $formName = 'form_PessoaForm';

    use Adianti\Base\AdiantiFileSaveTrait;
    use BuilderMasterDetailFieldListTrait;

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
        $this->form->setFormTitle("Pessoa");

        $criteria_idcidade = new TCriteria();
        $criteria_pessoadetalheitem_fk_idpessoa_idpessoadetalhe = new TCriteria();
        $criteria_bancopixtipoid = new TCriteria();
        $criteria_bancoid = new TCriteria();
        $criteria_bancocontatipoid = new TCriteria();
        $criteria_frontpage_id = new TCriteria();
        $criteria_usergroup = new TCriteria();

        $filterVar = TSession::getValue("usergroupids");
        $criteria_usergroup->add(new TFilter('id', 'in', $filterVar)); 
        $filterVar = "1";
        $criteria_usergroup->add(new TFilter('id', '>', $filterVar)); 

        $idpessoa = new TEntry('idpessoa');
        $asaasid = new THidden('asaasid');
        $pessoa = new TEntry('pessoa');
        $cnpjcpf = new TEntry('cnpjcpf');
        $button_busca_cnpj = new TButton('button_busca_cnpj');
        $politico = new TCombo('politico');
        $button_nao_sei_o_cep = new TButton('button_nao_sei_o_cep');
        $cep = new TEntry('cep');
        $button_autopreencher_com_cep = new TButton('button_autopreencher_com_cep');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'cidadeuf','idcidade asc' , $criteria_idcidade );
        $button_ = new TButton('button_');
        $selfie = new TImageCropper('selfie');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalheitem = new THidden('pessoadetalheitem_fk_idpessoa_idpessoadetalheitem[]');
        $pessoadetalheitem_fk_idpessoa___row__id = new THidden('pessoadetalheitem_fk_idpessoa___row__id[]');
        $pessoadetalheitem_fk_idpessoa___row__data = new THidden('pessoadetalheitem_fk_idpessoa___row__data[]');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe = new TDBCombo('pessoadetalheitem_fk_idpessoa_idpessoadetalhe[]', 'imobi_producao', 'Pessoadetalhe', 'idpessoadetalhe', '{pessoadetalhe}','pessoadetalhe asc' , $criteria_pessoadetalheitem_fk_idpessoa_idpessoadetalhe );
        $pessoadetalheitem_fk_idpessoa_pessoadetalheitem = new TEntry('pessoadetalheitem_fk_idpessoa_pessoadetalheitem[]');
        $this->pessoaitem = new TFieldList();
        $bancochavepix = new TEntry('bancochavepix');
        $bancopixtipoid = new TDBUniqueSearch('bancopixtipoid', 'imobi_producao', 'Bancopixtipo', 'idbancopixtipo', 'bancopixtipo','bancopixtipo asc' , $criteria_bancopixtipoid );
        $button_1 = new TButton('button_1');
        $bancoid = new TDBUniqueSearch('bancoid', 'imobi_producao', 'Banco', 'idbanco', 'banco','banco asc' , $criteria_bancoid );
        $button_2 = new TButton('button_2');
        $bancoagencia = new TEntry('bancoagencia');
        $bancoagenciadv = new TEntry('bancoagenciadv');
        $bancoconta = new TEntry('bancoconta');
        $bancocontadv = new TEntry('bancocontadv');
        $bancocontatipoid = new TDBUniqueSearch('bancocontatipoid', 'imobi_producao', 'Bancotipoconta', 'idbancotipoconta', 'bancotipoconta','bancotipoconta asc' , $criteria_bancocontatipoid );
        $button_3 = new TButton('button_3');
        $walletid = new TEntry('walletid');
        $button_informacoes_do_cliente = new TButton('button_informacoes_do_cliente');
        $systemuseractive = new TCombo('systemuseractive');
        $frontpage_id = new TDBUniqueSearch('frontpage_id', 'imobi_system', 'SystemProgram', 'id', 'name','name asc' , $criteria_frontpage_id );
        $usergroup = new TDBMultiSearch('usergroup', 'imobi_system', 'SystemGroup', 'id', 'name','name asc' , $criteria_usergroup );
        $button_reset_de_senha = new TButton('button_reset_de_senha');
        $systemuserid = new THidden('systemuserid');

        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa_idpessoadetalheitem, []);
        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa___row__id, ['uniqid' => true]);
        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa___row__data, []);
        $this->pessoaitem->addField(new TLabel("Item", null, '14px', null), $pessoadetalheitem_fk_idpessoa_idpessoadetalhe, ['width' => '50%']);
        $this->pessoaitem->addField(new TLabel("Descrição", null, '14px', null), $pessoadetalheitem_fk_idpessoa_pessoadetalheitem, ['width' => '50%']);

        $this->pessoaitem->width = '100%';
        $this->pessoaitem->setFieldPrefix('pessoadetalheitem_fk_idpessoa');
        $this->pessoaitem->name = 'pessoaitem';

        $this->criteria_pessoaitem = new TCriteria();
        $this->default_item_pessoaitem = new stdClass();

        $this->form->addField($pessoadetalheitem_fk_idpessoa_idpessoadetalheitem);
        $this->form->addField($pessoadetalheitem_fk_idpessoa___row__id);
        $this->form->addField($pessoadetalheitem_fk_idpessoa___row__data);
        $this->form->addField($pessoadetalheitem_fk_idpessoa_idpessoadetalhe);
        $this->form->addField($pessoadetalheitem_fk_idpessoa_pessoadetalheitem);

        $this->pessoaitem->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $cnpjcpf->setExitAction(new TAction([$this,'onExitCNPJCPF']));

        $pessoa->addValidation("Nome", new TRequiredValidator()); 
        $idcidade->addValidation("Cidade", new TRequiredValidator()); 

        $idpessoa->setEditable(false);
        $pessoa->forceUpperCase();
        $selfie->enableFileHandling();
        $selfie->setAllowedExtensions(["jpg","jpeg"]);
        $selfie->setImagePlaceholder(new TImage("fas:file-upload #979CA1"));
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe->enableSearch();
        $pessoa->setMaxLength(255);
        $cnpjcpf->setMaxLength(14);

        $pessoa->setInnerIcon(new TImage('fas:user #8694B0'), 'right');
        $cnpjcpf->setInnerIcon(new TImage('fas:address-card #8694B0'), 'right');

        $politico->addItems(["1"=>"Sim","2"=>"Não"]);
        $systemuseractive->addItems(["1"=>"Sim","2"=>"Não"]);

        $politico->setDefaultOption(false);
        $systemuseractive->setDefaultOption(false);

        $politico->setValue('2');
        $frontpage_id->setValue('173');
        $systemuseractive->setValue('2');

        $cnpjcpf->setTip("Somente os números");
        $pessoa->setTip("Nome ou Razão Social");
        $politico->setTip("Pessoa exposta Politicamente?");
        $walletid->setTip("Utilizado na transferência entre contas Asaas (walletId )");
        $usergroup->setTip("Você só pode Autorizar acesso para os grupos em que você tem permissão.");

        $bancoid->setMinLength(0);
        $idcidade->setMinLength(0);
        $usergroup->setMinLength(0);
        $frontpage_id->setMinLength(0);
        $bancopixtipoid->setMinLength(0);
        $bancocontatipoid->setMinLength(0);

        $usergroup->setMask('{name}');
        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $frontpage_id->setMask('{id} - {name}');
        $cnpjcpf->setMask('99999999999999', true);
        $bancoid->setMask('{codbanco} - {banco}');
        $bancopixtipoid->setMask('{bancopixtipo}');
        $bancocontatipoid->setMask('{bancotipoconta}');

        $button_->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_2->setAction(new TAction(['BancoFormList', 'onShow']), "");
        $button_1->setAction(new TAction(['BancopixtipoFormList', 'onShow']), "");
        $button_3->setAction(new TAction(['BancotipocontaFormList', 'onShow']), "");
        $button_reset_de_senha->setAction(new TAction([$this, 'onResetPass']), "Reset de Senha");
        $button_nao_sei_o_cep->setAction(new TAction(['PessoaCepSeekForm', 'onShow']), "Não Sei o CEP");
        $button_busca_cnpj->setAction(new TAction([$this, 'onBuscarCNPJ'],['static' => 1]), "Busca CNPJ");
        $button_autopreencher_com_cep->setAction(new TAction([$this, 'onCEPSeek']), "Autopreencher com CEP");
        $button_informacoes_do_cliente->setAction(new TAction([$this, 'onCustonerInfo']), "Informações do Cliente");

        $button_->addStyleClass('btn-default');
        $button_1->addStyleClass('btn-default');
        $button_2->addStyleClass('btn-default');
        $button_3->addStyleClass('btn-default');
        $button_busca_cnpj->addStyleClass('btn-default');
        $button_nao_sei_o_cep->addStyleClass('btn-default');
        $button_reset_de_senha->addStyleClass('btn-default');
        $button_autopreencher_com_cep->addStyleClass('btn-success');
        $button_informacoes_do_cliente->addStyleClass('btn-success');

        $button_busca_cnpj->setImage(' #FFFFFF');
        $button_nao_sei_o_cep->setImage(' #000000');
        $button_->setImage('fas:plus-circle #2ECC71');
        $button_1->setImage('fas:plus-circle #2ECC71');
        $button_2->setImage('fas:plus-circle #2ECC71');
        $button_3->setImage('fas:plus-circle #2ECC71');
        $button_autopreencher_com_cep->setImage(' #000000');
        $button_reset_de_senha->setImage('fas:key #2ECC71');
        $button_informacoes_do_cliente->setImage('fas:address-card #FFFFFF');

        $cep->setSize('100%');
        $asaasid->setSize(200);
        $pessoa->setSize('100%');
        $idpessoa->setSize('100%');
        $politico->setSize('100%');
        $selfie->setSize(150, 180);
        $bancocontadv->setSize(50);
        $walletid->setSize('100%');
        $systemuserid->setSize(200);
        $bancoagenciadv->setSize(50);
        $frontpage_id->setSize('100%');
        $bancochavepix->setSize('100%');
        $usergroup->setSize('100%', 110);
        $systemuseractive->setSize('100%');
        $bancoid->setSize('calc(100% - 70px)');
        $cnpjcpf->setSize('calc(100% - 120px)');
        $idcidade->setSize('calc(100% - 150px)');
        $bancoconta->setSize('calc(100% - 120px)');
        $bancoagencia->setSize('calc(100% - 130px)');
        $bancopixtipoid->setSize('calc(100% - 50px)');
        $bancocontatipoid->setSize('calc(100% - 50px)');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe->setSize('100%');
        $pessoadetalheitem_fk_idpessoa_pessoadetalheitem->setSize('100%');

        $cep->autofocus = 'autofocus';
        $cnpjcpf->placeholder = "Somente os números";
        $pessoa->placeholder = "Nome da Pessoa física ou jurídica";

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Cadastro");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Cód. da Pessoa:", null, '14px', null, '100%'),$idpessoa,$asaasid],[new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$pessoa]);
        $row1->layout = [' col-sm-3',' col-sm-9'];

        $bcontainer_643fe92cf6b77 = new BootstrapFormBuilder('bcontainer_643fe92cf6b77');
        $this->bcontainer_643fe92cf6b77 = $bcontainer_643fe92cf6b77;
        $bcontainer_643fe92cf6b77->setProperty('style', 'border:none; box-shadow:none;');
        $row2 = $bcontainer_643fe92cf6b77->addFields([new TLabel("CNPJ/CPF:", null, '14px', null, '100%'),$cnpjcpf,$button_busca_cnpj],[new TLabel("Exposto Politico:", null, '14px', null),$politico]);
        $row2->layout = [' col-sm-9',' col-sm-3'];

        $row3 = $bcontainer_643fe92cf6b77->addFields([new TLabel(" ", null, '14px', null, '100%'),$button_nao_sei_o_cep],[new TLabel("CEP", null, '14px', null, '100%'),$cep],[new TLabel(" ", null, '14px', null, '100%'),$button_autopreencher_com_cep]);
        $row3->layout = ['col-sm-3',' col-sm-6',' col-sm-3'];

        $row4 = $bcontainer_643fe92cf6b77->addFields([new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$idcidade,$button_]);
        $row4->layout = [' col-sm-12'];

        $bcontainer_643fe9daf6b7f = new BootstrapFormBuilder('bcontainer_643fe9daf6b7f');
        $this->bcontainer_643fe9daf6b7f = $bcontainer_643fe9daf6b7f;
        $bcontainer_643fe9daf6b7f->setProperty('style', 'border:none; box-shadow:none;');
        $row5 = $bcontainer_643fe9daf6b7f->addFields([new TLabel("Foto:", null, '14px', null, '100%'),$selfie]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$bcontainer_643fe92cf6b77],[$bcontainer_643fe9daf6b7f]);
        $row6->layout = [' col-sm-9',' col-sm-3'];

        $row7 = $this->form->addContent([new TFormSeparator("Detalhes", '#333', '18', '#eee')]);
        $row8 = $this->form->addFields([$this->pessoaitem]);
        $row8->layout = [' col-sm-12'];

        $this->form->appendPage("Informações Bancárias");
        $row9 = $this->form->addContent([new TFormSeparator("PIX", '#333', '18', '#eee')]);
        $row10 = $this->form->addFields([new TLabel("Chave:", null, '14px', null, '100%'),$bancochavepix],[new TLabel("Tipo de Chave:", null, '14px', null),$bancopixtipoid,$button_1]);
        $row10->layout = [' col-sm-6','col-sm-6'];

        $row11 = $this->form->addContent([new TFormSeparator("Conta Corrente", '#333', '18', '#eee')]);
        $row12 = $this->form->addFields([new TLabel("Banco:", null, '14px', null, '100%'),$bancoid,$button_2],[new TLabel("Agência:", null, '14px', null, '100%'),$bancoagencia,new TLabel("DV:", null, '14px', null),$bancoagenciadv]);
        $row12->layout = [' col-sm-7',' col-sm-5'];

        $row13 = $this->form->addFields([new TLabel("Conta Nº:", null, '14px', null, '100%'),$bancoconta,new TLabel("DV:", null, '14px', null),$bancocontadv],[new TLabel("Tipo da Conta:", null, '14px', null, '100%'),$bancocontatipoid,$button_3],[new TLabel("Carteira:", null, '14px', null, '100%'),$walletid]);
        $row13->layout = [' col-sm-5',' col-sm-4',' col-sm-3'];

        $row14 = $this->form->addFields([],[],[$button_informacoes_do_cliente]);
        $row14->layout = [' col-sm-5',' col-sm-4',' col-sm-3'];

        $this->form->appendPage("Usuário do Sistema");
        $row15 = $this->form->addFields([new TLabel("Permite acessar o sistema?", null, '14px', null),$systemuseractive,new TLabel("Página Inicial:", null, '14px', null, '100%'),$frontpage_id],[new TLabel("Grupo(s) de Acesso", null, '14px', null, '100%'),$usergroup],[new TLabel(" ", null, '14px', null, '100%'),new TLabel(" ", null, '14px', null, '100%'),$button_reset_de_senha,$systemuserid]);
        $row15->layout = [' col-sm-4','col-sm-5',' col-sm-3'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=PessoaForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public static function onExitCNPJCPF($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            if($param['cnpjcpf'] != '')
            {
                switch(strlen($param['cnpjcpf']))
                {
                    case 14:
                        //new TMessage('info', "CNPJ Inválido");
                        (new TCNPJValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);
                    break;
                    case 11:
                        //new TMessage('info', "CPF Inválido");
                        (new TCPFValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);
                    break;
                    default:
                        new TMessage('info', "CNPJ ou CPF Inválido");
                }

                $detail = new stdClass;
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                // $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
                // $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 29; // Celular
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                TFieldList::clearRows('pessoaitem');
                TFieldList::addRows('pessoaitem', 5);
                TForm::sendData(self::$formName, $detail, false, true, 500);                
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onBuscarCNPJ($param = null) 
    {
        try 
        {
            // http://cnpj.info/busca
            (new TCNPJValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);

            TTransaction::open(self::$database); // open a transaction

            $ini = parse_ini_file('app/config/application.ini');
            $url = "https://services.madbuilder.com.br/cnpj/api/v1/{$param['cnpjcpf']}/{$ini['token']}";
            // Resp: uf, cep, cnpj, bairro, numero, municipio, logradouro, complemento, razao_social, nome_fantasia, ddd_telefone_1, codigo_municipio_ibge

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $empresa = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if ($empresa == 'CNPJ não encontrado')
            	throw new Exception($empresa);

            $itens = 6;
            $detail = new stdClass;
            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->logradouro));

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->numero;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->bairro));

            if($empresa->complemento != ''){
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 31; // complemwnro
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->complemento;
                $itens ++;
            }

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->cep;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->ddd_telefone_1 == '' ? null : Uteis::mask($empresa->ddd_telefone_1,'(##)#### #####');

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 19;
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->nome_fantasia));

            TFieldList::clearRows('pessoaitem');
            TFieldList::addRows('pessoaitem', $itens);
            TForm::sendData(self::$formName, $detail, false, true, 500);

            // Cidade::getValidaCidade($cepfull); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', 'like', ucwords(strtolower($empresa->municipio)) )
                            ->where('codibge', '=', $empresa->codigo_municipio_ibge, TExpression::OR_OPERATOR )
                            ->first();

            if(!$cidade)
            {
                new TMessage('info', "A cidade de {$empresa->municipio} - IBGE Cód. {$empresa->codigo_municipio_ibge} não foi localizada.");
                $idcidade = null;
            }
            else
            {
                $idcidade = $cidade->idcidade;
            }

            $object = new stdClass();
            $object->pessoa = $empresa->razao_social;
            $object->cep = Uteis::mask($empresa->cep,'##.###-###');
            $object->idcidade = $idcidade;

            TForm::sendData(self::$formName, $object);
            TTransaction::close(); // close a transaction

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCEPSeek($param = null) 
    {
        try 
        {
            TTransaction::open(self::$database); // open a transaction

            if( strlen($param['cep']) !== 10 )
            {
                throw new Exception('CEP Inválido!');   
            }

            $cep = Uteis::soNumero($param['cep']);
            $ini = parse_ini_file('app/config/application.ini');
            // $url = "https://services.adiantibuilder.com.br/cep/api/v1/{$cep}/{$ini['token']}";

            $url = "https://viacep.com.br/ws/{$cep}/json/";
            // Retorno viacep: cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $cepfull = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if(isset($cepfull->erro))
                throw new Exception('O CEP não foi encontrado!');

            $itens = 0;
            $detail = new stdClass;
            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($cepfull->logradouro));

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            if($cepfull->complemento != ''){
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 31; // complemento
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $cepfull->complemento;
                $itens ++;
            }

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($cepfull->bairro));
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = Uteis::soNumero($cepfull->cep);
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 29; // Celular
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            TFieldList::clearRows('pessoaitem');
            TFieldList::addRows('pessoaitem', $itens);
            TForm::sendData(self::$formName, $detail, false, true, 600);

            TToast::show("info", "Cadastro autopreenchido com as informa&ccedil;&otilde;es do CEP", "topRight", "fas:pencil-ruler");

            Cidade::getValidaCidade($cepfull); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', '=', $cepfull->localidade)->first();

            $object = new stdClass();
            $object->idcidade = $cidade->idcidade;

            TForm::sendData(self::$formName, $object);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onCustonerInfo($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $pessoa = new Pessoa($param['idpessoa']);
            if( !$pessoa->asaasid)
            {
                TToast::show("warning", "Essa pessoa não possui cadastro no Banco. Isso acontecerá ao emitir a 1ª fatura.", "topRight", "fas:user-alt-slash");
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/v3/customers/{$pessoa->asaasid}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onResetPass($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $pessoa = new Pessoafull($param['idpessoa']);
            if(!$pessoa->email || !$pessoa->systemuserid)
                throw new Exception('Cadastro Incompleto. Atualize!');

            $config = new Config(1);
            $password = Uteis::gerarSenha(8, TRUE, TRUE, TRUE, FALSE);

            $permission  = TTransaction::open('permission');
            $preferences = SystemPreference::getAllPreferences();
            $systemuser  = new SystemUsers($pessoa->systemuserid);
            $systemuser->password = md5($password);
            $systemuser->accepted_term_policy_at = null;
            $systemuser->accepted_term_policy = 'N';
            $systemuser->store();
            $permisson = TTransaction::close();

            $message  = "<p>Olá {$pessoa->pessoa}!</p>";
            $message .= "<p>Suas configurações de acesso ao sistema Imobi-K Versão 2.0 foram reiniciadas:<br />Login: {$pessoa->cnpjcpf}<br />Senha: {$password}</p>";
            // $message .= '<p>Acesse pelo site <a href="https://app.imobik.com.br/">https://app.imobik.com.br/</a></p>';
            $message .= '<p>Acesse pelo site <a href="https://' . $config->appdomain . '/">' . $config->appdomain . '</a></p>';
            $message .= '<p></p><p></p><p></p>';
            $message .= '<p><span style="color: #ff0000;"><strong>ATENÇÃO</strong></span>: <ul>
                         <li>As senhas são pessoais e intransferíveis, a inicial serve somente para o primeiro acesso e deve ser substituída ao conectar-se no sistema já na primeira vez. 
                         O não cumprimento dessa regra sujeita o usuário a assumir a responsabilidade por acessos indevidos em seu nome;</li>
                         <li>Este é um e-mail automático, por favor, não responda.</li></p>';
            $message .= '<hr><p style="text-align: center;">
                        <span style="color: #888888;">"Respeite o meio ambiente, imprima somente o necessário."<br/>
                        *Este é um e-mail automático, por favor, não responda.
                        </span></p><hr>';
            $mail = new TMail;
            $mail->setFrom($preferences['mail_from'], $config->nomefantasia);
            $mail->setSubject('Liberação de Acesso');
            $mail->setHtmlBody("{$message}");
            $mail->addAddress("{$pessoa->email}", "{$pessoa->name}");
            $mail->SetUseSmtp();
            $mail->SMTPSecure = 'ssl';
            $mail->SetSmtpHost($preferences['smtp_host'], $preferences['smtp_port']);
            $mail->SetSmtpUser($preferences['smtp_user'], $preferences['smtp_pass']);
            $mail->send();

            TToast::show("info", "Encaminhando email com as novas configurações de Acesso.<br />Em caso de não recebimento, vierificar a caixa de SPAM.", "topRight", "fas:mail-bulk");
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            if( isset($param['usergroup']) )
            {
                if( !in_array('2', $param['usergroup']))
                {
                    array_push($param['usergroup'], 2);
                }
            }

            $this->form->validate(); // validate form data
            $config = new Config(1, FALSE);
            $object = new Pessoa(); // create an empty object 
            $franquia = Pessoa::getUserFranquia();

            $data = $this->form->getData(); // get form data as array

            $ehnovo = ($data->systemuserid == '' AND $data->systemuseractive == 1 )? 1 : 2;
            if( $ehnovo == 1 AND $franquia['saldo'] <= 0)
                throw new Exception('O Sistema excedeu a franquia de <strong>Usuários</strong>. Verifique!');

            if( (Pessoa::getPessoaPorCnpjcpf($param['cnpjcpf'])) AND (!$param['idpessoa']) )
                throw new Exception('CPF/CNPJ Já Cadastrado. Não é possível a duplicação de pessoas. Verifique!');

            if($data->cnpjcpf)
            {
                if (!in_array("1", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Bairro</strong> é requerido!');
                }
                if (!in_array("11", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>E-mail</strong> é requerido!');
                }
                if (!in_array("12", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Endereço</strong> é requerido!');
                }
                if (!in_array("14", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Fone(s)</strong> é requerido!');
                }
                if (!in_array("29", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Celular/WhatsApp</strong> é requerido!');
                }
                if (!in_array("30", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>End. Casa / Prédio Nº</strong> é requerido!');
                }
            }
            if(count(array_unique($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])) < count($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe']))
                throw new Exception('Há duplicidade de Ítens no Detalhamento desta Pessoa. Verifique!');

            $object->fromArray( (array) $data); // load the object with data

            $object->pessoa = strtoupper($data->pessoa);
            $data->pessoa = $object->pessoa;
            $object->ativo = TRUE;
            $object->idunit = TSession::getValue('userunitid');
            $object->idsystemuser = TSession::getValue('userid');
            $object->hecorretor = false;
            $object->systemuseractive = $object->systemuseractive == 1 ? true : false;
            $object->politico = $object->politico == 1 ? true : false;

            $selfie_dir = 'files/images/imoveis/';  

            $selfie_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/pessoa/';

            $object->store(); // save the object 

            $repository = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa);
            $repository->delete(); 

            if ($data->usergroup) 
            {
                foreach ($data->usergroup as $usergroup_value) 
                {
                    $pessoasystemusergroup = new Pessoasystemusergroup;

                    $pessoasystemusergroup->idgorup = $usergroup_value;
                    $pessoasystemusergroup->idpessoa = $object->idpessoa;
                    $pessoasystemusergroup->store();
                }
            }

            $this->saveFile($object, $data, 'selfie', $selfie_dir); 

//<generatedAutoCode>
            $this->criteria_pessoaitem->setProperty('order', 'pessoadetalheitem asc');
//</generatedAutoCode>
            $pessoadetalheitem_fk_idpessoa_items = $this->storeItems('Pessoadetalheitem', 'idpessoa', $object, $this->pessoaitem, function($masterObject, $detailObject){ 

            //code here
            if(!$detailObject->pessoadetalheitem )
                throw new Exception('Nos Detalhes há um ou mais Ítens sem Descrição!');

            if( $detailObject->pessoadetalheitem == '@@' )
            {
                $config = new Config(1);
                $detailObject->pessoadetalheitem = $config->email;
            }

            }, $this->criteria_pessoaitem); 

            // get the generated {PRIMARY_KEY}
            $data->idpessoa = $object->idpessoa; 
            $data->idpessoa = str_pad($object->idpessoa, 6, '0', STR_PAD_LEFT);
            $this->form->setData($data); // fill form data

            if( !$object->systemuseractive  AND $object->systemuserid)
            {
                $permission =TTransaction::open('permission');
                $systemuser = new SystemUsers($object->systemuserid);
                $systemuser->active = 'N';
                $systemuser->store();
                $permisson = TTransaction::close();
            }

            if($object->systemuseractive) // se habilitado o user
            {
                $pessoafull = new Pessoafull($object->idpessoa);
                $groups = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa)->load();

                if(!$object->cnpjcpf)
                    throw new Exception('Leads <b>não</b> podem ter acesso ao sistema!');

                if(!$pessoafull->email)
                    throw new Exception('Para habilitar um usuário é necessário o cadastro de um e-mail!');

                $permisson = TTransaction::open('permission');
                $preferences = SystemPreference::getAllPreferences();
                $systemuser = new SystemUsers($object->systemuserid);

                $passwordnew = Uteis::gerarSenha(8, TRUE, TRUE, TRUE, FALSE);
                $ehnovo = $object->systemuserid == '' ? true : false;
                $password = $ehnovo == true ? md5($passwordnew) : $systemuser->password;

                $systemuser->name = $object->pessoa;
                $systemuser->login = $object->cnpjcpf;
                $systemuser->password = $password;
                $systemuser->email = $pessoafull->email;
                $systemuser->frontpage_id = $data->frontpage_id;
                $systemuser->system_unit_id = TSession::getValue('userunitid');
                $systemuser->active = 'Y';
                $systemuser->accepted_term_policy = 'N';
                $systemuser->store();
                $object->systemuserid = $systemuser->id;

                if($data->selfie)
                    copy($object->selfie, "app/images/photos/{$systemuser->login}.jpg");

                SystemUserGroup::where('system_user_id', '=', $systemuser->id)->delete();
                SystemUserUnit::where('system_user_id', '=', $systemuser->id)->where('system_unit_id', '=',  TSession::getValue('userunitid'))->delete();

                if($groups)
                {
                    foreach($groups AS $group)
                    {
                        $usergroup = new SystemUserGroup();
                        $usergroup->system_user_id = $systemuser->id;
                        $usergroup->system_group_id = $group->idgorup;
                        $usergroup->store();
                    }
                }
                $systemunit = new SystemUserUnit();
                $systemunit->system_user_id = $systemuser->id;
                $systemunit->system_unit_id = TSession::getValue('userunitid');
                $systemunit->store();

                $permisson = TTransaction::close();
                $object->store();

                // enviar email caso seja novo
                if($ehnovo)
                {

                    // TToast::show("info", "Encaminhando email com as configurações de Acesso.", "topRight", "fas:mail-bulk");
                    TToast::show("info", "Encaminhando email com as configurações de Acesso.<br />Em caso de não recebimento, vierificar a caixa de SPAM.", "topRight", "fas:mail-bulk");

                    $message  = "<p>Olá {$object->pessoa}!</p>";
                    $message .= "<p>Suas configurações de acesso ao sistema Imobi-K Versão 2.0:<br />Login: {$object->cnpjcpf}<br />Senha: {$passwordnew}</p>";
                    $message .= '<p>Acesse pelo site <a href="https://' . $config->appdomain . '/">' . $config->appdomain . '</a></p>';
                    $message .= '<p></p><p></p><p></p>';
                    $message .= '<p><span style="color: #ff0000;"><strong>ATENÇÃO</strong></span>: <ul>
                                 <li>As senhas são pessoais e intransferíveis, a inicial serve somente para o primeiro acesso e deve ser substituída ao conectar-se no sistema já na primeira vez. 
                                 O não cumprimento dessa regra sujeita o usuário a assumir a responsabilidade por acessos indevidos em seu nome;</li>
                                 <li>Este é um e-mail automático, por favor, não responda.</li></p>';
                    $message .= '<hr><p style="text-align: center;">
                                <span style="color: #888888;">"Respeite o meio ambiente, imprima somente o necessário."<br/>
                                *Este é um e-mail automático, por favor, não responda.
                                </span></p><hr>';
                    $mail = new TMail;
                    $mail->setFrom($preferences['mail_from'], $config->nomefantasia);
                    $mail->setSubject('Liberação de Acesso');
                    $mail->setHtmlBody("{$message}");
                    $mail->addAddress("{$pessoafull->email}", "{$object->name}");
                    $mail->SetUseSmtp();
                    $mail->SMTPSecure = 'ssl';
                    $mail->SetSmtpHost($preferences['smtp_host'], $preferences['smtp_port']);
                    $mail->SetSmtpUser($preferences['smtp_user'], $preferences['smtp_pass']);
                    $mail->send();

                    // encaminhando boas vindas
                    $communication = TTransaction::open('communication');
                    $mess = 'Colega, você não sabe como a equipe e eu nos sentimos alegres em ter você em nossa equipe! A gente sabe que demora um pouquinho para se adaptar no começo, mas ajudaremos em qualquer coisa que você precisar. Mais do que trabalhos excelentes, criamos raízes aqui.';
                    $mensagem = new SystemMessage;
                    $mensagem->system_user_id = TSession::getValue('userid');
                    $mensagem->system_user_to_id = $systemuser->id;
                    $mensagem->subject = 'Bem-Vindo(a)';
                    $mensagem->message = $mess;
                    $mensagem->dt_message = date('Y-m-d H:i:s');
                    $mensagem->checked = 'N';
                    $mensagem->store();
                    $communication = TTransaction::close();
                } // if($ehnovo)

            } // if($data->useraccess == 1)

            if($object->asaasid)
            {
                $asaasService = new AsaasService;
                $asaasService->atualizarCliente($object->idpessoa);
            }

            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['idpessoa' => $object->idpessoa]);

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
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

                $object = new Pessoa($key); // instantiates the Active Record 
                $object->politico = $object->politico == true ? 1 : 2;

                if(!$object->systemuseractive)
                {
                    TButton::disableField(self::$formName, 'button_reset_de_senha');
                }

                $object->usergroup = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa)->getIndexedArray('idgorup', 'idgorup');

                $lbl_idpessoa = str_pad($object->idpessoa, 6, '0', STR_PAD_LEFT);
                $object->idpessoa = $lbl_idpessoa;
                $object->systemuseractive = $object->systemuseractive == true ? 1 : 2;

                $this->form->setFormTitle("Pessoa: ({$lbl_idpessoa}) $object->pessoa ");

                $this->criteria_pessoaitem->setProperty('order', 'pessoadetalheitem asc');
                $this->pessoaitem_items = $this->loadItems('Pessoadetalheitem', 'idpessoa', $object, $this->pessoaitem, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_pessoaitem); 

                if($object->systemuserid)
                {
                    $permisson = TTransaction::open('permission');
                    $systemuser = new SystemUsers($object->systemuserid);
                    $object->frontpage_id = $systemuser->frontpage_id;
                }

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

        $this->pessoaitem->addHeader();
        $this->pessoaitem->addDetail($this->default_item_pessoaitem);

        $this->pessoaitem->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->pessoaitem->addHeader();
        $this->pessoaitem->addDetail($this->default_item_pessoaitem);

        $this->pessoaitem->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


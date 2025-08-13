<?php

class InstallWizard2 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'idpessoa';
    private static $formName = 'form_PessoaForm';

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
        $this->form->setFormTitle("Responsável Legal");

        $criteria_idcidade = new TCriteria();

        $pageStep_676484199c9a4 = new TPageStep();
        $pessoa = new TEntry('pessoa');
        $cnpjcpf = new TEntry('cnpjcpf');
        $rg = new TEntry('rg');
        $dtnascimento = new TDate('dtnascimento');
        $button_nao_sei_o_cep = new TButton('button_nao_sei_o_cep');
        $cep = new TEntry('cep');
        $button_autopreencher_com_cep = new TButton('button_autopreencher_com_cep');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'cidadeuf','idcidade asc' , $criteria_idcidade );
        $button_ = new TButton('button_');
        $endereco = new TEntry('endereco');
        $nro = new TEntry('nro');
        $bairro = new TEntry('bairro');
        $complemento = new TEntry('complemento');
        $celular = new TEntry('celular');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        $login = new TEntry('login');
        $senha = new TPassword('senha');
        $senhaconfirm = new TPassword('senhaconfirm');

        $cnpjcpf->setExitAction(new TAction([$this,'onExitCNPJCPF']));

        $pessoa->addValidation("Nome", new TRequiredValidator()); 
        $cnpjcpf->addValidation("CNPJ/CPF", new TRequiredValidator()); 
        $rg->addValidation("RG", new TRequiredValidator()); 
        $cep->addValidation("CEP", new TRequiredValidator()); 
        $idcidade->addValidation("Cidade", new TRequiredValidator()); 
        $login->addValidation("Login", new TRequiredValidator()); 
        $senha->addValidation("senha", new TRequiredValidator()); 
        $senhaconfirm->addValidation("Confrimar a Senha", new TRequiredValidator()); 

        $pessoa->forceUpperCase();
        $dtnascimento->setDatabaseMask('yyyy-mm-dd');
        $idcidade->setMinLength(0);
        $pessoa->setMaxLength(255);
        $cnpjcpf->setMaxLength(14);

        $pessoa->setTip("Nome");
        $cnpjcpf->setTip("Somente os números");

        $pessoa->setInnerIcon(new TImage('fas:user #8694B0'), 'right');
        $cnpjcpf->setInnerIcon(new TImage('fas:address-card #8694B0'), 'right');

        $senha->enableToggleVisibility(true);
        $senhaconfirm->enableToggleVisibility(true);

        $button_->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_nao_sei_o_cep->setAction(new TAction(['PessoaCepSeekForm', 'onShow']), "Não Sei o CEP");
        $button_autopreencher_com_cep->setAction(new TAction([$this, 'onCEPSeek']), "Autopreencher com CEP");

        $button_->addStyleClass('btn-default');
        $button_nao_sei_o_cep->addStyleClass('btn-default');
        $button_autopreencher_com_cep->addStyleClass('btn-success');

        $button_nao_sei_o_cep->setImage(' #000000');
        $button_->setImage('fas:plus-circle #607D8B');
        $button_autopreencher_com_cep->setImage(' #FFFFFF');

        $rg->setMask('9!');
        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $dtnascimento->setMask('dd/mm/yyyy');
        $cnpjcpf->setMask('99999999999999', true);

        $rg->setSize('100%');
        $nro->setSize('100%');
        $email->setSize('100%');
        $login->setSize('100%');
        $senha->setSize('100%');
        $pessoa->setSize('100%');
        $bairro->setSize('100%');
        $cnpjcpf->setSize('100%');
        $celular->setSize('100%');
        $endereco->setSize('100%');
        $telefone->setSize('100%');
        $complemento->setSize('100%');
        $dtnascimento->setSize('100%');
        $senhaconfirm->setSize('100%');
        $cep->setSize('calc(100% - 410px)');
        $idcidade->setSize('calc(100% - 70px)');

        $cep->autofocus = 'autofocus';
        $pessoa->autofocus = 'autofocus';
        $cnpjcpf->placeholder = "Somente os números";
        $pessoa->placeholder = "Nome do Gerente/Responsável Legal";

        $pageStep_676484199c9a4->addItem("DB/Conexão");
        $pageStep_676484199c9a4->addItem("Administrador");
        $pageStep_676484199c9a4->addItem("Imobiliária");

        $pageStep_676484199c9a4->select("Administrador");

        $this->pageStep_676484199c9a4 = $pageStep_676484199c9a4;

        $row1 = $this->form->addFields([$pageStep_676484199c9a4]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$pessoa],[new TLabel("CPF:", '#FF0000', '14px', null, '100%'),$cnpjcpf],[new TLabel("RG:", '#FF0000', '14px', null),$rg],[new TLabel("Dt. Nascimento:", '#FF0000', '14px', null),$dtnascimento]);
        $row2->layout = ['col-sm-5','col-sm-3','col-sm-2','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("CEP", '#FF0000', '14px', null, '100%'),$button_nao_sei_o_cep,$cep,$button_autopreencher_com_cep],[new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$idcidade,$button_]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Endereço:", '#FF0000', '14px', null),$endereco],[new TLabel("Número:", '#FF0000', '14px', null),$nro],[new TLabel("Bairro:", '#FF0000', '14px', null),$bairro],[new TLabel("Complemento:", null, '14px', null),$complemento]);
        $row4->layout = [' col-sm-4',' col-sm-2',' col-sm-4','col-sm-2'];

        $row5 = $this->form->addFields([new TLabel("Celular/WhatsApp:", '#FF0000', '14px', null),$celular],[new TLabel("Telefone:", '#FF0000', '14px', null),$telefone],[new TLabel("E-Mail:", '#FF0000', '14px', null),$email],[new TLabel("Login <small>(Usuário)</small>:", '#FF0000', '14px', null),$login]);
        $row5->layout = ['col-sm-3','col-sm-3','col-sm-3',' col-sm-3'];

        $row6 = $this->form->addFields([new TLabel("Senha:", '#FF0000', '14px', null),$senha],[new TLabel("Confirmar a Senha:", '#FF0000', '14px', null),$senhaconfirm],[]);
        $row6->layout = ['col-sm-3','col-sm-3','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onreturn = $this->form->addAction("Voltar", new TAction([$this, 'onReturn']), 'fas:hand-point-left #000000');
        $this->btn_onreturn = $btn_onreturn;

        $btn_onadvance = $this->form->addAction("Avançar", new TAction([$this, 'onAdvance']), 'fas:hand-point-right #000000');
        $this->btn_onadvance = $btn_onadvance;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Cadastros","Responsável pela Imobiliária"]));
        }
        $container->add($this->form);

        parent::add($container);

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

            $object = new stdClass();
            $object->endereco = ucwords(strtolower($cepfull->logradouro));
            $object->bairro =  ucwords(strtolower($cepfull->bairro));
            $object->complemento =  ucwords(strtolower($cepfull->complemento));

            TToast::show("info", "Cadastro autopreenchido com as informações do CEP", "topRight", "fas:pencil-ruler");

            Cidade::getValidaCidade($cepfull); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', '=', $cepfull->localidade)->first();

            $object->idcidade = $cidade->idcidade;

            TForm::sendData(self::$formName, $object);
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

            $messageAction = new TAction(['PessoaList', 'onShow']);

            // echo '<pre>' ; print_r($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe']);echo '</pre>'; exit();

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

            $object->nt1emailenabledforcustomer     = $object->nt1emailenabledforcustomer == 1 ? true : false;
            $object->nt1emailenabledforprovider     = $object->nt1emailenabledforprovider == 1 ? true : false;
            $object->nt1enabled                     = $object->nt1enabled == 1 ? true : false;
            $object->nt1phonecallenabledforcustomer = $object->nt1phonecallenabledforcustomer == 1 ? true : false;
            $object->nt1smsenabledforcustomer       = $object->nt1smsenabledforcustomer ==  1 ? true : false;
            $object->nt1smsenabledforprovider       = $object->nt1smsenabledforprovider ==  1 ? true : false;
            $object->nt1whatsappenabledforcustomer  = $object->nt1whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt1whatsappenabledforprovider  = $object->nt1whatsappenabledforprovider ==  1 ? true : false;

            $object->nt2emailenabledforcustomer     = $object->nt2emailenabledforcustomer == 1 ? true : false;
            $object->nt2emailenabledforprovider     = $object->nt2emailenabledforprovider == 1 ? true : false;
            $object->nt2enabled                     = $object->nt2enabled == 1 ? true : false;
            $object->nt2phonecallenabledforcustomer = $object->nt2phonecallenabledforcustomer == 1 ? true : false;
            $object->nt2smsenabledforcustomer       = $object->nt2smsenabledforcustomer ==  1 ? true : false;
            $object->nt2smsenabledforprovider       = $object->nt2smsenabledforprovider ==  1 ? true : false;
            $object->nt2whatsappenabledforcustomer  = $object->nt2whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt2whatsappenabledforprovider  = $object->nt2whatsappenabledforprovider ==  1 ? true : false;

            $object->nt3emailenabledforcustomer     = $object->nt3emailenabledforcustomer == 1 ? true : false;
            $object->nt3emailenabledforprovider     = $object->nt3emailenabledforprovider == 1 ? true : false;
            $object->nt3enabled                     = $object->nt3enabled == 1 ? true : false;
            $object->nt3phonecallenabledforcustomer = $object->nt3phonecallenabledforcustomer == 1 ? true : false;
            $object->nt3smsenabledforcustomer       = $object->nt3smsenabledforcustomer ==  1 ? true : false;
            $object->nt3smsenabledforprovider       = $object->nt3smsenabledforprovider ==  1 ? true : false;
            $object->nt3whatsappenabledforcustomer  = $object->nt3whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt3whatsappenabledforprovider  = $object->nt3whatsappenabledforprovider ==  1 ? true : false;

            $object->nt4emailenabledforcustomer     = $object->nt4emailenabledforcustomer == 1 ? true : false;
            $object->nt4emailenabledforprovider     = $object->nt4emailenabledforprovider == 1 ? true : false;
            $object->nt4enabled                     = $object->nt4enabled == 1 ? true : false;
            $object->nt4phonecallenabledforcustomer = $object->nt4phonecallenabledforcustomer == 1 ? true : false;
            $object->nt4smsenabledforcustomer       = $object->nt4smsenabledforcustomer ==  1 ? true : false;
            $object->nt4smsenabledforprovider       = $object->nt4smsenabledforprovider ==  1 ? true : false;
            $object->nt4whatsappenabledforcustomer  = $object->nt4whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt4whatsappenabledforprovider  = $object->nt4whatsappenabledforprovider ==  1 ? true : false;

            $object->nt5emailenabledforcustomer     = $object->nt5emailenabledforcustomer == 1 ? true : false;
            $object->nt5emailenabledforprovider     = $object->nt5emailenabledforprovider == 1 ? true : false;
            $object->nt5enabled                     = $object->nt5enabled == 1 ? true : false;
            $object->nt5phonecallenabledforcustomer = $object->nt5phonecallenabledforcustomer == 1 ? true : false;
            $object->nt5smsenabledforcustomer       = $object->nt5smsenabledforcustomer ==  1 ? true : false;
            $object->nt5smsenabledforprovider       = $object->nt5smsenabledforprovider ==  1 ? true : false;
            $object->nt5whatsappenabledforcustomer  = $object->nt5whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt5whatsappenabledforprovider  = $object->nt5whatsappenabledforprovider ==  1 ? true : false;

            $object->nt6emailenabledforcustomer     = $object->nt6emailenabledforcustomer == 1 ? true : false;
            $object->nt6emailenabledforprovider     = $object->nt6emailenabledforprovider == 1 ? true : false;
            $object->nt6enabled                     = $object->nt6enabled == 1 ? true : false;
            $object->nt6phonecallenabledforcustomer = $object->nt6phonecallenabledforcustomer == 1 ? true : false;
            $object->nt6smsenabledforcustomer       = $object->nt6smsenabledforcustomer ==  1 ? true : false;
            $object->nt6smsenabledforprovider       = $object->nt6smsenabledforprovider ==  1 ? true : false;
            $object->nt6whatsappenabledforcustomer  = $object->nt6whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt6whatsappenabledforprovider  = $object->nt6whatsappenabledforprovider ==  1 ? true : false;

            $object->nt7emailenabledforcustomer     = $object->nt7emailenabledforcustomer == 1 ? true : false;
            $object->nt7emailenabledforprovider     = $object->nt7emailenabledforprovider == 1 ? true : false;
            $object->nt7enabled                     = $object->nt7enabled == 1 ? true : false;
            $object->nt7phonecallenabledforcustomer = $object->nt7phonecallenabledforcustomer == 1 ? true : false;
            $object->nt7smsenabledforcustomer       = $object->nt7smsenabledforcustomer ==  1 ? true : false;
            $object->nt7smsenabledforprovider       = $object->nt7smsenabledforprovider ==  1 ? true : false;
            $object->nt7whatsappenabledforcustomer  = $object->nt7whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt7whatsappenabledforprovider  = $object->nt7whatsappenabledforprovider ==  1 ? true : false;

            $object->nt8emailenabledforcustomer     = $object->nt8emailenabledforcustomer == 1 ? true : false;
            $object->nt8emailenabledforprovider     = $object->nt8emailenabledforprovider == 1 ? true : false;
            $object->nt8enabled                     = $object->nt8enabled == 1 ? true : false;
            $object->nt8phonecallenabledforcustomer = $object->nt8phonecallenabledforcustomer == 1 ? true : false;
            $object->nt8smsenabledforcustomer       = $object->nt8smsenabledforcustomer ==  1 ? true : false;
            $object->nt8smsenabledforprovider       = $object->nt8smsenabledforprovider ==  1 ? true : false;
            $object->nt8whatsappenabledforcustomer  = $object->nt8whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt8whatsappenabledforprovider  = $object->nt8whatsappenabledforprovider ==  1 ? true : false;

            $selfie_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/pessoa/';

            $object->store(); // save the object 

            $messageAction = new TAction(['PessoaList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            // Excluir todos os detalhes das pessoas. Está dando mensagem de duplicidade
            Pessoadetalheitem::where('idpessoa', '=', $object->idpessoa)->delete();

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
                $systemuser->login = $systemuser->login == '' ? $object->cnpjcpf : $systemuser->login;
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

                    TToast::show("info", "Encaminhando email com as configurações de Acesso.<br />Em caso de não recebimento, vierifiar a caixa de SPAM.", "topRight", "fas:mail-bulk");

                    $message  = "<p>Olá {$object->pessoa}!</p>";
                    $message .= "<p>Suas configurações de acesso ao sistema Imobi-K Versão 2.0:<br />Login: {$object->cnpjcpf}<br />Senha: {$passwordnew}</p>";
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

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onReturn($param = null) 
    {
        try 
        {
            //code here

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

            $this->form->validate(); // validate form data
            if($param['senha'] != $param['senhaconfirm'])
            {
                throw new Exception('As senhas não conferem!');
            }

            TSession::setValue('InstallWizad2', (array) $param);
            AdiantiCoreApplication::loadPage('InstallWizard3', 'onShow');

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

                $object = new Pessoa($key); // instantiates the Active Record 

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

        if(TSession::getValue('InstallWizad2'))
        {
            $object = (array) TSession::getValue('InstallWizad2');
            TForm::sendData(self::$formName, $object );
        }

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


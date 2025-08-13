<?php

class ImovelForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imovel';
    private static $primaryKey = 'idimovel';
    private static $formName = 'form_ImovelForm1';

    private $unidadeNome = '';

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
        $this->form->setFormTitle("Imóvel");

        $criteria_idcidade = new TCriteria();
        $criteria_imovelproprietario_fk_idimovel_idpessoa = new TCriteria();
        $criteria_imovelcorretor_fk_idimovel_idcorretor = new TCriteria();
        $criteria_idimoveltipo = new TCriteria();
        $criteria_idimovelmaterial = new TCriteria();
        $criteria_idimoveldestino = new TCriteria();
        $criteria_idimovelsituacao = new TCriteria();
        $criteria_imoveldetalheitem_fk_idimovel_idimoveldetalhe = new TCriteria();
        $criteria_imovelretiradachave_fk_idimovel_idpessoa = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = "5";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Imovelfull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $this->unidadeNome = strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) );

        TTransaction::open(self::$database);
        $config = new Config(1);
        TTransaction::close();

        $idimovel = new TEntry('idimovel');
        $button_buscar_pelo_endereco = new TButton('button_buscar_pelo_endereco');
        $cep = new TEntry('cep');
        $button_autocompletar_com_o_cep = new TButton('button_autocompletar_com_o_cep');
        $logradouro = new TEntry('logradouro');
        $logradouronro = new TEntry('logradouronro');
        $complemento = new TEntry('complemento');
        $perimetro = new TCombo('perimetro');
        $bairro = new TEntry('bairro');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'idcidade','cidadeuf asc' , $criteria_idcidade );
        $cidadeButton = new TButton('cidadeButton');
        $area = new TNumeric('area', '2', ',', '.' );
        $button_como_usar = new TButton('button_como_usar');
        $mapa = new TText('mapa');
        $createdat = new TDateTime('createdat');
        $updatedat = new TDateTime('updatedat');
        $systemUser = new TEntry('systemUser');
        $imovelproprietario_fk_idimovel_idimovelproprietario = new THidden('imovelproprietario_fk_idimovel_idimovelproprietario[]');
        $imovelproprietario_fk_idimovel___row__id = new THidden('imovelproprietario_fk_idimovel___row__id[]');
        $imovelproprietario_fk_idimovel___row__data = new THidden('imovelproprietario_fk_idimovel___row__data[]');
        $imovelproprietario_fk_idimovel_idpessoa = new TDBUniqueSearch('imovelproprietario_fk_idimovel_idpessoa[]', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoalead','pessoalead asc' , $criteria_imovelproprietario_fk_idimovel_idpessoa );
        $imovelproprietario_fk_idimovel_fracao = new TNumeric('imovelproprietario_fk_idimovel_fracao[]', '2', ',', '.' );
        $this->fieldList_Proprietarios = new TFieldList();
        $aluguel = new TNumeric('aluguel', '2', ',', '.' );
        $venda = new TNumeric('venda', '2', ',', '.' );
        $iptu = new TNumeric('iptu', '2', ',', '.' );
        $condominio = new TNumeric('condominio', '2', ',', '.' );
        $outrataxa = new TEntry('outrataxa');
        $outrataxavalor = new TNumeric('outrataxavalor', '2', ',', '.' );
        $imovelregistro = new TEntry('imovelregistro');
        $prefeituramatricula = new TEntry('prefeituramatricula');
        $setor = new TEntry('setor');
        $quadra = new TEntry('quadra');
        $lote = new TEntry('lote');
        $button_ = new TButton('button_');
        $imovelcorretor_fk_idimovel_idimovelcorretor = new THidden('imovelcorretor_fk_idimovel_idimovelcorretor[]');
        $imovelcorretor_fk_idimovel___row__id = new THidden('imovelcorretor_fk_idimovel___row__id[]');
        $imovelcorretor_fk_idimovel___row__data = new THidden('imovelcorretor_fk_idimovel___row__data[]');
        $imovelcorretor_fk_idimovel_idcorretor = new TDBUniqueSearch('imovelcorretor_fk_idimovel_idcorretor[]', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoalead','pessoalead asc' , $criteria_imovelcorretor_fk_idimovel_idcorretor );
        $imovelcorretor_fk_idimovel_divulgarsite = new TCombo('imovelcorretor_fk_idimovel_divulgarsite[]');
        $this->fieldList_Corretores = new TFieldList();
        $idimoveltipo = new TDBUniqueSearch('idimoveltipo', 'imobi_producao', 'Imoveltipo', 'idimoveltipo', 'imoveltipo','imoveltipo asc' , $criteria_idimoveltipo );
        $button_1 = new TButton('button_1');
        $idimovelmaterial = new TDBUniqueSearch('idimovelmaterial', 'imobi_producao', 'Imovelmaterial', 'idimovelmaterial', 'imovelmaterial','idimovelmaterial asc' , $criteria_idimovelmaterial );
        $button_2 = new TButton('button_2');
        $idimoveldestino = new TDBCombo('idimoveldestino', 'imobi_producao', 'Imoveldestino', 'idimoveldestino', '{imoveldestino}','imoveldestino asc' , $criteria_idimoveldestino );
        $idimovelsituacao = new TDBCombo('idimovelsituacao', 'imobi_producao', 'Imovelsituacao', 'idimovelsituacao', '{imovelsituacao}','imovelsituacao asc' , $criteria_idimovelsituacao );
        $caracteristicas = new TText('caracteristicas');
        $button_autocompletar_com_ia = new TButton('button_autocompletar_com_ia');
        $obs = new TText('obs');
        $imoveldetalheitem_fk_idimovel_idimoveldetalheitem = new THidden('imoveldetalheitem_fk_idimovel_idimoveldetalheitem[]');
        $imoveldetalheitem_fk_idimovel___row__id = new THidden('imoveldetalheitem_fk_idimovel___row__id[]');
        $imoveldetalheitem_fk_idimovel___row__data = new THidden('imoveldetalheitem_fk_idimovel___row__data[]');
        $imoveldetalheitem_fk_idimovel_idimoveldetalhe = new TDBUniqueSearch('imoveldetalheitem_fk_idimovel_idimoveldetalhe[]', 'imobi_producao', 'Imoveldetalhefull', 'idimoveldetalhe', 'family','family asc' , $criteria_imoveldetalheitem_fk_idimovel_idimoveldetalhe );
        $imoveldetalheitem_fk_idimovel_imoveldetalheitem = new TEntry('imoveldetalheitem_fk_idimovel_imoveldetalheitem[]');
        $this->fieldList_Detalhamento = new TFieldList();
        $marcadagua = new TCombo('marcadagua');
        $imgs = new TMultiFile('imgs');
        $imovelplanta_fk_idimovel_idimovelplanta = new THidden('imovelplanta_fk_idimovel_idimovelplanta[]');
        $imovelplanta_fk_idimovel___row__id = new THidden('imovelplanta_fk_idimovel___row__id[]');
        $imovelplanta_fk_idimovel___row__data = new THidden('imovelplanta_fk_idimovel___row__data[]');
        $imovelplanta_fk_idimovel_patch = new TFile('imovelplanta_fk_idimovel_patch[]');
        $imovelplanta_fk_idimovel_legenda = new TEntry('imovelplanta_fk_idimovel_legenda[]');
        $this->fieldList_Plantas = new TFieldList();
        $imovelvideo_fk_idimovel_idimovelvideo = new THidden('imovelvideo_fk_idimovel_idimovelvideo[]');
        $imovelvideo_fk_idimovel___row__id = new THidden('imovelvideo_fk_idimovel___row__id[]');
        $imovelvideo_fk_idimovel___row__data = new THidden('imovelvideo_fk_idimovel___row__data[]');
        $imovelvideo_fk_idimovel_patch = new TEntry('imovelvideo_fk_idimovel_patch[]');
        $imovelvideo_fk_idimovel_legenda = new TEntry('imovelvideo_fk_idimovel_legenda[]');
        $this->fieldList_63f691a634fe0 = new TFieldList();
        $imoveltur360_fk_idimovel_idimoveltur360 = new THidden('imoveltur360_fk_idimovel_idimoveltur360[]');
        $imoveltur360_fk_idimovel___row__id = new THidden('imoveltur360_fk_idimovel___row__id[]');
        $imoveltur360_fk_idimovel___row__data = new THidden('imoveltur360_fk_idimovel___row__data[]');
        $imoveltur360_fk_idimovel_patch = new TEntry('imoveltur360_fk_idimovel_patch[]');
        $imoveltur360_fk_idimovel_legenda = new TEntry('imoveltur360_fk_idimovel_legenda[]');
        $this->fieldList_TurVirtual = new TFieldList();
        $lancamentoimg = new TImageCropper('lancamentoimg');
        $capaimg = new TImageCropper('capaimg');
        $divulgar = new TRadioGroup('divulgar');
        $exibevalorvenda = new TRadioGroup('exibevalorvenda');
        $exibealuguel = new TRadioGroup('exibealuguel');
        $exibelogradouro = new TRadioGroup('exibelogradouro');
        $lancamento = new TRadioGroup('lancamento');
        $proposta = new TRadioGroup('proposta');
        $etiquetanome = new TEntry('etiquetanome');
        $etiquetamodelo = new TCombo('etiquetamodelo');
        $labelnovalvalues = new TEntry('labelnovalvalues');
        $grupozap = new TRadioGroup('grupozap');
        $fk_idlisting_title = new TEntry('fk_idlisting_title');
        $fk_idlisting_zone = new TEntry('fk_idlisting_zone');
        $imovelweb = new TRadioGroup('imovelweb');
        $claviculario = new TEntry('claviculario');
        $button_3 = new TButton('button_3');
        $imovelretiradachave_fk_idimovel_idimovelretiradachave = new THidden('imovelretiradachave_fk_idimovel_idimovelretiradachave[]');
        $imovelretiradachave_fk_idimovel___row__id = new THidden('imovelretiradachave_fk_idimovel___row__id[]');
        $imovelretiradachave_fk_idimovel___row__data = new THidden('imovelretiradachave_fk_idimovel___row__data[]');
        $imovelretiradachave_fk_idimovel_idpessoa = new TDBUniqueSearch('imovelretiradachave_fk_idimovel_idpessoa[]', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoalead','pessoalead asc' , $criteria_imovelretiradachave_fk_idimovel_idpessoa );
        $imovelretiradachave_fk_idimovel_dtretirada = new TDateTime('imovelretiradachave_fk_idimovel_dtretirada[]');
        $imovelretiradachave_fk_idimovel_prazo = new TDateTime('imovelretiradachave_fk_idimovel_prazo[]');
        $imovelretiradachave_fk_idimovel_dtentrega = new TDateTime('imovelretiradachave_fk_idimovel_dtentrega[]');
        $this->fieldList_Emprestimo = new TFieldList();
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $button_visualizar = new TButton('button_visualizar');
        $button_assinatura_eletronica = new TButton('button_assinatura_eletronica');
        $html = new THtmlEditor('html');

        $this->fieldList_Proprietarios->addField(null, $imovelproprietario_fk_idimovel_idimovelproprietario, []);
        $this->fieldList_Proprietarios->addField(null, $imovelproprietario_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_Proprietarios->addField(null, $imovelproprietario_fk_idimovel___row__data, []);
        $this->fieldList_Proprietarios->addField(new TLabel("Pessoa", '#FF0000', '14px', null), $imovelproprietario_fk_idimovel_idpessoa, ['width' => '80%']);
        $this->fieldList_Proprietarios->addField(new TLabel("Fração Imobiliária (%)", '#FF0000', '14px', null), $imovelproprietario_fk_idimovel_fracao, ['width' => '20%','sum' => true]);

        $this->fieldList_Proprietarios->width = '100%';
        $this->fieldList_Proprietarios->setFieldPrefix('imovelproprietario_fk_idimovel');
        $this->fieldList_Proprietarios->name = 'fieldList_Proprietarios';

        $this->criteria_fieldList_Proprietarios = new TCriteria();
        $this->default_item_fieldList_Proprietarios = new stdClass();

        $this->fieldList_Proprietarios->addButtonAction(new TAction([$this, 'onNewPessoa']), 'fas:user-plus #607D8B', "Cadastra nova pessoa");

        $this->form->addField($imovelproprietario_fk_idimovel_idimovelproprietario);
        $this->form->addField($imovelproprietario_fk_idimovel___row__id);
        $this->form->addField($imovelproprietario_fk_idimovel___row__data);
        $this->form->addField($imovelproprietario_fk_idimovel_idpessoa);
        $this->form->addField($imovelproprietario_fk_idimovel_fracao);

        $this->fieldList_Proprietarios->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_Corretores->addField(null, $imovelcorretor_fk_idimovel_idimovelcorretor, []);
        $this->fieldList_Corretores->addField(null, $imovelcorretor_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_Corretores->addField(null, $imovelcorretor_fk_idimovel___row__data, []);
        $this->fieldList_Corretores->addField(new TLabel("Pessoa", null, '14px', null), $imovelcorretor_fk_idimovel_idcorretor, ['width' => '80%']);
        $this->fieldList_Corretores->addField(new TLabel("Divulgar no Site", null, '14px', null), $imovelcorretor_fk_idimovel_divulgarsite, ['width' => '20%']);

        $this->fieldList_Corretores->width = '100%';
        $this->fieldList_Corretores->setFieldPrefix('imovelcorretor_fk_idimovel');
        $this->fieldList_Corretores->name = 'fieldList_Corretores';

        $this->criteria_fieldList_Corretores = new TCriteria();
        $this->default_item_fieldList_Corretores = new stdClass();

        $this->form->addField($imovelcorretor_fk_idimovel_idimovelcorretor);
        $this->form->addField($imovelcorretor_fk_idimovel___row__id);
        $this->form->addField($imovelcorretor_fk_idimovel___row__data);
        $this->form->addField($imovelcorretor_fk_idimovel_idcorretor);
        $this->form->addField($imovelcorretor_fk_idimovel_divulgarsite);

        $this->fieldList_Corretores->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_Detalhamento->addField(null, $imoveldetalheitem_fk_idimovel_idimoveldetalheitem, []);
        $this->fieldList_Detalhamento->addField(null, $imoveldetalheitem_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_Detalhamento->addField(null, $imoveldetalheitem_fk_idimovel___row__data, []);
        $this->fieldList_Detalhamento->addField(new TLabel("Ambiente / Item", null, '14px', null), $imoveldetalheitem_fk_idimovel_idimoveldetalhe, ['width' => '80%']);
        $this->fieldList_Detalhamento->addField(new TLabel("Quantidade", null, '14px', null), $imoveldetalheitem_fk_idimovel_imoveldetalheitem, ['width' => '20%']);

        $this->fieldList_Detalhamento->width = '100%';
        $this->fieldList_Detalhamento->setFieldPrefix('imoveldetalheitem_fk_idimovel');
        $this->fieldList_Detalhamento->name = 'fieldList_Detalhamento';

        $this->criteria_fieldList_Detalhamento = new TCriteria();
        $this->default_item_fieldList_Detalhamento = new stdClass();

        $this->fieldList_Detalhamento->addButtonAction(new TAction([$this, 'onNewItem']), 'fas:bed #607D8B', "Cadastrar novo Ambiente/Item");

        $this->form->addField($imoveldetalheitem_fk_idimovel_idimoveldetalheitem);
        $this->form->addField($imoveldetalheitem_fk_idimovel___row__id);
        $this->form->addField($imoveldetalheitem_fk_idimovel___row__data);
        $this->form->addField($imoveldetalheitem_fk_idimovel_idimoveldetalhe);
        $this->form->addField($imoveldetalheitem_fk_idimovel_imoveldetalheitem);

        $this->fieldList_Detalhamento->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_Plantas->addField(null, $imovelplanta_fk_idimovel_idimovelplanta, []);
        $this->fieldList_Plantas->addField(null, $imovelplanta_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_Plantas->addField(null, $imovelplanta_fk_idimovel___row__data, []);
        $this->fieldList_Plantas->addField(new TLabel("Croqui", null, '14px', null), $imovelplanta_fk_idimovel_patch, ['width' => '50%']);
        $this->fieldList_Plantas->addField(new TLabel("Legenda", null, '14px', null), $imovelplanta_fk_idimovel_legenda, ['width' => '50%']);

        $this->fieldList_Plantas->width = '100%';
        $this->fieldList_Plantas->setFieldPrefix('imovelplanta_fk_idimovel');
        $this->fieldList_Plantas->name = 'fieldList_Plantas';

        $this->criteria_fieldList_Plantas = new TCriteria();
        $this->default_item_fieldList_Plantas = new stdClass();

        $this->form->addField($imovelplanta_fk_idimovel_idimovelplanta);
        $this->form->addField($imovelplanta_fk_idimovel___row__id);
        $this->form->addField($imovelplanta_fk_idimovel___row__data);
        $this->form->addField($imovelplanta_fk_idimovel_patch);
        $this->form->addField($imovelplanta_fk_idimovel_legenda);

        $this->fieldList_Plantas->enableSorting();

        $this->fieldList_Plantas->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_63f691a634fe0->addField(null, $imovelvideo_fk_idimovel_idimovelvideo, []);
        $this->fieldList_63f691a634fe0->addField(null, $imovelvideo_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_63f691a634fe0->addField(null, $imovelvideo_fk_idimovel___row__data, []);
        $this->fieldList_63f691a634fe0->addField(new TLabel("Endereço do Vídeo no <strong>Youtube</strong>", null, '14px', null), $imovelvideo_fk_idimovel_patch, ['width' => '50%']);
        $this->fieldList_63f691a634fe0->addField(new TLabel("Legenda", null, '14px', null), $imovelvideo_fk_idimovel_legenda, ['width' => '50%']);

        $this->fieldList_63f691a634fe0->width = '100%';
        $this->fieldList_63f691a634fe0->setFieldPrefix('imovelvideo_fk_idimovel');
        $this->fieldList_63f691a634fe0->name = 'fieldList_63f691a634fe0';

        $this->criteria_fieldList_63f691a634fe0 = new TCriteria();
        $this->default_item_fieldList_63f691a634fe0 = new stdClass();

        $this->form->addField($imovelvideo_fk_idimovel_idimovelvideo);
        $this->form->addField($imovelvideo_fk_idimovel___row__id);
        $this->form->addField($imovelvideo_fk_idimovel___row__data);
        $this->form->addField($imovelvideo_fk_idimovel_patch);
        $this->form->addField($imovelvideo_fk_idimovel_legenda);

        $this->fieldList_63f691a634fe0->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_TurVirtual->addField(null, $imoveltur360_fk_idimovel_idimoveltur360, []);
        $this->fieldList_TurVirtual->addField(null, $imoveltur360_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_TurVirtual->addField(null, $imoveltur360_fk_idimovel___row__data, []);
        $this->fieldList_TurVirtual->addField(new TLabel("Tour Virtual", null, '14px', null), $imoveltur360_fk_idimovel_patch, ['width' => '50%']);
        $this->fieldList_TurVirtual->addField(new TLabel("Legenda", null, '14px', null), $imoveltur360_fk_idimovel_legenda, ['width' => '20%']);

        $this->fieldList_TurVirtual->width = '100%';
        $this->fieldList_TurVirtual->setFieldPrefix('imoveltur360_fk_idimovel');
        $this->fieldList_TurVirtual->name = 'fieldList_TurVirtual';

        $this->criteria_fieldList_TurVirtual = new TCriteria();
        $this->default_item_fieldList_TurVirtual = new stdClass();

        $this->form->addField($imoveltur360_fk_idimovel_idimoveltur360);
        $this->form->addField($imoveltur360_fk_idimovel___row__id);
        $this->form->addField($imoveltur360_fk_idimovel___row__data);
        $this->form->addField($imoveltur360_fk_idimovel_patch);
        $this->form->addField($imoveltur360_fk_idimovel_legenda);

        $this->fieldList_TurVirtual->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldList_Emprestimo->addField(null, $imovelretiradachave_fk_idimovel_idimovelretiradachave, []);
        $this->fieldList_Emprestimo->addField(null, $imovelretiradachave_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_Emprestimo->addField(null, $imovelretiradachave_fk_idimovel___row__data, []);
        $this->fieldList_Emprestimo->addField(new TLabel("Pessoa", null, '14px', null), $imovelretiradachave_fk_idimovel_idpessoa, ['width' => '40%']);
        $this->fieldList_Emprestimo->addField(new TLabel("Retirada", null, '14px', null), $imovelretiradachave_fk_idimovel_dtretirada, ['width' => '20%']);
        $this->fieldList_Emprestimo->addField(new TLabel("Prazo", null, '14px', null), $imovelretiradachave_fk_idimovel_prazo, ['width' => '20%']);
        $this->fieldList_Emprestimo->addField(new TLabel("Entrega", null, '14px', null), $imovelretiradachave_fk_idimovel_dtentrega, ['width' => '20%']);

        $this->fieldList_Emprestimo->width = '100%';
        $this->fieldList_Emprestimo->setFieldPrefix('imovelretiradachave_fk_idimovel');
        $this->fieldList_Emprestimo->name = 'fieldList_Emprestimo';

        $this->criteria_fieldList_Emprestimo = new TCriteria();
        $this->default_item_fieldList_Emprestimo = new stdClass();

        $this->form->addField($imovelretiradachave_fk_idimovel_idimovelretiradachave);
        $this->form->addField($imovelretiradachave_fk_idimovel___row__id);
        $this->form->addField($imovelretiradachave_fk_idimovel___row__data);
        $this->form->addField($imovelretiradachave_fk_idimovel_idpessoa);
        $this->form->addField($imovelretiradachave_fk_idimovel_dtretirada);
        $this->form->addField($imovelretiradachave_fk_idimovel_prazo);
        $this->form->addField($imovelretiradachave_fk_idimovel_dtentrega);

        $this->fieldList_Emprestimo->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $imgs->setCompleteAction(new TAction([$this,'onShowUpload']));

        $logradouro->addValidation("Logradouro", new TRequiredValidator()); 
        $logradouronro->addValidation("Número do Imóvel", new TRequiredValidator()); 
        $perimetro->addValidation("Perimetro", new TRequiredValidator()); 
        $bairro->addValidation("Bairro", new TRequiredValidator()); 
        $idcidade->addValidation("Idcidade", new TRequiredValidator()); 
        $idimoveltipo->addValidation("Características->Perfil->Tipo", new TRequiredValidator()); 
        $idimovelmaterial->addValidation("Características->Perfil->Edificado em", new TRequiredValidator()); 
        $idimoveldestino->addValidation("Características->Perfil->Finalidade", new TRequiredValidator()); 
        $idimovelsituacao->addValidation("Características->Perfil->Situação", new TRequiredValidator()); 
        $imovelproprietario_fk_idimovel_fracao->addValidation("[Básico][Propriedade][Fração Imobiliáira]", new TRequiredListValidator()); 

        $imgs->enableImageGallery('150', NULL);
        $imovelplanta_fk_idimovel_patch->enableImageGallery('100', NULL);

        $capaimg->setWindowTitle("Foto de Capa");
        $lancamentoimg->setWindowTitle("Imagem de Lançamento");

        $capaimg->setCropSize('1200', '800');
        $lancamentoimg->setCropSize('1200', '800');

        $capaimg->setImagePlaceholder(new TImage("fas:file-upload #dde5ec"));
        $lancamentoimg->setImagePlaceholder(new TImage("fas:file-upload #dde5ec"));

        $perimetro->setDefaultOption(false);
        $marcadagua->setDefaultOption(false);
        $imovelcorretor_fk_idimovel_divulgarsite->setDefaultOption(false);

        $idtemplate->enableSearch();
        $idimoveldestino->enableSearch();
        $idimovelsituacao->enableSearch();

        $idimovel->setEditable(false);
        $createdat->setEditable(false);
        $updatedat->setEditable(false);
        $systemUser->setEditable(false);

        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Ficha</i> <br />Tabela: <i>Imóvel</i>");
        $obs->setTip("Considerações ou anotações. Também usado como Título em compartilhamentos de sites.");
        $caracteristicas->setTip("Qualidades ou atributos que permite identificar o imóvel, distinguindo-o dos seus semelhantes.");
        $mapa->setTip("<strong>Mapa</strong>: Usando Frame  (Recomendado: width=100% height=450)<br />OU <i>Latitude@Longitude</i>, com este formato.");

        $imgs->enableFileHandling();
        $capaimg->enableFileHandling();
        $lancamentoimg->enableFileHandling();
        $imovelplanta_fk_idimovel_patch->enableFileHandling();

        $capaimg->setAllowedExtensions(["jpg","jpeg","png"]);
        $imgs->setAllowedExtensions(["jpg","jpeg","webp","png"]);
        $lancamentoimg->setAllowedExtensions(["jpg","jpeg","png"]);
        $imovelplanta_fk_idimovel_patch->setAllowedExtensions(["jpg","jpeg","tiff","webp"]);

        $createdat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $updatedat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $imovelretiradachave_fk_idimovel_prazo->setDatabaseMask('yyyy-mm-dd hh:ii');
        $imovelretiradachave_fk_idimovel_dtentrega->setDatabaseMask('yyyy-mm-dd hh:ii');
        $imovelretiradachave_fk_idimovel_dtretirada->setDatabaseMask('yyyy-mm-dd hh:ii');

        $idcidade->setMinLength(0);
        $idimoveltipo->setMinLength(0);
        $idimovelmaterial->setMinLength(0);
        $imovelcorretor_fk_idimovel_idcorretor->setMinLength(0);
        $imovelproprietario_fk_idimovel_idpessoa->setMinLength(0);
        $imovelretiradachave_fk_idimovel_idpessoa->setMinLength(0);
        $imoveldetalheitem_fk_idimovel_idimoveldetalhe->setMinLength(0);

        $divulgar->setLayout('horizontal');
        $proposta->setLayout('horizontal');
        $grupozap->setLayout('horizontal');
        $imovelweb->setLayout('horizontal');
        $lancamento->setLayout('horizontal');
        $exibealuguel->setLayout('horizontal');
        $exibevalorvenda->setLayout('horizontal');
        $exibelogradouro->setLayout('horizontal');

        $divulgar->setBooleanMode();
        $proposta->setBooleanMode();
        $grupozap->setBooleanMode();
        $imovelweb->setBooleanMode();
        $lancamento->setBooleanMode();
        $exibealuguel->setBooleanMode();
        $exibevalorvenda->setBooleanMode();
        $exibelogradouro->setBooleanMode();

        $button_->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button_3->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $cidadeButton->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_1->setAction(new TAction(['ImovelTipoFormList', 'onShow']), "");
        $button_como_usar->setAction(new TAction([$this, 'onTutor']), "Como Usar");
        $button_2->setAction(new TAction(['ImovelMaterialFormList', 'onShow']), "");
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_visualizar->setAction(new TAction([$this, 'onPrint']), "Visualizar");
        $button_assinatura_eletronica->setAction(new TAction([$this, 'onToSign']), "Assinatura Eletrônica");
        $button_autocompletar_com_o_cep->setAction(new TAction([$this, 'onCEPSeek']), "Autocompletar com o CEP");
        $button_autocompletar_com_ia->setAction(new TAction([$this, 'onGeraCaracterstica']), "Autocompletar com IA");
        $button_buscar_pelo_endereco->setAction(new TAction(['ImovelCepSeekForm', 'onShow']), "Buscar pelo Endereço");

        $button_->addStyleClass('btn-default');
        $button_1->addStyleClass('btn-default');
        $button_2->addStyleClass('btn-default');
        $button_3->addStyleClass('btn-default');
        $cidadeButton->addStyleClass('btn-default');
        $button_como_usar->addStyleClass('btn-default');
        $button_preencher->addStyleClass('btn-default');
        $button_visualizar->addStyleClass('btn-default');
        $button_buscar_pelo_endereco->addStyleClass('btn-default');
        $button_autocompletar_com_ia->addStyleClass('btn-default');
        $button_assinatura_eletronica->addStyleClass('btn-default');
        $button_autocompletar_com_o_cep->addStyleClass('btn-success');

        $button_->setImage('fas:user-plus #2ECC71');
        $button_3->setImage('fas:user-plus #607D8B');
        $button_1->setImage('fas:plus-circle #2ECC71');
        $button_2->setImage('fas:plus-circle #2ECC71');
        $button_visualizar->setImage('fas:print #9400D3');
        $cidadeButton->setImage('fas:plus-circle #2ECC71');
        $button_como_usar->setImage('fab:youtube #EF4648');
        $button_preencher->setImage('fas:file-import #9400D3');
        $button_autocompletar_com_ia->setImage('fas:brain #9400D3');
        $button_assinatura_eletronica->setImage('fas:signature #9400D3');
        $button_buscar_pelo_endereco->setImage('fas:map-marker-alt #2ECC71');
        $button_autocompletar_com_o_cep->setImage('fas:map-marker-alt #FFFFFF');

        $divulgar->addItems(["1"=>"Sim","2"=>"Não"]);
        $proposta->addItems(["1"=>"Sim","2"=>"Não"]);
        $grupozap->addItems(["1"=>"Sim","2"=>"Não"]);
        $imovelweb->addItems(["1"=>"Sim","2"=>"Não"]);
        $marcadagua->addItems(["1"=>"Sim","0"=>"Não"]);
        $lancamento->addItems(["1"=>"Sim","2"=>"Não"]);
        $exibealuguel->addItems(["1"=>"Sim","2"=>"Não"]);
        $perimetro->addItems(["U"=>"Urbano","R"=>"Rural"]);
        $exibevalorvenda->addItems(["1"=>"Sim","2"=>"Não"]);
        $exibelogradouro->addItems(["1"=>"Sim","2"=>"Não"]);
        $imovelcorretor_fk_idimovel_divulgarsite->addItems(["0"=>"Não","1"=>"Sim"]);
        $etiquetamodelo->addItems(["1"=>"1 - Cor do Tema","2"=>"2 - Verde Claro","3"=>"3 - Verde Escuro","4"=>"4 - Vermelho"]);

        $cep->setMaxLength(10);
        $lote->setMaxLength(200);
        $setor->setMaxLength(200);
        $bairro->setMaxLength(200);
        $quadra->setMaxLength(200);
        $outrataxa->setMaxLength(100);
        $logradouro->setMaxLength(200);
        $complemento->setMaxLength(200);
        $claviculario->setMaxLength(10);
        $logradouronro->setMaxLength(10);
        $etiquetanome->setMaxLength(100);
        $imovelregistro->setMaxLength(200);
        $prefeituramatricula->setMaxLength(200);

        $perimetro->setValue('U');
        $marcadagua->setValue('1');
        $divulgar->setValue('true');
        $proposta->setValue('true');
        $exibealuguel->setValue('1');
        $grupozap->setValue('FALSE');
        $imovelweb->setValue('FALSE');
        $lancamento->setValue('false');
        $etiquetamodelo->setValue('1');
        $exibevalorvenda->setValue('1');
        $exibelogradouro->setValue('false');
        $labelnovalvalues->setValue('Consulte');
        $idtemplate->setValue($config->templateimovel);

        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $idimoveltipo->setMask('{imoveltipo}');
        $createdat->setMask('dd/mm/yyyy hh:ii:ss');
        $updatedat->setMask('dd/mm/yyyy hh:ii:ss');
        $idimovelmaterial->setMask('{imovelmaterial}');
        $imovelcorretor_fk_idimovel_idcorretor->setMask('{pessoalead}');
        $imoveldetalheitem_fk_idimovel_imoveldetalheitem->setMask('9!');
        $imoveldetalheitem_fk_idimovel_idimoveldetalhe->setMask('{family}');
        $imovelretiradachave_fk_idimovel_prazo->setMask('dd/mm/yyyy hh:ii');
        $imovelretiradachave_fk_idimovel_dtentrega->setMask('dd/mm/yyyy hh:ii');
        $imovelretiradachave_fk_idimovel_dtretirada->setMask('dd/mm/yyyy hh:ii');
        $imovelproprietario_fk_idimovel_idpessoa->setMask('({idpessoa}) {pessoalead}');
        $imovelretiradachave_fk_idimovel_idpessoa->setMask('{idpessoa} - {pessoalead}');

        $cep->setSize(210);
        $area->setSize('100%');
        $iptu->setSize('100%');
        $lote->setSize('100%');
        $imgs->setSize('100%');
        $divulgar->setSize(80);
        $proposta->setSize(80);
        $grupozap->setSize(80);
        $venda->setSize('100%');
        $setor->setSize('100%');
        $imovelweb->setSize(80);
        $bairro->setSize('100%');
        $quadra->setSize('100%');
        $lancamento->setSize(80);
        $aluguel->setSize('100%');
        $marcadagua->setSize(150);
        $idimovel->setSize('100%');
        $obs->setSize('100%', 170);
        $exibealuguel->setSize(80);
        $perimetro->setSize('100%');
        $mapa->setSize('100%', 110);
        $createdat->setSize('100%');
        $updatedat->setSize('100%');
        $outrataxa->setSize('100%');
        $html->setSize('100%', 550);
        $logradouro->setSize('100%');
        $systemUser->setSize('100%');
        $condominio->setSize('100%');
        $complemento->setSize('100%');
        $capaimg->setSize('100%', 80);
        $exibevalorvenda->setSize(80);
        $exibelogradouro->setSize(80);
        $etiquetanome->setSize('100%');
        $claviculario->setSize('100%');
        $logradouronro->setSize('100%');
        $outrataxavalor->setSize('100%');
        $imovelregistro->setSize('100%');
        $etiquetamodelo->setSize('100%');
        $idimoveldestino->setSize('100%');
        $idimovelsituacao->setSize('100%');
        $labelnovalvalues->setSize('100%');
        $lancamentoimg->setSize('100%', 80);
        $fk_idlisting_zone->setSize('100%');
        $fk_idlisting_title->setSize('100%');
        $prefeituramatricula->setSize('100%');
        $caracteristicas->setSize('100%', 150);
        $idcidade->setSize('calc(100% - 60px)');
        $idtemplate->setSize('calc(100% - 480px)');
        $idimoveltipo->setSize('calc(100% - 50px)');
        $idimovelmaterial->setSize('calc(100% - 50px)');
        $imovelvideo_fk_idimovel_patch->setSize('100%');
        $imovelplanta_fk_idimovel_patch->setSize('100%');
        $imoveltur360_fk_idimovel_patch->setSize('100%');
        $imovelvideo_fk_idimovel_legenda->setSize('100%');
        $imovelplanta_fk_idimovel_legenda->setSize('100%');
        $imoveltur360_fk_idimovel_legenda->setSize('100%');
        $imovelproprietario_fk_idimovel_fracao->setSize('100%');
        $imovelcorretor_fk_idimovel_idcorretor->setSize('100%');
        $imovelretiradachave_fk_idimovel_prazo->setSize('100%');
        $imovelproprietario_fk_idimovel_idpessoa->setSize('100%');
        $imovelcorretor_fk_idimovel_divulgarsite->setSize('100%');
        $imovelretiradachave_fk_idimovel_idpessoa->setSize('100%');
        $imovelretiradachave_fk_idimovel_dtentrega->setSize('100%');
        $imovelretiradachave_fk_idimovel_dtretirada->setSize('100%');
        $imoveldetalheitem_fk_idimovel_idimoveldetalhe->setSize('100%');
        $imoveldetalheitem_fk_idimovel_imoveldetalheitem->setSize('100%');

        $imovelproprietario_fk_idimovel_fracao->placeholder = "100";

        // $imgs->enablePopover('Preview', '<img style="max-width:150px" src="download.php?file={file_name}">');
        $imgs->enablePopover('Preview', '<img width="500px" src="download.php?file={file_name}">');

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Básico");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $tab_63f62dcd34fac = new BootstrapFormBuilder('tab_63f62dcd34fac');
        $this->tab_63f62dcd34fac = $tab_63f62dcd34fac;
        $tab_63f62dcd34fac->setProperty('style', 'border:none; box-shadow:none;');

        $tab_63f62dcd34fac->appendPage("<span style=\"color: #ff0000;\">*</span>Gerais");

        $tab_63f62dcd34fac->addFields([new THidden('current_tab_tab_63f62dcd34fac')]);
        $tab_63f62dcd34fac->setTabFunction("$('[name=current_tab_tab_63f62dcd34fac]').val($(this).attr('data-current_page'));");

        $row1 = $tab_63f62dcd34fac->addFields([new TLabel("Imóvel:", null, '14px', null, '100%'),$idimovel],[new TLabel("CEP:", null, '14px', null, '100%'),$button_buscar_pelo_endereco,$cep,$button_autocompletar_com_o_cep]);
        $row1->layout = ['col-sm-3',' col-sm-9'];

        $row2 = $tab_63f62dcd34fac->addFields([new TLabel("Endereço:", '#ff0000', '14px', null, '100%'),$logradouro],[new TLabel("Número:", '#FF0000', '14px', null, '100%'),$logradouronro],[new TLabel("Complemento:", null, '14px', null, '100%'),$complemento],[new TLabel("Perímetro:", null, '14px', null, '100%'),$perimetro]);
        $row2->layout = ['col-sm-4','col-sm-2',' col-sm-4','col-sm-2'];

        $row3 = $tab_63f62dcd34fac->addFields([new TLabel("Bairro:", '#ff0000', '14px', null, '100%'),$bairro],[new TLabel("Cidade/Estado:", '#ff0000', '14px', null, '100%'),$idcidade,$cidadeButton],[new TLabel("Área (m<sup>2</sup> / Ha):", null, '14px', null, '100%'),$area]);
        $row3->layout = [' col-sm-5',' col-sm-5','col-sm-2'];

        $bcontainer_657d284946377 = new BootstrapFormBuilder('bcontainer_657d284946377');
        $this->bcontainer_657d284946377 = $bcontainer_657d284946377;
        $bcontainer_657d284946377->setProperty('style', 'border:none; box-shadow:none;');
        $row4 = $bcontainer_657d284946377->addFields([new TLabel("Dt. Inclusão:", null, '14px', null, '100%'),$createdat],[new TLabel("Dt. Atualização:", null, '14px', null, '100%'),$updatedat]);
        $row4->layout = [' col-sm-6',' col-sm-6'];

        $row5 = $bcontainer_657d284946377->addFields([new TLabel("Usuário Responsável:", null, '14px', null),$systemUser]);
        $row5->layout = [' col-sm-12'];

        $row6 = $tab_63f62dcd34fac->addFields([new TLabel("Localização:<font size=\"-3\"><i><u> google maps</u></i></font>", null, '14px', null),$button_como_usar,$mapa],[$bcontainer_657d284946377]);
        $row6->layout = [' col-sm-7',' col-sm-5'];

        $tab_63f62dcd34fac->appendPage("<span style=\"color: #ff0000;\">*</span>Propriedade");
        $row7 = $tab_63f62dcd34fac->addFields([new TLabel("Proprietário(s) <hr>", null, '18px', 'B')]);
        $row7->layout = [' col-sm-12'];

        $row8 = $tab_63f62dcd34fac->addFields([$this->fieldList_Proprietarios]);
        $row8->layout = [' col-sm-12'];

        $tab_63f62dcd34fac->appendPage("Valores");
        $row9 = $tab_63f62dcd34fac->addFields([new TLabel("Aluguel:", null, '14px', null, '100%'),$aluguel],[new TLabel("Venda:", null, '14px', null, '100%'),$venda],[new TLabel("Iptu:", null, '14px', null, '100%'),$iptu],[new TLabel("Condominio:", null, '14px', null, '100%'),$condominio]);
        $row9->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row10 = $tab_63f62dcd34fac->addFields([new TLabel("Outras Taxas (Descrição):", null, '14px', null, '100%'),$outrataxa],[new TLabel("Outras Taxas (Valor):", null, '14px', null, '100%'),$outrataxavalor]);
        $row10->layout = [' col-sm-3',' col-sm-3'];

        $tab_63f62dcd34fac->appendPage("Autencidade");
        $row11 = $tab_63f62dcd34fac->addFields([new TLabel("Registro:", null, '14px', null, '100%'),$imovelregistro],[new TLabel("Matricula:", null, '14px', null, '100%'),$prefeituramatricula],[new TLabel("Setor:", null, '14px', null, '100%'),$setor],[new TLabel("Quadra:", null, '14px', null, '100%'),$quadra],[new TLabel("Lote:", null, '14px', null, '100%'),$lote]);
        $row11->layout = [' col-sm-3',' col-sm-3',' col-sm-2',' col-sm-2',' col-sm-2'];

        $tab_63f62dcd34fac->appendPage("Corretor(es)");
        $row12 = $tab_63f62dcd34fac->addFields([new TLabel("Corretores <hr>", null, '18px', 'B'),$button_]);
        $row12->layout = ['col-sm-6'];

        $row13 = $tab_63f62dcd34fac->addFields([$this->fieldList_Corretores]);
        $row13->layout = [' col-sm-11'];

        $row14 = $this->form->addFields([$tab_63f62dcd34fac]);
        $row14->layout = ['col-sm-12'];

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Características");

        $detalhesitens = new BootstrapFormBuilder('detalhesitens');
        $this->detalhesitens = $detalhesitens;
        $detalhesitens->setProperty('style', 'border:none; box-shadow:none;');

        $detalhesitens->appendPage("<span style=\"color: #ff0000;\">*</span>Perfil");

        $detalhesitens->addFields([new THidden('current_tab_detalhesitens')]);
        $detalhesitens->setTabFunction("$('[name=current_tab_detalhesitens]').val($(this).attr('data-current_page'));");

        $row15 = $detalhesitens->addFields([new TLabel("Tipo:", '#ff0000', '14px', null, '100%'),$idimoveltipo,$button_1],[new TLabel("Edificado em:", '#ff0000', '14px', null, '100%'),$idimovelmaterial,$button_2],[new TLabel("Finalidade:", '#ff0000', '14px', null, '100%'),$idimoveldestino],[new TLabel("Situação:", '#ff0000', '14px', null, '100%'),$idimovelsituacao]);
        $row15->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row16 = $detalhesitens->addFields([new TLabel("Características:", null, '14px', null, '100%'),$caracteristicas,$button_autocompletar_com_ia],[new TLabel("Título/Observações:", null, '14px', null, '100%'),$obs]);
        $row16->layout = ['col-sm-6','col-sm-6'];

        $detalhesitens->appendPage("Detalhes Itens");
        $row17 = $detalhesitens->addFields([$this->fieldList_Detalhamento]);
        $row17->layout = [' col-sm-12'];

        $row18 = $this->form->addFields([$detalhesitens]);
        $row18->layout = ['col-sm-12'];

        $this->form->appendPage("Imagens");

        $tab_galeria = new BootstrapFormBuilder('tab_galeria');
        $this->tab_galeria = $tab_galeria;
        $tab_galeria->setProperty('style', 'border:none; box-shadow:none;');

        $tab_galeria->appendPage("Álbum Fotos");

        $tab_galeria->addFields([new THidden('current_tab_tab_galeria')]);
        $tab_galeria->setTabFunction("$('[name=current_tab_tab_galeria]').val($(this).attr('data-current_page'));");

        $row19 = $tab_galeria->addFields([new TLabel("Inserir Marca D'água:", '#3F51B5', '14px', 'B'),$marcadagua]);
        $row19->layout = [' col-sm-6'];

        $row20 = $tab_galeria->addFields([$imgs]);
        $row20->layout = [' col-sm-12'];

        $tab_galeria->appendPage("Plantas");
        $row21 = $tab_galeria->addFields([$this->fieldList_Plantas]);
        $row21->layout = [' col-sm-12'];

        $tab_galeria->appendPage("Youtube");
        $row22 = $tab_galeria->addFields([$this->fieldList_63f691a634fe0]);
        $row22->layout = [' col-sm-12'];

        $tab_galeria->appendPage("Tur 360");
        $row23 = $tab_galeria->addFields([$this->fieldList_TurVirtual]);
        $row23->layout = [' col-sm-12'];

        $tab_galeria->appendPage("Destaques");
        $row24 = $tab_galeria->addFields([new TLabel("Imagem de Lançamento:", null, '14px', null, '100%'),$lancamentoimg],[new TLabel("Foto de Capa:", null, '14px', null, '100%'),$capaimg]);
        $row24->layout = [' col-sm-6',' col-sm-6'];

        $row25 = $this->form->addFields([$tab_galeria]);
        $row25->layout = [' col-sm-12'];

        $this->form->appendPage("Site");

        $tab_portais = new BootstrapFormBuilder('tab_portais');
        $this->tab_portais = $tab_portais;
        $tab_portais->setProperty('style', 'border:none; box-shadow:none;');

        $tab_portais->appendPage("Seu Site");

        $tab_portais->addFields([new THidden('current_tab_tab_portais')]);
        $tab_portais->setTabFunction("$('[name=current_tab_tab_portais]').val($(this).attr('data-current_page'));");

        $row26 = $tab_portais->addFields([new TLabel("Mostrar Imóvel no Site:", null, '14px', null, '100%'),$divulgar],[new TLabel("Exibe R$ Venda:", null, '14px', null, '100%'),$exibevalorvenda],[new TLabel("Exibe R$ Aluguel:", null, '14px', null, '100%'),$exibealuguel],[new TLabel("Exibe Endereço:", null, '14px', null, '100%'),$exibelogradouro],[new TLabel("É Lancamento:", null, '14px', null, '100%'),$lancamento],[new TLabel("Aceita Proposta:", null, '14px', null, '100%'),$proposta]);
        $row26->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2',' col-sm-2',' col-sm-2'];

        $row27 = $tab_portais->addFields([new TLabel("Etiqueta de Destaque:", null, '14px', null, '100%'),$etiquetanome],[new TLabel("Cor da Etiqueta de Destaque:", null, '14px', null, '100%'),$etiquetamodelo],[new TLabel("Etiqueta Quando Sem Nome:", null, '14px', null, '100%'),$labelnovalvalues]);
        $row27->layout = ['col-sm-4','col-sm-4',' col-sm-4'];

        $tab_portais->appendPage("Grupo Zap");
        $row28 = $tab_portais->addFields([new TLabel("Publicar No Grupo Zap?:", null, '14px', null, '100%'),$grupozap],[new TLabel("Título:", null, '14px', null),$fk_idlisting_title],[new TLabel("Zona:", null, '14px', null),$fk_idlisting_zone]);
        $row28->layout = [' col-sm-3',' col-sm-4',' col-sm-5'];

        $tab_portais->appendPage("Imovelweb");
        $row29 = $tab_portais->addFields([new TLabel("Rótulo:", null, '14px', null)],[]);
        $row30 = $tab_portais->addFields([new TLabel("Publicar No Imovelweb?:", null, '14px', null, '100%'),$imovelweb]);
        $row30->layout = ['col-sm-6'];

        $row31 = $this->form->addFields([$tab_portais]);
        $row31->layout = ['col-sm-12'];

        $this->form->appendPage("Chaves");
        $row32 = $this->form->addFields([new TLabel("Identificação no Claviculário:", null, '14px', null, '100%'),$claviculario]);
        $row32->layout = [' col-sm-4'];

        $row33 = $this->form->addFields([new TLabel("Tomadores <hr>", null, '18px', 'B'),$button_3,new TLabel("nova pessoa", null, '12px', null)]);
        $row33->layout = ['col-sm-6'];

        $row34 = $this->form->addFields([$this->fieldList_Emprestimo]);
        $row34->layout = [' col-sm-12'];

        $this->form->appendPage("Impressão");
        $row35 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate,$button_preencher,$button_visualizar,$button_assinatura_eletronica]);
        $row35->layout = [' col-sm-12'];

        $row36 = $this->form->addFields([$html]);
        $row36->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ImovelList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Cadastros","Imovel"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onNewPessoa($param = null) 
    {
        try 
        {
            new TQuestion("A Pessoa não foi encontrada na Lista?<br /> Deseja cadastrar uma nova pessoa?", new TAction([__CLASS__, 'onPessoaYes'], $param), new TAction([__CLASS__, 'onPessoaNo'], $param));

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onNewItem($param = null) 
    {
        try 
        {
            //code here
            // Código gerado pelo snippet: "Questionamento"
        new TQuestion("Não encontrou o item na Lista?<br />Deseja cadastrar novo ambiente?", new TAction([__CLASS__, 'onItemYes'], $param), new TAction([__CLASS__, 'onItemNo'], $param));
        // -----

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onShowUpload($param = null) 
    {
        try 
        {
            //code here
            TToast::show("success", "Imagem Carregada!", "topRight", "fas:fa-image");

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
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            if(!$param['cep'])
            {
                throw new Exception('Por favor, informe o CEP!');   
            }

            if( strlen($param['cep']) !== 10 )
            {
                throw new Exception('CEP Inválido!');   
            }

            TTransaction::open(self::$database); // open a transaction
            $object = new Imovel($param['idimovel']);

            $cep = Uteis::soNumero($param['cep']);
            $ini = parse_ini_file('app/config/application.ini');

            $url = "https://viacep.com.br/ws/{$cep}/json/";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if(isset($response->erro))
                throw new Exception('O CEP não foi encontrado!');

            Cidade::getValidaCidade($response); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', '=', $response->localidade)->first();

            $object->logradouro     = $response->logradouro;
            $object->bairro        = $response->bairro;
            $object->cep           = Uteis::mask(Uteis::soNumero($response->cep),'##.###-###');
            $object->complement    = $response->complemento;
            $object->idcidade      = $cidade->idcidade;

            TForm::sendData(self::$formName, $object);

            TToast::show("info", "O Endereço, o bairro e a cidade foram autopreenchidos, complete o cadastro.", "topRight", "fas:pencil-ruler");

            // TForm::sendData(self::$formName, (object)['idimovel' => $object->idimovel]);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onTutor($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);
            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/adQkVc7Lqoo";
            $iframe->frameborder = "0";
            $iframe->scrolling = "yes";
            $iframe->width = "100%";
            $iframe->height = "600px";

            $window->add($iframe);
            $window->show();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onGeraCaracterstica($param = null) 
    {
        try 
        {
            //code here
            if($param['idimovel'] == '')
            {
                throw new Exception('Salve o Imóvel antes de usar esta opção!');
            }

            TTransaction::open(self::$database);
            $openaiservice = new OpenAIService;
            $caracteristicas = $openaiservice->geraResposta( ['activerecord' => 'Imovelfull', 'key' => $param['idimovel'], 'assunto' => 7, 'comentarios' => $param['caracteristicas'] ]);
            $object = new stdClass();
            $object->caracteristicas = $caracteristicas; //nl2br($consenso);
            TForm::sendData(self::$formName, $object);

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $template = new Templatefull($param['idtemplate']);
            $html = TulpaTranslator::Translator($template->view, $param['idimovel'], $template->template); 
            $obj = new StdClass;
            $obj->html = $html;
            TForm::sendData(self::$formName, $obj);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPrint($param = null) 
    {
        try 
        {
            //code here
            $html = $param['html'];
            // $dompdf = new \Dompdf\Dompdf();
            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Impressão de Documento - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            TForm::sendData(self::$formName, $param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToSign($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            if (strlen($param['html']) < 100 )
               throw new Exception('O documento a ser enviado é Inválido!');

            $franquia = Documento::getDocumentoFranquia();
            if($franquia['franquia'] > 0)
            {
                if($franquia['franquia'] <= $franquia['consumo'])
                {
                    new TMessage('info', "Franquia expirada. Essa operação pode gerar custos.");
                }
            } // if($franquia['franquia'] > 0)

            $html = $param['html'];

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idimovel'], 'pdf' => $pdf, 'data' =>'imovel' ]);
            TForm::sendData(self::$formName, $param);
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
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $messageAction = null;
            $mesnagem = "Registro salvo";

            global $fracao; // verifica a fração imobiliária dos proprietários

            $this->fracao = 0;

            $this->form->validate(); // validate form data

            if(count(array_unique($param['imoveldetalheitem_fk_idimovel_idimoveldetalhe'])) < count($param['imoveldetalheitem_fk_idimovel_idimoveldetalhe']))
            {
                throw new Exception('Há duplicidade de Ambientes/Itens no Detalhamento deste Imóvel. Verifique [<strong>*Caracteríticas</strong>] [<strong>Detalhes Itens</strong>].');  
            }

            $object = new Imovel(); // create an empty object 

            $config = new Config(1);

            if($param['imgs'])
            {
                if ($config->imagens >= 1000 )
                {
                    if ($config->countImg > $config->imagens)
                    {
                        throw new Exception("Seu limite de <i>upload</i> de imagens foi atingido!<br />Atual: {$config->countImg}");
                    }
                }

                if( count($param['imgs']) > $config->imagens )
                {
                    $mesnagem = "Registro salvo, porém o número excessivo de imagens deste imóvel poderá prejudicar a velocidade e a usabilidade do seu site, resultando em uma experiência insatisfatória para os visitantes.<br />Recomendado: <b>{$config->imagens} imagens.</b>";
                    // TToast::show("warning", $mesnagem, "center", "fas:exclamation-triangle");
                }
            } // if($param['imgs'])

            if($param['idimovel'])
            {
                Imoveldetalheitem::where('idimovel', '=', $param['idimovel'])->delete();
            }

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data

            $new = $object->idimovel > 0 ? false : true;

            $object->idsystemuser = TSession::getValue('userid');

            $lancamentoimg_dir = 'files/images/';
            $capaimg_dir = 'files/images/';
            $imgs_dir = 'files/images/';
            $imovelplanta_fk_idimovel_patch_dir = 'files/images/';  

            $lancamentoimg_dir                  .=  $this->unidadeNome .'/lancamento/';
            $capaimg_dir                        .=  $this->unidadeNome .'/capa/';
            $imovelplanta_fk_idimovel_patch_dir .=  $this->unidadeNome .'/planta/';
            $imgs_dir .=  $this->unidadeNome .'/album/';
            if( !is_dir($imgs_dir) ) { mkdir($imgs_dir, 0777, true); }

            $object->store(); // save the object 

            // $lbl_idimovel = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);

            // aqui tratar a franquia de imóveis

            if(isset($data->imgs) )
            {
                $trataimagem = new TrataImagemService;

                $trataimagem_data = new stdClass();
                $trataimagem_data->activerecord  = 'Imovelalbum';
                $trataimagem_data->pk            = 'idimovelalbum';
                $trataimagem_data->idmaster      = $object->idimovel;
                $trataimagem_data->images        = $data->imgs;
                $trataimagem_data->imgs_dir      = $imgs_dir;
                $trataimagem_data->resizewidht   = 700;
                $trataimagem_data->resizehight   = '';
                $trataimagem_data->resizequality = 70;
                $trataimagem_data->marcadagua    = $data->marcadagua == 1 ? true : false;

                $files_imgs = $trataimagem->saveImages($trataimagem_data);
            }

            $this->saveFile($object, $data, 'lancamentoimg', $lancamentoimg_dir);
            $this->saveFile($object, $data, 'capaimg', $capaimg_dir);

/*

            $this->saveFile($object, $data, 'lancamentoimg', $lancamentoimg_dir);
            $this->saveFile($object, $data, 'capaimg', $capaimg_dir);
            $files_imgs = $this->saveFiles($object, $data, 'imgs', $imgs_dir, 'Imovelalbum', 'patch', 'idimovel'); 

*/

            $imovelproprietario_fk_idimovel_items = $this->storeItems('Imovelproprietario', 'idimovel', $object, $this->fieldList_Proprietarios, function($masterObject, $detailObject){ 

                $this->fracao += $detailObject->fracao;

            }, $this->criteria_fieldList_Proprietarios); 

            if( ($this->fracao < 99.5 ) OR ($this->fracao > 100) )
            {
                throw new Exception('[Básico][Propriedade][Fração Imobiliáira] tem de fechar em 100%.');   
            }

            $imovelretiradachave_fk_idimovel_items = $this->storeItems('Imovelretiradachave', 'idimovel', $object, $this->fieldList_Emprestimo, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_Emprestimo); 

            $imoveltur360_fk_idimovel_items = $this->storeItems('Imoveltur360', 'idimovel', $object, $this->fieldList_TurVirtual, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_TurVirtual); 

            $imovelvideo_fk_idimovel_items = $this->storeItems('Imovelvideo', 'idimovel', $object, $this->fieldList_63f691a634fe0, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_63f691a634fe0); 

            $imovelplanta_fk_idimovel_items = $this->storeItems('Imovelplanta', 'idimovel', $object, $this->fieldList_Plantas, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_Plantas); 
            if(!empty($imovelplanta_fk_idimovel_items))
            {
                foreach ($imovelplanta_fk_idimovel_items as $item)
                {
                    $dataFile = new stdClass();
                    $dataFile->patch = $item->patch;
                    $this->saveFile($item, $dataFile, 'patch', $imovelplanta_fk_idimovel_patch_dir);
                }
            }

            $imovelcorretor_fk_idimovel_items = $this->storeItems('Imovelcorretor', 'idimovel', $object, $this->fieldList_Corretores, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldList_Corretores); 

            $imoveldetalheitem_fk_idimovel_items = $this->storeItems('Imoveldetalheitem', 'idimovel', $object, $this->fieldList_Detalhamento, function($masterObject, $detailObject){ 

                //code here
                // echo '<pre>' ; print_r($detailObject);echo '</pre>'; exit();

                $detailObject->imoveldetalheitem = $detailObject->imoveldetalheitem == '' ? 1 : $detailObject->imoveldetalheitem;

            }, $this->criteria_fieldList_Detalhamento); 

            // get the generated {PRIMARY_KEY}
            $data->idimovel = $object->idimovel; 

            $lblidimovel = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);
            $data->idimovel = $lblidimovel;
            $this->form->setFormTitle("Imóvel - {$lblidimovel}");
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            if ($new)
            {
                TScript::create('$(`.nav-item a:contains(Imagens)`).closest("li").show();');
            }

/*

            new TMessage('info', "Registro salvo", $messageAction); 

*/

            new TMessage('info', $mesnagem, $messageAction);

            TForm::sendData(self::$formName, (object)['idimovel' => $object->idimovel]);

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

                $object = new Imovel($key); // instantiates the Active Record 

                $lbl_idimovel = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);
                $object->idimovel = $lbl_idimovel;
                // $object->systemuser = ;
                $this->form->setFormTitle("Imóvel - {$lbl_idimovel}");

/* Comentado apra o sistema não realizar 2 x a mesma ação
                                $object->imgs  = Imovelalbum::where('idimovel', '=', $object->idimovel)->getIndexedArray('idimovelalbum','patch');
                $object->fk_idlisting_title = $object->fk_idlisting->title;
                $object->fk_idlisting_zone = $object->fk_idlisting->zone;

*/

                $object->imgs  = Imovelalbum::where('idimovel', '=', $object->idimovel)->orderBy('orderby')->getIndexedArray('idimovelalbum','patch');
                $object->fk_idlisting_title = $object->fk_idlisting->title;
                $object->fk_idlisting_zone = $object->fk_idlisting->zone;                 

                $this->fieldList_Proprietarios_items = $this->loadItems('Imovelproprietario', 'idimovel', $object, $this->fieldList_Proprietarios, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_Proprietarios); 

                $this->fieldList_Emprestimo_items = $this->loadItems('Imovelretiradachave', 'idimovel', $object, $this->fieldList_Emprestimo, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_Emprestimo); 

                $this->fieldList_TurVirtual_items = $this->loadItems('Imoveltur360', 'idimovel', $object, $this->fieldList_TurVirtual, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_TurVirtual); 

                $this->fieldList_63f691a634fe0_items = $this->loadItems('Imovelvideo', 'idimovel', $object, $this->fieldList_63f691a634fe0, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_63f691a634fe0); 

                $this->fieldList_Plantas_items = $this->loadItems('Imovelplanta', 'idimovel', $object, $this->fieldList_Plantas, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_Plantas); 

                $this->fieldList_Corretores_items = $this->loadItems('Imovelcorretor', 'idimovel', $object, $this->fieldList_Corretores, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_Corretores); 

                $this->fieldList_Detalhamento_items = $this->loadItems('Imoveldetalheitem', 'idimovel', $object, $this->fieldList_Detalhamento, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_Detalhamento); 

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

        $this->fieldList_Proprietarios->addHeader();
        $this->fieldList_Proprietarios->addDetail($this->default_item_fieldList_Proprietarios);

        $this->fieldList_Proprietarios->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Corretores->addHeader();
        $this->fieldList_Corretores->addDetail($this->default_item_fieldList_Corretores);

        $this->fieldList_Corretores->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Detalhamento->addHeader();
        $this->fieldList_Detalhamento->addDetail($this->default_item_fieldList_Detalhamento);

        $this->fieldList_Detalhamento->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Plantas->addHeader();
        $this->fieldList_Plantas->addDetail($this->default_item_fieldList_Plantas);

        $this->fieldList_Plantas->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_63f691a634fe0->addHeader();
        $this->fieldList_63f691a634fe0->addDetail($this->default_item_fieldList_63f691a634fe0);

        $this->fieldList_63f691a634fe0->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_TurVirtual->addHeader();
        $this->fieldList_TurVirtual->addDetail($this->default_item_fieldList_TurVirtual);

        $this->fieldList_TurVirtual->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Emprestimo->addHeader();
        $this->fieldList_Emprestimo->addDetail($this->default_item_fieldList_Emprestimo);

        $this->fieldList_Emprestimo->addCloneAction(null, 'fas:plus #28A745', "Clonar");

TScript::create('$(`.nav-item a:contains(Imagens)`).closest("li").hide();');

    }

    public function onShow($param = null)
    {
        $this->fieldList_Proprietarios->addHeader();
        $this->fieldList_Proprietarios->addDetail($this->default_item_fieldList_Proprietarios);

        $this->fieldList_Proprietarios->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Corretores->addHeader();
        $this->fieldList_Corretores->addDetail($this->default_item_fieldList_Corretores);

        $this->fieldList_Corretores->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Detalhamento->addHeader();
        $this->fieldList_Detalhamento->addDetail($this->default_item_fieldList_Detalhamento);

        $this->fieldList_Detalhamento->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Plantas->addHeader();
        $this->fieldList_Plantas->addDetail($this->default_item_fieldList_Plantas);

        $this->fieldList_Plantas->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_63f691a634fe0->addHeader();
        $this->fieldList_63f691a634fe0->addDetail($this->default_item_fieldList_63f691a634fe0);

        $this->fieldList_63f691a634fe0->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_TurVirtual->addHeader();
        $this->fieldList_TurVirtual->addDetail($this->default_item_fieldList_TurVirtual);

        $this->fieldList_TurVirtual->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        $this->fieldList_Emprestimo->addHeader();
        $this->fieldList_Emprestimo->addDetail($this->default_item_fieldList_Emprestimo);

        $this->fieldList_Emprestimo->addCloneAction(null, 'fas:plus #28A745', "Clonar");

TScript::create('$(`.nav-item a:contains(Imagens)`).closest("li").hide();');

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onPessoaYes($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('PessoaForm', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPessoaNo($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('PessoaForm', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onItemYes($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('ImovelDetalheFormList', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onItemNo($param = null) 
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

}


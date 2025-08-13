<?php

class SiteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Site';
    private static $primaryKey = 'idsite';
    private static $formName = 'form_SiteForm';

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
        $this->form->setFormTitle("Cadastro de site");

        $criteria_idsitetemplate = new TCriteria();
        $criteria_sitesecaotitulo_fk_idsite_idsitesecao = new TCriteria();

        $idsite = new TEntry('idsite');
        $domain = new TEntry('domain');
        $startdate = new TDate('startdate');
        $enddate = new TDate('enddate');
        $patchphotos = new TEntry('patchphotos');
        $idanalityc = new TEntry('idanalityc');
        $apikeygooglemaps = new TEntry('apikeygooglemaps');
        $sitekeyemail = new TEntry('sitekeyemail');
        $keysecretemail = new TEntry('keysecretemail');
        $active = new TRadioGroup('active');
        $customerbutton = new TRadioGroup('customerbutton');
        $title = new TEntry('title');
        $description = new TText('description');
        $keywords = new TEntry('keywords');
        $collordefault = new TColor('collordefault');
        $collordefaulttext = new TColor('collordefaulttext');
        $mission = new TEntry('mission');
        $siteheadtext_fk_idsite_idsiteheadtext = new THidden('siteheadtext_fk_idsite_idsiteheadtext[]');
        $siteheadtext_fk_idsite___row__id = new THidden('siteheadtext_fk_idsite___row__id[]');
        $siteheadtext_fk_idsite___row__data = new THidden('siteheadtext_fk_idsite___row__data[]');
        $siteheadtext_fk_idsite_siteheadtext = new TEntry('siteheadtext_fk_idsite_siteheadtext[]');
        $siteheadtext_fk_idsite_templatesection = new TCombo('siteheadtext_fk_idsite_templatesection[]');
        $this->fieldListhHeads = new TFieldList();
        $endereco = new TText('endereco');
        $telefone = new TText('telefone');
        $msgcookies = new TText('msgcookies');
        $rodape = new TText('rodape');
        $about = new THtmlEditor('about');
        $textsectionmain = new THtmlEditor('textsectionmain');
        $facebook = new TEntry('facebook');
        $instagran = new TEntry('instagran');
        $telegram = new TEntry('telegram');
        $youtube = new TEntry('youtube');
        $whatsapp = new TEntry('whatsapp');
        $whatsappphone = new TEntry('whatsappphone');
        $iframe = new TText('iframe');
        $siteslide_fk_idsite_idsiteslide = new THidden('siteslide_fk_idsite_idsiteslide[]');
        $siteslide_fk_idsite___row__id = new THidden('siteslide_fk_idsite___row__id[]');
        $siteslide_fk_idsite___row__data = new THidden('siteslide_fk_idsite___row__data[]');
        $siteslide_fk_idsite_siteslide = new TFile('siteslide_fk_idsite_siteslide[]');
        $siteslide_fk_idsite_templatesection = new TCombo('siteslide_fk_idsite_templatesection[]');
        $this->fieldListSiteSlide = new TFieldList();
        $idsitetemplate = new TDBUniqueSearch('idsitetemplate', 'imobi_producao', 'Sitetemplate', 'idsitetemplate', 'sitetemplate','idsitetemplate asc' , $criteria_idsitetemplate );
        $button_ = new TButton('button_');
        $sitesecaotitulo_fk_idsite_idsitesecaotitulo = new THidden('sitesecaotitulo_fk_idsite_idsitesecaotitulo[]');
        $sitesecaotitulo_fk_idsite___row__id = new THidden('sitesecaotitulo_fk_idsite___row__id[]');
        $sitesecaotitulo_fk_idsite___row__data = new THidden('sitesecaotitulo_fk_idsite___row__data[]');
        $sitesecaotitulo_fk_idsite_idsitesecao = new TDBUniqueSearch('sitesecaotitulo_fk_idsite_idsitesecao[]', 'imobi_producao', 'Sitesecao', 'idsitesecao', 'nome','idsitesecao asc' , $criteria_sitesecaotitulo_fk_idsite_idsitesecao );
        $sitesecaotitulo_fk_idsite_sitesecaotitulo = new TEntry('sitesecaotitulo_fk_idsite_sitesecaotitulo[]');
        $this->fieldListsitedecao = new TFieldList();
        $conteinerDepoimentos = new BPageContainer();

        $this->fieldListhHeads->addField(null, $siteheadtext_fk_idsite_idsiteheadtext, []);
        $this->fieldListhHeads->addField(null, $siteheadtext_fk_idsite___row__id, ['uniqid' => true]);
        $this->fieldListhHeads->addField(null, $siteheadtext_fk_idsite___row__data, []);
        $this->fieldListhHeads->addField(new TLabel("Texto Cabeçalho Site:", '#FF0000', '14px', null), $siteheadtext_fk_idsite_siteheadtext, ['width' => '50%']);
        $this->fieldListhHeads->addField(new TLabel("Seção", null, '14px', null), $siteheadtext_fk_idsite_templatesection, ['width' => '100%']);

        $this->fieldListhHeads->width = '100%';
        $this->fieldListhHeads->setFieldPrefix('siteheadtext_fk_idsite');
        $this->fieldListhHeads->name = 'fieldListhHeads';

        $this->criteria_fieldListhHeads = new TCriteria();
        $this->default_item_fieldListhHeads = new stdClass();

        $this->form->addField($siteheadtext_fk_idsite_idsiteheadtext);
        $this->form->addField($siteheadtext_fk_idsite___row__id);
        $this->form->addField($siteheadtext_fk_idsite___row__data);
        $this->form->addField($siteheadtext_fk_idsite_siteheadtext);
        $this->form->addField($siteheadtext_fk_idsite_templatesection);

        $this->fieldListhHeads->enableSorting();

        $this->fieldListhHeads->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldListSiteSlide->addField(null, $siteslide_fk_idsite_idsiteslide, []);
        $this->fieldListSiteSlide->addField(null, $siteslide_fk_idsite___row__id, ['uniqid' => true]);
        $this->fieldListSiteSlide->addField(null, $siteslide_fk_idsite___row__data, []);
        $this->fieldListSiteSlide->addField(new TLabel("Slide(s)", '#FF0000', '14px', null), $siteslide_fk_idsite_siteslide, ['width' => '50%']);
        $this->fieldListSiteSlide->addField(new TLabel("Template", null, '14px', null), $siteslide_fk_idsite_templatesection, ['width' => '100%']);

        $this->fieldListSiteSlide->width = '100%';
        $this->fieldListSiteSlide->setFieldPrefix('siteslide_fk_idsite');
        $this->fieldListSiteSlide->name = 'fieldListSiteSlide';

        $this->criteria_fieldListSiteSlide = new TCriteria();
        $this->default_item_fieldListSiteSlide = new stdClass();

        $this->form->addField($siteslide_fk_idsite_idsiteslide);
        $this->form->addField($siteslide_fk_idsite___row__id);
        $this->form->addField($siteslide_fk_idsite___row__data);
        $this->form->addField($siteslide_fk_idsite_siteslide);
        $this->form->addField($siteslide_fk_idsite_templatesection);

        $this->fieldListSiteSlide->enableSorting();

        $this->fieldListSiteSlide->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldListsitedecao->addField(null, $sitesecaotitulo_fk_idsite_idsitesecaotitulo, []);
        $this->fieldListsitedecao->addField(null, $sitesecaotitulo_fk_idsite___row__id, ['uniqid' => true]);
        $this->fieldListsitedecao->addField(null, $sitesecaotitulo_fk_idsite___row__data, []);
        $this->fieldListsitedecao->addField(new TLabel("Seção", null, '14px', null), $sitesecaotitulo_fk_idsite_idsitesecao, ['width' => '50%']);
        $this->fieldListsitedecao->addField(new TLabel("Título", null, '14px', null), $sitesecaotitulo_fk_idsite_sitesecaotitulo, ['width' => '50%']);

        $this->fieldListsitedecao->width = '100%';
        $this->fieldListsitedecao->setFieldPrefix('sitesecaotitulo_fk_idsite');
        $this->fieldListsitedecao->name = 'fieldListsitedecao';

        $this->criteria_fieldListsitedecao = new TCriteria();
        $this->default_item_fieldListsitedecao = new stdClass();

        $this->fieldListsitedecao->addButtonAction(new TAction(['SiteSecaoFormList', 'onShow']), 'fas:outdent #2ECC71', "Nova Seção");

        $this->form->addField($sitesecaotitulo_fk_idsite_idsitesecaotitulo);
        $this->form->addField($sitesecaotitulo_fk_idsite___row__id);
        $this->form->addField($sitesecaotitulo_fk_idsite___row__data);
        $this->form->addField($sitesecaotitulo_fk_idsite_idsitesecao);
        $this->form->addField($sitesecaotitulo_fk_idsite_sitesecaotitulo);

        $this->fieldListsitedecao->enableSorting();

        $this->fieldListsitedecao->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $domain->addValidation("Domain", new TRequiredValidator()); 
        $patchphotos->addValidation("Phatch Photos", new TRequiredValidator()); 
        $title->addValidation("Title", new TRequiredValidator()); 
        $siteheadtext_fk_idsite_siteheadtext->addValidation("Siteheadtext", new TRequiredListValidator()); 
        $sitesecaotitulo_fk_idsite_sitesecaotitulo->addValidation("Sitesecaotitulo", new TRequiredListValidator()); 

        $idsite->setEditable(false);
        $domain->setTip("<b>ATENÇÃO! </b><br />NÃO usar http ou https://");
        $siteslide_fk_idsite_siteslide->enableFileHandling();
        $siteslide_fk_idsite_siteslide->setAllowedExtensions(["jpg","jpeg","tiff","png","webp"]);
        $siteslide_fk_idsite_siteslide->enableImageGallery('100', NULL);
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus #2ECC71');
        $conteinerDepoimentos->setId('b6500db9f83baf');
        $conteinerDepoimentos->hide();
        $enddate->setDatabaseMask('yyyy-mm-dd');
        $startdate->setDatabaseMask('yyyy-mm-dd');

        $active->setLayout('horizontal');
        $customerbutton->setLayout('horizontal');

        $active->setValue('2');
        $customerbutton->setValue('2');

        $active->setBooleanMode();
        $customerbutton->setBooleanMode();

        $siteslide_fk_idsite_templatesection->enableSearch();
        $siteheadtext_fk_idsite_templatesection->enableSearch();

        $idsitetemplate->setMinLength(0);
        $sitesecaotitulo_fk_idsite_idsitesecao->setMinLength(0);

        $button_->setAction(new TAction(['SiteTemplateFormList', 'onShow']), "");
        $conteinerDepoimentos->setAction(new TAction(['DepoimentosList', 'onShow']));

        $enddate->setMask('dd/mm/yyyy');
        $startdate->setMask('dd/mm/yyyy');
        $idsitetemplate->setMask('({idsitetemplate}) {sitetemplate}');
        $sitesecaotitulo_fk_idsite_idsitesecao->setMask('({idsitesecao}) {nome}');

        $active->addItems(["1"=>"Sim","2"=>"Não"]);
        $customerbutton->addItems(["1"=>"Sim","2"=>"Não"]);
        $siteslide_fk_idsite_templatesection->addItems(["v1-t01-header-1-900x900"=>"v1-t01-header-1-900x900","v1-t01-main-1-900x900"=>"v1-t01-main-1-900x900","v2-t01-header-1-1920x1080"=>"v2-t01-header-1-1920x1080","v2-t01-header-2-1920x1080"=>"v2-t01-header-2-1920x1080","v2-t01-header-3-1920x1080"=>"v2-t01-header-3-1920x1080","v2-t02-header-1920x1280"=>"v2-t02-header-1920x1280","v2-t03-header-1920x1280"=>"v2-t03-header-1920x1280","v2-t04-header-1920x1280"=>"v2-t04-header-1920x1280","v2-t05-header-1920x1280"=>"v2-t05-header-1920x1280","v2-t07-header-1920x1280"=>"v2-t07-header-1920x1280"]);
        $siteheadtext_fk_idsite_templatesection->addItems(["v1-t01-header-1"=>"v1-t01-header-1","v1-t01-header-2"=>"v1-t01-header-2","v1-t01-header-3"=>"v1-t01-header-3","v1-t01-main-1"=>"v1-t01-main-1","v1-t01-main-2"=>"v1-t01-main-2","v2-t01-header-slide1-text1"=>"v2-t01-header-slide1-text1","v2-t01-header-slide1-text2"=>"v2-t01-header-slide1-text2","v2-t01-header-slide2-text1"=>"v2-t01-header-slide2-text1","v2-t01-header-slide2-text2"=>"v2-t01-header-slide2-text2","v2-t01-header-slide3-text1"=>"v2-t01-header-slide3-text1","v2-t01-header-slide3-text2"=>"v2-t01-header-slide3-text2","v2-t02-header-text1"=>"v2-t02-header-text1","v2-t02-header-text2"=>"v2-t02-header-text2","v2-t02-header-text3"=>"v2-t02-header-text3","v2-t03-header-text1"=>"v2-t03-header-text1","v2-t03-header-text2"=>"v2-t03-header-text2","v2-t04-header-text1"=>"v2-t04-header-text1","v2-t04-header-text2"=>"v2-t04-header-text2","v2-t05-header-text1"=>"v2-t05-header-text1","v2-t05-header-text2"=>"v2-t05-header-text2","v2-t07-header-text1"=>"v2-t07-header-text1","v2-t07-header-text2"=>"v2-t07-header-text2","v2-t07-header-text3"=>"v2-t07-header-text3","v2-t07-header-title1"=>"v2-t07-header-title1","v2-t07-header-subtitle1"=>"v2-t07-header-subtitle1","v2-t07-header-title2"=>"v2-t07-header-title2","v2-t07-header-subtitle2"=>"v2-t07-header-subtitle2","v2-t07-header-title3"=>"v2-t07-header-title3","v2-t07-header-subtitle3"=>"v2-t07-header-subtitle3"]);

        $title->setSize('100%');
        $idsite->setSize('100%');
        $domain->setSize('100%');
        $active->setSize('100%');
        $enddate->setSize('100%');
        $mission->setSize('100%');
        $youtube->setSize('100%');
        $keywords->setSize('100%');
        $facebook->setSize('100%');
        $telegram->setSize('100%');
        $whatsapp->setSize('100%');
        $startdate->setSize('100%');
        $instagran->setSize('100%');
        $idanalityc->setSize('100%');
        $rodape->setSize('100%', 70);
        $about->setSize('100%', 250);
        $iframe->setSize('100%', 70);
        $patchphotos->setSize('100%');
        $sitekeyemail->setSize('100%');
        $endereco->setSize('100%', 70);
        $telefone->setSize('100%', 70);
        $collordefault->setSize('100%');
        $whatsappphone->setSize('100%');
        $keysecretemail->setSize('100%');
        $customerbutton->setSize('100%');
        $msgcookies->setSize('100%', 70);
        $apikeygooglemaps->setSize('100%');
        $description->setSize('100%', 100);
        $collordefaulttext->setSize('100%');
        $textsectionmain->setSize('100%', 250);
        $conteinerDepoimentos->setSize('100%');
        $idsitetemplate->setSize('calc(100% - 60px)');
        $siteslide_fk_idsite_siteslide->setSize('100%');
        $siteheadtext_fk_idsite_siteheadtext->setSize('100%');
        $siteslide_fk_idsite_templatesection->setSize('100%');
        $sitesecaotitulo_fk_idsite_idsitesecao->setSize('100%');
        $siteheadtext_fk_idsite_templatesection->setSize('100%');
        $sitesecaotitulo_fk_idsite_sitesecaotitulo->setSize('100%');

        $domain->placeholder = "Ex: dominio.com.br";

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $conteinerDepoimentos->add($loadingContainer);

        $this->conteinerDepoimentos = $conteinerDepoimentos;

        $this->form->appendPage("Setup");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idsite],[new TLabel("Endereço Domínio:", '#FF0000', '14px', null),$domain],[new TLabel("Data Início:", null, '14px', null, '100%'),$startdate],[new TLabel("Data Fim:", null, '14px', null, '100%'),$enddate]);
        $row1->layout = ['col-sm-2',' col-sm-4','col-sm-3','col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Patch Photos:", '#FF0000', '14px', null, '100%'),$patchphotos],[new TLabel("Id Google Analitycs:", null, '14px', null, '100%'),$idanalityc],[new TLabel("Id Google Maps:", null, '14px', null),$apikeygooglemaps]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Key Email:", null, '14px', null, '100%'),$sitekeyemail],[new TLabel("Key Secret Email:", null, '14px', null, '100%'),$keysecretemail]);
        $row3->layout = [' col-sm-6',' col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Site Ativo:", null, '14px', null, '100%'),$active],[new TLabel("Botão Portal Cliente:", null, '14px', null, '100%'),$customerbutton]);
        $row4->layout = ['col-sm-3','col-sm-3'];

        $this->form->appendPage("SEO");
        $row5 = $this->form->addFields([new TLabel("Título:", '#FF0000', '14px', null)],[$title]);
        $row6 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null)],[$description]);
        $row7 = $this->form->addFields([new TLabel("Palavras Chaves (entre vírgulas):", null, '14px', null)],[$keywords]);

        $this->form->appendPage("Layout");
        $row8 = $this->form->addFields([new TLabel("Cor Padrão do Site:", '#FF0000', '14px', null, '100%'),$collordefault],[new TLabel("Cor Padrão Texto:", '#FF0000', '14px', null, '100%'),$collordefaulttext],[new TLabel("Missão:", null, '14px', null),$mission]);
        $row8->layout = [' col-sm-3',' col-sm-3',' col-sm-6'];

        $row9 = $this->form->addFields([$this->fieldListhHeads]);
        $row9->layout = [' col-sm-12'];

        $row10 = $this->form->addFields([new TLabel("Endereço da Empresa:", null, '14px', null),$endereco],[new TLabel("Telefone(s) para contato:", null, '14px', null),$telefone]);
        $row10->layout = ['col-sm-6','col-sm-6'];

        $row11 = $this->form->addFields([new TLabel("Mensagem Cookies:", null, '14px', null),$msgcookies],[new TLabel("Texto Rodapé Site:", null, '14px', null),$rodape]);
        $row11->layout = ['col-sm-6','col-sm-6'];

        $row12 = $this->form->addFields([new TLabel("Sobre a Empresa:", null, '14px', null),$about],[new TLabel("Texto Seção Padrão:", null, '14px', null),$textsectionmain]);
        $row12->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("Mídias Socias");
        $row13 = $this->form->addFields([new TLabel("Facebook:", null, '14px', null, '100%'),$facebook],[new TLabel("Instagram:", null, '14px', null, '100%'),$instagran],[new TLabel("Telegram", null, '14px', null, '100%'),$telegram]);
        $row13->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row14 = $this->form->addFields([new TLabel("Youtube:", null, '14px', null, '100%'),$youtube],[new TLabel("WhatsApp:", null, '14px', null, '100%'),$whatsapp],[new TLabel("WhatsApp Phone:", null, '14px', null, '100%'),$whatsappphone]);
        $row14->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $this->form->appendPage("Imagens");
        $row15 = $this->form->addFields([new TLabel("Google Maps:", null, '14px', null),$iframe]);
        $row15->layout = [' col-sm-6'];

        $row16 = $this->form->addFields([$this->fieldListSiteSlide]);
        $row16->layout = [' col-sm-12'];

        $this->form->appendPage("Seções");
        $row17 = $this->form->addFields([new TLabel("Modelo Site:", '#FF0000', '14px', null, '100%'),$idsitetemplate,$button_]);
        $row17->layout = [' col-sm-6'];

        $row18 = $this->form->addFields([$this->fieldListsitedecao]);
        $row18->layout = [' col-sm-12'];

        $this->form->appendPage("Depoimentos");
        $row19 = $this->form->addFields([$conteinerDepoimentos]);
        $row19->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Site", new TAction([$this, 'onClear']), 'fas:plus #2ECC71');
        $this->btn_onclear = $btn_onclear;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=SiteForm]');
        $style->width = '85% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $config = new Config(1);

            $object = new Site(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->idunit = TSession::getValue('userunitid');

            $siteslide_fk_idsite_siteslide_dir = 'files/images/';  

            $logomarca_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $watermark_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $siteslide_fk_idsite_siteslide_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/slides/';

            $object->store(); // save the object 

//<generatedAutoCode>
            $this->criteria_fieldListSiteSlide->setProperty('order', 'idsiteslide asc');
//</generatedAutoCode>
            $siteslide_fk_idsite_items = $this->storeItems('Siteslide', 'idsite', $object, $this->fieldListSiteSlide, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListSiteSlide); 
            if(!empty($siteslide_fk_idsite_items))
            {
                foreach ($siteslide_fk_idsite_items as $item)
                {
                    $dataFile = new stdClass();
                    $dataFile->siteslide = $item->siteslide;
                    $this->saveFile($item, $dataFile, 'siteslide', $siteslide_fk_idsite_siteslide_dir);
                }
            }

//<generatedAutoCode>
            $this->criteria_fieldListsitedecao->setProperty('order', 'idsitesecao asc');
//</generatedAutoCode>
            $sitesecaotitulo_fk_idsite_items = $this->storeItems('Sitesecaotitulo', 'idsite', $object, $this->fieldListsitedecao, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListsitedecao); 

//<generatedAutoCode>
            $this->criteria_fieldListhHeads->setProperty('order', 'idsiteheadtext asc');
//</generatedAutoCode>
            $siteheadtext_fk_idsite_items = $this->storeItems('Siteheadtext', 'idsite', $object, $this->fieldListhHeads, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListhHeads); 

            // get the generated {PRIMARY_KEY}
            $data->idsite = $object->idsite; 

            $this->form->setData($data); // fill form data

                // CRUD no DB System tabela siteconnect
                TTransaction::open('imobi_system');
                $siteconnect = Siteconnect::where('idunit', '=', TSession::getValue('userunitid') )
                                          ->where('idsite', '=', $object->idsite )
                                          ->first();

                if( $siteconnect )
                {
                    $siteconnect->database = $config->database;
                    $siteconnect->domain = $object->domain;
                    $siteconnect->store();
                }
                else
                {
                    $connectnew           = new Siteconnect();
                    $connectnew->idunit   = TSession::getValue('userunitid');
                    $connectnew->idsite   = $object->idsite;
                    $connectnew->database = $config->database;
                    $connectnew->domain   = $object->domain;
                    $connectnew->store();
                }
                TTransaction::close(); // close the transaction

            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

            TForm::sendData(self::$formName, (object)['idsite' => $object->idsite]);

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

                $object = new Site($key); // instantiates the Active Record 

                                $this->conteinerDepoimentos->unhide();

                $this->criteria_fieldListSiteSlide->setProperty('order', 'idsiteslide asc');
                $this->fieldListSiteSlide_items = $this->loadItems('Siteslide', 'idsite', $object, $this->fieldListSiteSlide, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListSiteSlide); 

                $this->criteria_fieldListsitedecao->setProperty('order', 'idsitesecao asc');
                $this->fieldListsitedecao_items = $this->loadItems('Sitesecaotitulo', 'idsite', $object, $this->fieldListsitedecao, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListsitedecao); 

                $this->criteria_fieldListhHeads->setProperty('order', 'idsiteheadtext asc');
                $this->fieldListhHeads_items = $this->loadItems('Siteheadtext', 'idsite', $object, $this->fieldListhHeads, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListhHeads); 

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

        $this->fieldListhHeads->addHeader();
        $this->fieldListhHeads->addDetail($this->default_item_fieldListhHeads);

        $this->fieldListhHeads->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        $this->fieldListSiteSlide->addHeader();
        $this->fieldListSiteSlide->addDetail($this->default_item_fieldListSiteSlide);

        $this->fieldListSiteSlide->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        $this->fieldListsitedecao->addHeader();
        $this->fieldListsitedecao->addDetail($this->default_item_fieldListsitedecao);

        $this->fieldListsitedecao->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListhHeads->addHeader();
        $this->fieldListhHeads->addDetail($this->default_item_fieldListhHeads);

        $this->fieldListhHeads->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        $this->fieldListSiteSlide->addHeader();
        $this->fieldListSiteSlide->addDetail($this->default_item_fieldListSiteSlide);

        $this->fieldListSiteSlide->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        $this->fieldListsitedecao->addHeader();
        $this->fieldListsitedecao->addDetail($this->default_item_fieldListsitedecao);

        $this->fieldListsitedecao->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


<?php

class VistoriaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoria';
    private static $primaryKey = 'idvistoria';
    private static $formName = 'form_VistoriaForm';

    use BuilderMasterDetailTrait;

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
        $this->form->setFormTitle("Vistoria");

        $criteria_idvistoriador = new TCriteria();
        $criteria_vistoriadetalhe_fk_idvistoria_idimoveldetalhe = new TCriteria();
        $criteria_vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado = new TCriteria();

        TTransaction::open(self::$database);
        $config = new Config(1);
        TTransaction::close();

        $idimovel = new TEntry('idimovel');
        $idvistoria = new THidden('idvistoria');
        $enderecofull = new TEntry('enderecofull');
        $idvistoriatipo = new THidden('idvistoriatipo');
        $idvistoriastatus = new THidden('idvistoriastatus');
        $idvistoriador = new TDBUniqueSearch('idvistoriador', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoalead','pessoalead asc' , $criteria_idvistoriador );
        $button_ = new TButton('button_');
        $dtagendamento = new TDateTime('dtagendamento');
        $dtvistoriado = new TDate('dtvistoriado');
        $pzcontestacao = new TDate('pzcontestacao');
        $videolink = new TEntry('videolink');
        $obs = new TText('obs');
        $vistoriadetalhe_fk_idvistoria_idimoveldetalhe = new TDBUniqueSearch('vistoriadetalhe_fk_idvistoria_idimoveldetalhe', 'imobi_producao', 'Imoveldetalhefull', 'idimoveldetalhe', 'family','family asc' , $criteria_vistoriadetalhe_fk_idvistoria_idimoveldetalhe );
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalhe = new THidden('vistoriadetalhe_fk_idvistoria_idvistoriadetalhe');
        $vistoriadetalhe_fk_idvistoria_editado = new THidden('vistoriadetalhe_fk_idvistoria_editado');
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado = new TDBCombo('vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado', 'imobi_producao', 'Vistoriadetalheestado', 'idvistoriadetalheestado', '{vistoriadetalheestado}','vistoriadetalheestado asc' , $criteria_vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado );
        $vistoriadetalhe_fk_idvistoria_index = new TEntry('vistoriadetalhe_fk_idvistoria_index');
        $vistoriadetalhe_fk_idvistoria_avaliacao = new TText('vistoriadetalhe_fk_idvistoria_avaliacao');
        $vistoriadetalhe_fk_idvistoria_caracterizacao = new TText('vistoriadetalhe_fk_idvistoria_caracterizacao');
        $vistoriadetalhe_fk_idvistoria_descricao = new TText('vistoriadetalhe_fk_idvistoria_descricao');
        $button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria = new TButton('button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria');
        $button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria = new TButton('button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria');


        $vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado->setDefaultOption(false);
        $idimovel->setEditable(false);
        $enderecofull->setEditable(false);

        $idvistoriador->setMinLength(0);
        $vistoriadetalhe_fk_idvistoria_idimoveldetalhe->setMinLength(0);

        $vistoriadetalhe_fk_idvistoria_editado->setValue('false');
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado->setValue('2');

        $button_->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria->setAction(new TAction(['ImovelDetalheFormList', 'onShow']), "Cadastrar novo Ambiente/Item");
        $button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria->setAction(new TAction([$this, 'onAddDetailVistoriadetalheFkIdvistoria'],['static' => 1]), "Adicionar Ambiente na Vistoria");

        $button_->addStyleClass('btn-default');
        $button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria->addStyleClass('btn-default');
        $button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria->addStyleClass('btn-success');

        $button_->setImage('fas:user-plus #607D8B');
        $button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria->setImage('fas:bed #9E9E9E');
        $button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria->setImage('fas:plus #FFFFFF');

        $dtvistoriado->setDatabaseMask('yyyy-mm-dd');
        $pzcontestacao->setDatabaseMask('yyyy-mm-dd');
        $dtagendamento->setDatabaseMask('yyyy-mm-dd hh:ii');

        $dtvistoriado->setMask('dd/mm/yyyy');
        $pzcontestacao->setMask('dd/mm/yyyy');
        $dtagendamento->setMask('dd/mm/yyyy hh:ii');
        $idvistoriador->setMask('{idpessoa}  - {pessoalead}');
        $vistoriadetalhe_fk_idvistoria_idimoveldetalhe->setMask('{family}');

        $vistoriadetalhe_fk_idvistoria_descricao->setTip("Identifica ou pormenoriza o item.");
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado->setTip("Estado de conservação do Item.");
        $vistoriadetalhe_fk_idvistoria_idimoveldetalhe->setTip("Cômodo, Ambiente, Chaves, Medidores, etc.");
        $vistoriadetalhe_fk_idvistoria_index->setTip("Organiza a exibição dos itens no modo de impressão.");
        $vistoriadetalhe_fk_idvistoria_caracterizacao->setTip("Características ou particularidades do item.");
        $vistoriadetalhe_fk_idvistoria_avaliacao->setTip("Ponderações, críticas ou de esclarecimento, acerca do item.");

        $idvistoria->setSize(200);
        $idimovel->setSize('100%');
        $obs->setSize('100%', 100);
        $videolink->setSize('100%');
        $idvistoriatipo->setSize(200);
        $enderecofull->setSize('100%');
        $dtvistoriado->setSize('100%');
        $idvistoriastatus->setSize(200);
        $dtagendamento->setSize('100%');
        $pzcontestacao->setSize('100%');
        $idvistoriador->setSize('calc(100% - 80px)');
        $vistoriadetalhe_fk_idvistoria_editado->setSize(200);
        $vistoriadetalhe_fk_idvistoria_index->setSize('100%');
        $vistoriadetalhe_fk_idvistoria_avaliacao->setSize('100%', 70);
        $vistoriadetalhe_fk_idvistoria_descricao->setSize('100%', 70);
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalhe->setSize(200);
        $vistoriadetalhe_fk_idvistoria_idimoveldetalhe->setSize('100%');
        $vistoriadetalhe_fk_idvistoria_caracterizacao->setSize('100%', 70);
        $vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado->setSize('100%');

        $button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria->id = '64064552da23f';
        $vistoriadetalhe_fk_idvistoria_index->placeholder = "Ex.: 1 - aparecer em primeiro no laudo";
        $vistoriadetalhe_fk_idvistoria_avaliacao->placeholder = "Ex: Desgastado, oxidado, com marcas de uso, ...";
        $vistoriadetalhe_fk_idvistoria_caracterizacao->placeholder = "Ex.: cor, tamanho, material, tipo, marca, quantidade, ...";

        if(isset($param['key']))
        {
            // $idcontrato->setEditable(false);
            // $idimovel->setEditable(false);
        }

        $this->form->appendPage("Gestão");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Imóvel Cód.:", null, '14px', null, '100%'),$idimovel,$idvistoria],[new TLabel("Endereço:", null, '14px', null, '100%'),$enderecofull,$idvistoriatipo,$idvistoriastatus]);
        $row1->layout = ['col-sm-2',' col-sm-10'];

        $row2 = $this->form->addFields([new TLabel("Vistoriador:", null, '14px', null, '100%'),$idvistoriador,$button_],[new TLabel("Agendamento:", null, '14px', null, '100%'),$dtagendamento],[new TLabel("Visitado em:", null, '14px', null, '100%'),$dtvistoriado],[new TLabel("Prazo p/ Contestação:", null, '14px', null, '100%'),$pzcontestacao]);
        $row2->layout = [' col-sm-5',' col-sm-3','col-sm-2','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Video Link:", null, '14px', null, '100%'),$videolink]);
        $row3->layout = ['col-sm-8'];

        $row4 = $this->form->addFields([new TLabel("Obs:", null, '14px', null, '100%'),$obs]);
        $row4->layout = [' col-sm-12'];

        $this->form->appendPage("Ambientes/Ítens");

        $this->detailFormVistoriadetalheFkIdvistoria = new BootstrapFormBuilder('detailFormVistoriadetalheFkIdvistoria');
        $this->detailFormVistoriadetalheFkIdvistoria->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormVistoriadetalheFkIdvistoria->setProperty('class', 'form-horizontal builder-detail-form');

        $row5 = $this->detailFormVistoriadetalheFkIdvistoria->addFields([new TLabel("Ambiente/Item:", '#ff0000', '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_idimoveldetalhe,$vistoriadetalhe_fk_idvistoria_idvistoriadetalhe,$vistoriadetalhe_fk_idvistoria_editado],[new TLabel("Estado:", '#ff0000', '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado],[new TLabel("Ordenação:", null, '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_index]);
        $row5->layout = [' col-sm-6',' col-sm-4',' col-sm-2'];

        $row6 = $this->detailFormVistoriadetalheFkIdvistoria->addFields([new TLabel("Avaliação:", null, '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_avaliacao],[new TLabel("Caracterização:", null, '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_caracterizacao],[new TLabel("Descrição:", null, '14px', null, '100%'),$vistoriadetalhe_fk_idvistoria_descricao]);
        $row6->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row7 = $this->detailFormVistoriadetalheFkIdvistoria->addFields([$button_adicionar_ambiente_na_vistoria_vistoriadetalhe_fk_idvistoria,$button_cadastrar_novo_ambienteitem_vistoriadetalhe_fk_idvistoria]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->detailFormVistoriadetalheFkIdvistoria->addFields([new THidden('vistoriadetalhe_fk_idvistoria__row__id')]);
        $this->vistoriadetalhe_fk_idvistoria_criteria = new TCriteria();

        $this->vistoriadetalhe_fk_idvistoria_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->vistoriadetalhe_fk_idvistoria_list->generateHiddenFields();
        $this->vistoriadetalhe_fk_idvistoria_list->setId('vistoriadetalhe_fk_idvistoria_list');

        $this->vistoriadetalhe_fk_idvistoria_list->style = 'width:100%';
        $this->vistoriadetalhe_fk_idvistoria_list->class .= ' table-bordered';

        $column_vistoriadetalhe_fk_idvistoria_editado_transformed = new TDataGridColumn('editado', "Status Item", 'center' , '10%');
        $column_vistoriadetalhe_fk_idvistoria_fk_idimoveldetalhe_family_transformed = new TDataGridColumn('fk_idimoveldetalhe->family', "Ambiente/Item", 'left' , '25%');
        $column_vistoriadetalhe_fk_idvistoria_fk_idvistoriadetalheestado_vistoriadetalheestado_transformed = new TDataGridColumn('fk_idvistoriadetalheestado->vistoriadetalheestado', "Estado", 'left' , '20%');
        $column_vistoriadetalhe_fk_idvistoria_caracterizacao = new TDataGridColumn('caracterizacao', "Caracterização", 'left' , '20%');
        $column_vistoriadetalhe_fk_idvistoria_descricao = new TDataGridColumn('descricao', "Descrição", 'left' , '20%');
        $column_vistoriadetalhe_fk_idvistoria_index = new TDataGridColumn('index', "Ordenação", 'left' , '5%');

        $column_vistoriadetalhe_fk_idvistoria__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_vistoriadetalhe_fk_idvistoria__row__data->setVisibility(false);

        $action_onEditDetailVistoriadetalhe = new TDataGridAction(array('VistoriaForm', 'onEditDetailVistoriadetalhe'));
        $action_onEditDetailVistoriadetalhe->setUseButton(false);
        $action_onEditDetailVistoriadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailVistoriadetalhe->setLabel("Editar");
        $action_onEditDetailVistoriadetalhe->setImage('far:edit #047AFD');
        $action_onEditDetailVistoriadetalhe->setFields(['__row__id', '__row__data']);

        $this->vistoriadetalhe_fk_idvistoria_list->addAction($action_onEditDetailVistoriadetalhe);
        $action_onDeleteDetailVistoriadetalhe = new TDataGridAction(array('VistoriaForm', 'onDeleteDetailVistoriadetalhe'));
        $action_onDeleteDetailVistoriadetalhe->setUseButton(false);
        $action_onDeleteDetailVistoriadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailVistoriadetalhe->setLabel("Excluir");
        $action_onDeleteDetailVistoriadetalhe->setImage('far:trash-alt #EF4648');
        $action_onDeleteDetailVistoriadetalhe->setFields(['__row__id', '__row__data']);

        $this->vistoriadetalhe_fk_idvistoria_list->addAction($action_onDeleteDetailVistoriadetalhe);
        $action_OnLaudoFotografico = new TDataGridAction(array('VistoriaForm', 'OnLaudoFotografico'));
        $action_OnLaudoFotografico->setUseButton(false);
        $action_OnLaudoFotografico->setButtonClass('btn btn-default btn-sm');
        $action_OnLaudoFotografico->setLabel("Laudo Fotográfico");
        $action_OnLaudoFotografico->setImage('fas:camera-retro #9400D3');
        $action_OnLaudoFotografico->setFields(['__row__id', '__row__data']);
        $action_OnLaudoFotografico->setDisplayCondition('VistoriaForm::onDisplayLaudoFotografico');

        $this->vistoriadetalhe_fk_idvistoria_list->addAction($action_OnLaudoFotografico);
        $action_onInconformidade = new TDataGridAction(array('VistoriaForm', 'onInconformidade'));
        $action_onInconformidade->setUseButton(false);
        $action_onInconformidade->setButtonClass('btn btn-default btn-sm');
        $action_onInconformidade->setLabel("Inconformidade");
        $action_onInconformidade->setImage('fas:thumbs-down #EF4648');
        $action_onInconformidade->setFields(['__row__id', '__row__data']);
        $action_onInconformidade->setDisplayCondition('VistoriaForm::onDisplayInconformidade');

        $this->vistoriadetalhe_fk_idvistoria_list->addAction($action_onInconformidade);
        $action_onContestacao = new TDataGridAction(array('VistoriaForm', 'onContestacao'));
        $action_onContestacao->setUseButton(false);
        $action_onContestacao->setButtonClass('btn btn-default btn-sm');
        $action_onContestacao->setLabel("Contestação");
        $action_onContestacao->setImage('fas:hand-paper #FF5722');
        $action_onContestacao->setFields(['__row__id', '__row__data']);
        $action_onContestacao->setDisplayCondition('VistoriaForm::onDisplaycontestacao');

        $this->vistoriadetalhe_fk_idvistoria_list->addAction($action_onContestacao);

        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_editado_transformed);
        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_fk_idimoveldetalhe_family_transformed);
        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_fk_idvistoriadetalheestado_vistoriadetalheestado_transformed);
        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_caracterizacao);
        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_descricao);
        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria_index);

        $this->vistoriadetalhe_fk_idvistoria_list->addColumn($column_vistoriadetalhe_fk_idvistoria__row__data);

        $this->vistoriadetalhe_fk_idvistoria_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->vistoriadetalhe_fk_idvistoria_list);
        $this->detailFormVistoriadetalheFkIdvistoria->addContent([$tableResponsiveDiv]);

        $column_vistoriadetalhe_fk_idvistoria_editado_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$object->idvistoriadetalhe)
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<i class=\"fa-solid fa-circle-check\"></i><strong>Não Salvo</strong>");
                return $lbl_status;
            }

            if( $value )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-warning";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<i class=\"fa-solid fa-circle-check\"></i><br /><strong>Editado</strong><br />&nbsp;&nbsp;Não Salvo&nbsp;&nbsp;");
                return $lbl_status;
            }

            if( !$value ) 
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-success";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<i class=\"fa-solid fa-circle-check\"></i>&nbsp;<strong>Salvo</strong>");
                return $lbl_status;
            }
            return '';

        });

        $column_vistoriadetalhe_fk_idvistoria_fk_idimoveldetalhe_family_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            $flag_ok         = '<i class="far fa-thumbs-up"></i> ';
            $flag_conteste   = '<i class="far fa-hand-paper"></i> ';
            $flag_inconforme = '<i class="far fa-thumbs-down"></i> ';
            $flag            = '';
            if((isset($object->dtinconformidade)) AND (!is_null($object->dtinconformidade)) AND (!$object->inconformidadereparo))
                $flag .= $flag_inconforme;
            if( (isset($object->dtcontestacao)) AND (!is_null($object->dtcontestacao)) AND (!$object->contestacaoresposta))
                $flag .= $flag_conteste;
            if( $flag == '')
                $flag = $flag_ok;
            return $value . ' ' . $flag;

        });

        $column_vistoriadetalhe_fk_idvistoria_fk_idvistoriadetalheestado_vistoriadetalheestado_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            switch($value)
            {
                case 'Novo':
                    $div = '<span style=" border-radius: 50%; display: inline-block; height: 15px; width: 15px; border: 1px solid #000000; background-color: blue;"></span> Novo';
                break;
                case 'Bom':
                    $div = '<span style="border-radius: 50%; display: inline-block; height: 15px; width: 15px; border: 1px solid #000000; background-color: green;"></span> Bom';
                break;
                case 'Regular':
                    $div = '<span style="border-radius: 50%; display: inline-block; height: 15px; width: 15px; border: 1px solid #000000; background-color: yellow;"></span> Regular';
                    break;
                case 'Inservível':
                    $div = '<span style="border-radius: 50%; display: inline-block; height: 15px; width: 15px; border: 1px solid #000000; background-color: red;"></span> Inservível';
               break;
            }
               $avalizacao = $object->avaliacao == '' ? $div : $div . ' - ' . $object->avaliacao;
               return $avalizacao;

        });        $row9 = $this->form->addFields([$this->detailFormVistoriadetalheFkIdvistoria]);
        $row9->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['VistoriaList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Imobiliária","Vistoria"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onAddDetailVistoriadetalheFkIdvistoria($param = null) 
    {
        try
        {
            $data = $this->form->getData();
        TToast::show("show", "O Laudo Fotográfico estará disponível após <b>Salvar</b>.", "topRight", "fas:photo-video");

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Ambiente/Item", 'name'=>"vistoriadetalhe_fk_idvistoria_idimoveldetalhe", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Idvistoriadetalheestado", 'name'=>"vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado", 'class'=>'TRequiredValidator', 'value'=>[]];
            foreach($requiredFields as $requiredField)
            {
                try
                {
                    (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                }
                catch(Exception $e)
                {
                    $errors[] = $e->getMessage() . '.';
                }
             }
             if(count($errors) > 0)
             {
                 throw new Exception(implode('<br>', $errors));
             }

            $__row__id = !empty($data->vistoriadetalhe_fk_idvistoria__row__id) ? $data->vistoriadetalhe_fk_idvistoria__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new Vistoriadetalhe();
            $grid_data->__row__id = $__row__id;
            $grid_data->idimoveldetalhe = $data->vistoriadetalhe_fk_idvistoria_idimoveldetalhe;
            $grid_data->idvistoriadetalhe = $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalhe;
            $grid_data->editado = $data->vistoriadetalhe_fk_idvistoria_editado;
            $grid_data->idvistoriadetalheestado = $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado;
            $grid_data->index = $data->vistoriadetalhe_fk_idvistoria_index;
            $grid_data->avaliacao = $data->vistoriadetalhe_fk_idvistoria_avaliacao;
            $grid_data->caracterizacao = $data->vistoriadetalhe_fk_idvistoria_caracterizacao;
            $grid_data->descricao = $data->vistoriadetalhe_fk_idvistoria_descricao;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idimoveldetalhe'] =  $param['vistoriadetalhe_fk_idvistoria_idimoveldetalhe'] ?? null;
            $__row__data['__display__']['idvistoriadetalhe'] =  $param['vistoriadetalhe_fk_idvistoria_idvistoriadetalhe'] ?? null;
            $__row__data['__display__']['editado'] =  $param['vistoriadetalhe_fk_idvistoria_editado'] ?? null;
            $__row__data['__display__']['idvistoriadetalheestado'] =  $param['vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado'] ?? null;
            $__row__data['__display__']['index'] =  $param['vistoriadetalhe_fk_idvistoria_index'] ?? null;
            $__row__data['__display__']['avaliacao'] =  $param['vistoriadetalhe_fk_idvistoria_avaliacao'] ?? null;
            $__row__data['__display__']['caracterizacao'] =  $param['vistoriadetalhe_fk_idvistoria_caracterizacao'] ?? null;
            $__row__data['__display__']['descricao'] =  $param['vistoriadetalhe_fk_idvistoria_descricao'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->vistoriadetalhe_fk_idvistoria_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('vistoriadetalhe_fk_idvistoria_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->vistoriadetalhe_fk_idvistoria_idimoveldetalhe = '';
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalhe = '';
            $data->vistoriadetalhe_fk_idvistoria_editado = 'false';
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado = '2';
            $data->vistoriadetalhe_fk_idvistoria_index = '';
            $data->vistoriadetalhe_fk_idvistoria_avaliacao = '';
            $data->vistoriadetalhe_fk_idvistoria_caracterizacao = '';
            $data->vistoriadetalhe_fk_idvistoria_descricao = '';
            $data->vistoriadetalhe_fk_idvistoria__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#64064552da23f');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onEditDetailVistoriadetalhe($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;
            $fireEvents = true;
            $aggregate = false;

            $data = new stdClass;
            $data->vistoriadetalhe_fk_idvistoria_idimoveldetalhe = $__row__data->__display__->idimoveldetalhe ?? null;
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalhe = $__row__data->__display__->idvistoriadetalhe ?? null;
            $data->vistoriadetalhe_fk_idvistoria_editado = $__row__data->__display__->editado ?? null;
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado = $__row__data->__display__->idvistoriadetalheestado ?? null;
            $data->vistoriadetalhe_fk_idvistoria_index = $__row__data->__display__->index ?? null;
            $data->vistoriadetalhe_fk_idvistoria_avaliacao = $__row__data->__display__->avaliacao ?? null;
            $data->vistoriadetalhe_fk_idvistoria_caracterizacao = $__row__data->__display__->caracterizacao ?? null;
            $data->vistoriadetalhe_fk_idvistoria_descricao = $__row__data->__display__->descricao ?? null;
            $data->vistoriadetalhe_fk_idvistoria__row__id = $__row__data->__row__id;

            $data->vistoriadetalhe_fk_idvistoria_editado = true;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#64064552da23f');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editado</span>\");
               if(!element.attr('edit')){
                   element.attr('edit', base64_encode(element.html()));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onDeleteDetailVistoriadetalhe($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->vistoriadetalhe_fk_idvistoria_idimoveldetalhe = '';
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalhe = '';
            $data->vistoriadetalhe_fk_idvistoria_editado = '';
            $data->vistoriadetalhe_fk_idvistoria_idvistoriadetalheestado = '';
            $data->vistoriadetalhe_fk_idvistoria_index = '';
            $data->vistoriadetalhe_fk_idvistoria_avaliacao = '';
            $data->vistoriadetalhe_fk_idvistoria_caracterizacao = '';
            $data->vistoriadetalhe_fk_idvistoria_descricao = '';
            $data->vistoriadetalhe_fk_idvistoria__row__id = '';

            TForm::sendData(self::$formName, $data);

        new TMessage('info', "Não esqueça de [Salvar] esta vistoria para efetivar a exclusão!");

            TDataGrid::removeRowById('vistoriadetalhe_fk_idvistoria_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#64064552da23f');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function OnLaudoFotografico($param = null) 
    {
        try 
        {
            //code here

            $data = unserialize(base64_decode($param['__row__data']));
            TTransaction::open(self::$database);
            $detalhe = new Imoveldetalhefull($data->idimoveldetalhe);
            TTransaction::close();

            AdiantiCoreApplication::loadPage( 'VistoriadetalheimgFormList', 'onShow');

            TSession::setValue('idvistoriadetalhe', $data->idvistoriadetalhe);
            TSession::setValue('imoveldetalhe', "<i class=\"fas fa-camera-retro\"></i> - {$detalhe->family}");
            if(isset($data->idvistoria) )
                TSession::setValue('idvistoria', $data->idvistoria);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayLaudoFotografico($object)
    {
        try 
        {
            if($object->idvistoriadetalhe)
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
    public static function onInconformidade($param = null) 
    {
        try 
        {
            //code here

            $data = unserialize(base64_decode($param['__row__data']));
            AdiantiCoreApplication::loadPage( 'VistoriaInconformidadeForm', 'onEdit', ['key' => $data->idvistoriadetalhe]);
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayInconformidade($object)
    {
        try 
        {
            if($object->idvistoriadetalhe)
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
    public static function onContestacao($param = null) 
    {
        try 
        {
            //code here

            $data = unserialize(base64_decode($param['__row__data']));
            AdiantiCoreApplication::loadPage( 'VistoriaContestacaoForm', 'onEdit', ['key' => $data->idvistoriadetalhe]);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplaycontestacao($object)
    {
        try 
        {
            if( (isset($object->dtcontestacao)) AND (!is_null($object->dtcontestacao)) )

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
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Vistoria(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            TForm::sendData(self::$formName, (object)['idvistoria' => $object->idvistoria]);

//<generatedAutoCode>
            $this->vistoriadetalhe_fk_idvistoria_criteria->setProperty('order', 'index asc');
//</generatedAutoCode>
            $vistoriadetalhe_fk_idvistoria_items = $this->storeMasterDetailItems('Vistoriadetalhe', 'idvistoria', 'vistoriadetalhe_fk_idvistoria', $object, $param['vistoriadetalhe_fk_idvistoria_list___row__data'] ?? [], $this->form, $this->vistoriadetalhe_fk_idvistoria_list, function($masterObject, $detailObject){ 

                //code here
                $detailObject->editado = false;

            }, $this->vistoriadetalhe_fk_idvistoria_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->idvistoria = $object->idvistoria; 

            $vistoriahistorico = new Vistoriahistorico();
            $vistoriahistorico->idvistoria   = $object->idvistoria;
            $vistoriahistorico->idsystemuser = TSession::getValue('userid');
            $vistoriahistorico->titulo       = 'Edição';
            $vistoriahistorico->historico    = "Vistoria editada por {$vistoriahistorico->fk_idsystemuser->name} em " . date("d/m/Y H:i");
            $vistoriahistorico->store();

            $this->form->setData($data); // fill form data
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
    public static function onTutor($param = null) 
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

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Vistoria($key); // instantiates the Active Record 

                $imovel = new Imovelfull($object->idimovel);

                $lbl_idvistoria = str_pad($object->idvistoria, 6, '0', STR_PAD_LEFT);
                $object->idvistoria = $lbl_idvistoria;
                $object->idimovel  = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);
                $object->enderecofull = $imovel->enderecofull;
                $this->form->setFormTitle("Vistoria - {$lbl_idvistoria}");

//<generatedAutoCode>
                $this->vistoriadetalhe_fk_idvistoria_criteria->setProperty('order', 'index asc');
//</generatedAutoCode>
                $vistoriadetalhe_fk_idvistoria_items = $this->loadMasterDetailItems('Vistoriadetalhe', 'idvistoria', 'vistoriadetalhe_fk_idvistoria', $object, $this->form, $this->vistoriadetalhe_fk_idvistoria_list, $this->vistoriadetalhe_fk_idvistoria_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                if(isset($param['page']) )
                $this->form->setCurrentPage($param['page']);

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

    public function onReturn($param = null)
    {

        $this->form->setCurrentPage($param['page']);
        Application::loadPage(__CLASS__, 'onEdit', ['key' => $param['key']]);

    }

}


<?php

class FaturaReportForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Relatorio';
    private static $primaryKey = 'idrelatorio';
    private static $formName = 'form_FaturaReportForm';

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
        $this->form->setFormTitle("Relatório de Contas Pag/Rec");

        $criteria_idpessoa = new TCriteria();
        $criteria_idimovel = new TCriteria();
        $criteria_idfaturaformapagamento = new TCriteria();

        $retrato = '↕️ ' . ' Retrato';
        $paisagem = '↔️ ' . ' Paisagem';
        $asc = '⬇️ ️ ' . 'Ascendente';
        $desc = '⬆️ ' . 'Descendente';

        $idfatura = new TEntry('idfatura');
        $referencia = new TEntry('referencia');
        $idcontrato = new TEntry('idcontrato');
        $pagamento = new TCombo('pagamento');
        $idpessoa = new TDBCombo('idpessoa', 'imobi_producao', 'Pessoafull', 'idpessoa', '#{idpessoachar} {pessoalead}','pessoalead asc' , $criteria_idpessoa );
        $idimovel = new TDBCombo('idimovel', 'imobi_producao', 'Imovelfull', 'idimovel', '{idimovelchar} - {enderecofull}','idimovel asc' , $criteria_idimovel );
        $es = new TCombo('es');
        $idfaturaformapagamento = new TDBCombo('idfaturaformapagamento', 'imobi_producao', 'Faturaformapagamento', 'idfaturaformapagamento', '{faturaformapagamento}','faturaformapagamento asc' , $criteria_idfaturaformapagamento );
        $dtvencimentostatus = new TCombo('dtvencimentostatus');
        $status = new TCombo('status');
        $instrucao = new TEntry('instrucao');
        $dtpagamento = new TDate('dtpagamento');
        $dtpagamento1 = new TDate('dtpagamento1');
        $dtvencimento = new TDate('dtvencimento');
        $dtvencimento1 = new TDate('dtvencimento1');
        $createdat0 = new TDate('createdat0');
        $createdat1 = new TDate('createdat1');
        $format = new TCombo('format');
        $orientacao = new TCombo('orientacao');
        $ordem = new TCombo('ordem');
        $sentido = new TCombo('sentido');
        $estilo = new TCombo('estilo');
        $relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe = new THidden('relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe[]');
        $relatoriodetalhe_fk_idrelatorio___row__id = new THidden('relatoriodetalhe_fk_idrelatorio___row__id[]');
        $relatoriodetalhe_fk_idrelatorio___row__data = new THidden('relatoriodetalhe_fk_idrelatorio___row__data[]');
        $relatoriodetalhe_fk_idrelatorio_coluna = new TCombo('relatoriodetalhe_fk_idrelatorio_coluna[]');
        $relatoriodetalhe_fk_idrelatorio_largura = new TNumeric('relatoriodetalhe_fk_idrelatorio_largura[]', '0', ',', '.' );
        $relatoriodetalhe_fk_idrelatorio_totais = new TCombo('relatoriodetalhe_fk_idrelatorio_totais[]');
        $this->fieldList_66e56f3f2d170 = new TFieldList();

        $this->fieldList_66e56f3f2d170->addField(null, $relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe, []);
        $this->fieldList_66e56f3f2d170->addField(null, $relatoriodetalhe_fk_idrelatorio___row__id, ['uniqid' => true]);
        $this->fieldList_66e56f3f2d170->addField(null, $relatoriodetalhe_fk_idrelatorio___row__data, []);
        $this->fieldList_66e56f3f2d170->addField(new TLabel("Campo a Exibir", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_coluna, ['width' => '70%']);
        $this->fieldList_66e56f3f2d170->addField(new TLabel("Largura (pixel)", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_largura, ['width' => '15%']);
        $this->fieldList_66e56f3f2d170->addField(new TLabel("Totais", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_totais, ['width' => '15%']);

        $this->fieldList_66e56f3f2d170->width = '100%';
        $this->fieldList_66e56f3f2d170->setFieldPrefix('relatoriodetalhe_fk_idrelatorio');
        $this->fieldList_66e56f3f2d170->name = 'fieldList_66e56f3f2d170';

        $this->criteria_fieldList_66e56f3f2d170 = new TCriteria();
        $this->default_item_fieldList_66e56f3f2d170 = new stdClass();

        $this->form->addField($relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio___row__id);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio___row__data);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_coluna);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_largura);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_totais);

        $this->fieldList_66e56f3f2d170->enableSorting();

        $this->fieldList_66e56f3f2d170->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $relatoriodetalhe_fk_idrelatorio_largura->setTip("1px  ± 1mm, dependendo do dispositivo. 100 é o padrão.");
        $relatoriodetalhe_fk_idrelatorio_largura->setAllowNegative(false);
        $idpessoa->enableSearch();
        $idimovel->enableSearch();
        $pagamento->enableSearch();
        $dtvencimentostatus->enableSearch();
        $relatoriodetalhe_fk_idrelatorio_coluna->enableSearch();

        $estilo->setValue('R');
        $format->setValue('html');
        $sentido->setValue('asc');
        $orientacao->setValue('P');
        $ordem->setValue('idcaixa');

        $ordem->setDefaultOption(false);
        $format->setDefaultOption(false);
        $estilo->setDefaultOption(false);
        $sentido->setDefaultOption(false);
        $orientacao->setDefaultOption(false);

        $createdat0->setDatabaseMask('yyyy-mm-dd');
        $createdat1->setDatabaseMask('yyyy-mm-dd');
        $dtpagamento->setDatabaseMask('yyyy-mm-dd');
        $dtpagamento1->setDatabaseMask('yyyy-mm-dd');
        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $dtvencimento1->setDatabaseMask('yyyy-mm-dd');

        $idfatura->setMask('9!');
        $idcontrato->setMask('9!');
        $createdat0->setMask('dd/mm/yyyy');
        $createdat1->setMask('dd/mm/yyyy');
        $dtpagamento->setMask('dd/mm/yyyy');
        $dtpagamento1->setMask('dd/mm/yyyy');
        $dtvencimento->setMask('dd/mm/yyyy');
        $dtvencimento1->setMask('dd/mm/yyyy');

        $es->addItems(["E"=>"Entrada","S"=>"Saída"]);
        $estilo->addItems(["R"=>"Resumido","A"=>"Ampliado"]);
        $sentido->addItems(["asc"=>"{$asc}","desc"=>"{$desc}"]);
        $pagamento->addItems(["1"=>"Pago","2"=>"<b>Não</b> Pago"]);
        $orientacao->addItems(["P"=>"{$retrato}","L"=>"{$paisagem}"]);
        $format->addItems(["html"=>"HTML","pdf"=>"PDF","xls"=>"XLS (Excel)"]);
        $dtvencimentostatus->addItems(["vencida"=>"Atrasadas","vincenda"=>"a Vencer"]);
        $status->addItems(["CANCELLED"=>"Cancelada","FAILED"=>"Fracassada","PENDING"=>"Pendente","DONE"=>"Realizada"]);
        $relatoriodetalhe_fk_idrelatorio_totais->addItems(["C"=>"Contar (Count)","M"=>"Média (Average)","S"=>"Soma (Sum)"]);
        $ordem->addItems(["idcaixa"=>"Caixa Cód.","idcontrato"=>"Contrato Nº","descontotipo"=>" Desconto Tipo","createdat"=>"Emissão Dt.","idfatura"=>"Fatura Cód.","faturaformapagamento"=>"Forma de Pagamento","es"=>"Movimento Tipo (E/S)","dtpagamento"=>"Pagamento Dt.","dtpagamentostatus"=>"Pagamento Status","pessoa"=>"Pessoa","referencia"=>"Referência","dtvencimento"=>"Vencimento Dt.","dtvencimentostatus"=>"Vencimento Status"]);
        $relatoriodetalhe_fk_idrelatorio_coluna->addItems(["idfatura"=>"Fatura Cód.","idcaixa"=>"Caixa Cód.","idcontrato"=>"Contrato Nº","descontodiasant"=>" Desconto Dias Antecipação","descontotipo"=>" Desconto Tipo","descontovalor"=>" Desconto Valor","createdat"=>"Emissão Dt.","emiterps"=>"Emitir RPS","faturaformapagamento"=>"Forma de Pagamento","instrucao"=>"Instruções","juros"=>"Juros","es"=>"Movimento Tipo (E/S)","multa"=>"Multa","dtpagamento"=>"Pagamento Dt.","dtpagamentostatus"=>"Pagamento status","pessoa"=>"Pessoa","bairro"=>"Pessoa Bairro","celular"=>"Pessoa Celular","cidade"=>"Pessoa Cidade","cnpjcpf"=>"Pessoa CNPJ/CPF","fone"=>"Pessoa Fone","endereco"=>"Pessoa Endereço","email"=>"Pessoa E-mail","referencia"=>"Referência","valortotal"=>"Valor Fatura","caixavalor"=>"Valor Pago","dtvencimento"=>"Vencimento Dt.","dtvencimentostatus"=>"Vencimento status"]);

        $es->setSize('100%');
        $ordem->setSize('100%');
        $status->setSize('100%');
        $format->setSize('100%');
        $estilo->setSize('100%');
        $sentido->setSize('100%');
        $idfatura->setSize('100%');
        $idpessoa->setSize('100%');
        $idimovel->setSize('100%');
        $pagamento->setSize('100%');
        $instrucao->setSize('100%');
        $createdat0->setSize('48%');
        $createdat1->setSize('47%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $dtpagamento->setSize('48%');
        $orientacao->setSize('100%');
        $dtpagamento1->setSize('47%');
        $dtvencimento->setSize('48%');
        $dtvencimento1->setSize('47%');
        $dtvencimentostatus->setSize('100%');
        $idfaturaformapagamento->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_coluna->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_totais->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_largura->setSize('100%');

        $relatoriodetalhe_fk_idrelatorio_largura->placeholder = "Ex.: 100";

        $bcontainer_66e56ed62d166 = new BContainer('bcontainer_66e56ed62d166');
        $this->bcontainer_66e56ed62d166 = $bcontainer_66e56ed62d166;

        $bcontainer_66e56ed62d166->setTitle("<i class=\"fas fa-filter\"></i>Filtros", '#333', '18px', '', '#fff');
        $bcontainer_66e56ed62d166->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_66e56ed62d166->addFields([new TLabel("Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Estado:", null, '14px', null, '100%'),$pagamento]);
        $row1->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row2 = $bcontainer_66e56ed62d166->addFields([new TLabel("Pessoa:", null, '14px', null, '100%'),$idpessoa],[new TLabel("Imóvel:", null, '14px', null, '100%'),$idimovel]);
        $row2->layout = [' col-sm-6',' col-sm-6'];

        $row3 = $bcontainer_66e56ed62d166->addFields([new TLabel("Movimento:", null, '14px', null, '100%'),$es],[new TLabel("Forma de Pagamento:", null, '14px', null, '100%'),$idfaturaformapagamento],[new TLabel("Status Vencimento:", null, '14px', null),$dtvencimentostatus],[new TLabel("Status Transferência:", null, '14px', null, '100%'),$status],[new TLabel("Instrução:", null, '14px', null),$instrucao]);
        $row3->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-4'];

        $row4 = $bcontainer_66e56ed62d166->addFields([new TLabel("Dt. Pagamento <small>(Período)</small>:", null, '14px', null, '100%'),$dtpagamento,$dtpagamento1],[new TLabel("Dt. Vencimento <small>(Período)</small>:", null, '14px', null, '100%'),$dtvencimento,$dtvencimento1],[new TLabel("Dt. Lançamento <small>(Período)</small>:", null, '14px', null, '100%'),$createdat0,$createdat1]);
        $row4->layout = [' col-sm-4','col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([$bcontainer_66e56ed62d166]);
        $row5->layout = [' col-sm-12'];

        $bcontainer_66e56f0b2d16a = new BContainer('bcontainer_66e56f0b2d16a');
        $this->bcontainer_66e56f0b2d16a = $bcontainer_66e56f0b2d16a;

        $bcontainer_66e56f0b2d16a->setTitle("<i class=\"fas fa-file-alt\" style=\"color: #74C0FC;\"></i> Formato do Relatório", '#333', '18px', '', '#fff');
        $bcontainer_66e56f0b2d16a->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_66e56f0b2d16a->addFields([new TLabel("Formato:", null, '14px', null, '100%'),$format],[new TLabel("Orientação:", null, '14px', null, '100%'),$orientacao],[new TLabel("Ordenação:", null, '14px', null, '100%'),$ordem],[new TLabel("Sentido:", null, '14px', null),$sentido],[new TLabel("Estilo:", null, '14px', null),$estilo]);
        $row6->layout = [' col-sm-2',' col-sm-2',' col-sm-3',' col-sm-2','col-sm-3'];

        $row7 = $bcontainer_66e56f0b2d16a->addFields([$this->fieldList_66e56f3f2d170]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([$bcontainer_66e56f0b2d16a]);
        $row8->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Gerar Relatório Analítico", new TAction([$this, 'onPrint']), 'fas:cogs #FFFFFF');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onsalvar = $this->form->addAction("Salvar Favorito", new TAction([$this, 'onSalvar']), 'fas:star #3071A9');
        $this->btn_onsalvar = $btn_onsalvar;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Relatório de Faturas"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onPrint($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>';
            TTransaction::open(self::$database); // open a transaction

            $param['coluna'] = $param['relatoriodetalhe_fk_idrelatorio_coluna'];
            $param['largura'] = $param['relatoriodetalhe_fk_idrelatorio_largura'];
            $param['totais'] = $param['relatoriodetalhe_fk_idrelatorio_totais'];

            $criteria = new TCriteria;

            if (isset($param['idfatura']) AND $param['idfatura'] !== '')
            {
                $criteria->add(new TFilter('idfatura', '=', $param['idfatura'] )); 
            }
            if (isset($param['referencia']) AND $param['referencia'] !== '')
            {
                $criteria->add(new TFilter('referencia', 'ilike', $param['referencia'] )); 
            }
            if (isset($param['es']) AND $param['es'] !== '')
            {
                $criteria->add(new TFilter('es', '=', $param['es'] )); 
            }
            if (isset($param['idfaturaformapagamento']) AND $param['idfaturaformapagamento'] !== '')
            {
                $criteria->add(new TFilter('idfaturaformapagamento', '=', $param['idfaturaformapagamento'] )); 
            }
            if (isset($param['dtpagamento']) AND $param['dtpagamento'] !== '')
            {
                $criteria->add(new TFilter('dtpagamento', '>', TDate::date2us($param['dtpagamento']) )); 
            }
            if (isset($param['dtpagamento1']) AND $param['dtpagamento1'] !== '')
            {
                $criteria->add(new TFilter('dtpagamento', '<', TDate::date2us($param['dtpagamento1']) )); 
            }
            if (isset($param['dtvencimento']) AND $param['dtvencimento'] !== '')
            {
                $criteria->add(new TFilter('dtvencimento', '>', TDate::date2us($param['dtvencimento']) )); 
            }
            if (isset($param['dtvencimento1']) AND $param['dtvencimento1'] !== '')
            {
                $criteria->add(new TFilter('dtpagamento', '<', TDate::date2us($param['dtvencimento1']) )); 
            }
            if (isset($param['createdat0']) AND $param['createdat0'] !== '')
            {
                $criteria->add(new TFilter('createdat', '>', TDate::date2us($param['createdat0']) )); 
            }
            if (isset($param['createdat1']) AND $param['createdat1'] !== '')
            {
                $criteria->add(new TFilter('createdat', '<', TDate::date2us($param['createdat1']) )); 
            }
            if (isset($param['idpessoa']) AND $param['idpessoa'] !== '')
            {
                $criteria->add(new TFilter('idpessoa', '=', $param['idpessoa'] )); 
            }
            if (isset($param['idcontrato']) AND $param['idcontrato'] !== '')
            {
                $criteria->add(new TFilter('idcontrato', '=', $param['idcontrato'] )); 
            }
            if (isset($param['status']) AND $param['status'] !== '')
            {
                $criteria->add(new TFilter('status', '=', $param['status'] )); 
            }
            if (isset($param['idimovel']) AND $param['idimovel'] !== '')
            {
                $criteria->add(new TFilter('idimovel', '=', $param['idimovel'] )); 
            }

            if (isset($param['dtvencimentostatus']) AND $param['dtvencimentostatus'] !== '')
            {
                $criteria->add(new TFilter('dtvencimentostatus', '=', $param['dtvencimentostatus'] )); 
            }

            if (isset($param['pagamento']) AND $param['pagamento'] !== '')
            {
                if( $param['pagamento'] == 1)
                {
                    $criteria->add(new TFilter('dtpagamento', 'IS NOT', null)); 
                }
                if( $param['pagamento'] == 2)
                {
                    $criteria->add(new TFilter('dtpagamento', 'IS', null)); 
                }
            }

            $criteria->setProperty('order', "{$param['ordem']} {$param['sentido']}");
            // load using repository
            $repository = new TRepository('Faturafull'); 
            $faturas = $repository->load($criteria);

            if(!$faturas)
            {
                throw new Exception('Sem registro a serem exibidos!');
            }

            foreach($param['largura'] AS $largura)
            {
                $larg[] = $largura < 1 ? 100 : $largura;
            }
            $widths = $larg;

            switch ($param['format'])
            {
                case 'html':
                    $tr = new TTableWriterHTML($widths);
                    $font = 'courier';
                    break;
                case 'xls':
                    $tr = new TTableWriterXLS($widths);
                    $font = 'courier';
                    break;
                case 'pdf':
                    $tr = new TTableWriterPDF($widths, $param['orientacao'], 'A4');
                    $font = 'courier';
                    break;
                case 'rtf':
                    if (!class_exists('PHPRtfLite_Autoloader'))
                    {
                        PHPRtfLite::registerAutoloader();
                    }
                    $tr = new TTableWriterRTF($widths, $param['orientacao'], 'A4');
                    $font = 'Arial';
                    break;
            }

            if (empty($tr))
            {
                throw new Exception('Não foi possível determinar o formato do relatório!');
            }            

            // create the document styles
            $tr->addStyle('title', $font, '9', 'B',   '#ffffff', '#96c0e6');
            $tr->addStyle('datap', $font, '8', '',    '#000000', '#f0f0f0');
            $tr->addStyle('datai', $font, '8', '',    '#000000', '#ffffff');
            $tr->addStyle('header', $font, '16', 'B',   '#ffffff', '#494D90');
            $tr->addStyle('header1', $font, '10', 'i',   '#ffffff', '#494D90');
            $tr->addStyle('footer', $font, '10', 'B',  '#4589c5', '#B1B1EA');
            $tr->addStyle('break', $font, '10', 'B',  '#ffffff', '#8da4bc');
            $tr->addStyle('total', $font, '10', 'I',  '#000000', '#b2d1dc');
            $tr->addStyle('breakTotal', $font, '10', 'I',  '#000000', '#b3d5f3');            

            $labels = array( 'idfatura' => 'Fatura Cód.',
                             'idcaixa' => 'Caixa Cód.',
                             'idcontrato' => 'Contrato Nº',
                             'descontodiasant' => 'Desconto Dias Antecipação',
                             'descontotipo' => 'Desconto Tipo',
                             'descontovalor' => 'Desconto Valor',
                             'createdat' => 'Emissão Dt.',
                             'emiterps' => 'Emitir RPS',
                             'faturaformapagamento' => 'Forma de Pagamento',
                             'instrucao' => 'Instruções',
                             'juros' => 'Juros',
                             'es' => 'Tipo de Movimento',
                             'multa' => 'Multa',
                             'dtpagamento' => 'Pagamento Dt.',
                             'dtpagamentostatus' => 'Pagamento status',
                             'pessoa' => 'Pessoa',
                             'referencia' => 'Referência',
                             'valortotal' => 'Valor Fatura',
                             'caixavalor' => 'Valor Pago',
                             'dtvencimento' => 'Vencimento Dt.',
                             'dtvencimentostatus' => 'Vencimento status',
                             'bairro' => 'Bairro',
                             'celular' => 'Celular',
                             'cidade' => 'Cidade',
                             'cnpjcpf' => 'CNPJ/CPF',
                             'fone' => 'Fone',
                             'endereco' => 'Endereço',
                             'email' => 'E-mail' );

            // add titles row
            $tr->addRow();
            $tr->addCell('Relatório Analítico de Faturas', 'center', 'header', count($param['coluna']) );

            $tr->addRow();
            foreach( $param['coluna'] AS $coluna)
            {
                $tr->addCell($labels["{$coluna}"], 'center', 'title');
            }

            $colour = false;
            foreach ($faturas as $fatura)
            {
                // echo '<pre>' ; print_r($fatura);echo '</pre>'; exit();
                $style = $colour ? 'datap' : 'datai';
                $firstRow = false;
                $tr->addRow();

                foreach( $param['coluna'] AS $row => $coluna)
                {
                    if( $coluna === 'emiterps' )
                    {
                        $tr->addCell($fatura->$coluna == true ? 'Sim' : 'Não', 'center', $style);
                        continue;
                    }

                    if( $coluna === 'dtpagamento' OR $coluna === 'dtvencimento' OR $coluna === 'createdat' )
                    {
                        $tr->addCell(TDate::date2br($fatura->$coluna), 'center', $style);
                        continue;
                    }

                    if( $coluna === 'idfatura' OR $coluna === 'idcaixa' OR $coluna === 'idcontrato' )
                    {
                        $tr->addCell($fatura->$coluna == '' ? '' : str_pad($fatura->$coluna, 6, '0', STR_PAD_LEFT), 'center', $style);
                        continue;
                    }

                    if( $coluna === 'juros' OR $coluna === 'multa' OR $coluna === 'valortotal' OR $coluna === 'caixavalor' )
                    {
                        $tr->addCell( number_format($fatura->$coluna, 2, ',', '.'), 'right', $style);
                        continue;
                    }

                    if( $coluna === 'es' )
                    {
                        $tr->addCell( $fatura->$coluna == 'E' ? 'A Receber' : 'A Pagar', 'center', $style);
                        continue;
                    }

                    $tr->addCell($fatura->$coluna, 'left', $style);

                } // foreach( $param['coluna'] AS $coluna)

                if($param['estilo'] == 'A')
                {
                     $faturadetalhes = Faturadetalhefull::where('idfatura', '=', $fatura->idfatura)->load();
                     if ($faturadetalhes)
                     {
                        $tr->addRow();

                        $tr->addCell($param['format'] != 'html' ? 'Ítens da fatura':   '<strong>Ítens da fatura</strong>', 'center', $style, count($param['coluna']) < 6 ? 6 : count($param['coluna']) );
                        $tr->addRow();
                        $tr->addCell('Item', 'center', 'title');
                        $tr->addCell('Qtde', 'center', 'title');
                        $tr->addCell('Valor', 'center', 'title');
                        $tr->addCell('Desconto', 'center', 'title');
                        $tr->addCell('Bruto', 'center', 'title');
                        $tr->addCell('Líquido', 'center', 'title');

                        foreach($faturadetalhes AS $faturadetalhe)
                        {
                            $tr->addRow();
                            $tr->addCell($faturadetalhe->faturadetalheitem, 'left', $style);
                            $tr->addCell($faturadetalhe->qtde, 'right', $style);
                            $tr->addCell($faturadetalhe->valor, 'right', $style);
                            $tr->addCell($faturadetalhe->desconto, 'right', $style);
                            $tr->addCell($faturadetalhe->totalsemdesconto, 'right', $style);
                            $tr->addCell($faturadetalhe->totalcomdesconto, 'right', $style);

                        }
                        $tr->addRow();
                        $tr->addCell($param['format'] != 'html' ?  ' - '  :'<hr size="2" width="80%" align="center" noshade>', 'center', $style, count($param['coluna']) < 6 ? 6 : count($param['coluna']) );
                        $tr->addRow();
                        foreach( $param['coluna'] AS $coluna)
                        {
                            $tr->addCell($labels["{$coluna}"], 'center', 'title');
                        }

                     } // if ($faturadetalhes)

                } // if($param['estilo'] == 'A')

                $colour = !$colour;
            } // foreach ($faturas as $fatura)

            $tr->addRow();
            foreach ( $param['totais'] AS $row => $total )
            {
                switch ($total)
                {
                    case "C":
                        $count = 0;
                        foreach( $faturas AS $faturacont)
                        {
                            $coluna = $param['coluna'][$row];
                            $count = $faturacont->$coluna != '' ? $count +1  : $count;
                        }
                        $grandTotal[$row] = 'Cnt = '. $count;
                        break;

                    case "S":
                        $sum = 0;
                        foreach( $faturas AS $faturacont)
                        {
                            $coluna = $param['coluna'][$row];
                            $sum = is_numeric( $faturacont->$coluna ) ? $sum + $faturacont->$coluna  : $sum;
                        }
                        $grandTotal[$row] = 'Sum = '. number_format($sum, 2, ',', '.');
                        break;

                    case "M":
                        $sum = 0;
                        $count = 0;
                        foreach( $faturas AS $faturacont)
                        {
                            $coluna = $param['coluna'][$row];
                            $sum = is_numeric( $faturacont->$coluna ) ? $sum + $faturacont->$coluna  : $sum;
                            $count = is_numeric( $faturacont->$coluna ) ? $count +1  : $count;
                        }
                        if($sum > 0)
                        {
                            $grandTotal[$row] = 'Avg = '. number_format($sum / $count, 2, ',', '.');
                        }
                        else
                        {
                            $grandTotal[$row] = 'Avg = NULL';
                        }
                        break;

                    default:
                        $grandTotal[$row] = '';
                }
                $tr->addCell($grandTotal[$row], 'right', $style);
            }

            $file = 'report_'.uniqid().".{$param['format']}";

            // stores the file
            if (!file_exists("app/output/{$file}") || is_writable("app/output/{$file}"))
            {
                $tr->save("app/output/{$file}");
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . "app/output/{$file}");
            }            

            parent::openFile("app/output/{$file}");

            new TMessage('info', "Documento gerado com sucesso.");

            TTransaction::close(); // close the transaction

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onSalvar($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; //exit();
            TSession::setValue('relatorio_favorito', $param);

            // AdiantiCoreApplication::loadPage( 'RelatorioFavoritoNovoForm', 'onEdit', ['key' => 1]);
            AdiantiCoreApplication::loadPage( 'RelatorioFavoritoNovoForm', 'onEdit');

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

                $object = new Relatorio($key); // instantiates the Active Record 

                $this->fieldList_66e56f3f2d170_items = $this->loadItems('Relatoriodetalhe', 'idrelatorio', $object, $this->fieldList_66e56f3f2d170, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_66e56f3f2d170); 

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

        $this->fieldList_66e56f3f2d170->addHeader();
        $this->fieldList_66e56f3f2d170->addDetail($this->default_item_fieldList_66e56f3f2d170);

        $this->fieldList_66e56f3f2d170->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldList_66e56f3f2d170->addHeader();
        $this->fieldList_66e56f3f2d170->addDetail($this->default_item_fieldList_66e56f3f2d170);

        $this->fieldList_66e56f3f2d170->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


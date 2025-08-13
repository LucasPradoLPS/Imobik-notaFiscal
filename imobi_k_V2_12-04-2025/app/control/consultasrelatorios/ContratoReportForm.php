<?php

class ContratoReportForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratofull';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ContratoReportForm';

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
        $this->form->setFormTitle("Relatório de Contratos");

        $retrato = '↕️ ' . ' Retrato';
        $paisagem = '↔️ ' . ' Paisagem';
        $asc = '⬇️ ️ ' . 'Ascendente';
        $desc = '⬆️ ' . 'Descendente';

        $idcontrato = new TEntry('idcontrato');
        $idimovel = new TEntry('idimovel');
        $logradouro = new TEntry('logradouro');
        $bairro = new TEntry('bairro');
        $cidadeuf = new TEntry('cidadeuf');
        $cep = new TEntry('cep');
        $comissao = new TNumeric('comissao', '2', ',', '.' );
        $periodicidade = new TEntry('periodicidade');
        $locador = new TEntry('locador');
        $inquilino = new TEntry('inquilino');
        $procurador = new TEntry('procurador');
        $fiador = new TEntry('fiador');
        $aluguelgarantido = new TCombo('aluguelgarantido');
        $comissaofixa = new TCombo('comissaofixa');
        $rescindido = new TCombo('rescindido');
        $renovadoalterado = new TCombo('renovadoalterado');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $dtproxreajuste = new TDate('dtproxreajuste');
        $format = new TCombo('format');
        $orientacao = new TCombo('orientacao');
        $ordem = new TCombo('ordem');
        $sentido = new TCombo('sentido');
        $coluna = new TCombo('coluna[]');
        $largura = new TNumeric('largura[]', '0', ',', '.' );
        $this->colunasList = new TFieldList();

        $this->colunasList->addField(new TLabel("Campo a Exibir", null, '14px', null), $coluna, ['width' => '75%']);
        $this->colunasList->addField(new TLabel("Largura (pixel)", null, '14px', null), $largura, ['width' => '100%']);

        $this->colunasList->width = '100%';
        $this->colunasList->name = 'colunasList';

        $this->criteria_colunasList = new TCriteria();
        $this->default_item_colunasList = new stdClass();

        $this->form->addField($coluna);
        $this->form->addField($largura);

        $this->colunasList->enableSorting();

        $this->colunasList->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $coluna->enableSearch();
        $largura->setTip("1px  ± 1mm, dependendo do dispositivo. 100 é o padrão.");
        $rescindido->setBooleanMode();
        $comissaofixa->setBooleanMode();
        $aluguelgarantido->setBooleanMode();
        $renovadoalterado->setBooleanMode();

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');
        $dtproxreajuste->setDatabaseMask('yyyy-mm-dd');

        $format->setValue('html');
        $sentido->setValue('asc');
        $orientacao->setValue('P');
        $ordem->setValue('idcontratochar');
        $coluna->setValue('idcontratochar');

        $ordem->setDefaultOption(false);
        $format->setDefaultOption(false);
        $coluna->setDefaultOption(false);
        $sentido->setDefaultOption(false);
        $orientacao->setDefaultOption(false);

        $idimovel->setMask('9!');
        $idcontrato->setMask('9!');
        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $dtproxreajuste->setMask('dd/mm/yyyy');

        $rescindido->addItems(["1"=>"Sim","2"=>"Não"]);
        $comissaofixa->addItems(["1"=>"Sim","2"=>"Não"]);
        $aluguelgarantido->addItems(["1"=>"Sim","2"=>"Não"]);
        $renovadoalterado->addItems(["1"=>"Sim","2"=>"Não"]);
        $sentido->addItems(["asc"=>"{$asc}","desc"=>"{$desc}"]);
        $orientacao->addItems(["P"=>"{$retrato}","L"=>"{$paisagem}"]);
        $format->addItems(["html"=>"HTML","pdf"=>"PDF","xls"=>"XLS (Excel)","rtf"=>"RTF (Exportar)"]);
        $ordem->addItems(["aluguel"=>"Aluguel (R$)","caucao"=>"Caução (R$)","comissao"=>"Comissão","bairro"=>"Bairro","cidadeuf"=>"Cidade","idcontratochar"=>"Cod. Contrato","idimovelchar"=>"Cod. Imovel","dtcelebracao"=>"Dt. Celebração","dtextincao"=>"Dt. Extinção","dtfim"=>"Dt. Fim","dtinicio"=>"Dt. Inicio","dtproxreajuste"=>"Dt. Reajuste","imovel"=>"Endereço","fiador"=>"Fiador","inquilino"=>"Inquilino","locador"=>"Locador","procurador"=>"Procurador","testemunha"=>"Testemunha"]);
        $coluna->addItems(["idcontratochar"=>"Cod. Contrato","aluguel"=>"Aluguel (R$)","aluguelgarantido"=>"Aluguel Garantido","caucao"=>"Caução","caucaoobs"=>" Caução Obs.","comissao"=>"Comissão","comissaofixa"=>"Comissão Fixa","bairro"=>"Bairro","cidadeuf"=>"Cidade","idimovelchar"=>"Cod. Imóvel","dtcelebracao"=>"Dt. Celebração","dtextincao"=>"Dt. Extinção","dtfim"=>"Dt. Fim","dtinicio"=>"Dt. Inicio","dtproxreajuste"=>"Dt. Reajuste","imovel"=>"Endereço","fiador"=>"Fiador","inquilino"=>"Inquilino","jurosmora"=>"Juros","locador"=>"Locador","multamora"=>"Multa","obs"=>"Observações","periodicidade"=>"Periodicidade","procurador"=>"Procurador","rescindido"=>"Rescindido","testemunha"=>"Testemunha","vistoriado"=>"Vistoriado"]);

        $cep->setSize('100%');
        $dtfim->setSize('100%');
        $ordem->setSize('100%');
        $bairro->setSize('100%');
        $fiador->setSize('100%');
        $format->setSize('100%');
        $coluna->setSize('100%');
        $locador->setSize('100%');
        $sentido->setSize('100%');
        $largura->setSize('100%');
        $idimovel->setSize('100%');
        $cidadeuf->setSize('100%');
        $comissao->setSize('100%');
        $dtinicio->setSize('100%');
        $inquilino->setSize('100%');
        $idcontrato->setSize('100%');
        $logradouro->setSize('100%');
        $procurador->setSize('100%');
        $rescindido->setSize('100%');
        $orientacao->setSize('100%');
        $comissaofixa->setSize('100%');
        $dtcelebracao->setSize('100%');
        $periodicidade->setSize('100%');
        $dtproxreajuste->setSize('100%');
        $aluguelgarantido->setSize('100%');
        $renovadoalterado->setSize('100%');


        $bcontainer_6521e7c5992cc = new BContainer('bcontainer_6521e7c5992cc');
        $this->bcontainer_6521e7c5992cc = $bcontainer_6521e7c5992cc;

        $bcontainer_6521e7c5992cc->setTitle("<i class=\"fas fa-filter\"></i> Filtros", '#333', '18px', '', '#fff');
        $bcontainer_6521e7c5992cc->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_6521e7c5992cc->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Cod. Imóvel:", null, '14px', null, '100%'),$idimovel],[new TLabel("Endereço:", null, '14px', null, '100%'),$logradouro],[new TLabel("Bairro:", null, '14px', null, '100%'),$bairro]);
        $row1->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $bcontainer_6521e7c5992cc->addFields([new TLabel("Cidade:", null, '14px', null, '100%'),$cidadeuf],[new TLabel("Cep:", null, '14px', null, '100%'),$cep],[new TLabel("Comissão:", null, '14px', null, '100%'),$comissao],[new TLabel("Periodicidade:", null, '14px', null, '100%'),$periodicidade]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $bcontainer_6521e7c5992cc->addFields([new TLabel("Locador:", null, '14px', null, '100%'),$locador],[new TLabel("Inquilino:", null, '14px', null, '100%'),$inquilino],[new TLabel("Procurador:", null, '14px', null, '100%'),$procurador],[new TLabel("Fiador:", null, '14px', null, '100%'),$fiador]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $bcontainer_6521e7c5992cc->addFields([new TLabel("Aluguel Garantido:", null, '14px', null, '100%'),$aluguelgarantido],[new TLabel("Comissão Fixa:", null, '14px', null, '100%'),$comissaofixa],[new TLabel("Rescindido:", null, '14px', null, '100%'),$rescindido],[new TLabel("Renovadoalterado:", null, '14px', null, '100%'),$renovadoalterado]);
        $row4->layout = ['col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row5 = $bcontainer_6521e7c5992cc->addFields([new TLabel("Dt. Celebração:", null, '14px', null, '100%'),$dtcelebracao],[new TLabel("Dt. Inicio:", null, '14px', null, '100%'),$dtinicio],[new TLabel("Dt. Fim:", null, '14px', null, '100%'),$dtfim],[new TLabel("Dt. Reajuste:", null, '14px', null, '100%'),$dtproxreajuste]);
        $row5->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row6 = $this->form->addFields([$bcontainer_6521e7c5992cc]);
        $row6->layout = [' col-sm-12'];

        $bcontainer_6521f7cb992dc = new BContainer('bcontainer_6521f7cb992dc');
        $this->bcontainer_6521f7cb992dc = $bcontainer_6521f7cb992dc;

        $bcontainer_6521f7cb992dc->setTitle("<i class=\"fas fa-cogs\"></i> Configuração do Relatório", '#333', '18px', '', '#fff');
        $bcontainer_6521f7cb992dc->setBorderColor('#c0c0c0');

        $row7 = $bcontainer_6521f7cb992dc->addFields([new TLabel("Formato:", null, '14px', null),$format],[new TLabel("Orientação:", null, '14px', null),$orientacao],[new TLabel("Ordenação:", null, '14px', null),$ordem],[new TLabel("Sentido:", null, '14px', null),$sentido]);
        $row7->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row8 = $bcontainer_6521f7cb992dc->addFields([$this->colunasList]);
        $row8->layout = [' col-sm-12'];

        $row9 = $this->form->addFields([$bcontainer_6521f7cb992dc]);
        $row9->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Imprimir", new TAction([$this, 'onPrint']), 'fas:print #FFFFFF');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Contratos"]));
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
            // open a transaction with database
            TTransaction::open('imobi_producao');

            $criteria = new TCriteria;

            if (isset($param['idcontratochar']) AND $param['idcontratochar'] !== '')
            {
                $criteria->add(new TFilter('idimidcontratocharovel', 'ilike', $param['idcontratochar'] )); 
            }

            if (isset($param['aluguel']) AND $param['aluguel'] !== '')
            {
                $criteria->add(new TFilter('aluguel', '=', $param['aluguel'] )); 
            }

            if (isset($param['aluguelgarantido']) AND $param['aluguelgarantido'] !== '')
            {
                $criteria->add(new TFilter('aluguel', '=', $param['aluguelgarantido'] )); 
            }

            if (isset($param['caucao']) AND $param['caucao'] !== '')
            {
                $criteria->add(new TFilter('caucao', '=', $param['caucao'] )); 
            }

            if (isset($param['caucaoobs']) AND $param['caucaoobs'] !== '')
            {
                $criteria->add(new TFilter('caucaoobs', 'ilike', $param['caucao'] )); 
            }

            if (isset($param['comissao']) AND $param['comissao'] !== '')
            {
                $criteria->add(new TFilter('comissao', '=', $param['comissao'] )); 
            }

            if (isset($param['comissaofixa']) AND $param['comissaofixa'] !== '')
            {
                $criteria->add(new TFilter('comissaofixa', '=', $param['comissaofixa'] )); 
            }

            if (isset($param['bairro']) AND $param['bairro'] !== '')
            {
                $criteria->add(new TFilter('bairro', 'ilike', $param['bairro'] )); 
            }

            if (isset($param['cidadeuf']) AND $param['cidadeuf'] !== '')
            {
                $criteria->add(new TFilter('cidadeuf', 'ilike', $param['cidadeuf'] )); 
            }

            if (isset($param['idimovelchar']) AND $param['idimovelchar'] !== '')
            {
                $criteria->add(new TFilter('idimovelchar', 'ilike', $param['idimovelchar'] )); 
            }

            if (isset($param['dtcelebracao']) AND $param['dtcelebracao'] !== '')
            {
                $criteria->add(new TFilter('dtcelebracao', '=', $param['dtcelebracao'] )); 
            }

            if (isset($param['dtextincao']) AND $param['dtextincao'] !== '')
            {
                $criteria->add(new TFilter('dtextincao', '=', $param['dtextincao'] )); 
            }

            if (isset($param['dtfim']) AND $param['dtfim'] !== '')
            {
                $criteria->add(new TFilter('dtfim', '=', $param['dtfim'] )); 
            }

            if (isset($param['dtinicio']) AND $param['dtinicio'] !== '')
            {
                $criteria->add(new TFilter('dtinicio', '=', $param['dtinicio'] )); 
            }

            if (isset($param['dtproxreajuste']) AND $param['dtproxreajuste'] !== '')
            {
                $criteria->add(new TFilter('dtproxreajuste', '=', $param['dtproxreajuste'] )); 
            }

            if (isset($param['imovel']) AND $param['imovel'] !== '')
            {
                $criteria->add(new TFilter('imovel', 'ilike', $param['imovel'] )); 
            }

            if (isset($param['fiador']) AND $param['fiador'] !== '')
            {
                $criteria->add(new TFilter('fiador', 'ilike', $param['fiador'] )); 
            }

            if (isset($param['inquilino']) AND $param['inquilino'] !== '')
            {
                $criteria->add(new TFilter('inquilino', 'ilike', $param['inquilino'] )); 
            }

            if (isset($param['jurosmora']) AND $param['jurosmora'] !== '')
            {
                $criteria->add(new TFilter('jurosmora', '=', $param['jurosmora'] )); 
            }

            if (isset($param['locador']) AND $param['locador'] !== '')
            {
                $criteria->add(new TFilter('locador', 'ilike', $param['locador'] )); 
            }

            if (isset($param['multamora']) AND $param['multamora'] !== '')
            {
                $criteria->add(new TFilter('multamora', '=', $param['multamora'] )); 
            }

            if (isset($param['obs']) AND $param['obs'] !== '')
            {
                $criteria->add(new TFilter('obs', 'ilike', $param['obs'] )); 
            }

            if (isset($param['periodicidade']) AND $param['periodicidade'] !== '')
            {
                $criteria->add(new TFilter('periodicidade', '=', $param['periodicidade'] )); 
            }

            if (isset($param['procurador']) AND $param['procurador'] !== '')
            {
                $criteria->add(new TFilter('procurador', 'ilike', $param['procurador'] )); 
            }

            if (isset($param['rescindido']) AND $param['rescindido'] !== '')
            {
                $criteria->add(new TFilter('rescindido', '=', $param['rescindido'] )); 
            }

            if (isset($param['testemunha']) AND $param['testemunha'] !== '')
            {
                $criteria->add(new TFilter('testemunha', 'ilike', $param['testemunha'] )); 
            }

            if (isset($param['vistoriado']) AND $param['vistoriado'] !== '')
            {
                $criteria->add(new TFilter('vistoriado', '=', $param['vistoriado'] )); 
            }

            $criteria->setProperty('order', "{$param['ordem']} {$param['sentido']}");

            // echo $criteria->dump() .'<br>';

            // load using repository
            $repository = new TRepository('Contratofull'); 
            $contratos = $repository->load($criteria);

            if(!$contratos)
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
                    break;
                case 'xls':
                    $tr = new TTableWriterXLS($widths);
                    break;
                case 'pdf':
                    $tr = new TTableWriterPDF($widths, $param['orientacao'], 'A4');
                    break;
                case 'rtf':
                    if (!class_exists('PHPRtfLite_Autoloader'))
                    {
                        PHPRtfLite::registerAutoloader();
                    }
                    $tr = new TTableWriterRTF($widths, $param['orientacao'], 'A4');
                    break;
            }

            if (empty($tr))
            {
                throw new Exception('Não foi possível determinar o formato do relatório!');
            }

            // create the document styles
            $tr->addStyle('title', 'Helvetica', '9', 'B',   '#ffffff', '#96c0e6');
            $tr->addStyle('datap', 'Arial', '8', '',    '#000000', '#f0f0f0');
            $tr->addStyle('datai', 'Arial', '8', '',    '#000000', '#ffffff');
            $tr->addStyle('header', 'Helvetica', '16', 'B',   '#ffffff', '#494D90');
            $tr->addStyle('header1', 'Helvetica', '10', 'i',   '#ffffff', '#494D90');
            $tr->addStyle('footer', 'Helvetica', '10', 'B',  '#4589c5', '#B1B1EA');
            $tr->addStyle('break', 'Helvetica', '10', 'B',  '#ffffff', '#8da4bc');
            $tr->addStyle('total', 'Helvetica', '10', 'I',  '#000000', '#b2d1dc');
            $tr->addStyle('breakTotal', 'Helvetica', '10', 'I',  '#000000', '#b3d5f3');            

            $labels = array( 'idcontratochar' => 'Cod. Contrato',
                             'idimovelchar' => 'Cód. Imóvel',
                             'imovel' => 'Endereço',
                             'bairro' => 'Bairro',
                             'cep' => 'CEP',
                             'cidadeuf' => 'Cidade/UF',
                             'fiador' => 'Fiador',
                             'inquilino' => 'Inquilino',
                             'locador' => 'Locador',
                             'procurador' => 'Procurador',
                             'testemunha' => 'testemunha',
                             'prazo' => 'Prazo',
                             'dtcelebracao' => 'Dt. Celebração',
                             'dtextincao' => 'Dt. Extinção',
                             'dtinicio' => 'Dt. Inicio',
                             'dtfim' => 'Dt. Fim',
                             'dtproxreajuste' => 'Reajuste',
                             'aluguel' => 'Aluguel',
                             'aluguelgarantido' => 'Garantido',
                             'jurosmora' => 'Juros',
                             'melhordia' => 'Melhor Dia',
                             'multamora' => 'Multa',
                             'comissao' => 'Comissão',
                             'caucao' => 'Caução',
                             'caucaoobs' => 'Caução Obs.',
                             'obs' => 'Observações',
                             'periodicidade' => 'Periodicidade',
                             'prazorepasse' => 'Repasse',
                             'vistoriado' => 'Vistoriado',
                             'rescindido' => 'Rescindido',
                             'comissaofixa' => 'Comissão Fixa' );

            // add titles row
            $tr->addRow();
            $tr->addCell('Relatório de Contratos', 'center', 'header', count($param['coluna']) );

            $tr->addRow();
            foreach( $param['coluna'] AS $coluna)
            {
                $tr->addCell($labels["{$coluna}"], 'center', 'title');
            }

            $colour = false;
            foreach ($contratos as $contrato)
            {
                $style = $colour ? 'datap' : 'datai';
                $firstRow = false;
                $tr->addRow();

                foreach( $param['coluna'] AS $coluna)
                {

                    if( $coluna === 'aluguel' OR $coluna === 'jurosmora' OR $coluna === 'multamora' OR $coluna === 'comissao'  OR $coluna === 'caucao' )
                    {
                        $tr->addCell(number_format($contrato->$coluna, 2, ',', '.'), 'right', $style);
                        continue;
                    }

                    if( $coluna === 'dtcelebracao' OR $coluna === 'dtinicio' OR $coluna === 'dtfim' OR $coluna === 'dtproxreajuste' OR $coluna === 'dtextincao')
                    {
                        $tr->addCell( TDate::date2br($contrato->$coluna), 'center', $style);
                        continue;
                    }

                    if( $coluna === 'vistoriado' OR $coluna === 'rescindido' OR $coluna === 'comissaofixa' OR $coluna === 'aluguelgarantido')
                    {
                        $tr->addCell($contrato->$coluna == FALSE ? 'Não' : 'Sim', 'center', $style);
                        continue;
                    }

                    if( $coluna === 'idcontratochar' OR $coluna === 'idimovelchar')
                    {
                        $tr->addCell($contrato->$coluna, 'center', $style);
                        continue;
                    }

                    if( $coluna === 'imovel' OR $coluna === 'bairro' OR $coluna === 'cep' OR $coluna === 'cidadeuf' OR
                        $coluna === 'fiador' OR $coluna === 'inquilino' OR $coluna === 'prazo' OR $coluna === 'procurador' OR 
                        $coluna === 'melhordia' OR $coluna === 'testemunha' OR $coluna === 'obs' OR $coluna === 'periodicidade' OR
                        $coluna === 'prazorepasse' OR $coluna === 'caucaoobs' OR
                        $coluna === 'locador')
                    {
                        $tr->addCell($contrato->$coluna, 'left', $style);
                        continue;
                    }

                    //  $tr->addCell($contrato->$coluna, 'left', $style);

                }

                 $colour = !$colour;

            } // foreach ($imoveis as $imovel)

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

                $object = new Contratofull($key); // instantiates the Active Record 

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

        $this->colunasList->addHeader();
        $this->colunasList->addDetail($this->default_item_colunasList);

        $this->colunasList->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->colunasList->addHeader();
        $this->colunasList->addDetail($this->default_item_colunasList);

        $this->colunasList->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


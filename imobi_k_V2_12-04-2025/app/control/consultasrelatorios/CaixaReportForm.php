<?php

class CaixaReportForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Relatorio';
    private static $primaryKey = 'idrelatorio';
    private static $formName = 'form_CaixaReportForm';

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
        $this->form->setFormTitle("Relatório de Caixa");

        $criteria_pessoa = new TCriteria();
        $criteria_family = new TCriteria();
        $criteria_idcaixaespecie = new TCriteria();
        $criteria_idsystemuser = new TCriteria();

        $retrato = '↕️ ' . ' Retrato';
        $paisagem = '↔️ ' . ' Paisagem';
        $asc = '⬇️ ️ ' . 'Ascendente';
        $desc = '⬆️ ' . 'Descendente';

        $dtcaixa = new TDate('dtcaixa');
        $dtcaixa1 = new TDate('dtcaixa1');
        $pessoa = new TDBEntry('pessoa', 'imobi_producao', 'Pessoa', 'pessoa','pessoa asc' , $criteria_pessoa );
        $family = new TDBCombo('family', 'imobi_producao', 'Pcontafull', 'family', '{family}','family asc' , $criteria_family );
        $historico = new TEntry('historico');
        $es = new TCombo('es');
        $idcaixaespecie = new TDBCombo('idcaixaespecie', 'imobi_producao', 'Caixaespecie', 'idcaixaespecie', '{caixaespecie}','caixaespecie asc' , $criteria_idcaixaespecie );
        $idsystemuser = new TDBCombo('idsystemuser', 'imobi_system', 'SystemUsers', 'id', '{name}','name asc' , $criteria_idsystemuser );
        $idcaixa = new TEntry('idcaixa');
        $idfatura = new TEntry('idfatura');
        $referencia = new TEntry('referencia');
        $idcontrato = new TEntry('idcontrato');
        $filtracom = new TCheckGroup('filtracom');
        $format = new TCombo('format');
        $orientacao = new TCombo('orientacao');
        $ordem = new TCombo('ordem');
        $sentido = new TCombo('sentido');
        $relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe = new THidden('relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe[]');
        $relatoriodetalhe_fk_idrelatorio___row__id = new THidden('relatoriodetalhe_fk_idrelatorio___row__id[]');
        $relatoriodetalhe_fk_idrelatorio___row__data = new THidden('relatoriodetalhe_fk_idrelatorio___row__data[]');
        $relatoriodetalhe_fk_idrelatorio_coluna = new TCombo('relatoriodetalhe_fk_idrelatorio_coluna[]');
        $relatoriodetalhe_fk_idrelatorio_largura = new TNumeric('relatoriodetalhe_fk_idrelatorio_largura[]', '0', ',', '.' );
        $relatoriodetalhe_fk_idrelatorio_totais = new TCombo('relatoriodetalhe_fk_idrelatorio_totais[]');
        $this->fieldListCaixa = new TFieldList();

        $this->fieldListCaixa->addField(null, $relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe, []);
        $this->fieldListCaixa->addField(null, $relatoriodetalhe_fk_idrelatorio___row__id, ['uniqid' => true]);
        $this->fieldListCaixa->addField(null, $relatoriodetalhe_fk_idrelatorio___row__data, []);
        $this->fieldListCaixa->addField(new TLabel("Campo a Exibir", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_coluna, ['width' => '70%']);
        $this->fieldListCaixa->addField(new TLabel("Largura (pixel)", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_largura, ['width' => '15%']);
        $this->fieldListCaixa->addField(new TLabel("Totais", null, '14px', null), $relatoriodetalhe_fk_idrelatorio_totais, ['width' => '15%']);

        $this->fieldListCaixa->width = '100%';
        $this->fieldListCaixa->setFieldPrefix('relatoriodetalhe_fk_idrelatorio');
        $this->fieldListCaixa->name = 'fieldListCaixa';

        $this->criteria_fieldListCaixa = new TCriteria();
        $this->default_item_fieldListCaixa = new stdClass();

        $this->form->addField($relatoriodetalhe_fk_idrelatorio_idrelatoriodetalhe);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio___row__id);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio___row__data);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_coluna);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_largura);
        $this->form->addField($relatoriodetalhe_fk_idrelatorio_totais);

        $this->fieldListCaixa->enableSorting();

        $this->fieldListCaixa->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $pessoa->setDisplayMask('{pessoa}');
        $filtracom->setLayout('horizontal');
        $relatoriodetalhe_fk_idrelatorio_largura->setTip("1px  ± 1mm, dependendo do dispositivo. 100 é o padrão.");
        $relatoriodetalhe_fk_idrelatorio_largura->setAllowNegative(false);
        $dtcaixa->setDatabaseMask('yyyy-mm-dd');
        $dtcaixa1->setDatabaseMask('yyyy-mm-dd');

        $format->setValue('html');
        $sentido->setValue('asc');
        $ordem->setValue('idcaixa');

        $ordem->setDefaultOption(false);
        $format->setDefaultOption(false);
        $sentido->setDefaultOption(false);

        $idcaixa->setMask('9!');
        $idfatura->setMask('9!');
        $idcontrato->setMask('9!');
        $dtcaixa->setMask('dd/mm/yyyy');
        $dtcaixa1->setMask('dd/mm/yyyy');

        $ordem->enableSearch();
        $family->enableSearch();
        $orientacao->enableSearch();
        $idsystemuser->enableSearch();
        $idcaixaespecie->enableSearch();
        $relatoriodetalhe_fk_idrelatorio_coluna->enableSearch();
        $relatoriodetalhe_fk_idrelatorio_totais->enableSearch();

        $es->addItems(["E"=>"Entradas","S"=>"Saídas"]);
        $sentido->addItems(["asc"=>"{$asc}","desc"=>"{$desc}"]);
        $orientacao->addItems(["P"=>"{$retrato}","L"=>"{$paisagem}"]);
        $filtracom->addItems(["j"=>"Juros","m"=>"Multa","d"=>"Desconto"]);
        $format->addItems(["html"=>"HTML","pdf"=>"PDF","xls"=>"XLS (Excel)"]);
        $relatoriodetalhe_fk_idrelatorio_totais->addItems(["C"=>"Contar (Count)","M"=>"Média (Average)","S"=>"Soma (Sum)"]);
        $ordem->addItems(["idsystemuser"=>"Atendente","idfatura"=>"Cód. da Fatura","idcaixa"=>"Cód. do Caixa","dtcaixa"=>"Data do Movimento","idcaixaespecie"=>"Espécie","pessoa"=>"Pessoa","idpconta"=>"Plano de Contas","es"=>"Tipo de Movimento","valor"=>"Valor Bruto","valortotal"=>"Valor Líquido"]);
        $relatoriodetalhe_fk_idrelatorio_coluna->addItems(["idcaixa"=>"Cód. do Caixa","idsystemuser"=>"Atendente","idfatura"=>"Cód. da Fatura","dtcaixa"=>"Data do Movimento","desconto"=>"Desconto","idcaixaespecie"=>"Espécie","family"=>"Estrutural","historico"=>"Histórico","juros"=>"Juros","multa"=>"Multa","pessoa"=>"Pessoa","es"=>"Tipo de Movimento","valor"=>"Valor Bruto","valortotal"=>"Valor Líquido"]);

        $es->setSize('100%');
        $dtcaixa->setSize(150);
        $dtcaixa1->setSize(150);
        $ordem->setSize('100%');
        $pessoa->setSize('100%');
        $family->setSize('100%');
        $format->setSize('100%');
        $idcaixa->setSize('100%');
        $sentido->setSize('100%');
        $idfatura->setSize('100%');
        $historico->setSize('100%');
        $filtracom->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $orientacao->setSize('100%');
        $idsystemuser->setSize('100%');
        $idcaixaespecie->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_coluna->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_totais->setSize('100%');
        $relatoriodetalhe_fk_idrelatorio_largura->setSize('100%');

        $dtcaixa->placeholder = "De:";
        $dtcaixa1->placeholder = "Até:";
        $relatoriodetalhe_fk_idrelatorio_largura->placeholder = "Ex.: 100";

        $bcontainer_66e4b580829e9 = new BContainer('bcontainer_66e4b580829e9');
        $this->bcontainer_66e4b580829e9 = $bcontainer_66e4b580829e9;

        $bcontainer_66e4b580829e9->setTitle("<i class=\"fas fa-filter\"></i>Filtros", '#333', '18px', '', '#fff');
        $bcontainer_66e4b580829e9->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_66e4b580829e9->addFields([new TLabel("Período:", null, '14px', null, '100%'),$dtcaixa,$dtcaixa1]);
        $row1->layout = [' col-sm-5'];

        $row2 = $bcontainer_66e4b580829e9->addFields([new TLabel("Pessoa:", null, '14px', null, '100%'),$pessoa],[new TLabel("Estrutural <small>(Plano de Contas)</small>:", null, '14px', null, '100%'),$family],[new TLabel("Histórico:", null, '14px', null),$historico]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $bcontainer_66e4b580829e9->addFields([new TLabel("Movimento:", null, '14px', null, '100%'),$es],[new TLabel("Espécie:", null, '14px', null, '100%'),$idcaixaespecie],[new TLabel("Atendente:", null, '14px', null, '100%'),$idsystemuser]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $bcontainer_66e4b580829e9->addFields([new TLabel("Cód. Caixa:", null, '14px', null, '100%'),$idcaixa],[new TLabel("Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Filtrar somente os que tenham:", null, '14px', null, '100%'),$filtracom]);
        $row4->layout = [' col-sm-2',' col-sm-2',' col-sm-2','col-sm-2',' col-sm-4'];

        $row5 = $this->form->addFields([$bcontainer_66e4b580829e9]);
        $row5->layout = [' col-sm-12'];

        $bcontainer_66e4b8ef82a03 = new BContainer('bcontainer_66e4b8ef82a03');
        $this->bcontainer_66e4b8ef82a03 = $bcontainer_66e4b8ef82a03;

        $bcontainer_66e4b8ef82a03->setTitle("<i class=\"fas fa-file-alt\" style=\"color: #74C0FC;\"></i> Formato do Relatório", '#333', '18px', '', '#fff');
        $bcontainer_66e4b8ef82a03->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_66e4b8ef82a03->addFields([new TLabel("Formato:", null, '14px', null, '100%'),$format],[new TLabel("Orientação:", null, '14px', null, '100%'),$orientacao],[new TLabel("Ordenação:", null, '14px', null, '100%'),$ordem],[new TLabel("Sentido:", null, '14px', null, '100%'),$sentido]);
        $row6->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row7 = $bcontainer_66e4b8ef82a03->addFields([$this->fieldListCaixa]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([$bcontainer_66e4b8ef82a03]);
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
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Relatório de Caixa"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onPrint($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $param['coluna'] = $param['relatoriodetalhe_fk_idrelatorio_coluna'];
            $param['largura'] = $param['relatoriodetalhe_fk_idrelatorio_largura'];
            $param['totais'] = $param['relatoriodetalhe_fk_idrelatorio_totais'];

            $criteria = new TCriteria;

            if (isset($param['pessoa']) AND $param['pessoa'] !== '')
            {
                $criteria->add(new TFilter('pessoa', 'ilike', "%{$param['pessoa']}%" )); 
            }

            if (isset($param['family']) AND $param['family'] !== '')
            {
                $criteria->add(new TFilter('family', 'like', "{$param['family']}%" )); 
            }

            if (isset($param['historico']) AND $param['historico'] !== '')
            {
                $criteria->add(new TFilter('historico', 'ilike', "%{$param['historico']}%" ));
            }

            if (isset($param['es']) AND $param['es'] !== '')
            {
                $criteria->add(new TFilter('es', '=', $param['es'] )); 
            }

            if (isset($param['idcaixaespecie']) AND $param['idcaixaespecie'] !== '')
            {
                $criteria->add(new TFilter('idcaixaespecie', '=', $param['idcaixaespecie'])); 
            }

            if (isset($param['idsystemuser']) AND $param['idsystemuser'] !== '')
            {
                $criteria->add(new TFilter('idsystemuser', '=', $param['idsystemuser'] )); 
            }

            if (isset($param['idcaixa']) AND $param['idcaixa'] !== '')
            {
                $criteria->add(new TFilter('idcaixa', '=', $param['idcaixa'] )); 
            }

            if (isset($param['idfatura']) AND $param['idfatura'] !== '')
            {
                $criteria->add(new TFilter('idfatura', '=', $param['idfatura'] )); 
            }

            if (isset($param['referencia']) AND $param['referencia'] !== '')
            {
                // avoid deprecated variable-variable interpolation; concat safely
                $criteria->add(new TFilter('referencia', 'ilike', $param['referencia'] . '%'));
            }

            if (isset($param['idcontrato']) AND $param['idcontrato'] !== '')
            {
                $criteria->add(new TFilter('idcontrato', '=', $param['idcontrato'] )); 
            }
            if (isset($param['dtcaixa']) AND $param['dtcaixa'] !== '')
            {
                $criteria->add(new TFilter('dtcaixa', '>=', TDate::date2us($param['dtcaixa'] )));
            }

            if (isset($param['dtcaixa1']) AND $param['dtcaixa1'] !== '')
            {
                $criteria->add(new TFilter('dtcaixa', '>=', TDate::date2us($param['dtcaixa1'] )));
            }
            if (isset($param['filtracom']) AND $param['filtracom'] !== '')
            {
                if (in_array("j", $param['filtracom']))
                $criteria->add(new TFilter('juros', '>', 0 ));
                if (in_array("m", $param['filtracom']))
                $criteria->add(new TFilter('multa', '>', 0 ));
                if (in_array("d", $param['filtracom']))
                $criteria->add(new TFilter('desconto', '>', 0 ));
            }

            $criteria->setProperty('order', "{$param['ordem']} {$param['sentido']}");
            // load using repository
            $repository = new TRepository('Caixafull');
            $faturas = $repository->load($criteria);
            // echo '$faturas<pre>' ; print_r($faturas);echo '</pre>'; exit();

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

            $labels = array( 'idsystemuser' => 'Atendente',
                             'idfatura' => 'Fatura Nº',
                             'idcaixa' => 'Caixa Nº',
                             'desconto' => 'Desconto',
                             'dtcaixa' => 'Dt. Mov.',
                             'idcaixaespecie' => 'Espécie',
                             'historico' => 'Histórico',
                             'juros' => 'Juros',
                             'multa' => 'Multa',
                             'pessoa' => 'Pessoa',
                             'family' => 'Estrutural',
                             'es' => 'Tipo de Movimento',
                             'valor' => 'Valor Bruto',
                             'valortotal' => 'Valor Líquido');

            // add titles row
            $tr->addRow();
            $tr->addCell('Relatório Analítico de Caixa', 'center', 'header', count($param['coluna']) );

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

                    if( $coluna === 'idsystemuser')
                    {
                        TTransaction::open('imobi_system'); // open a transaction
                        $user = new SystemUsers($fatura->$coluna);
                        TTransaction::close();
                        $tr->addCell($user->name, 'left', $style);
                        continue;
                    }

                    if( $coluna === 'dtcaixa')
                    {
                        $tr->addCell(TDate::date2br($fatura->$coluna), 'center', $style);
                        continue;
                    }

                    if( $coluna === 'idfatura' OR $coluna === 'idcaixa' OR $coluna === 'idcontrato' )
                    {
                        $tr->addCell($fatura->$coluna == '' ? '' : str_pad($fatura->$coluna, 6, '0', STR_PAD_LEFT), 'center', $style);
                        continue;
                    }

                    if( $coluna === 'juros' OR $coluna === 'multa' OR $coluna === 'desconto')
                    {
                        $tr->addCell( number_format($fatura->$coluna, 2, ',', '.'), 'right', $style);
                        continue;
                    }

                    if( $coluna === 'valor' OR $coluna === 'valortotal' )
                    {
                        $sinal = $fatura->es == 'E' ? '(+)' : '(-)';
                        $tr->addCell( $sinal . number_format($fatura->$coluna, 2, ',', '.'), 'right', $style);
                        continue;
                    }

                    if( $coluna === 'es' )
                    {
                        $tr->addCell( $fatura->$coluna == 'E' ? 'A Receber' : 'A Pagar', 'center', $style);
                        continue;
                    }

                    if( $coluna === 'idcaixaespecie' )
                    {
                        $tr->addCell( $fatura->caixaespecie, 'center', $style);
                        continue;
                    }

                    $tr->addCell($fatura->$coluna, 'left', $style);

                } // foreach( $param['coluna'] AS $coluna)

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
                        $grandTotal[$row] = 'Cnt '. $count;
                        break;

                    case "S":
                        $sum = 0;
                        foreach( $faturas AS $faturacont)
                        {
                            $coluna = $param['coluna'][$row];
                            if($coluna == 'valor' OR $coluna == 'valortotal')
                            {
                                $sum = (is_numeric( $faturacont->$coluna ) AND ($faturacont->es == 'E')) ? $sum + $faturacont->$coluna  : $sum;
                                $sum = (is_numeric( $faturacont->$coluna ) AND ($faturacont->es == 'S')) ? $sum - $faturacont->$coluna  : $sum;                                
                            }
                            else
                            {
                                $sum = is_numeric( $faturacont->$coluna ) ? $sum + $faturacont->$coluna  : $sum;
                            }

                        }
                        $grandTotal[$row] = 'Sum '. number_format($sum, 2, ',', '.');
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
                            $grandTotal[$row] = 'Avg '. number_format($sum / $count, 2, ',', '.');
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

                $this->fieldListCaixa_items = $this->loadItems('Relatoriodetalhe', 'idrelatorio', $object, $this->fieldListCaixa, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListCaixa); 

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

        $this->fieldListCaixa->addHeader();
        $this->fieldListCaixa->addDetail($this->default_item_fieldListCaixa);

        $this->fieldListCaixa->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListCaixa->addHeader();
        $this->fieldListCaixa->addDetail($this->default_item_fieldListCaixa);

        $this->fieldListCaixa->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


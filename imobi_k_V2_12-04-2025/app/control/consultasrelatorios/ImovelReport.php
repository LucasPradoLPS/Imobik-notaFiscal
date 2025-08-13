<?php

class ImovelReport extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ImovelReport';

    use BuilderMasterDetailFieldListTrait;

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
        $this->form->setFormTitle("Relatório de Imóveis");

        $criteria_idcidade = new TCriteria();
        $criteria_idimovelsituacao = new TCriteria();
        $criteria_idimoveldestino = new TCriteria();
        $criteria_idimoveltipo = new TCriteria();
        $criteria_idimovelmaterial = new TCriteria();

        $retrato = '↕️ ' . ' Retrato';
        $paisagem = '↔️ ' . ' Paisagem';
        $asc = '⬇️ ️ ' . 'Ascendente';
        $desc = '⬆️ ' . 'Descendente';

        $idimovel = new TEntry('idimovel');
        $enderecofull = new TEntry('enderecofull');
        $idcidade = new TDBCombo('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', '{cidadeuf}','cidadeuf asc' , $criteria_idcidade );
        $complemento = new TEntry('complemento');
        $bairro = new TEntry('bairro');
        $cep = new TEntry('cep');
        $caracteristicas = new TEntry('caracteristicas');
        $obs = new TEntry('obs');
        $claviculario = new TEntry('claviculario');
        $pessoas = new TEntry('pessoas');
        $idimovelsituacao = new TDBCombo('idimovelsituacao', 'imobi_producao', 'Imovelsituacao', 'idimovelsituacao', '{imovelsituacao}','imovelsituacao asc' , $criteria_idimovelsituacao );
        $idimoveldestino = new TDBCombo('idimoveldestino', 'imobi_producao', 'Imoveldestino', 'idimoveldestino', '{imoveldestino}','imoveldestino asc' , $criteria_idimoveldestino );
        $idimoveltipo = new TDBCombo('idimoveltipo', 'imobi_producao', 'Imoveltipo', 'idimoveltipo', '{imoveltipo}','imoveltipo asc' , $criteria_idimoveltipo );
        $idimovelmaterial = new TDBCombo('idimovelmaterial', 'imobi_producao', 'Imovelmaterial', 'idimovelmaterial', '{imovelmaterial}','imovelmaterial asc' , $criteria_idimovelmaterial );
        $perimetro = new TCombo('perimetro');
        $imovelregistro = new TEntry('imovelregistro');
        $prefeituramatricula = new TEntry('prefeituramatricula');
        $quadra = new TEntry('quadra');
        $setor = new TEntry('setor');
        $etiquetanome = new TEntry('etiquetanome');
        $lote = new TEntry('lote');
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

        $largura->setTip("1px  ± 1mm, dependendo do dispositivo. 100 é o padrão.");
        $idimovel->setMask('9!');
        $cep->setMask('99.999-999');

        $coluna->enableSearch();
        $idcidade->enableSearch();
        $perimetro->enableSearch();

        $ordem->setDefaultOption(false);
        $format->setDefaultOption(false);
        $coluna->setDefaultOption(false);
        $sentido->setDefaultOption(false);
        $orientacao->setDefaultOption(false);

        $perimetro->addItems(["U"=>"Urbano","R"=>"Rural"]);
        $sentido->addItems(["asc"=>"{$asc}","desc"=>"{$desc}"]);
        $orientacao->addItems(["P"=>"{$retrato}","L"=>"{$paisagem}"]);
        $format->addItems(["html"=>"HTML","pdf"=>"PDF","xls"=>"XLS (Excel)","rtf"=>"RTF (Exportar)"]);
        $ordem->addItems(["aluguel"=>"Aluguel (R$)","area"=>"Área","bairro"=>"Bairro","caracteristicas"=>"Características","cep"=>"CEP","cidadeuf"=>"Cidade/UF","claviculario"=>"Claviculário","idimovelchar"=>"Código","complemento"=>"Complemento","condominio"=>"Condomínio (R$)","imoveldestino"=>"Destino","endereco"=>"Endereço","iptu"=>"IPTU (R$)","imovelmaterial"=>"Material (Construção)","obs"=>"Observações","perimetro"=>"Perímetro","pessoas"=>"Proprietário(s)","imovelsituacao"=>"Situação","imoveltipo"=>"Tipo","venda"=>"Venda(R$)"]);
        $coluna->addItems(["endereco"=>"Endereço","aluguel"=>"Aluguel (R$)","area"=>"Área","bairro"=>"Bairro","caracteristicas"=>"Características","cep"=>"CEP","cidadeuf"=>"Cidade/UF","claviculario"=>"Claviculário","idimovelchar"=>"Código","complemento"=>"Complemento","condominio"=>"Condomínio (R$)","imoveldestino"=>"Destino","iptu"=>"IPTU (R$)","imovelmaterial"=>"Material (Construção)","obs"=>"Observações","perimetro"=>"Perímetro","pessoas"=>"Proprietário(s)","imovelsituacao"=>"Situação","imoveltipo"=>"Tipo","venda"=>"Venda(R$)"]);

        $format->setValue('html');
        $sentido->setValue('asc');
        $largura->setValue('100');
        $orientacao->setValue('P');
        $ordem->setValue('endereco');
        $coluna->setValue('endereco');

        $cep->setSize('100%');
        $obs->setSize('100%');
        $lote->setSize('100%');
        $setor->setSize('100%');
        $ordem->setSize('100%');
        $bairro->setSize('100%');
        $quadra->setSize('100%');
        $format->setSize('100%');
        $coluna->setSize('100%');
        $pessoas->setSize('100%');
        $sentido->setSize('100%');
        $largura->setSize('100%');
        $idimovel->setSize('100%');
        $idcidade->setSize('100%');
        $perimetro->setSize('100%');
        $orientacao->setSize('100%');
        $complemento->setSize('100%');
        $enderecofull->setSize('100%');
        $claviculario->setSize('100%');
        $idimoveltipo->setSize('100%');
        $etiquetanome->setSize('100%');
        $imovelregistro->setSize('100%');
        $caracteristicas->setSize('100%');
        $idimoveldestino->setSize('100%');
        $idimovelsituacao->setSize('100%');
        $idimovelmaterial->setSize('100%');
        $prefeituramatricula->setSize('100%');


        $bcontainer_650b5fb50f280 = new BContainer('bcontainer_650b5fb50f280');
        $this->bcontainer_650b5fb50f280 = $bcontainer_650b5fb50f280;

        $bcontainer_650b5fb50f280->setTitle("<i class=\"fas fa-filter\"></i> Filtros", '#333', '18px', '', '#fff');
        $bcontainer_650b5fb50f280->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_650b5fb50f280->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idimovel],[new TLabel("Endereço:", null, '14px', null, '100%'),$enderecofull],[new TLabel("Cidade:", null, '14px', null, '100%'),$idcidade]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $bcontainer_650b5fb50f280->addFields([new TLabel("Complemento:", null, '14px', null, '100%'),$complemento],[new TLabel("Bairro:", null, '14px', null, '100%'),$bairro],[new TLabel("CEP:", null, '14px', null, '100%'),$cep]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $bcontainer_650b5fb50f280->addFields([new TLabel("Características:", null, '14px', null, '100%'),$caracteristicas],[new TLabel("Obs.:", null, '14px', null, '100%'),$obs],[new TLabel("Claviculário:", null, '14px', null, '100%'),$claviculario]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $bcontainer_650b5fb50f280->addFields([new TLabel("Proprietário(s):", null, '14px', null, '100%'),$pessoas],[new TLabel("Situação:", null, '14px', null, '100%'),$idimovelsituacao],[new TLabel("Finalidade:", null, '14px', null, '100%'),$idimoveldestino]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $bcontainer_650b5fb50f280->addFields([new TLabel("Tipo:", null, '14px', null, '100%'),$idimoveltipo],[new TLabel("Material (Construção):", null, '14px', null, '100%'),$idimovelmaterial],[new TLabel("Perímetro:", null, '14px', null, '100%'),$perimetro]);
        $row5->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row6 = $bcontainer_650b5fb50f280->addFields([new TLabel("Registro de Imóveis:", null, '14px', null, '100%'),$imovelregistro],[new TLabel("Registro na Prefeitura:", null, '14px', null, '100%'),$prefeituramatricula],[new TLabel("Quadra:", null, '14px', null, '100%'),$quadra]);
        $row6->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row7 = $bcontainer_650b5fb50f280->addFields([new TLabel("Setor:", null, '14px', null, '100%'),$setor],[new TLabel("Etiqueta do Site:", null, '14px', null, '100%'),$etiquetanome],[new TLabel("Lote:", null, '14px', null, '100%'),$lote]);
        $row7->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row8 = $this->form->addFields([$bcontainer_650b5fb50f280]);
        $row8->layout = [' col-sm-12'];

        $bcontainer_650b61130f293 = new BContainer('bcontainer_650b61130f293');
        $this->bcontainer_650b61130f293 = $bcontainer_650b61130f293;

        $bcontainer_650b61130f293->setTitle("<i class=\"fas fa-cogs\"></i> Configuração do Relatório", '#333', '18px', '', '#fff');
        $bcontainer_650b61130f293->setBorderColor('#c0c0c0');

        $row9 = $bcontainer_650b61130f293->addFields([new TLabel("Formato:", null, '14px', null),$format],[new TLabel("Orientação:", null, '14px', null),$orientacao],[new TLabel("Ordenação:", null, '14px', null),$ordem],[new TLabel("Sentido:", null, '14px', null),$sentido]);
        $row9->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row10 = $bcontainer_650b61130f293->addFields([$this->colunasList]);
        $row10->layout = [' col-sm-12'];

        $row11 = $this->form->addFields([$bcontainer_650b61130f293]);
        $row11->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Imprimir", new TAction([$this, 'onPrint']), 'fas:print #ffffff');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Imóveis"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onPrint($param = null) 
    {
        try
        {
            // open a transaction with database
            TTransaction::open('imobi_producao');

            $criteria = new TCriteria;

            if (isset($param['idimovel']) AND $param['idimovel'] !== '')
            {
                $criteria->add(new TFilter('idimovel', '=', $param['idimovel'] )); 
            }

            if (isset($param['enderecofull']) AND $param['enderecofull'] !== '')
            {
                $criteria->add(new TFilter('enderecofull', 'ilike', $param['enderecofull'] )); 
            }

            if (isset($param['idcidade']) AND $param['idcidade'] !== '')
            {
                $criteria->add(new TFilter('idcidade', '=', $param['idcidade'] )); 
            }

            if (isset($param['complemento']) AND $param['complemento'] !== '')
            {
                $criteria->add(new TFilter('complemento', 'ilike', $param['complemento'] )); 
            }

            if (isset($param['bairro']) AND $param['bairro'] !== '')
            {
                $criteria->add(new TFilter('bairro', 'ilike', $param['bairro'] )); 
            }

            if (isset($param['cep']) AND $param['cep'] !== '')
            {
                $criteria->add(new TFilter('bairro', '=', $param['cep'] )); 
            }

            if (isset($param['caracteristicas']) AND $param['caracteristicas'] !== '')
            {
                $criteria->add(new TFilter('caracteristicas', 'ilike', $param['caracteristicas'] )); 
            }

            if (isset($param['obs']) AND $param['obs'] !== '')
            {
                $criteria->add(new TFilter('obs', 'ilike', $param['obs'] )); 
            }

            if (isset($param['claviculario']) AND $param['claviculario'] !== '')
            {
                $criteria->add(new TFilter('claviculario', 'ilike', $param['claviculario'] )); 
            }

            if (isset($param['pessoas']) AND $param['pessoas'] !== '')
            {
                $criteria->add(new TFilter('pessoas', 'ilike', '%'.$param['pessoas'].'%' )); 
            }

            if (isset($param['idimovelsituacao']) AND $param['idimovelsituacao'] !== '')
            {
                $idimovelsituacao = $param['idimovelsituacao'];
                if( $idimovelsituacao == 5 )
                {
                    $fi = [1,3,5];
                    $criteria->add(new TFilter('idimovelsituacao', 'in', $fi )); 
                }
                if( $idimovelsituacao == 1)
                {
                    $fi = [1,5];
                    $criteria->add(new TFilter('idimovelsituacao', 'in', $fi )); 
                }
                if( $idimovelsituacao == 3)
                {
                    $fi = [3,5];
                    $criteria->add(new TFilter('idimovelsituacao', 'in', $fi )); 
                }
                if( $idimovelsituacao == 2 OR $idimovelsituacao == 4 OR $idimovelsituacao == 6 )
                {
                    $criteria->add(new TFilter('idimovelsituacao', '=', $idimovelsituacao ));
                }

            }

            if (isset($param['idimoveldestino']) AND $param['idimoveldestino'] !== '')
            {
                $criteria->add(new TFilter('idimoveldestino', '=', $param['idimoveldestino'] )); 
            }

            if (isset($param['idimoveltipo']) AND $param['idimoveltipo'] !== '')
            {
                $criteria->add(new TFilter('idimoveltipo', '=', $param['idimoveltipo'] )); 
            }

            if (isset($param['idimovelmaterial']) AND $param['idimovelmaterial'] !== '')
            {
                $criteria->add(new TFilter('idimovelmaterial', '=', $param['idimovelmaterial'] )); 
            }

            if (isset($param['perimetro']) AND $param['perimetro'] !== '')
            {
                $criteria->add(new TFilter('perimetro', '=', $param['perimetro'] )); 
            }

            if (isset($param['imovelregistro']) AND $param['imovelregistro'] !== '')
            {
                $criteria->add(new TFilter('imovelregistro', 'ilike', $param['imovelregistro'] )); 
            }

            if (isset($param['prefeituramatricula']) AND $param['prefeituramatricula'] !== '')
            {
                $criteria->add(new TFilter('prefeituramatricula', 'ilike', $param['prefeituramatricula'] )); 
            }

            if (isset($param['quadra']) AND $param['quadra'] !== '')
            {
                $criteria->add(new TFilter('quadra', 'ilike', $param['quadra'] )); 
            }

            if (isset($param['setor']) AND $param['setor'] !== '')
            {
                $criteria->add(new TFilter('setor', 'ilike', $param['setor'] )); 
            }

            if (isset($param['etiquetanome']) AND $param['etiquetanome'] !== '')
            {
                $criteria->add(new TFilter('etiquetanome', 'ilike', $param['etiquetanome'] )); 
            }

            if (isset($param['lote']) AND $param['lote'] !== '')
            {
                $criteria->add(new TFilter('lote', 'ilike', $param['lote'] )); 
            }

            if (isset($param['lote']) AND $param['lote'] !== '')
            {
                $criteria->add(new TFilter('lote', 'ilike', $param['lote'] )); 
            }

            $criteria->setProperty('order', "{$param['ordem']} {$param['sentido']}");

            // echo $criteria->dump() .'<br>';

            // load using repository
            $repository = new TRepository('Imovelfull'); 
            $imoveis = $repository->load($criteria);

            if(!$imoveis)
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

            $labels = array( 'endereco' => 'Endereço',
                             'aluguel' => 'Aluguel (R$)',
                             'area' => 'Área',
                             'bairro' => 'Bairro',
                             'caracteristicas' => 'Características',
                             'cep' => 'CEP',
                             'cidadeuf' => 'Cidade/UF',
                             'claviculario' => 'Claviculário',
                             'idimovelchar' => 'Código',
                             'complemento' => 'Complemento',
                             'condominio' => 'Condomínio (R$)',
                             'imoveldestino' => 'Destino',
                             'iptu' => 'IPTU (R$)',
                             'imovelmaterial' => 'Material (Construção)',
                             'obs' => 'Observações',
                             'perimetro' => 'Perímetro',
                             'pessoas' => 'Proprietário(s)',
                             'imovelsituacao' => 'Situação',
                             'imoveltipo' => 'Tipo',
                             'venda' => 'Venda(R$)');

            // $cabecalho = strtr($param['coluna'], $labels);
            // echo 'coluna<pre>' ; print_r($param['coluna']);echo '</pre>';

            // add titles row
            $tr->addRow();
            $tr->addCell('Relatório de Imóveis', 'center', 'header', count($param['coluna']) );

            // $tr->addRow();
            // $tr->addCell("<p>Filtros: " . $criteria->dump() . '</p>', 'left', 'header1', count($param['coluna']) );

            $tr->addRow();
            foreach( $param['coluna'] AS $coluna)
            {
                $tr->addCell($labels["{$coluna}"], 'center', 'title');
            }

            $colour = false;
            foreach ($imoveis as $imovel)
            {
                $style = $colour ? 'datap' : 'datai';
                $firstRow = false;
                $tr->addRow();

                foreach( $param['coluna'] AS $coluna)
                {
                    if( $coluna == 'aluguel' OR $coluna == 'condominio' OR $coluna == 'iptu' OR $coluna == 'venda' )
                    {
                        $tr->addCell(number_format($imovel->$coluna, 2, ',', '.'), 'right', $style);
                    }
                    else
                    {
                        $tr->addCell($imovel->$coluna, 'left', $style);
                    }

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

    public function onShow($param = null)
    {               
        $this->colunasList->addHeader();
        $this->colunasList->addDetail($this->default_item_colunasList);

        $this->colunasList->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

}


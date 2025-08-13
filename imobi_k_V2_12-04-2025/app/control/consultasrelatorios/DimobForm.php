<?php

class DimobForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_DimobForm';

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
        $this->form->setFormTitle("DIMOB");


        $explica = new TText('explica');
        $anocalendario = new TCombo('anocalendario');


        $anocalendario->addItems( Uteis::getAnos());
        $explica->setSize('100%', 100);
        $anocalendario->setSize('100%');

        $anocalendario->setValue( $param['ano'] ?? date('Y') - 1);
        $explica->setValue('Esta funcionalidade permite a geração do arquivo de exportação para o DIMOB (Declaração de Informações sobre Atividades Imobiliárias), conforme as exigências da Receita Federal. O arquivo contém os dados sobre transações imobiliárias e receitas de aluguéis, necessários para o cumprimento da obrigação acessória anual.');

$anocalendario->style = 'font-size: 16pt; text-align: center; height: 35px; ';

        $row1 = $this->form->addFields([$explica],[new TLabel("Ano Calendário:", '#FF0000', '18px', null),new TLabel(" ", null, '14px', null, '100%'),$anocalendario]);
        $row1->layout = [' col-sm-7',' col-sm-4'];

        // create the form actions
        $btn_onexport = $this->form->addAction("Gerar Arquivo para Exportação", new TAction([$this, 'onExport']), 'fas:cogs #ffffff');
        $this->btn_onexport = $btn_onexport;
        $btn_onexport->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","DIMOB"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onExport($param = null) 
    {
        try
        {
            /*
            $html = new THtmlRenderer('app/resources/em_obras.html');
            $html->enableSection('main');
            $panel = new TPanelGroup('');
            $panel->add($html);
            $window = TWindow::create("Estamos em Construção", 0.70, 0.80);
            $window->add($panel);
            $window->show();
            exit();
            */

            TTransaction::open('imobi_producao'); // open a transaction
            $config = new Configfull(1);
            TTransaction::close(); // open a transaction
             if( strlen($config->cnpjcpf) != 14)
             {
                 throw new Exception('Opração permitida somente para PESSOAS JURÍDICAS!');
             }

            if(!$param['anocalendario'])
            {
                throw new Exception('Ano-Calentário é requerido!');
            }

            new TQuestion("Essa ação pode levar um tempo considerável e deixar o sistema mais lento. Você deseja prosseguir?", new TAction([__CLASS__, 'onExportYes'], $param), new TAction([__CLASS__, 'onExportNo'], $param));

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

    public static function onExportYes($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 500 );
            TTransaction::open('imobi_producao'); // open a transaction
            $declarante = new Configfull(1);
            $extratocontratopessoas = Extratocontratopessoas::where('anocaledario', '=', $param['anocalendario'])->load();

            if(!$extratocontratopessoas)
            {
                throw new Exception("Sem registros para o ano de {$param['anocalendario']}" );
            }

            $row = 1;
            $arquivo = 'app/output/dimob_'. uniqid() . '.txt';
            $fp = fopen($arquivo, "w+"); // Abre arquivo

            $header  = 'DIMOB';                   //de 1 a 5 - 5 - Constante "DIMOB"
            $header .=  str_repeat(chr(32), 369); //de 6 a 374 - 369 - Brancos
            $header .= chr(13).chr(10);           //EOL
            fwrite($fp, $header); // Escreve no arquivo aberto.

            // echo $header . '<br>' . strlen ($header); exit();

            // Cria Ficha de Dados Iniciais - R01
            $fdi  = 'R01';                   //de 1 a 3    - 3  - Constante "R01"
            $fdi .= $declarante->cnpjcpf;    //de 4 a 17   - 14 - CNPJ do declarante
            $fdi .= $param['anocalendario']; //de 18 a 21  - 4  - Ano-calendário
            $fdi .= '0';                     //de 22 a 22  - 1  - Declaração Retificadora / "0" - Não, "1" - Sim
            $fdi .= str_repeat('0', 10);     //de 23 a 32  - 10 - Número do Recibo (se for retificadora)
            $fdi .= '0';                     //de 33 a 33  - 1  - Situação Especial / "0" - Não, "1" - Sim
            $fdi .= str_repeat('0', 8);      //de 34 a 41  - 8  - Data do evento situação especial
            $fdi .= '00';                    //de 42 a 43  - 2  - Código da situação especial / "00" - Normal
            $fdi .= str_pad(strtoupper( Uteis::sanitizeString(substr($declarante->razaosocial, 0, 60))), 60, chr(32), STR_PAD_RIGHT); //de 44 a 103 - 60 - Nome Empresarial             
            $fdi .= str_pad($declarante->responsavelcpf, 11, "0", STR_PAD_LEFT); //de 104 a 114 - 11 - CPF do Responsável pela pessoa jurídica perante à RFB
            $fdi .= str_pad(Uteis::sanitizeString(substr($declarante->endereco, 0, 120)), 120, chr(32), STR_PAD_RIGHT); //de 115 - 234 - 120 - Endereço completo do contribuinte
            $fdi .= $declarante->uf;         //de 235 - 236 - 2  - UF do Contribuinte
            $fdi .= $declarante->codreceita; //de 237 a 240 - 4  - Código do Município do Contribuinte junto a Receita
            $fdi .= str_repeat(chr(32), 20); //de 241 a 260 - 20 - Branco(s)
            $fdi .= str_repeat(chr(32), 10); //de 261 a 270 - 10 - Branco(s)
            $fdi .= chr(13).chr(10);      //EOL
            fwrite($fp, $fdi);      //Escreve no arquivo aberto.
            // echo $fdi . '<br>' . strlen ($fdi); exit();

            // Cria trailler - T9
            $trailler  = 'T9';                      //de 1 a 2   - 2   - Constante "T9"
            $trailler .= str_repeat(chr(32), 100); //de 3 a 102 - 100 - Branco(s)     
            $trailler .= chr(13).chr(10);           //EOL
            // echo $trailler . '<br>' . strlen ($trailler);

            foreach($extratocontratopessoas AS $extratocontratopessoa)
            {
                // ALUGUEL E REPASSE TOTAL
                $extratoaluguelmensal = Extratoaluguelmensal::where('idcontrato', '=', $extratocontratopessoa->idcontrato)
                                                            ->where('idpessoa', '=', $extratocontratopessoa->idpessoa)
                                                            ->where('anocaledario', '=', $param['anocalendario'])
                                                            ->first();

                $contrato = new Contratofull($extratocontratopessoa->idcontrato);
                $imovel = new Imovel($contrato->idimovel, FALSE);
                $cidade = new Cidadefull($imovel->idcidade);

                if (substr($contrato->dtinicio, 0, 4) > $param['anocalendario'])
                {
                    throw new Exception("Contrato nº {$contrato->idcontratochar}: A <strong>Data de Início</strong> é inválida. Ajuste o valor e reexecute o processo de exportação." );
                }

                if($extratoaluguelmensal)
                {
                    // Inquilino/ Locatário
                    $inquilino = Uteis::sanitizeString($extratoaluguelmensal->pessoa);
                    $inquilinocnpjcpf = $extratoaluguelmensal->cnpjcpf;

                    $aluguel_jan = $extratoaluguelmensal->aluguel_jan;
                    $repasse_jan = $extratoaluguelmensal->repasse_jan;

                    $aluguel_fev = $extratoaluguelmensal->aluguel_fev;
                    $repasse_fev = $extratoaluguelmensal->repasse_fev;

                    $aluguel_mar = $extratoaluguelmensal->aluguel_mar;
                    $repasse_mar = $extratoaluguelmensal->repasse_mar;

                    $aluguel_abr = $extratoaluguelmensal->aluguel_abr;
                    $repasse_abr = $extratoaluguelmensal->repasse_abr;

                    $aluguel_mai = $extratoaluguelmensal->aluguel_mai;
                    $repasse_mai = $extratoaluguelmensal->repasse_mai;

                    $aluguel_jun = $extratoaluguelmensal->aluguel_jun;
                    $repasse_jun = $extratoaluguelmensal->repasse_jun;

                    $aluguel_jul = $extratoaluguelmensal->aluguel_jul;
                    $repasse_jul = $extratoaluguelmensal->repasse_jul;

                    $aluguel_ago = $extratoaluguelmensal->aluguel_ago;
                    $repasse_ago = $extratoaluguelmensal->repasse_ago;

                    $aluguel_set = $extratoaluguelmensal->aluguel_set;
                    $repasse_set = $extratoaluguelmensal->repasse_set;

                    $aluguel_out = $extratoaluguelmensal->aluguel_out;
                    $repasse_out = $extratoaluguelmensal->repasse_out;

                    $aluguel_nov = $extratoaluguelmensal->aluguel_nov;
                    $repasse_nov = $extratoaluguelmensal->repasse_nov;

                    $aluguel_dez = $extratoaluguelmensal->aluguel_dez;
                    $repasse_dez = $extratoaluguelmensal->repasse_dez;                    

                    // echo "1 - Aluguel: Contrato {$extratocontratopessoa->idcontrato} - Inquilino {$extratoaluguelmensal->pessoa} - Aluguel Pago Novembro {$extratoaluguelmensal->aluguel_nov} / {$extratoaluguelmensal->repasse_nov} <br />";
                } //if($extratoaluguelmensal)

                // REPASSE INDIVIDUAL
                $extratocomissaomensal = Extratocomissaomensal::where('idcontrato', '=', $extratocontratopessoa->idcontrato)
                                                              ->where('idpessoa', '=', $extratocontratopessoa->idpessoa)
                                                              ->where('anocaledario', '=', $param['anocalendario'])
                                                              ->first();
                if($extratocomissaomensal)
                {
                    // Locador/ Proprietário
                    $locador = Uteis::sanitizeString($extratocomissaomensal->pessoa);
                    $locadorcnpjcpf = $extratocomissaomensal->cnpjcpf;

                    if($locadorcnpjcpf == $inquilinocnpjcpf)
                    {
                        throw new Exception("Contrato nº {$contrato->idcontratochar}: O CNPJ/CPF do inquilino não pode ser igual ao do locador. Verifique os dados, corrija e reexecute o processo de exportação." );

                    }

                    $com_jan =  ($aluguel_jan > 0 AND $repasse_jan > 0) ? number_format(($aluguel_jan * ($extratocomissaomensal->comissao_jan / $repasse_jan * 100) / 100) - $extratocomissaomensal->comissao_jan, 2, '.', '') : '0.00';
                    $com_fev =  ($aluguel_fev > 0 AND $repasse_fev > 0) ? number_format(($aluguel_fev * ($extratocomissaomensal->comissao_fev / $repasse_fev * 100) / 100) - $extratocomissaomensal->comissao_fev, 2, '.', '') : '0.00';
                    $com_mar =  ($aluguel_mar > 0 AND $repasse_mar > 0) ? number_format(($aluguel_mar * ($extratocomissaomensal->comissao_mar / $repasse_mar * 100) / 100) - $extratocomissaomensal->comissao_mar, 2, '.', '') : '0.00';
                    $com_abr =  ($aluguel_abr > 0 AND $repasse_abr > 0) ? number_format(($aluguel_abr * ($extratocomissaomensal->comissao_abr / $repasse_abr * 100) / 100) - $extratocomissaomensal->comissao_abr, 2, '.', '') : '0.00';
                    $com_mai =  ($aluguel_mai > 0 AND $repasse_mai > 0) ? number_format(($aluguel_mai * ($extratocomissaomensal->comissao_mai / $repasse_mai * 100) / 100) - $extratocomissaomensal->comissao_mai, 2, '.', '') : '0.00';
                    $com_jun =  ($aluguel_jun > 0 AND $repasse_jun > 0) ? number_format(($aluguel_jun * ($extratocomissaomensal->comissao_jun / $repasse_jun * 100) / 100) - $extratocomissaomensal->comissao_jun, 2, '.', '') : '0.00';
                    $com_jul =  ($aluguel_jul > 0 AND $repasse_jul > 0) ? number_format(($aluguel_jul * ($extratocomissaomensal->comissao_jul / $repasse_jul * 100) / 100) - $extratocomissaomensal->comissao_jul, 2, '.', '') : '0.00';
                    $com_ago =  ($aluguel_ago > 0 AND $repasse_ago > 0) ? number_format(($aluguel_ago * ($extratocomissaomensal->comissao_ago / $repasse_ago * 100) / 100) - $extratocomissaomensal->comissao_ago, 2, '.', '') : '0.00';
                    $com_set =  ($aluguel_set > 0 AND $repasse_set > 0) ? number_format(($aluguel_set * ($extratocomissaomensal->comissao_set / $repasse_set * 100) / 100) - $extratocomissaomensal->comissao_set, 2, '.', '') : '0.00';
                    $com_out =  ($aluguel_out > 0 AND $repasse_out > 0) ? number_format(($aluguel_out * ($extratocomissaomensal->comissao_out / $repasse_out * 100) / 100) - $extratocomissaomensal->comissao_out, 2, '.', '') : '0.00';
                    $com_nov =  ($aluguel_nov > 0 AND $repasse_nov > 0) ? number_format(($aluguel_nov * ($extratocomissaomensal->comissao_nov / $repasse_nov * 100) / 100) - $extratocomissaomensal->comissao_nov, 2, '.', '') : '0.00';
                    $com_dez =  ($aluguel_dez > 0 AND $repasse_dez > 0) ? number_format(($aluguel_dez * ($extratocomissaomensal->comissao_dez / $repasse_dez * 100) / 100) - $extratocomissaomensal->comissao_dez, 2, '.', '') : '0.00';

                    //01 - de 1 a 3   - 3  - Constante "R02"
                    $ftr02  = 'R02';
                    //02 - de 4 a 17  - 14 - CNPJ do declarante
                    $ftr02 .= $declarante->cnpjcpf;
                    //03 - de 18 a 21 - 4  - Ano-calendário
                    $ftr02 .= $param['anocalendario'];
                    //04 - de 22 a 26 - 5  - Sequencial da Locação - Varia de "00001" a "99999"
                    $ftr02 .= str_pad($row, 5, '0', STR_PAD_LEFT);
                    //05 - de 27 a 40 - 14 - CPF/CNPJ do Locador
                    $ftr02 .= str_pad(Uteis::soNumero($locadorcnpjcpf), 14, ' ', STR_PAD_RIGHT);
                    //06 - de 41 a 100 - 60 - Nome/Nome Empresarial do Locador
                    $ftr02 .= str_pad(Uteis::sanitizeString(substr($locador, 0, 60)), 60, chr(32), STR_PAD_RIGHT);
                    //07 - de 101 a 114 - 14 - CPF/CNPJ do Locatário (inquilino)
                    $ftr02 .= str_pad(Uteis::soNumero($inquilinocnpjcpf), 14, ' ', STR_PAD_RIGHT);
                    //08 - de 115 a 174 - 60 -Nome/Nome Empresarial do Locatário
                    $ftr02 .= str_pad(Uteis::sanitizeString(substr($inquilino, 0, 60)), 60, chr(32), STR_PAD_RIGHT); 
                    //09 - de 175 a 180 - 6  - Número do Contrato
                    $ftr02 .= str_pad($contrato->idcontrato, 6, '0', STR_PAD_LEFT);
                    //10 - de 181 a 188 - 8 - Data do Contrato no formato DDMMAAAA
                    $ftr02 .= date("dmY", strtotime($contrato->dtinicio));
                    // os 12 meses de aluguel, sendo 14 digitos paea cada um dos valores mensais (504 digitos) do 189 ao 692
                    // Janeiro - 182 a 196
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_jan), 14, '0', STR_PAD_LEFT) . // 182 a 196
                              str_pad(Uteis::soNumero($com_jan), 14, '0', STR_PAD_LEFT). // 197 a 211
                             '00000000000000';

                    // Fevereiro
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_fev), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_fev), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Março
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_mar), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_mar), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Abril
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_abr), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_abr), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Maio
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_mai), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_mai), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Junho
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_jun), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_jun), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Julho
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_jul), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_jul), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Agosto
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_ago), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_ago), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Setembro
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_set), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_set), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Outubro
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_out), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_out), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Novembro
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_nov), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_nov), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    // Dezembro
                    $ftr02 .= str_pad(Uteis::soNumero($extratocomissaomensal->comissao_dez), 14, '0', STR_PAD_LEFT) .
                              str_pad(Uteis::soNumero($com_dez), 14, '0', STR_PAD_LEFT).
                             '00000000000000';

                    //47 - de 693 a 693 - 1 - Tipo do Imóvel - "U" - Imóvel Urbano / "R" - Imóvel Rural
                    $ftr02 .= $imovel->perimetro;
                    //48 - de 694 a 753 - 60 - Endereço do Imóvel
                    $ftr02 .= str_pad(Uteis::sanitizeString(substr($contrato->imovel, 0, 60)), 60, chr(32), STR_PAD_RIGHT);
                    //49 - de 754 a 761 - 8 - CEP
                    $ftr02 .= str_pad(Uteis::soNumero($contrato->cep), 8, "0", STR_PAD_RIGHT);
                    //50 - de 762 a 765 - 4   - Código do Município do Imóvel
                    $ftr02 .= str_pad($cidade->codreceita, 4, '0', STR_PAD_RIGHT);
                    //51 - de 766 a 785 - 20  - Branco(s)
                    $ftr02 .= str_repeat(chr(32), 20);
                    //52 - de 786 a 787 - 2   - UF
                    $ftr02 .= Uteis::sanitizeString($cidade->uf);
                     //53 - de 788 a 797 - 10  - Branco(s)
                     $ftr02 .= str_repeat(chr(32), 10);
                    //EOL
                    $ftr02 .= chr(13).chr(10);
                    //Escreve no arquivo aberto.
                    fwrite($fp, $ftr02);
                    $row ++; // Avança a linha
                }

            } // foreach($extratocontratopessoas AS $extratocontratopessoa)

            //Escreve no arquivo aberto.
            fwrite($fp, $trailler);
            //Fecha o arquivo.
            fclose($fp);
            // Abre (download) o arquivo
            TPage::openFile($arquivo);

            set_time_limit ( 30 );

            TTransaction::close(); 

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            set_time_limit ( 30 );
            fclose($fp);
        }
    }

    public static function onExportNo($param = null) 
    {
        try 
        {
            TToast::show("info", "Operação Cancelada!", "topRight", "fas:info");
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}


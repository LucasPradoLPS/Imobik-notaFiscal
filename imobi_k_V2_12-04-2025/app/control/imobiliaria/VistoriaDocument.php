<?php

class VistoriaDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoria';
    private static $primaryKey = 'idvistoria';
    private static $htmlFile = 'app/resources/imobiliaria/vistoria_document.html';
    
    
    
    public function __construct($param)
    {
        parent::__construct();
        
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        
    }
    
    public static function onGenerate($param)
    {
        try 
        {
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            TTransaction::open(self::$database);
            $html = new THtmlRenderer(self::$htmlFile);
            $html->disableHtmlConversion();
            $config = new Config(1);
            $vistoria = new Vistoriafull($param['key']);
            $imovel = new Imovelfull($vistoria->idimovel);
            $contrato = new Contratofull($vistoria->idcontrato);
            $detalhes = Vistoriadetalhefull::where('idvistoria', '=', $vistoria->idvistoria)->
                                             orderBy('index')->
                                             load();
            
            $repasseimg = [];

            if(isset($param['laudo']))
            {
                $laudo = $param['laudo'];
            }
            else
            {
                $laudo = ' ';
                // $api_url = 'https://hipsum.co/api/?paras=3&type=hipster-latin&start=with-lorem';
                
                // Faz uma solicitação HTTP para a API
                // $response = file_get_contents($api_url);
                
                // Decodifica a resposta JSON em um array
                
                //$data = json_decode($response);
                // Itera através dos parágrafos e imprime cada um
                // foreach ($data as $paragraph) {$laudo .= '<p style="text-align: justify;">' . $paragraph . '</p>';}
            }
            
            $main = [ 'nomefantasia'         => $config->nomefantasia,
                      'logomarca'            => TrataImagemService::imgToBase64($config->logomarca),
                      'persontype'           => $config->persontype == 'J' ? 'CNPJ' : 'CPF',
                      'cnpjcpf'              => $config->persontype == 'J' ? Uteis::mask($config->cnpjcpf,'##.###.###/####-##') : Uteis::mask($config->cnpjcpf,'###.###.###-##'),
                      'endereco'             => "{$config->endereco}, {$config->addressnumber}",
                      'bairro'               => $config->bairro,
                      'cidadeuf'             => $config->cidadeuf,
                      'creci'                => $config->creci,
                      'fone'                 => Uteis::mask($config->fone,'(##)#### ####'),
                      'mobilephone'          => Uteis::mask($config->mobilephone,'(##)##### ####'),
                      'email'                => $config->email,
                      'idvistoria'           => $vistoria->idvistoriachar,
                      'vistoriatipo'         => $vistoria->vistoriatipo,
                      'vistoriastatus'       => $vistoria->vistoriastatus,
                      'dtagendamento'        => $vistoria->dtagendamento,
                      'pzcontestacao'        => $vistoria->pzcontestacao,
                      'vistoriador'          => $vistoria->vistoriador,
                      'idimovelchar'         => $imovel->idimovelchar,
                      'imovel_endereco'      => $imovel->endereco,
                      'imovel_proprietarios' => $imovel->ImovelproprietariosString,
                      'imovel_bairro'        => $imovel->bairro,
                      'imove_cidadeuf'       => $imovel->cidadeuf,
                      'imovel_cep'           => $imovel->cep,
                      'idcontrato'           => $contrato->idcontratochar,
                      'dtinicio'             => TDate::date2br($contrato->dtinicio),
                      'dtfim'                => TDate::date2br($contrato->dtfim),
                      'prazo'                => "{$contrato->prazo} ({$contrato->periodicidade})",
                      'aluguel'              => is_null($contrato->aluguel)? '  ' :number_format($contrato->aluguel, 2, ',', '.'),
                      'inquilino'            => $contrato->inquilino,
                      'locador'              => $contrato->locador,
                      'laudo'                => $laudo,
                      'dtatual'              => date("d/m/Y H:i"),
                      'print'               => !empty($param['returnHtml']) ?
                                                '<div style="page-break-before: always;"> </div><a href="#" onclick="window.print();">Imprimir ou Salvar Página</a>' : '' ];
            
            // detalhes/ítens
            foreach($detalhes AS $detalhe)
            {
                $imgs = Vistoriadetalheimg::where('idvistoriadetalhe', '=', $detalhe->idvistoriadetalhe)->load();
                $last = count($imgs);
                $repasseimg = [];
                $count = 1;

                switch($detalhe->vistoriadetalheestado)
                {
                    case 'Novo':
                        $estado = '<span style=" border-radius: 50%; display: inline-block; height: 10px; width: 10px; border: 1px solid #000000; background-color: blue;"></span> Novo';
                        $estado = $detalhe->avaliacao == '' ? $estado : $estado . ' - ' . $detalhe->avaliacao;
                    break;
                    case 'Bom':
                        $estado = '<span style="border-radius: 50%; display: inline-block; height: 10px; width: 10px; border: 1px solid #000000; background-color: green;"></span> Bom';
                        $estado = $detalhe->avaliacao == '' ? $estado : $estado . ' - ' . $detalhe->avaliacao;
                    break;
                    case 'Regular':
                        $estado = '<span style="border-radius: 50%; display: inline-block; height: 10px; width: 10px; border: 1px solid #000000; background-color: yellow;"></span> Regular';
                        $estado = $detalhe->avaliacao == '' ? $estado : $estado . ' - ' . $detalhe->avaliacao;
                    break;
                    case 'Inservível':
                        $estado = '<span style="border-radius: 50%; display: inline-block; height: 10px; width: 10px; border: 1px solid #000000; background-color: red;"></span> Inservível';
                        $estado = $detalhe->avaliacao == '' ? $estado : $estado . ' - ' . $detalhe->avaliacao;
                   break;
                }
                
                if($imgs)
                {
                    foreach($imgs AS $index => $img)
                    {
                        $index = $index + 1;
                        if($count == 1 ){ $tagopen = '<tr><td style="text-align: center;">'; $tagclose = '</td>'; } else {$tagopen = '<td style="text-align: center;">'; $tagclose = '</td>';}
                        if($count == 1 AND $last == $index){ $tagclose .= '<td>&nbsp;</td><td>&nbsp;</td>'; }
                        if($count == 2 AND $last == $index){ $tagclose .= '<td>&nbsp;</td>'; }
                        if($count == 3 AND $last == $index){ $tagclose .= '</tr>'; }
                        $repasseimg[] = array( 'tagopen'             => $tagopen,
                                               'tagclose'            => $tagclose,
                                                // 'vistoriadetalheimg' => !empty($param['returnHtml']) ? "download.php?file={$img->vistoriadetalheimg}" : $img->vistoriadetalheimg,
                                                'vistoriadetalheimg' => 'https://' . $_SERVER['HTTP_HOST'] . '/' . $img->vistoriadetalheimg,
                                               'legenda'             => (string) $img->legenda );
                        $count = $count == 3 ? 0 : $count;
                        $count ++;
                    }
                }
                else
                {
                        $repasseimg[] = array( 'tagopen'            => '<tr><td>',  
                                               'tagclose'           => '</td><td></td><td></td></tr>',
                                               'vistoriadetalheimg' => null,
                                               'legenda'            => null );
                    
                }

                $contestacao = [];
                if($detalhe->dtcontestacao)
                {
                    $contestacao[] = array( 'dtcontestacao'         => (string) TDate::date2br($detalhe->dtcontestacao),
                                            'contestacaoargumento'  => (string) $detalhe->contestacaoargumento,
                                            'contestacaoresposta'   => (string) $detalhe->contestacaoresposta,
                                            'contestacaoimg'        => 'https://' . $_SERVER['HTTP_HOST'] . '/' . $detalhe->contestacaoimg );
                }

                
                $inconformidade = [];
                if($detalhe->dtinconformidade)
                {
                    $inconformidade[] = array( 'dtinconformidade'      => (string) TDate::date2br($detalhe->dtinconformidade),
                                               'inconformidadevalor'   => number_format($detalhe->inconformidadevalor, 2, ',', '.'),
                                               'inconformidadereparo'  => $detalhe->inconformidadereparo == 'TRUE' ? 'Sim' : 'Não',
                                               'inconformidade'        => (string) $detalhe->inconformidade,
                                               'inconformidadeimg'     => 'https://' . $_SERVER['HTTP_HOST'] . '/' . $detalhe->inconformidadeimg,
                                               'imagens'               => $repasseimg );
                }
                
                $itens[] = array( 'imoveldetalhe' => (string) $detalhe->imoveldetalhe,
                                  'vistoriadetalheestado' => (string) $estado,
                                  'avaliacao'             => (string) $detalhe->avaliacao,
                                  'caracterizacao'        => (string) $detalhe->caracterizacao,
                                  'descricao'             => (string) $detalhe->descricao,
                                  'imagens'               => $repasseimg,
                                  'contestacao'           => $contestacao,
                                  'inconformidade'        => $inconformidade);                                           
                                           
                                           
            } // foreach($detalhes AS $detalhe)
            
            $html->enableSection('main', $main);
            $html->enableSection('detalhes', $itens, TRUE);
            
            TTransaction::close();

            $arquivohtml = 'app/output/' . uniqid() .'.html';
            $contents = file_put_contents($arquivohtml, $html->getContents());

            if( isset($param['returnHtml']) AND $param['returnHtml'] == 1 )
            {
                parent::openFile($arquivohtml);
                new TMessage('info', _t('Document successfully generated'));
            }
            
            if( isset($param['returnPdf']) AND $param['returnPdf'] == 1)
            {
                $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
                //lendo o arquivo HTML correspondente
                $html = file_get_contents($arquivohtml);
                //inserindo o HTML que queremos converter
                $dompdf->loadHtml($html);
                // Definindo o papel e a orientação
                $dompdf->setPaper('A4', 'portrait');
                // Renderizando o HTML como PDF
                $dompdf->render();
                // Enviando o PDF para o browser
                // $dompdf->stream();                
                $arquivopdf = 'app/output/' . uniqid() .'.pdf';
                file_put_contents($arquivopdf, $dompdf->output());
                
                //unlink($arquivohtml);
                
                parent::openFile($arquivopdf);
                
                new TMessage('info', _t('Document successfully generated'));
            }
            
            if( isset($param['returnFile']) AND $param['returnFile'] == 1)
            {
                
                // $dompdf = new \Dompdf\Dompdf();
                $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
                $html = file_get_contents($arquivohtml);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $arquivopdf = 'app/output/' . uniqid() .'.pdf';
                file_put_contents($arquivopdf, $dompdf->output());
                // unlink($arquivohtml);
                return $arquivopdf;
            }

        }
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    
    
}

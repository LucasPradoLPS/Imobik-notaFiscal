<?php

class DocumentoFormView extends TPage
{
    private static $database = 'imobi_producao';
    
    public function __construct($param)
    {
        parent::__construct();
        
        $html = new THtmlRenderer('app/resources/imobiliaria/documento_view.html');
        $main = array();
        $signers  = array();
        
        
        try
        {
            // TTransaction::open(TSession::getValue('unit_database')); // open a transaction
            TTransaction::open(self::$database);
            $key = $param['key'];
            $documento = new Documento($key);
            $lbl_documento = str_pad($documento->iddocumento, 6, '0', STR_PAD_LEFT);
            $signatarios = Signatario::where('iddocumento', '=', $key)->load();
            
            $main['docname']      = $documento->docname;
            $main['iddocumento']  = $lbl_documento;
            $main['createdat']    = @date("d/m/Y H:i", strtotime($documento->createdat) );
            $main['lastupdateat'] = @date("d/m/Y H:i", strtotime($documento->lastupdateat) );
            $main['status']       = $documento->status == 'signed' ? 'Assinado' : 'Pendente';
            $main['originalfile'] = $documento->originalfile;
            $main['signedfile']   = $documento->signedfile;
            $main['sigbutton']    = $documento->status != 'signed' ? 'btn btn-primary disabled' : 'btn btn-primary ';

            foreach( $signatarios as $row => $signatario)
            {
                $mess  = $signatario->timesviewed != '' ? "Visualizado {$signatario->timesviewed} vezes." : '';
                $mess .= $signatario->lastviewat  != '' ? ' Última visualização em '. TDate::date2br($signatario->lastviewat) : '';
                $mess  = $mess == '' ? 'Não abriu o Link.' : $mess;
                
                if($signatario->signedat != '')
                    $mess = 'Assinado em '. TDate::date2br($signatario->signedat);
                
                switch($signatario->status)
                {
                    case 'new':
                        $sstatus = 'Novo';                        
                    break;
                    case 'signed':
                        $sstatus = 'Assinado';
                    break;
                    case 'link-opened':
                        $sstatus = 'Visualizado';
                    break;
                    default:
                        $sstatus = $signatario->status;
                    break;
                }
                
                $signers[] = array( 'signatario' => $signatario->nome,
                                    'qualification' => $signatario->qualification,
                                    'signurl' => $signatario->signurl,
                                    'sstatus' => $sstatus,
                                    'mess' => $mess
                                   );
            }
            
            $html->enableSection('main', $main);
            $html->enableSection('signers', $signers, TRUE);
            $container = TVBox::pack($html);
            $container->style = 'width: 100%';
            
            // parent::add($container);
            // wrap the page content

            $bc = new TBreadCrumb();
            $bc->style = 'width: 100%';
            $bc->addHome();
            $bc->addItem('Imobiliária');
            $bc->addItem('e-assinatura');
            $bc->addItem('Detalhe');
            $vbox = new TVBox;
            $vbox->style = 'width: 100%';
            $vbox->add($bc);
            $vbox->add($container);
            
            // add the form inside the page
            parent::add($vbox);
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }

    }
    
    // função executa ao clicar no item de menu
    public function onEdit( $param )
    {
        //
    }
}

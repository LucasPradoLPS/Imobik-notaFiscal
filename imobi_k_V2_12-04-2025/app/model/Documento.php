<?php

class Documento extends TRecord
{
    const TABLENAME  = 'autenticador.documento';
    const PRIMARYKEY = 'iddocumento';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';

    private $fk_iddocumentotipo;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('iddocumentotipo');
        parent::addAttribute('brandlogo');
        parent::addAttribute('brandname');
        parent::addAttribute('brandprimarycolor');
        parent::addAttribute('createdat');
        parent::addAttribute('createdby');
        parent::addAttribute('createdthrough');
        parent::addAttribute('datelimittosign');
        parent::addAttribute('deleted');
        parent::addAttribute('deletedat');
        parent::addAttribute('disablesigneremails');
        parent::addAttribute('docname');
        parent::addAttribute('dtregistro');
        parent::addAttribute('endpoint');
        parent::addAttribute('eventtype');
        parent::addAttribute('externalid');
        parent::addAttribute('folderpath');
        parent::addAttribute('lang');
        parent::addAttribute('lastupdateat');
        parent::addAttribute('observers');
        parent::addAttribute('openid');
        parent::addAttribute('originalfile');
        parent::addAttribute('pkey');
        parent::addAttribute('sandox');
        parent::addAttribute('signatureorderactive');
        parent::addAttribute('signedfile');
        parent::addAttribute('signedfileonlyfinished');
        parent::addAttribute('status');
        parent::addAttribute('tabela');
        parent::addAttribute('token');
    
    }

    /**
     * Method set_documentotipo
     * Sample of usage: $var->documentotipo = $object;
     * @param $object Instance of Documentotipo
     */
    public function set_fk_iddocumentotipo(Documentotipo $object)
    {
        $this->fk_iddocumentotipo = $object;
        $this->iddocumentotipo = $object->iddocumentotipo;
    }

    /**
     * Method get_fk_iddocumentotipo
     * Sample of usage: $var->fk_iddocumentotipo->attribute;
     * @returns Documentotipo instance
     */
    public function get_fk_iddocumentotipo()
    {
    
        // loads the associated object
        if (empty($this->fk_iddocumentotipo))
            $this->fk_iddocumentotipo = new Documentotipo($this->iddocumentotipo);
    
        // returns the associated object
        return $this->fk_iddocumentotipo;
    }

    /**
     * Method getSignatarios
     */
    public function getSignatarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('iddocumento', '=', $this->iddocumento));
        return Signatario::getObjects( $criteria );
    }

    public function set_signatario_fk_iddocumento_to_string($signatario_fk_iddocumento_to_string)
    {
        if(is_array($signatario_fk_iddocumento_to_string))
        {
            $values = Documento::where('iddocumento', 'in', $signatario_fk_iddocumento_to_string)->getIndexedArray('iddocumento', 'iddocumento');
            $this->signatario_fk_iddocumento_to_string = implode(', ', $values);
        }
        else
        {
            $this->signatario_fk_iddocumento_to_string = $signatario_fk_iddocumento_to_string;
        }

        $this->vdata['signatario_fk_iddocumento_to_string'] = $this->signatario_fk_iddocumento_to_string;
    }

    public function get_signatario_fk_iddocumento_to_string()
    {
        if(!empty($this->signatario_fk_iddocumento_to_string))
        {
            return $this->signatario_fk_iddocumento_to_string;
        }
    
        $values = Signatario::where('iddocumento', '=', $this->iddocumento)->getIndexedArray('iddocumento','{fk_iddocumento->iddocumento}');
        return implode(', ', $values);
    }

    public function set_signatario_fk_idpessoa_to_string($signatario_fk_idpessoa_to_string)
    {
        if(is_array($signatario_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $signatario_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->signatario_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->signatario_fk_idpessoa_to_string = $signatario_fk_idpessoa_to_string;
        }

        $this->vdata['signatario_fk_idpessoa_to_string'] = $this->signatario_fk_idpessoa_to_string;
    }

    public function get_signatario_fk_idpessoa_to_string()
    {
        if(!empty($this->signatario_fk_idpessoa_to_string))
        {
            return $this->signatario_fk_idpessoa_to_string;
        }
    
        $values = Signatario::where('iddocumento', '=', $this->iddocumento)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public static function getDocumentoFranquia()
    {
        // Neste caso a franquia é mensal
        $config = new Config(1);
        $franquia = $config->sigfranquia;
        // $consumo = Documento::count();
        $consumo = Documento::where("Extract(month from dtregistro )", '=', date("m")) ->count();    
        $saldo = $franquia - $consumo;
        $class = '';
        if($franquia > 0 )
        {
            $consumido = number_format($consumo * 100 / $franquia, 2);
        
            if ($consumido <= 30)
                    $class ='success';    
            if ($consumido >= 50)
                    $class = 'info';    
            if ($consumido >= 80)
                    $class = 'warning';    
            if ($consumido >= 95)
                    $class = 'danger';

            $return = [ 'franquia'  => $franquia,
                        'consumo'   => $consumo,
                        'saldo'     => $saldo,
                        'consumido' => $consumido,
                        'excedido'  => abs($saldo),
                        'class'     => $class];
        }
        else
        {
            $return = [ 'franquia'  => 0,
                        'consumo'   =>  0,
                        'saldo'     => 0,
                        'consumido' => 0,
                        'excedido'  =>  0,
                        'class'     => FALSE];
        }
        return $return;         
    }

    public function get_signatarios()

    {

        $signatarios = Signatario::where('iddocumento', '=', $this->iddocumento)->load();

        return $signatarios;

    }  

    /**
     * Envia documento para assinatura
     * Exemplo:
     * Documento::setDocumentToSing($iddocumento, $pdf);
     */

    public static function setDocumentToSing( $iddocumento, $pdf )
    {
    
        $config = new Config(1);
        $documento = new Documento($iddocumento);
        $lbl_iddocumento = str_pad($iddocumento, 6, '0', STR_PAD_LEFT);
    
        $base64 = base64_encode( file_get_contents( $pdf ) );
    
        $itens     = Signatario::where('iddocumento', '=', $iddocumento) -> load();
        $observers = explode(", ", $config->zsobservers);
        // echo '$observers<pre>' ; print_r($observers);echo '</pre>'; exit();
    
        // preenche signatarios
        foreach( $itens AS $count => $item)
        {
            $signers[$count] = [ 'name'                   => $item->nome,
                                 'auth_mode'              => $item->authmode,
                                 'email'                  => $item->email,
                                 'send_automatic_email'   => $item->sendautomaticemail,
                                 'custom_message'         => (string) $item->custommessage,
                                 'phone_country'          => (string) $item->phonecountry,
                                 'phone_number'           => (string) $item->phonenumber,
                                 'lock_email'             => $item->lockemail,
                                 'lock_phone'             => $item->lockphone,
                                 'lock_name'              => $item->lockname,
                                 'require_selfie_photo'   => $item->requireselfiephoto,
                                 'require_document_photo' => $item->requiredocumentphoto,
                                 'qualification'          => (string) $item->qualification,
                                 'external_id'            => (string) $item->externalid,
                                 'redirect_link'          => (string) $item->redirectlink ];
        }
    
        // cria o POST
        $payload = [ 'sandbox'                   => $documento->sandox,
                     'name'                      => $documento->docname,
                     'lang'                      => $documento->lang,
                     'base64_pdf'                => $base64,
                     'disable_signer_emails'     => $documento->disablesigneremails,
                     'signed_file_only_finished' => $documento->signedfileonlyfinished,
                     'brand_logo'                => (string) $documento->brandlogo,
                     'brand_primary_color'       => (string) $documento->brandprimarycolor,
                     'brand_name'                => (string) $documento->brandname,
                     'external_id'               => (string) $documento->externalid,
                     'folder_path'               => (string) $documento->folderpath,
                     'created_by'                => (string) $documento->createdby,
                     'date_limit_to_sign'        => $documento->datelimittosign == '' ? '2099-12-31T23:59:0.000000Z' : $documento->datelimittosign,
                     'signature_order_active'    => $documento->signatureorderactive,
                     'observers'                 => $observers,
                     'signers'                   => $signers ];

        $json_payload = json_encode($payload);

        $ch = curl_init( "https://api.zapsign.com.br/api/v1/docs/?api_token={$config->zstoken}" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
    
        $zswebhook = new Zswebhook();
        $zswebhook->post = $result;
        $zswebhook->store();

        $result = json_decode($result);
        $return = '';
    
        if ( $result == 'Body da requisição deve vir em formato JSON.' )
                $return = [ 'status' => FALSE, 'mess' => 'O documento gerado excede o limite seguro de memória.<br />Tente excluir algumas fotos e enviar novamente!' ] ;
    
        if( ($result == '') OR (is_null($result) ) )
            $return = [ 'status' => FALSE, 'mess' => '<strong>ZapSign</strong>: O documento não pode ser Gerado!' ] ;
    
        if(isset($result->detail))
        {
            $return = [ 'status' => FALSE, 'mess' => '<strong>ZapSign</strong>: ' . $result->detail];
        }
        else
        {
            // $externalid = explode('#', $result->external_id);
            // processa o retorno
            $docupdate = new Documento( $iddocumento );
            $docupdate->openid       = $result->open_id;
            $docupdate->token        = $result->token;
            $docupdate->status       = $result->status;
            $docupdate->originalfile = $result->original_file;
            $docupdate->createdat    = $result->created_at;
            $docupdate->lastupdateat = $result->last_update_at;
            $docupdate->signedfile   = $result->signed_file;
            $docupdate->create       = $result->created_through;
            $docupdate->store();

            foreach($result->signers AS $signer)
            {
                $externalid = explode('#', $signer->external_id);
                $sigupdate = new Signatario( $externalid[0] );
                $sigupdate->signurl = $signer->sign_url;
                $sigupdate->token   = $signer->token;
                $sigupdate->status  = $signer->status;
                $sigupdate->store();
            } // foreach($result->signers AS $signer)
        
            $return = [ 'status' => TRUE,
                        'mess' => "Arquivo enviado para assinaturas.<br/ >Companhe o andamento pelo Documento nº #{$lbl_iddocumento}",
                        'open_id' => $result->open_id ,
                        'token' => $result->token ,
                        'tstatus' => $result->status ,
                        'original_file' => $result->original_file ,
                        'created_at' => $result->created_at ,
                        'last_update_at' => $result->last_update_at ,
                        'signed_file' => $result->signed_file ,
                        'created_through' => $result->created_through ];        
        }
    
        return $return;
    }

    public static function setAlert()
    {
            $franquia = Documento::getDocumentoFranquia();
        
            if($franquia['consumido'] >= 100)
            {
                $tmess = '<br/>Franquia de Assinatura excedido.';
                TToast::show('warning','Aviso.<br />A sua franquia mensal de Documentos excedeu.', 'top right', 'fas:battery-quarter' );
                $permission = TTransaction::open('permission');
                $preferences = SystemPreference::getAllPreferences();
                $permission = TTransaction::close();
                $message = 'From: ' . TSession::getValue('userunitname') . ' / ' . TSession::getValue('username') . "\n\n";
                $message .= "Este cliente atingiu a franquia mensal de assinaturas digitais, a saber: \n\n";
                $message .= " Franquia Mensal: {$franquia['franquia']} \n Consumo : {$franquia['consumo']} \n Excedido: {$franquia['excedido']}"; 
                MailService::send( trim($preferences['mail_support'] ?? ''), 'Alerta', $message );
            }

    } 

                                                                    
}


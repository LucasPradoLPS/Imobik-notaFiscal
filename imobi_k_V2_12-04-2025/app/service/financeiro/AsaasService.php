<?php

class AsaasService
{

    /*
    public function __construct($param)
    {
        
    }
    */
    
    public static function myFunction($param)
    {
        try
        {
            // 
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }    
    
    /*
     * $asaasService = new AsaasService;
     * $id = $asaasService->cadastrarCliente('101');
     * $id = $this->cadastrarCliente('101');
     * é definida como private, o que significa que ela só pode ser acessada dentro da própria classe.
    */    
    
    public function cadastrarCliente($idpessoa)
    {
        try
        {
            $config = new Config(1);
			$url = "https://{$config->system}/customers";
            $token = $config->apikey;
            $pessoa = new Pessoafull($idpessoa);
            
            if($pessoa) // Se a pessoa existe
            {
                if($pessoa->asaasid == '') ///Se pessoa não possui cadastro no Asaas
                {
                    // monta os parâmetros para a solicitação de criação de cliente
                    $customer = [ 'name'                 => $pessoa->pessoa,
                                  'email'                => $pessoa->email,
                                  'phone'                => Uteis::soNumero($pessoa->fones),
                                  'mobilePhone'          => Uteis::soNumero($pessoa->celular),
                                  'cpfCnpj'              => $pessoa->cnpjcpf,
                                  'postalCode'           => Uteis::mask(Uteis::soNumero($pessoa->cep),'#####-###'),
                                  'address'              => $pessoa->endereco,
                                  'province'             => $pessoa->bairro,
                                  'externalReference'    => $pessoa->idpessoa,
                                  'notificationDisabled' => 'FALSE',
                                  'additionalEmails'     => 'comercial@imobik.com.br',
                                  'municipalInscription' => $pessoa->inscmunicipal,
                                  'stateInscription'     => $pessoa->inscestadual,
                                  'observations'         => "{$pessoa->observacoes} - fone(s): " . Uteis::soNumero($pessoa->fones),
                                  'groupName'            => TSession::getValue('userunitname')
                                ];

                    // envia a solicitação POST para a API do Asaas
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'access_token: ' . $token]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customer, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                    $response = curl_exec($ch);
                    curl_close($ch);
                    
                    // verifica se houve erro na resposta da API do Asaas
                    $response = json_decode($response);
                    
                    if(is_null($response)){
                        throw new Exception('O servidor Webhook não respondeu. Confira as configurações da empresa!');
                    }
                    
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }
                    
                    //  Atualizar cadastro da Pessoa, salvando
                    $customer = new Pessoa($idpessoa);
                    $customer->asaasid = $response->id;
                    $customer->store();
                    
                    // Atualizar notificaçoes
                    $this->atualizaNotificacao($customer->idpessoa);
                    
                    // retorne o ID do cliente criado
                    return $response->id;
                    
                } // if($pessoa->asaasid == '')
            } // if($pessoa)
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }        
    } // cadastrarCliente
    



    public function atualizarCliente($idpessoa)
    {
        try
        {
            $config = new Config(1);
            $pessoa = new Pessoafull($idpessoa);
			$url = "https://{$config->system}/customers/{$pessoa->asaasid}";
            $token = $config->apikey;
            
            $customer = [ 'name'                 => $pessoa->pessoa,
                          'email'                => $pessoa->email,
                          'phone'                => Uteis::soNumero($pessoa->fones),
                          'mobilePhone'          => Uteis::soNumero($pessoa->celular),
                          'cpfCnpj'              => $pessoa->cnpjcpf,
                          'postalCode'           => Uteis::mask(Uteis::soNumero($pessoa->cep),'#####-###'),
                          'address'              => $pessoa->endereco,
                          'province'             => $pessoa->bairro,
                          'externalReference'    => $pessoa->idpessoa,
                          'notificationDisabled' => 'FALSE',
                          'additionalEmails'     => 'comercial@imobik.com.br',
                          'municipalInscription' => $pessoa->inscmunicipal,
                          'stateInscription'     => $pessoa->inscestadual,
                          'observations'         => "{$pessoa->observacoes} - fone(s): " . Uteis::soNumero($pessoa->fones),
                          'groupName'            => TSession::getValue('userunitname')
                        ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json',
                                                  "User-Agent:Imobi-K_v2",
                                                  'access_token: ' . $token]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customer, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $response = curl_exec($ch);
            curl_close($ch);
            
            // verifica se houve erro na resposta da API do Asaas
            $response = json_decode($response);
            
            if(is_null($response)){
                throw new Exception('O servidor Webhook não respondeu. Confira as configurações da empresa!');
            }
            
            if(isset($response->errors))
            {
                $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }
            
            // retorne o ID do cliente criado
            return $response->id;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }        
    } // atualizarCliente




    
    public function createCobranca($data)
    {
        try
        {
            // echo '<pre>' ; print_r($data);echo '</pre>';
            $config           = new Config(1);
            $pessoa           = new Pessoa($data->idpessoa, FALSE);
            $formadepagamento = new Faturaformapagamento($data->idfaturaformapagamento);
            $billingtype      = $formadepagamento->billingtype;
            $discount_value   = $data->descontovalor == '' ? 0 : $data->descontovalor;
            $daysafterduedatetocancellationregistration = $data->daysafterduedatetocancellationregistration == 0 ? '' : 1 ;
            $fine_value = $data->multafixa == TRUE ? 'FIXED' : 'PERCENTAGE'; //Trata Multa
            // parâmetros
            $boleto =  ['customer'           => $pessoa->asaasid == '' ? $this->cadastrarCliente($pessoa->idpessoa) : $pessoa->asaasid,
                        'billingType'        => $billingtype,
                        'daysAfterDueDateToCancellationRegistration' => $daysafterduedatetocancellationregistration,
                        'dueDate'            => $data->dtvencimento,
                        'value'              => $data->valortotal,
                        'description'        => str_replace(array("<p>", "<br>", "<br />"), "\n", $data->instrucao),
                        'externalReference'  => $config->database .'#'. $data->idfatura,
                        'discount'           => ['value'            => $data->descontovalor == '' ? 0 : $data->descontovalor,
                                                 'dueDateLimitDays' => $data->descontodiasant,
                                                 'type'             => $data->descontotipo == ''? 'FIXED' : $data->descontotipo ],
                       'interest'            => ['value'            => $data->juros == '' ? 0 : $data->juros],
                       'fine'                => ['value'            => $data->multa,
                                                 'type'             => $fine_value ],
                       'postalService'       => 'FALSE' ];
            // echo '<pre>' ; print_r($boleto);echo '</pre>'; exit();
            $boleto = json_encode($boleto, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
            // incluindo o boleto
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $boleto);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}"));
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response);
            
            if(isset($response->errors))
            {
                $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }            
            
            $faturaresponse = new Faturaresponse();
            $faturaresponse->idfatura                     = $data->idfatura;
            $faturaresponse->idasaasfatura                = $response->id;
            $faturaresponse->anticipable                  = $response->anticipable;
            $faturaresponse->anticipated                  = $response->anticipated;
            $faturaresponse->bankslipurl                  = $response->bankSlipUrl;
            $faturaresponse->billingtype                  = $response->billingType;
            $faturaresponse->canbepaidafterduedate        = $response->canBePaidAfterDueDate;
            $faturaresponse->daysafterduedatetocancellationregistration = $data->daysafterduedatetocancellationregistration;
            // $faturaresponse->candelete                    = $response->canDelete;
            // $faturaresponse->canedit                      = $response->canEdit;
            // $faturaresponse->cannotbedeletedreason        = $response->cannotBeDeletedReason;
            // $faturaresponse->cannoteditreason             = $response->cannotEditReason;
            // $faturaresponse->chargebackreason             = $response->chargeback->reason;
            // $faturaresponse->chargebackstatus             = $response->chargeback->status;
            $faturaresponse->clientpaymentdate            = $response->clientPaymentDate;
            // $faturaresponse->confirmeddate                = $response->confirmedDate;
            $faturaresponse->customer                     = $response->customer;
            $faturaresponse->datecreated                  = $response->dateCreated;
            $faturaresponse->deleted                      = $response->deleted;
            $faturaresponse->description                  = $response->description;
            $faturaresponse->discountduedatelimitdays     = $response->discount->dueDateLimitDays;
            $faturaresponse->discounttype                 = $response->discount->type;
            $faturaresponse->discountvalue                = $response->discount->value;
            $faturaresponse->duedate                      = $response->dueDate;
            $faturaresponse->externalreference            = $response->externalReference;
            $faturaresponse->finetype                     = $response->fine->type;
            $faturaresponse->finevalue                    = $response->fine->value;
            // $faturaresponse->installment                  = $response->installment;
            $faturaresponse->installmentnumber            = $response->installmentNumber;
            $faturaresponse->interestvalue                = $response->interest->value;
            $faturaresponse->invoicenumber                = $response->invoiceNumber;
            $faturaresponse->invoiceurl                   = $response->invoiceUrl;
            // $faturaresponse->municipalinscription         = $response->municipalInscription;
            $faturaresponse->nossonumero                  = $response->nossoNumero;
            $faturaresponse->netvalue                     = $response->netValue;
            $faturaresponse->object                       = $response->object;
            $faturaresponse->originalduedate              = $response->originalDueDate;
            $faturaresponse->originalvalue                = $response->originalValue;
            $faturaresponse->paymentdate                  = $response->paymentDate;
            $faturaresponse->paymentlink                  = $response->paymentLink;
            // $faturaresponse->pixqrcodeid                  = $response->pixQrCodeId;
            $faturaresponse->pixtransaction               = $response->pixTransaction;
            $faturaresponse->postalservice                = $response->postalService;
            // $faturaresponse->refundsdatecreated           = $response->refunds->dateCreated;
            // $faturaresponse->refundsdescription           = $response->refunds->description;
            // $faturaresponse->refundsstatus                = $response-> refunds->status;
            // $faturaresponse->refundstransactionreceipturl = $response->refunds->transactionReceiptUrl;
            // $faturaresponse->refundsvalue                 = $response->refunds->value;
            // $faturaresponse->splitfixedvalue              = $response->split->fixedValue;
            // $faturaresponse->splitpercentualvalue         = $response->split->percentualValue;
            // $faturaresponse->splitrefusalreason           = $response->split->refusalReason;
            // $faturaresponse->splitstatus                  = $response->split->status;
            // $faturaresponse->splitwalletid                = $response->split->walletId;
            // $faturaresponse->stateInscription             = $response->stateInscription;
            $faturaresponse->status                       = $response->status;
            // $faturaresponse->subscription                 = $response->subscription;
            $faturaresponse->transactionreceipturl        = $response->transactionReceiptUrl;
            $faturaresponse->value                        = $response->value;
            $faturaresponse->store();        
            return $response;
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }
    } //  createCobranca


    public function updateCobranca($data)
    {
        try
        {
            $config           = new Config(1);
            $pessoa           = new Pessoa($data->idpessoa, FALSE);
            $formadepagamento = new Faturaformapagamento($data->idfaturaformapagamento);
            $billingtype      = $formadepagamento->billingtype;
            $discount_value   = $data->descontovalor == '' ? 0 : $data->descontovalor;
            $daysafterduedatetocancellationregistration = $data->daysafterduedatetocancellationregistration == 0 ? '': 1 ;
            $fine_value = $data->multafixa == TRUE ? 'FIXED' : 'PERCENTAGE'; //Trata Multa
    
            // parâmetros
            $boleto =  ['billingType'        => $billingtype,
                        'dueDate'            => $data->dtvencimento,
                        'daysAfterDueDateToCancellationRegistration' => $daysafterduedatetocancellationregistration,
                        'value'              => $data->valortotal,
                        'description'        => str_replace(array("<p>","</p>", "<br>", "<br />", "<br></p>"), "\n", $data->instrucao),
                        'externalReference'  => $config->database .'#'. $data->idfatura,
                        'discount'           => ['value'            => $data->descontovalor == '' ? 0 : $data->descontovalor,
                                                 'dueDateLimitDays' => $data->descontodiasant,
                                                 'type'             => $data->descontotipo == ''? 'FIXED' : $data->descontotipo ],
                       'interest'            => ['value'            => $data->juros == '' ? 0 : $data->juros],
                       'fine'                => ['value'            => $data->multa == '' ? 0 : $data->multa,
                                                 'type'             => $fine_value ],
                       'postalService'       => 'FALSE' ];
            
            $boleto = json_encode($boleto, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments/{$data->referencia}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $boleto);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}"));
            $response = curl_exec($ch);
            
            $response = json_decode($response);
            
            curl_close($ch);
            
            if(isset($response->errors))
            {
                $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }            
            
            // echo '<pre>' ; print_r($response);echo '</pre>';
            
            // Atualizar Faturaresponse
            $faturaresponse = Faturaresponse::where('idasaasfatura', '=', $data->referencia)->first();
            $faturaresponse->idfatura                     = $data->idfatura;
            $faturaresponse->idasaasfatura                = $response->id;
            $faturaresponse->anticipable                  = $response->anticipable;
            $faturaresponse->anticipated                  = $response->anticipated;
            $faturaresponse->bankslipurl                  = $response->bankSlipUrl;
            $faturaresponse->billingtype                  = $response->billingType;
            $faturaresponse->daysafterduedatetocancellationregistration = $data->daysafterduedatetocancellationregistration;
            // $faturaresponse->canbepaidafterduedate        = $response->canBePaidAfterDueDate;
            $faturaresponse->clientpaymentdate            = $response->clientPaymentDate;
            $faturaresponse->customer                     = $response->customer;
            $faturaresponse->datecreated                  = $response->dateCreated;
            $faturaresponse->deleted                      = $response->deleted;
            $faturaresponse->description                  = $response->description;
            $faturaresponse->discountduedatelimitdays     = $response->discount->dueDateLimitDays;
            $faturaresponse->discounttype                 = $response->discount->type;
            $faturaresponse->discountvalue                = $response->discount->value;
            $faturaresponse->duedate                      = $response->dueDate;
            $faturaresponse->externalreference            = $response->externalReference;
            $faturaresponse->finetype                     = $response->fine->type;
            $faturaresponse->finevalue                    = $response->fine->value;
            $faturaresponse->installmentnumber            = $response->installmentNumber;
            $faturaresponse->interestvalue                = $response->interest->value;
            $faturaresponse->invoicenumber                = $response->invoiceNumber;
            $faturaresponse->invoiceurl                   = $response->invoiceUrl;
            $faturaresponse->nossonumero                  = $response->nossoNumero;
            $faturaresponse->netvalue                     = $response->netValue;
            $faturaresponse->object                       = $response->object;
            $faturaresponse->originalduedate              = $response->originalDueDate;
            $faturaresponse->originalvalue                = $response->originalValue;
            $faturaresponse->paymentdate                  = $response->paymentDate;
            $faturaresponse->paymentlink                  = $response->paymentLink;
            $faturaresponse->pixtransaction               = $response->pixTransaction;
            $faturaresponse->postalservice                = $response->postalService;
            $faturaresponse->status                       = $response->status;
            $faturaresponse->transactionreceipturl        = $response->transactionReceiptUrl;
            $faturaresponse->value                        = $response->value;
            $faturaresponse->store();
            return $response;            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }        

        
    } // updateCobranca


    public function deleteCobanca($data)
    {
        $config = new Config(1);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments/{$data->referencia}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                   "User-Agent:Imobi-K_v2",
                                                   "access_token:{$config->apikey}"));
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception('Erro ao se conectar com a API do Asaas: '.curl_error($ch));
        }
        
        curl_close($ch);
        
        $response = json_decode($response);
        
        // Atualizar Faturaresponse
        $faturaresponse = Faturaresponse::where('idasaasfatura', '=', $data->referencia)->first();
        $faturaresponse->deleted = $response->deleted;
        $faturaresponse->store();
        return $response;
        
    }  // deleteCobanca
    
    
    public function uploadDocumento($documento, $data)
    {
        try
        {
            $config = new Config(1);
            $faturaresponse = Faturaresponse::where('idasaasfatura', '=', $data->referencia)->first();
        	
        	$ch = curl_init();
        	$cfile = curl_file_create(realpath($documento), 'application/pdf', 'Copia_da_Fatura_'. uniqid() . '.pdf');

        	$document = [ 'availableAfterPayment' => FALSE,
           			      'type' => 'DOCUMENT',
        			      'file' => $cfile];
        	
        	curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments/{$data->referencia}/documents");
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        	curl_setopt($ch, CURLOPT_HEADER, FALSE);
        	curl_setopt($ch, CURLOPT_POST, TRUE);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data",
        	                                           "User-Agent:Imobi-K_v2",
        	                                           "access_token:{$config->apikey}" ));
        	$response = curl_exec($ch);
        	
        	curl_close($ch);
        	
        	$response = json_decode($response);
        	
        	if(isset($response->errors))
            {
                $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }
        	// salvando response
        	$faturaresponse->docobject                = $response->object;
        	$faturaresponse->docid                    = $response->id;
        	$faturaresponse->docname                  = $response->name;
        	$faturaresponse->doctype                  = $response->type;
        	$faturaresponse->docavailableafterpayment = $response->availableAfterPayment;
        	$faturaresponse->docfilepublicid          = $response->file->publicId;
        	$faturaresponse->docfileoriginalname      = $response->file->originalName;
        	$faturaresponse->docfilesize              = $response->file->size;
        	$faturaresponse->docfileextension         = $response->file->extension;
        	$faturaresponse->docfilepreviewurl        = $response->file->previewUrl;
        	$faturaresponse->docfiledownloadurl       = $response->file->downloadUrl;
        	$faturaresponse->docdeleted               = $response->deleted;
        	$faturaresponse->store();
            
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }
    }  // uploadDocumento

    
    public function deleteDocumento($data)
    {
        $config = new Config(1);
        $faturaresponse = Faturaresponse::where('idasaasfatura', '=', $data->referencia)->first();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments/{$data->referencia}/documents/{$faturaresponse->docid}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                   "User-Agent:Imobi-K_v2",
                                                   "access_token:{$config->apikey}" ));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        
        return $response;

    } // deleteDocumento
    
    
    public function updateDocumento($documento, $data)
    {
        $this->deleteDocumento($data);
        $this->uploadDocumento($documento, $data);
        return null;
    } // deleteDocumento
    
    
    public function receiveInCash($data)
    {
        $config = new Config(1);
        
        $dados = [ 'paymentDate'    => $data->dtpagamento,
                   'value'          => $data->value,
                   'notifyCustomer' => 'FALSE' ];
        
        $dados = json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/payments/{$data->referencia}/receiveInCash");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                   "User-Agent:Imobi-K_v2",
                                                   "access_token: {$config->apikey}" ));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        
        return $response;

    } // deleteDocumento

    public static function saldoAtual()
    {
        try
        {
            $config = new Config(1);
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/finance/balance",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);
            
            $response = curl_exec($curl);
            curl_close($curl);
            // echo '<pre>' ; print_r(json_decode($response));echo '</pre>'; exit();
            return json_decode($response);
            
            // $err = curl_error($curl);
            /*
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }            
            */
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    } // saldoAtual()

    public static function accountNumber()
    {
        try
        {
            $config = new Config(1);
            
            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/accountNumber/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);
            
            $response = curl_exec($curl);
            $response = json_decode($response);
            curl_close($curl);
            
            return $response;
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    } // saldoAtual()


    public static function onTed($param)
    {
        try
        {
            $config = new Config(1);
            $data = (object) $param;
            $fatura = new Fatura($data->idfatura);
            $pessoa = new Pessoafull($fatura->idpessoa);
            
            $transferencia = [ 'value'       => $fatura->valortotal,
                               'bankAccount' => [ 'bank'            => [ 'code' => $pessoa->bancocod],
                                                  'accountName'     => $pessoa->banco,
                                                  'ownerName'       => "{$config->database}#{$fatura->idfatura}#{$pessoa->pessoa}",
                                                  'ownerBirthDate'  => $data->dtnascimento,
                                                  'cpfCnpj'         => $pessoa->cnpjcpf,
                                                  'agency'          => $pessoa->bancoagencia,
                                                  'account'         => $pessoa->bancoconta,
                                                  'accountDigit'    => $pessoa->bancocontadv,
                                                  'bankAccountType' => $pessoa->bankaccounttype,
                                                  'ispb'            => $pessoa->ispb ],
                               'description' => $data->instrucao,
                               'scheduleDate' => $data->scheduledate
                             ];

            $transferencia = json_encode($transferencia, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $transferencia);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}" ));
            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
            
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }  

    public static function onTedAvulso($param)
    {
        try
        {
            $config = new Config(1);
            $data = (object) $param;

            $transferencia = [ 'value'       => $data->value,
                               'bankAccount' => [ 'bank'            => [ 'code' => $data->code],
                                                  'accountName'     => $data->accountname,
                                                  'ownerName'       => $data->ownername,
                                                  'ownerBirthDate'  => $data->ownerbirthdate,
                                                  'cpfCnpj'         => $data->cpfcnpj,
                                                  'agency'          => $data->agency,
                                                  'account'         => $data->account,
                                                  'accountDigit'    => $data->accountdigit,
                                                  'bankAccountType' => $data->bankaccounttype,
                                                  'ispb'            => $data->ispb ],
                               'description' => $data->description,
                               'scheduleDate' => $data->scheduleDate
                             ];

            // echo '$data<pre>' ; print_r($transferencia);echo '</pre>';
            $transferencia = json_encode($transferencia, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
            
            // echo '$data<pre>' ; print_r($transferencia);echo '</pre>';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $transferencia);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}" ));
            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
            
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }  


    public static function onPix($param)
    {
        try
        {
            $config = new Config(1);
            $data = (object) $param;
            $fatura = new Fatura($data->idfatura);
            $pessoa = new Pessoafull($fatura->idpessoa);
            
            $transferencia = [ 'value'             => $fatura->valortotal,
                               'pixAddressKey'     => $pessoa->bancochavepix,
                               'pixAddressKeyType' => $pessoa->pixaddresskeytype,
                               'description'       => $data->instrucao,
                               'ownerName'         => $pessoa->pessoa,
                               'scheduleDate'      => $data->scheduledate
                             ];

            $transferencia = json_encode($transferencia, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $transferencia);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}" ));
            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
            // echo '$response<pre>' ; print_r($response);echo '</pre>';
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }  


    public static function onPixAvulso($param)
    {
        try
        {
            $config = new Config(1);
            $data = (object) $param;
            

            $transferencia = [ 'value'             => $data->value,
                               'pixAddressKey'     => $data->pixaddresskey,
                               'pixAddressKeyType' => $data->pixaddresskeytype,
                               'ownerName'         => "{$config->database}#-1#NC",
                               'description'       => $data->description,
                               'scheduleDate'      => $data->scheduledate
                             ];

            $transferencia = json_encode($transferencia, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $transferencia);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}" ));
            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
            
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }  


    public static function transferenciaStatus($param)
    {
        try
        {
            
            $config = new Config(1);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers/{$param}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}" ));
            $response = curl_exec($ch);
            curl_close($ch);
            // print_r($response);
            $response = json_decode($response);
            // echo '<pre>' ; print_r($response);echo '</pre>'; exit();
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            // TTransaction::rollback(); // undo all pending operations
        }
    }


    public static function extratoList($dtinicial, $dtfinal, $offset = 0)
    {
        try
        {
            $config = new Config(1); 

        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/financialTransactions?startDate={$dtinicial}&finishDate={$dtfinal}&offset={$offset}&limit=100");
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        	curl_setopt($ch, CURLOPT_HEADER, FALSE);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
        	                                           "User-Agent:Imobi-K_v2",
        	                                           "access_token: {$config->apikey}"));
        	$response = json_decode(curl_exec($ch));
        	curl_close($ch);
        	
        	return isset($response->data) ? $response->data : $response;
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    
    public static function transferenciaList($dtinicial, $dtfinal, $offset = 0)
    {
        try
        {
            $config = new Config(1);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers?dateCreated[ge]={$dtinicial}&dateCreated[le]={$dtfinal}}&offset={$offset}&limit=100");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent:Imobi-K_v2", "access_token:{$config->apikey}"));
            $response = json_decode(curl_exec($ch));
            curl_close($ch);
            return isset($response->data) ? $response->data : $response;
            
            }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }



    public static function AtualizaWHCobranca()
    {
        try
        {
        
            $config = new Config(1);
            $postcobranca = [ 'url'         => $config->whurl,
                              'email'       => $config->whemail,
                              'interrupted' => $config->whinterrupted,
                              'enabled'     => $config->whenabled,
                              'apiVersion'  => $config->whapiversion,
                              'authToken'   => $config->whauthtoken ];
            
            $postcobranca = json_encode($postcobranca, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/webhook");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postcobranca);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}") );
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response);
            return $response;
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }    



    public static function atualizaNotificacao($customer)
    {
        try
        {
            $config = new Config(1);
            $pessoa = new Pessoa($customer, FALSE);
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://{$config->system}/customers/{$pessoa->asaasid}/notifications",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [ "accept: application/json",
                                        "User-Agent:Imobi-K_v2",
                                        "access_token: {$config->apikey}" ], ]);            

            $response = json_decode(curl_exec($curl) );
            $err = curl_error($curl);
            curl_close($curl);
            
            $notificacoes = $response->data;
            
            // echo '<pre>' ; print_r($notificacoes);echo '</pre>'; exit();
            
            foreach($notificacoes AS $notificacao)
            {
                
                if($notificacao->event == 'PAYMENT_CREATED')
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt1emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt1smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt1emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt1smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt1phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt1whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // PAYMENT_CREATED
                
                if($notificacao->event == 'PAYMENT_UPDATED')
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt2emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt2smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt2emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt2smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt2phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt2whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // PAYMENT_UPDATED
                
                if($notificacao->event == 'PAYMENT_DUEDATE_WARNING' AND $notificacao->scheduleOffset != 0 )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt3emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt3smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt3emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt3smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt3phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt3whatsappenabledforcustomer,
                        'scheduleOffset'              => $pessoa->nt3scheduleoffset
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}", 
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // 'PAYMENT_DUEDATE_WARNING' AND $notificacao->scheduleOffset != 0
                

                if($notificacao->event == 'PAYMENT_DUEDATE_WARNING' AND $notificacao->scheduleOffset == 0 )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt4emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt4smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt4emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt4smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt4phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt4whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // 'PAYMENT_DUEDATE_WARNING' AND $notificacao->scheduleOffset == 0
                
                if($notificacao->event == 'SEND_LINHA_DIGITAVEL' )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt5emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt5smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt5emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt5smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt5phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt5whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // SEND_LINHA_DIGITAVEL
                
                
                if($notificacao->event == 'PAYMENT_OVERDUE' AND $notificacao->scheduleOffset == 0 )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt6emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt6smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt6emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt6smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt6phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt6whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // 'PAYMENT_OVERDUE' AND $notificacao->scheduleOffset == 0
                
                if($notificacao->event == 'PAYMENT_OVERDUE' AND $notificacao->scheduleOffset != 0 )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt7emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt7smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt7emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt7smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt7phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt7whatsappenabledforcustomer,
                        'scheduleOffset'              => $pessoa->nt7scheduleoffset
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // 'PAYMENT_OVERDUE' AND $notificacao->scheduleOffset != 0
                
                if($notificacao->event == 'PAYMENT_RECEIVED' )
                {
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://{$config->system}/notifications/{$notificacao->id}",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "PUT",
                      CURLOPT_POSTFIELDS => json_encode([
                        'enabled'                     => true,
                        'emailEnabledForProvider'     => $pessoa->nt8emailenabledforprovider,
                        'smsEnabledForProvider'       => $pessoa->nt8smsenabledforprovider,
                        'emailEnabledForCustomer'     => $pessoa->nt8emailenabledforcustomer,
                        'smsEnabledForCustomer'       => $pessoa->nt8smsenabledforcustomer,
                        'phoneCallEnabledForCustomer' => $pessoa->nt8phonecallenabledforcustomer,
                        'whatsappEnabledForCustomer'  => $pessoa->nt8whatsappenabledforcustomer,
                        'scheduleOffset'              => '0'
                      ]),
                      CURLOPT_HTTPHEADER => [ "accept: application/json",
                                              "User-Agent:Imobi-K_v2",
                                              "access_token: {$config->apikey}",
                                              "content-type: application/json" ],
                    ]);
                    $response = json_decode(curl_exec($curl));
                    $err = curl_error($curl);
                    curl_close($curl);
                    if(isset($response->errors))
                    {
                        $msg = '<strong><u>Erro ao se conectar com a API do Asaas</u>:</strong><br>';
                        foreach($response->errors AS $error )
                        {
                            $msg .=   $error->description.'<br />';
                        }
                        throw new Exception($msg); 
                    }                    
                } // PAYMENT_RECEIVED
            } // foreach($notificacoes AS $notificacao)
            
            TToast::show("success", "Alterações Encaminhadas!", "topRight", "fas:share");
            
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }    
    

    
}

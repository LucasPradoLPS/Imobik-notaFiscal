<?php

class OpenAIService
{
    /*
    public function __construct($param)
    {
        
    }
    */
    
    /*
     * $openaiservice = new OpenAIService;
     * $lista_modelo = $openaiservice->listarModelos();
     * Retorna se a chave é válida e a lista de modelos disponíveis
    */     
    public function funcaoGenerica()
    {
        try
        {
            // código aqui
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }    
    
    /*
     * $openaiservice = new OpenAIService;
     * $lista_modelo = $openaiservice->listarModelos();
     * Retorna se a chave é válida e a lista de modelos disponíveis
    */
    
    public function listarModelos()
    {
        try
        {
            // 
            $openaiconfig = new Openaiapi(1);
            // echo '<pre>' ; print_r($openaiconfig);echo '</pre>'; exit();
            $apiKey = $openaiconfig->apikey;
            $apiUrl = 'https://api.openai.com/v1/models';
            $return = '';
            
            // Inicializa o cURL
            $ch = curl_init($apiUrl);
            
            // Configura as opções do cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
            ]);
            
            // Executa a solicitação
            $response = curl_exec($ch);
            
            // Verifica se houve erro
            if (curl_errno($ch)) {
                $return = 'Erro na solicitação:<br />' . curl_error($ch);
                // Fecha a sessão cURL
                curl_close($ch);

            } else {
                // Fecha a sessão cURL
                curl_close($ch);
                
                // Decodifica a resposta JSON
                $responseData = json_decode($response, true);
                
                // Verifica o status da resposta
                if (isset($responseData['error'])) {
                    // Se houver um erro, a chave de API é inválida ou ocorreu um problema
                    $return = "Chave de API inválida ou erro:\n" . $responseData['error']['message'] . "\n";
                } else {
                    // Se a resposta não contiver erro, a chave é válida
                    $return = "Chave de API válida. Modelos disponíveis:\n";
                    foreach ($responseData['data'] as $model) {
                        $return .= "- " . $model['id'] . "\n";
                    }
                }
            }
            
            return $return;
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }    
 
 
    /*
     * $openaiservice = new OpenAIService;
     * $lista_modelo = $openaiservice->geraResposta(activerecord, key, assunto);
     * activerecord = model a buscar os detalhes_do_prompt
     * key = PK do objeto a ser detalhados
     * assunto = PK do assunto a ter-se a resposta 
    */     
    public function geraResposta($param)
    {
        try
        {
            $openaiapi     = Openaiapi::find(1);;
            $openaiassunto = Openaiassunto::find($param['assunto']);
            $openaiassunto->apikey = $openaiapi->apikey;
            $openaiassunto->apiurl = $openaiapi->apiurl;
            $activerecord  = $param['activerecord']::find($param['key']);
            $prompt        = $openaiassunto->prompt;
            $prompt        = str_replace('{$detalhes_do_prompt}', $activerecord->detalhes_do_prompt, $prompt);
            if(isset($param['comentarios']) OR !empty($param['comentarios']) OR !empty($param['comentarios']) )
            {
                $prompt .= "\n {$param['comentarios']} ";
            }

            $data = [
                'model' => $openaiassunto->data_model,
                'messages' => [
                    ['role' => 'system', 'content' => $openaiassunto->system_content],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => $openaiassunto->max_tokens,
                'temperature' => floatval($openaiassunto->temperature),
            ];
            
            // Inicializa o cURL
            $ch = curl_init($openaiassunto->apiurl);
            
            // Configura as opções do cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $openaiassunto->apikey,
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            // Executa a solicitação e captura a resposta
            $response = curl_exec($ch);
            
            // Verifica se houve erro
            if (curl_errno($ch)) {
                $return = 'Erro na solicitação: <br />' . curl_error($ch);
            } else {
                // Decodifica a resposta JSON
                $responseData = json_decode($response, true);
                
                // Exibe o contrato gerado
                if (isset($responseData['choices'][0]['message']['content'])) {
                    //$return  = "Contrato de Locação Gerado:<br /><br />";
                    $return = $responseData['choices'][0]['message']['content'];
                } else {
                    $response = str_replace('{', '', $response);
                    $response = str_replace('}', '', $response);
                    $return = "<strong>Resposta inesperada da API:</strong> {$response}";
                }
            }
            curl_close($ch);
            return $return;
       }
		catch (Exception $e) // in case of exception
        {
            // new TMessage('error', $e->getMessage()); // shows the exception error message
            return $e->getMessage();
            // TTransaction::rollback(); // undo all pending operations
        }
    }    
    
    
}
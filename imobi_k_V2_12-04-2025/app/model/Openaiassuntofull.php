<?php

class Openaiassuntofull extends DBQuery
{
    const PRIMARYKEY = 'idonpenaiassunto';

    /**
     * Constructor method
     */
    public function __construct()
    {
        $sql = '
        (
        SELECT 
    openaiassunto.idonpenaiassunto as "idonpenaiassunto",
    openaiapi.idopenaiapi as "idopenaiapi",
    openaiapi.apikey as "apikey",
    openaiapi.apiurl as "apiurl",
    openaiassunto.assunto as "assunto",
    openaiassunto.data_model as "data_model",
    openaiassunto.max_tokens as "max_tokens",
    openaiassunto.prompt as "prompt",
    openaiassunto.temperature as "temperature",
    openaiassunto.system_content as "system_content"
FROM 
    openai.openaiapi, openai.openaiassunto
WHERE 
    openaiassunto.idopenaiapi = openaiapi.idopenaiapi
ORDER BY openaiassunto
        ) builder_db_query_temp
        ';
    
 
        parent::setSqlQuery($sql);

        parent::addAttribute('idopenaiapi');
        parent::addAttribute('apikey');
        parent::addAttribute('apiurl');
        parent::addAttribute('assunto');
        parent::addAttribute('data_model');
        parent::addAttribute('max_tokens');
        parent::addAttribute('prompt');
        parent::addAttribute('temperature');
        parent::addAttribute('system_content');
    
    }

}


<?php

class OpenaiAssuntoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Openaiassunto';
    private static $primaryKey = 'idonpenaiassunto';
    private static $formName = 'form_OpenaiAssuntoForm';

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
        $this->form->setFormTitle("Assunto");


        $idonpenaiassunto = new TEntry('idonpenaiassunto');
        $assunto = new TEntry('assunto');
        $data_model = new TEntry('data_model');
        $button_ = new TButton('button_');
        $bhelper_670b1ed515130 = new BHelper();
        $max_tokens = new TNumeric('max_tokens', '0', ',', '.' );
        $bhelper_670b1f777a750 = new BHelper();
        $temperature = new TNumeric('temperature', '1', ',', '.' );
        $prompt = new TText('prompt');
        $system_content = new TText('system_content');

        $assunto->addValidation("Assunto", new TRequiredValidator()); 
        $data_model->addValidation("Modelo", new TRequiredValidator()); 
        $max_tokens->addValidation("Comprimento", new TRequiredValidator()); 
        $temperature->addValidation("Criatividade", new TRequiredValidator()); 
        $prompt->addValidation("Estrutura do prompt", new TRequiredValidator()); 
        $system_content->addValidation("Completação de Chat", new TRequiredValidator()); 

        $idonpenaiassunto->setEditable(false);
        $button_->setAction(new TAction([$this, 'OnModelList']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:tasks #F26A6C');
        $assunto->setMaxLength(200);
        $temperature->setMaxLength(8);

        $bhelper_670b1ed515130->setSide("bottom");
        $bhelper_670b1f777a750->setSide("bottom");

        $bhelper_670b1ed515130->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_670b1f777a750->setIcon(new TImage("fas:question #fa931f"));

        $bhelper_670b1ed515130->setTitle("Token");
        $bhelper_670b1f777a750->setTitle("Temperature");

        $bhelper_670b1ed515130->setContent("<p><strong>O que são Tokens?</strong></p><p>São as unidades básicas de texto que o modelo processa. Elas podem ser tão pequenas quanto um único caractere ou tão grandes quanto uma palavra inteira. Por exemplo, a palavra ChatGPT pode ser um único token, enquanto uma frase longa pode ser dividida em múltiplos tokens.</p><p><strong>Importância:</strong></p><ul><li><strong>Limitação de Comprimento:</strong> Define o comprimento máximo da resposta gerada. Isso é útil para controlar a quantidade de texto retornado e evitar respostas excessivamente longas.</li><li><strong>Custos:</strong> A contagem de tokens também afeta o custo da utilização da API, já que geralmente a cobrança é baseada no número de tokens processados.</li></ul><p><strong>Considerações:</strong></p><ul><li><strong>Equilíbrio:</strong> Ajustar o <i>comprimento</i> é um equilíbrio entre obter respostas completas e manter o controle sobre o comprimento e os custos.</li><li><strong>Contexto:</strong> Lembre-se que o <i>comprimento </i>se aplica apenas à resposta gerada, não inclui os tokens do prompt enviado.</li></ul><p></p>");
        $bhelper_670b1f777a750->setContent("<p><strong>Definição:</strong></p><p><code>temperature</code> controla a aleatoriedade ou criatividade da resposta gerada pelo modelo.</p><p><p><strong>Como Funciona:</strong></p><ul><li><strong>Valores Baixos (Próximos de 0):</strong> Tornam a saída mais determinística e focada. O modelo tende a escolher as palavras mais prováveis, resultando em respostas mais previsíveis e consistentes.</li><li><strong>Valores Altos (Próximos de 1 ou acima):</strong> Aumentam a aleatoriedade, permitindo que o modelo gere respostas mais variadas e criativas. Pode resultar em saídas mais interessantes, mas também mais imprevisíveis.</li></ul><p><strong>Faixa Comum:</strong></p><ul><li>Geralmente, valores entre 0.6 e 0.9 são usados para equilibrar criatividade e coerência. O valor padrão é frequentemente 0.7.</li><li>Com uma temperatura de 0.7, a resposta será relativamente criativa, mas ainda mantendo uma boa coerência e relevância em relação ao prompt.</li></ul><p><strong>Considerações:</strong></p><ul><li><strong>Tipo de Aplicação:</strong><ul><li><strong>Aplicações Focadas em Precisão:</strong> Como respostas factuais ou técnicas, valores mais baixos (0.2 - 0.5) são recomendados.</li><li><strong>Aplicações Criativas:</strong> Como geração de histórias ou ideias, valores mais altos (0.7 - 1.0) podem ser mais apropriados.</li></ul></li><li><strong>Experimentação:</strong> É útil experimentar com diferentes valores para encontrar o equilíbrio que melhor atende às necessidades do seu aplicativo.</li></ul></p>");

        $max_tokens->setAllowNegative(false);
        $temperature->setAllowNegative(false);

        $max_tokens->setValue('1500');
        $temperature->setValue('0.7');
        $data_model->setValue('gpt-4');

        $assunto->setTip("Tópico ou conteúdo central da resposta fornecida pela IA.");
        $temperature->setTip(" Aleatoriedade ou criatividade da resposta gerada pelo modelo.");
        $prompt->setTip("Fornece instruções detalhadas sobre o que o documento deve incluir.");
        $max_tokens->setTip("Especifica o número máximo de tokens que a API deve gerar na resposta.");
        $system_content->setTip("Define o papel da IA, orientando-a a atuar como um assistente especializado.");
        $data_model->setTip("Selecione o modelo de IA que você deseja utilizar para processar a solicitação.");

        $assunto->setSize('100%');
        $max_tokens->setSize('100%');
        $temperature->setSize('100%');
        $prompt->setSize('100%', 200);
        $idonpenaiassunto->setSize('100%');
        $bhelper_670b1ed515130->setSize('14');
        $bhelper_670b1f777a750->setSize('14');
        $system_content->setSize('100%', 100);
        $data_model->setSize('calc(100% - 50px)');

        $row1 = $this->form->addFields([new TLabel("Cód:", null, '14px', null, '100%'),$idonpenaiassunto],[new TLabel("Assunto:", '#ff0000', '14px', null, '100%'),$assunto]);
        $row1->layout = [' col-sm-2',' col-sm-10'];

        $row2 = $this->form->addFields([new TLabel("Modelo:", '#ff0000', '14px', null, '100%'),$data_model,$button_],[$bhelper_670b1ed515130,new TLabel("Comprimento:", '#ff0000', '14px', null),$max_tokens],[$bhelper_670b1f777a750,new TLabel("Criatividade:", '#ff0000', '14px', null),$temperature]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Estrutura do Prompt:", '#ff0000', '14px', null, '100%'),$prompt]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Completação de Chat:", '#ff0000', '14px', null, '100%'),$system_content]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=OpenaiAssuntoForm]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public static function OnModelList($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $openaiservice = new OpenAIService;

            $panel = new TPanelGroup('');
            $panel->add(str_replace("\n", '<br> ', print_r($openaiservice->listarModelos(), true)));
            $window = TWindow::create("Validade e Lista de Modelos da API", 0.60, 0.90);
            $window->add($panel);
            $window->show();            

            TTransaction::close(); // close the transaction            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Openaiassunto(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $messageAction = new TAction(['OpenAiAssuntoList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            // get the generated {PRIMARY_KEY}
            $data->idonpenaiassunto = $object->idonpenaiassunto; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
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

                $object = new Openaiassunto($key); // instantiates the Active Record 

                $object->idonpenaiassunto = str_pad($object->idonpenaiassunto, 6, '0', STR_PAD_LEFT);

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

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}


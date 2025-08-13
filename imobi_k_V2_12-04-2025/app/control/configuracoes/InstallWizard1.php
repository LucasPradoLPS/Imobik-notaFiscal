<?php

class InstallWizard1 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_InstallWizard1';

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
        $this->form->setFormTitle("Base de Dados/Conexão");


        $database = new TEntry('database');
        $empresa = new TEntry('empresa');

        $database->addValidation("Data Base", new TRequiredValidator()); 

        $database->setMaxLength(25);
        $database->forceLowerCase();
        $empresa->setSize('100%');
        $database->setSize('100%');

        $database->placeholder = "Sem espaços ou caracteres especiais";


        $row1 = $this->form->addFields([new TLabel("Banco de Dados/Conexão:", '#FF0000', '14px', null),$database],[new TLabel("Nome da Imobiliária:", '#FF0000', '14px', null),$empresa]);
        $row1->layout = ['col-sm-4',' col-sm-4'];

        // create the form actions
        $btn_onadvance = $this->form->addAction("Criar nova Empresa", new TAction([$this, 'onAdvance']), 'fas:plus-circle #ffffff');
        $this->btn_onadvance = $btn_onadvance;
        $btn_onadvance->addStyleClass('full_width'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Base de Dados/Conexão"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onAdvance($param = null) 
    {
        try
        {
            // Verifica se a string contém caracteres que não são letras, números ou sublinhados
            if (preg_match('/\W/', $param['database'])) {
                throw new Exception("Erro: O nome do banco de dados contém espaços ou caracteres especiais.");
            }

            // Dados de conexão
            $dbHost     = 'localhost';
            $dbPort     = '5432';
            $dbUser     = 'postgres';
            $dbPassword = 'kabongo#pma@16';

            // Nome da nova base de dados e caminho para o dump
            $newDbName = 'imobi_' . $param['database'];
            $dumpFile = 'app/database/imobi_start.backup';

            // Caminho para o arquivo de dump customizado
            if (!file_exists($dumpFile))
            {
                throw new Exception("Arquivo não encontrado em: {$dumpFile}");
            }

            // Define a variável de ambiente para a senha
            putenv("PGPASSWORD=$dbPassword");

            // Conecta ao banco de dados 'postgres' para verificar a existência do banco desejado
            $checkCommand = "psql -h $dbHost -p $dbPort -U $dbUser -tAc \"SELECT 1 FROM pg_database WHERE datname='$newDbName'\"";
            exec($checkCommand, $checkOutput, $checkReturn);

            if (!empty($checkOutput) && $checkOutput[0] == '1')
            {
                throw new Exception("Erro: O banco de dados <strong>{$param['database']}</strong> já existe.");
            }            

            // Comando para criar a base de dados
            $createCommand = "createdb -h $dbHost -p $dbPort -U $dbUser $newDbName";
            exec($createCommand, $createOutput, $createReturn);

            if ($createReturn !== 0)
            {
                throw new Exception("Erro ao criar o banco de dados. Código de erro: $createReturn.<br /> {$createOutput}");
            }

            TToast::show("success", "Banco de dados {$newDbName} criado com sucesso!", "topRight", "fas:thumbs-up");

            // Comando para restaurar o dump na base criada
            $restoreCommand = "pg_restore -h $dbHost -p $dbPort -U $dbUser -d $newDbName $dumpFile";
            exec($restoreCommand, $restoreOutput, $restoreReturn);

            if ($restoreReturn !== 0)
            {
                $restoreOutput = implode("\n", $restoreOutput);
                throw new Exception("Erro ao restaurar o dump. Código de erro: {$restoreReturn}");
            }

            TToast::show("success", "Dump restaurado com sucesso na base {$newDbName}", "topRight", "fas:thumbs-up");

            // Criar arquivo de configuração
            $fp = fopen('app/config/' . $newDbName. '.php', "w+"); // Abre arquivo
            $fdi = '<?php';
            $fdi .= chr(13).chr(10);      //EOL
            $fdi .= 'return[';
            $fdi .= chr(13).chr(10);
            $fdi .= "'host' => 'localhost',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'name' => '{$newDbName}',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'user' => 'postgres',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'pass' => 'kabongo#pma@16',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'type' => 'pgsql',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'prep' => '1',";
            $fdi .= chr(13).chr(10);
            $fdi .= "'slog' => 'SystemSqlLogService',";
            $fdi .= chr(13).chr(10);
            $fdi .= '];';
            fwrite($fp, $fdi); //Escreve no arquivo aberto.
            fclose($fp); //Fecha o arquivo.

            // Registrar Empresa
            // Código gerado pelo snippet: "Conexão com banco de dados"
            TTransaction::open('imobi_system');

            // code
            $objeto = new SystemUnit();
            $objeto->name = $param['empresa'];
            $objeto->connection_name = $newDbName;
            $objeto->store();
            TTransaction::close();
            AdiantiCoreApplication::loadPage('SystemUnitList', 'onShow');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

}


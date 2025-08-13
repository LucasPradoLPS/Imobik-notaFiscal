<?php

class CalendarEventForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'CalendarEvent';
    private static $primaryKey = 'id';
    private static $formName = 'form_CalendarEventForm';
    private static $startDateField = 'start_time';
    private static $endDateField = 'end_time';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.50, null);
        parent::setTitle("Calendário de Eventos");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Calendário de Eventos");

        $view = new THidden('view');

        $start_time = new TDateTime('start_time');
        $id = new THidden('id');
        $systemuser = new THidden('systemuser');
        $end_time = new TDateTime('end_time');
        $privado = new TRadioGroup('privado');
        $color = new TColor('color');
        $title = new TEntry('title');
        $fk_systemuser_name = new TEntry('fk_systemuser_name');
        $description = new TText('description');

        $start_time->addValidation("Horário inicial", new TRequiredValidator()); 
        $end_time->addValidation("Horário final", new TRequiredValidator()); 
        $title->addValidation("Título", new TRequiredValidator()); 

        $privado->addItems(["1"=>"Sim","2"=>"Não"]);
        $privado->setLayout('horizontal');
        $privado->setValue('2');
        $privado->setBooleanMode();
        $fk_systemuser_name->setEditable(false);
        $end_time->setMask('dd/mm/yyyy hh:ii');
        $start_time->setMask('dd/mm/yyyy hh:ii');

        $end_time->setDatabaseMask('yyyy-mm-dd hh:ii');
        $start_time->setDatabaseMask('yyyy-mm-dd hh:ii');

        $id->setSize(200);
        $privado->setSize(80);
        $end_time->setSize(150);
        $color->setSize('100%');
        $title->setSize('100%');
        $systemuser->setSize(200);
        $start_time->setSize('100%');
        $description->setSize('100%', 70);
        $fk_systemuser_name->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Horário Inicial:", '#ff0000', '14px', null, '100%'),$start_time,$id,$systemuser],[new TLabel("Horário Final:", '#ff0000', '14px', null, '100%'),$end_time],[new TLabel("Privado:", null, '14px', null, '100%'),$privado],[new TLabel("Cor:", null, '14px', null, '100%'),$color]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Título", '#FF0000', '14px', null, '100%'),$title],[new TLabel("Proprietário:", null, '14px', null),$fk_systemuser_name]);
        $row2->layout = [' col-sm-8',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$description]);
        $row3->layout = [' col-sm-12'];

        $this->form->addFields([$view]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Agendamento", new TAction([$this, 'onClear']), 'fas:calendar-plus #9400D3');
        $this->btn_onclear = $btn_onclear;

        $btn_ondelete = $this->form->addAction("Cancelar Evento", new TAction([$this, 'onDelete']), 'fas:calendar-times #9400D3');
        $this->btn_ondelete = $btn_ondelete;

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            if( ( $param['privado'] == 1) AND ($param['systemuser'] != TSession::getValue("userid")) AND  ($param['id'] != '') )
                throw new Exception('Somente o Proprietário tem permissão para tornar este Evento PRIVADO!');

            $object = new CalendarEvent(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->systemuser = TSession::getValue('userid');

            $object->store(); // save the object 

            $messageAction = new TAction(['CalendarEventFormView', 'onReload']);
            $messageAction->setParameter('view', $data->view);
            $messageAction->setParameter('date', explode(' ', $data->start_time)[0]);

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Evento Salvo", 'topRight', 'far:check-circle'); 

                TWindow::closeWindow(parent::getId()); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onDelete($param = null) 
    {
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                $key = $param[self::$primaryKey];

                // open a transaction with database
                TTransaction::open(self::$database);

                $class = self::$activeRecord;

                // instantiates object
                $object = new $class($key, FALSE);

                if( $param['systemuser'] != TSession::getValue('userid') )
                    throw new Exception('Somente o Proprietário tem permissão para CANCELAR este Evento!');

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                $messageAction = new TAction(array(__CLASS__.'View', 'onReload'));
                $messageAction->setParameter('view', $param['view']);
                $messageAction->setParameter('date', explode(' ',$param[self::$startDateField])[0]);

                // shows the success message
                new TMessage('info', 'Evento Cancelado!', $messageAction);

            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters((array) $this->form->getData());
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion('Deseja realmente CANCELAR este Evento?', $action);   
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

                $object = new CalendarEvent($key); // instantiates the Active Record 

                                $object->fk_systemuser_name = $object->fk_systemuser->name;
                $object->view = !empty($param['view']) ? $param['view'] : 'agendaWeek'; 

                // $object->privado = $object->systemuser == null ? FALSE : TRUE ;

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

    public function onStartEdit($param)
    {

        $this->form->clear(true);

        $data = new stdClass;
        $data->view = $param['view'] ?? 'agendaWeek'; // calendar view
        $data->color = '#3a87ad';

        if (!empty($param['date']))
        {
            if(strlen($param['date']) == '10')
                $param['date'].= ' 09:00';

            $data->start_time = str_replace('T', ' ', $param['date']);

            $end_time = new DateTime($data->start_time);
            $end_time->add(new DateInterval('PT1H'));
            $data->end_time = $end_time->format('Y-m-d H:i:s');

        }

        $this->form->setData( $data );
    }

    public static function onUpdateEvent($param)
    {
        try
        {
            if (isset($param['id']))
            {
                TTransaction::open(self::$database);

                $class = self::$activeRecord;
                $object = new $class($param['id']);

                $object->start_time = str_replace('T', ' ', $param['start_time']);
                $object->end_time   = str_replace('T', ' ', $param['end_time']);

                $object->store();

                // close the transaction
                TTransaction::close();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            TTransaction::rollback();
        }
    }

    public static function getFormName()
    {
        return self::$formName;
    }

}


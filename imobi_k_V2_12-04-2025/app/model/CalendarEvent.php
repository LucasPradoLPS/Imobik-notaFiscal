<?php

class CalendarEvent extends TRecord
{
    const TABLENAME  = 'public.calendar_event';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_systemuser;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('color');
        parent::addAttribute('start_time');
        parent::addAttribute('description');
        parent::addAttribute('end_time');
        parent::addAttribute('notificar');
        parent::addAttribute('systemuser');
        parent::addAttribute('title');
        parent::addAttribute('privado');
            
    }

    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_fk_systemuser(SystemUsers $object)
    {
        $this->fk_systemuser = $object;
        $this->systemuser = $object->id;
    }

    /**
     * Method get_fk_systemuser
     * Sample of usage: $var->fk_systemuser->attribute;
     * @returns SystemUsers instance
     */
    public function get_fk_systemuser()
    {
        try{
        TTransaction::openFake('permission');
        // loads the associated object
        if (empty($this->fk_systemuser))
            $this->fk_systemuser = new SystemUsers($this->systemuser);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_systemuser;
    }

    
}


<?php

class SystemUsers extends TRecord
{
    const TABLENAME  = 'system_users';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_unit;
    private $frontpage;

    private $unit;
    private $system_user_groups = array();
    private $system_user_programs = array();
    private $system_user_units = array();
            

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        // $senha_nova = 'NovaSenha123';
        // $hash = password_hash($senha_nova, PASSWORD_DEFAULT);
        // echo $hash;
        // die();
        // try {
        //     TTransaction::open('imobi_log'); // substitua pelo nome do banco no database.ini
        
        //     $conn = TTransaction::get(); // pega a conexão ativa (PDO)
        //     $stmt = $conn->prepare("SELECT login, password FROM system_users");
        //     $stmt->execute();
        
        //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //         echo 'Login: ' . $row['login'] . ' - Senha: ' . $row['password'] . '<br>';
        //     }
        
        //     TTransaction::close();
        // } catch (Exception $e) {
        //     new TMessage('error', $e->getMessage());
        //     TTransaction::rollback();
        // }

        

        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('login');
        parent::addAttribute('password');
        parent::addAttribute('email');
        parent::addAttribute('frontpage_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('active');
        parent::addAttribute('accepted_term_policy_at');
        parent::addAttribute('accepted_term_policy');
        parent::addAttribute('two_factor_enabled');
        parent::addAttribute('two_factor_type');
        parent::addAttribute('two_factor_secret');
    
    }

    /**
     * Method set_system_unit
     * Sample of usage: $var->system_unit = $object;
     * @param $object Instance of SystemUnit
     */
    public function set_system_unit(SystemUnit $object)
    {
        $this->system_unit = $object;
        $this->system_unit_id = $object->id;
    }

    /**
     * Method get_system_unit
     * Sample of usage: $var->system_unit->attribute;
     * @returns SystemUnit instance
     */
    public function get_system_unit()
    {
    
        // loads the associated object
        if (empty($this->system_unit))
            $this->system_unit = new SystemUnit($this->system_unit_id);
    
        // returns the associated object
        return $this->system_unit;
    }
    /**
     * Method set_system_program
     * Sample of usage: $var->system_program = $object;
     * @param $object Instance of SystemProgram
     */
    public function set_frontpage(SystemProgram $object)
    {
        $this->frontpage = $object;
        $this->frontpage_id = $object->id;
    }

    /**
     * Method get_frontpage
     * Sample of usage: $var->frontpage->attribute;
     * @returns SystemProgram instance
     */
    public function get_frontpage()
    {
    
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);
    
        // returns the associated object
        return $this->frontpage;
    }

    /**
     * Method getMurals
     */
    public function getMurals()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsystemuser', '=', $this->id));
        return Mural::getObjects( $criteria );
    }
    /**
     * Method getFaturas
     */
    public function getFaturas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsystemuser', '=', $this->id));
        return Fatura::getObjects( $criteria );
    }
    /**
     * Method getContratos
     */
    public function getContratos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsystemuser', '=', $this->id));
        return Contrato::getObjects( $criteria );
    }
    /**
     * Method getCaixas
     */
    public function getCaixas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsystemuser', '=', $this->id));
        return Caixa::getObjects( $criteria );
    }
    /**
     * Method getVistoriahistoricos
     */
    public function getVistoriahistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsystemuser', '=', $this->id));
        return Vistoriahistorico::getObjects( $criteria );
    }

    public function set_fatura_fk_idcontrato_to_string($fatura_fk_idcontrato_to_string)
    {
        if(is_array($fatura_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $fatura_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->fatura_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idcontrato_to_string = $fatura_fk_idcontrato_to_string;
        }

        $this->vdata['fatura_fk_idcontrato_to_string'] = $this->fatura_fk_idcontrato_to_string;
    }

    public function get_fatura_fk_idcontrato_to_string()
    {
        if(!empty($this->fatura_fk_idcontrato_to_string))
        {
            return $this->fatura_fk_idcontrato_to_string;
        }
    
        $values = Fatura::where('idsystemuser', '=', $this->id)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idfaturaformapagamento_to_string($fatura_fk_idfaturaformapagamento_to_string)
    {
        if(is_array($fatura_fk_idfaturaformapagamento_to_string))
        {
            $values = Faturaformapagamento::where('idfaturaformapagamento', 'in', $fatura_fk_idfaturaformapagamento_to_string)->getIndexedArray('faturaformapagamento', 'faturaformapagamento');
            $this->fatura_fk_idfaturaformapagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idfaturaformapagamento_to_string = $fatura_fk_idfaturaformapagamento_to_string;
        }

        $this->vdata['fatura_fk_idfaturaformapagamento_to_string'] = $this->fatura_fk_idfaturaformapagamento_to_string;
    }

    public function get_fatura_fk_idfaturaformapagamento_to_string()
    {
        if(!empty($this->fatura_fk_idfaturaformapagamento_to_string))
        {
            return $this->fatura_fk_idfaturaformapagamento_to_string;
        }
    
        $values = Fatura::where('idsystemuser', '=', $this->id)->getIndexedArray('idfaturaformapagamento','{fk_idfaturaformapagamento->faturaformapagamento}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idpessoa_to_string($fatura_fk_idpessoa_to_string)
    {
        if(is_array($fatura_fk_idpessoa_to_string))
        {
            $values = Pessoafull::where('idpessoa', 'in', $fatura_fk_idpessoa_to_string)->getIndexedArray('idpessoa', 'idpessoa');
            $this->fatura_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idpessoa_to_string = $fatura_fk_idpessoa_to_string;
        }

        $this->vdata['fatura_fk_idpessoa_to_string'] = $this->fatura_fk_idpessoa_to_string;
    }

    public function get_fatura_fk_idpessoa_to_string()
    {
        if(!empty($this->fatura_fk_idpessoa_to_string))
        {
            return $this->fatura_fk_idpessoa_to_string;
        }
    
        $values = Fatura::where('idsystemuser', '=', $this->id)->getIndexedArray('idpessoa','{fk_idpessoa->idpessoa}');
        return implode(', ', $values);
    }

    public function set_contrato_fk_idcontrato_to_string($contrato_fk_idcontrato_to_string)
    {
        if(is_array($contrato_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $contrato_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contrato_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contrato_fk_idcontrato_to_string = $contrato_fk_idcontrato_to_string;
        }

        $this->vdata['contrato_fk_idcontrato_to_string'] = $this->contrato_fk_idcontrato_to_string;
    }

    public function get_contrato_fk_idcontrato_to_string()
    {
        if(!empty($this->contrato_fk_idcontrato_to_string))
        {
            return $this->contrato_fk_idcontrato_to_string;
        }
    
        $values = Contrato::where('idsystemuser', '=', $this->id)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contrato_fk_idimovel_to_string($contrato_fk_idimovel_to_string)
    {
        if(is_array($contrato_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $contrato_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->contrato_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->contrato_fk_idimovel_to_string = $contrato_fk_idimovel_to_string;
        }

        $this->vdata['contrato_fk_idimovel_to_string'] = $this->contrato_fk_idimovel_to_string;
    }

    public function get_contrato_fk_idimovel_to_string()
    {
        if(!empty($this->contrato_fk_idimovel_to_string))
        {
            return $this->contrato_fk_idimovel_to_string;
        }
    
        $values = Contrato::where('idsystemuser', '=', $this->id)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_caixa_fk_idcaixaespecie_to_string($caixa_fk_idcaixaespecie_to_string)
    {
        if(is_array($caixa_fk_idcaixaespecie_to_string))
        {
            $values = Caixaespecie::where('idcaixaespecie', 'in', $caixa_fk_idcaixaespecie_to_string)->getIndexedArray('caixaespecie', 'caixaespecie');
            $this->caixa_fk_idcaixaespecie_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idcaixaespecie_to_string = $caixa_fk_idcaixaespecie_to_string;
        }

        $this->vdata['caixa_fk_idcaixaespecie_to_string'] = $this->caixa_fk_idcaixaespecie_to_string;
    }

    public function get_caixa_fk_idcaixaespecie_to_string()
    {
        if(!empty($this->caixa_fk_idcaixaespecie_to_string))
        {
            return $this->caixa_fk_idcaixaespecie_to_string;
        }
    
        $values = Caixa::where('idsystemuser', '=', $this->id)->getIndexedArray('idcaixaespecie','{fk_idcaixaespecie->caixaespecie}');
        return implode(', ', $values);
    }

    public function set_caixa_fk_idfatura_to_string($caixa_fk_idfatura_to_string)
    {
        if(is_array($caixa_fk_idfatura_to_string))
        {
            $values = Faturafull::where('idfatura', 'in', $caixa_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->caixa_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idfatura_to_string = $caixa_fk_idfatura_to_string;
        }

        $this->vdata['caixa_fk_idfatura_to_string'] = $this->caixa_fk_idfatura_to_string;
    }

    public function get_caixa_fk_idfatura_to_string()
    {
        if(!empty($this->caixa_fk_idfatura_to_string))
        {
            return $this->caixa_fk_idfatura_to_string;
        }
    
        $values = Caixa::where('idsystemuser', '=', $this->id)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idvistoria_to_string($vistoriahistorico_fk_idvistoria_to_string)
    {
        if(is_array($vistoriahistorico_fk_idvistoria_to_string))
        {
            $values = Vistoriafull::where('idvistoria', 'in', $vistoriahistorico_fk_idvistoria_to_string)->getIndexedArray('idvistoria', 'idvistoria');
            $this->vistoriahistorico_fk_idvistoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idvistoria_to_string = $vistoriahistorico_fk_idvistoria_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idvistoria_to_string'] = $this->vistoriahistorico_fk_idvistoria_to_string;
    }

    public function get_vistoriahistorico_fk_idvistoria_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idvistoria_to_string))
        {
            return $this->vistoriahistorico_fk_idvistoria_to_string;
        }
    
        $values = Vistoriahistorico::where('idsystemuser', '=', $this->id)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idcontrato_to_string($vistoriahistorico_fk_idcontrato_to_string)
    {
        if(is_array($vistoriahistorico_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $vistoriahistorico_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->vistoriahistorico_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idcontrato_to_string = $vistoriahistorico_fk_idcontrato_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idcontrato_to_string'] = $this->vistoriahistorico_fk_idcontrato_to_string;
    }

    public function get_vistoriahistorico_fk_idcontrato_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idcontrato_to_string))
        {
            return $this->vistoriahistorico_fk_idcontrato_to_string;
        }
    
        $values = Vistoriahistorico::where('idsystemuser', '=', $this->id)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idimovel_to_string($vistoriahistorico_fk_idimovel_to_string)
    {
        if(is_array($vistoriahistorico_fk_idimovel_to_string))
        {
            $values = Imovelfull::where('idimovel', 'in', $vistoriahistorico_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->vistoriahistorico_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idimovel_to_string = $vistoriahistorico_fk_idimovel_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idimovel_to_string'] = $this->vistoriahistorico_fk_idimovel_to_string;
    }

    public function get_vistoriahistorico_fk_idimovel_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idimovel_to_string))
        {
            return $this->vistoriahistorico_fk_idimovel_to_string;
        }
    
        $values = Vistoriahistorico::where('idsystemuser', '=', $this->id)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    /**
     * Return the user' group's
     * @return Collection of SystemGroup
     */
    public function getSystemUserGroups()
    {
        return parent::loadAggregate('SystemGroup', 'SystemUserGroup', 'system_user_id', 'system_group_id', $this->id);
    }

    /**
     * Return the user' unit's
     * @return Collection of SystemUnit
     */
    public function getSystemUserUnits()
    {
        return parent::loadAggregate('SystemUnit', 'SystemUserUnit', 'system_user_id', 'system_unit_id', $this->id);
    }

    /**
     * Return the user' program's
     * @return Collection of SystemProgram
     */
    public function getSystemUserPrograms()
    {
        return parent::loadAggregate('SystemProgram', 'SystemUserProgram', 'system_user_id', 'system_program_id', $this->id);
    }

    /**
     * Returns the frontpage name
     */
    public function get_frontpage_name()
    {
        // loads the associated object
        if (empty($this->frontpage))
            $this->frontpage = new SystemProgram($this->frontpage_id);

        // returns the associated object
        return $this->frontpage->name;
    }

    /**
     * Returns the unit
     */
    public function get_unit()
    {
        // loads the associated object
        if (empty($this->unit))
            $this->unit = new SystemUnit($this->system_unit_id);

        // returns the associated object
        return $this->unit;
    }

    /**
     * Add a Group to the user
     * @param $object Instance of SystemGroup
     */
    public function addSystemUserGroup(SystemGroup $systemgroup)
    {
        $object = new SystemUserGroup;
        $object->system_group_id = $systemgroup->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a Unit to the user
     * @param $object Instance of SystemUnit
     */
    public function addSystemUserUnit(SystemUnit $systemunit)
    {
        $object = new SystemUserUnit;
        $object->system_unit_id = $systemunit->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Add a program to the user
     * @param $object Instance of SystemProgram
     */
    public function addSystemUserProgram(SystemProgram $systemprogram)
    {
        $object = new SystemUserProgram;
        $object->system_program_id = $systemprogram->id;
        $object->system_user_id = $this->id;
        $object->store();
    }

    /**
     * Get user group ids
     */
    public function getSystemUserGroupIds( $as_string = false )
    {
        $groupids = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupids[] = $group->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $groupids);
        }
    
        return $groupids;
    }

    /**
     * Get user unit ids
     */
    public function getSystemUserUnitIds( $as_string = false )
    {
        $unitids = array();
        $units = $this->getSystemUserUnits();
        if ($units)
        {
            foreach ($units as $unit)
            {
                $unitids[] = $unit->id;
            }
        }
    
        if ($as_string)
        {
            return implode(',', $unitids);
        }
    
        return $unitids;
    }

    /**
     * Get user group names
     */
    public function getSystemUserGroupNames()
    {
        $groupnames = array();
        $groups = $this->getSystemUserGroups();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $groupnames[] = $group->name;
            }
        }
    
        return implode(',', $groupnames);
    }

    /**
     * Reset aggregates
     */
    public function clearParts()
    {
        SystemUserGroup::where('system_user_id', '=', $this->id)->delete();
        SystemUserUnit::where('system_user_id', '=', $this->id)->delete();
        SystemUserProgram::where('system_user_id', '=', $this->id)->delete();
    }

    /**
     * Delete the object and its aggregates
     * @param $id object ID
     */
    public function delete($id = NULL)
    {
        // delete the related System_userSystem_user_group objects
        $id = isset($id) ? $id : $this->id;
    
        SystemUserGroup::where('system_user_id', '=', $id)->delete();
        SystemUserUnit::where('system_user_id', '=', $id)->delete();
        SystemUserProgram::where('system_user_id', '=', $id)->delete();
    
        // delete the object itself
        parent::delete($id);
    }

    /**
     * Validate user login
     * @param $login String with user login
     */
    public static function validate($login)
    {
        $user = self::newFromLogin($login);
    
        if ($user instanceof SystemUsers)
        {
            if ($user->active == 'N')
            {
                throw new Exception(_t('Inactive user'));
            }
        }
        else
        {
            throw new Exception(_t('User not found'));
        }
    
        return $user;
    }

    /**
     * Authenticate the user
     * @param $login String with user login
     * @param $password String with user password
     * @returns TRUE if the password matches, otherwise throw Exception
     */
    public static function authenticate($login, $password)
    {
        $user = self::newFromLogin($login);
        if (hash_equals($user->password, md5($password)))
        {
            self::updatePasswordHash($user, $password);
        }
        if (password_verify($password, $user->password)) 
        {
            if (password_needs_rehash($user->password, PASSWORD_DEFAULT))
            {
                self::updatePasswordHash($user, $password);
            }
        }
        else
        {
            throw new Exception(_t('Invalid username or password'));
        }
        return $user;
    }

    /**
     * Returns a SystemUser object based on its login
     * @param $login String with user login
     */
    static public function newFromLogin($login)
    {
        return SystemUsers::where('login', '=', $login)->first();
    }

    /**
     * Returns a SystemUser object based on its e-mail
     * @param $email String with user email
     */
    static public function newFromEmail($email)
    {
        return SystemUsers::where('email', '=', $email)->first();
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getPrograms()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = true;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = true;
        }
    
        return $programs;
    }

    /**
     * Return the programs the user has permission to run
     */
    public function getProgramsList()
    {
        $programs = array();
    
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                $programs[$prog->controller] = $prog->name;
            }
        }
            
        foreach( $this->getSystemUserPrograms() as $prog )
        {
            $programs[$prog->controller] = $prog->name;
        }
    
        asort($programs);
        return $programs;
    }

    /**
     * Check if the user is within a group
     */
    public function checkInGroup( SystemGroup $group )
    {
        $user_groups = array();
        foreach( $this->getSystemUserGroups() as $user_group )
        {
            $user_groups[] = $user_group->id;
        }

        return in_array($group->id, $user_groups);
    }

    /**
     *
     */
    public static function getInGroups( $groups )
    {
        $collection = [];
        $users = self::all();
        if ($users)
        {
            foreach ($users as $user)
            {
                foreach ($groups as $group)
                {
                    if ($user->checkInGroup($group))
                    {
                        $collection[] = $user;
                    }
                }
            }
        }
        return $collection;
    }

    /**
     * Clone the entire object and related ones
     */
    public function cloneUser()
    {
        $groups   = $this->getSystemUserGroups();
        $units    = $this->getSystemUserUnits();
        $programs = $this->getSystemUserPrograms();
        unset($this->id);
        $this->name .= ' (clone)';
        $this->store();
        if ($groups)
        {
            foreach ($groups as $group)
            {
                $this->addSystemUserGroup( $group );
            }
        }
        if ($units)
        {
            foreach ($units as $unit)
            {
                $this->addSystemUserUnit( $unit );
            }
        }
        if ($programs)
        {
            foreach ($programs as $program)
            {
                $this->addSystemUserProgram( $program );
            }
        }
    }

            
    private static function updatePasswordHash($user, $userPassword)
    {
        $user->password = password_hash($userPassword, PASSWORD_DEFAULT);
        $user->store();
    }

     public function getProgramsActions()
    {
        $programs_actions = [];
        foreach( $this->getSystemUserGroups() as $group )
        {
            foreach( $group->getSystemPrograms() as $prog )
            {
                if($prog->actions)
                {
                    $programs_actions[$prog->controller] = [];
                    $actions = array_map(function($actions){
                        return $actions->action;
                    },json_decode($prog->actions));
                    $allowed_actions = json_decode($prog->allowed_actions);
                    $allowed_actions = array_flip($allowed_actions);
                    if($actions)
                    {
                        foreach($actions as $action)
                        {
                            if(!isset($programs_actions[$prog->controller][$action]))
                            {
                                $programs_actions[$prog->controller][$action] = false;
                            }
                            if(isset($allowed_actions[$action]))
                            {
                                $programs_actions[$prog->controller][$action] = true;
                            }
                        }   
                    }
                }
            }
        }
        return $programs_actions;
    }
}


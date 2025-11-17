<?php

use Adianti\Database\TTransaction;

class RegisterCrmProgram
{
    public static function run($param = null)
    {
        try {
            TTransaction::open('permission');

            // Ensure program exists
            $controller = 'CrmView';
            $program = SystemProgram::where('controller', '=', $controller)->first();
            if (!$program) {
                $program = new SystemProgram;
                $program->name = 'CRM';
                $program->controller = $controller;
                $program->store();
            }

            // Grant to all groups (safe default)
            $groups = SystemGroup::get();
            if ($groups) {
                foreach ($groups as $g) {
                    $exists = SystemGroupProgram::where('system_group_id', '=', $g->id)
                        ->where('system_program_id', '=', $program->id)
                        ->count();
                    if (!$exists) {
                        $gp = new SystemGroupProgram;
                        $gp->system_group_id = $g->id;
                        $gp->system_program_id = $program->id;
                        $gp->store();
                    }
                }
            }

            TTransaction::close();

            echo "Registered program {$program->controller} (id {$program->id}) and granted to available groups." . PHP_EOL;
        } catch (Exception $e) {
            TTransaction::rollback();
            fwrite(STDERR, $e->getMessage() . PHP_EOL);
        }
    }
}

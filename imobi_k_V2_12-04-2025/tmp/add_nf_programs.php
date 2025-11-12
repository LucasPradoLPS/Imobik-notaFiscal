<?php
// Script to add system_program entries and associate them to all groups
require_once __DIR__ . '/../init.php';

try {
    TTransaction::open('imobi_producao');

    $controllers = [
        ['controller' => 'NotaFiscalList', 'name' => 'Notas Fiscais - Listar'],
        ['controller' => 'NotaFiscalEmitForm', 'name' => 'Notas Fiscais - Emitir'],
        ['controller' => 'NotaFiscalReportForm', 'name' => 'Notas Fiscais - Relatórios'],
    ];

    foreach ($controllers as $c) {
        $existing = SystemProgram::findByController($c['controller']);
        if ($existing) {
            echo "Program already exists: {$c['controller']} (id={$existing->id})\n";
            $program = $existing;
        } else {
            $program = new SystemProgram;
            $program->name = $c['name'];
            $program->controller = $c['controller'];
            $program->actions = null;
            $program->store();
            echo "Created program: {$c['controller']} (id={$program->id})\n";
        }

        // associate to all groups
        $groups = SystemGroup::where('id','>',0)->load();
        if ($groups) {
            foreach ($groups as $g) {
                $g->addSystemProgram($program);
                echo "  Assigned to group: {$g->name} (id={$g->id})\n";
            }
        } else {
            // create admin group
            $g = new SystemGroup;
            $g->name = 'Admin';
            $g->store();
            $g->addSystemProgram($program);
            echo "  Created group Admin and assigned (id={$g->id})\n";
        }
    }

    TTransaction::close();
    echo "Done.\n";
}
catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    TTransaction::rollback();
}

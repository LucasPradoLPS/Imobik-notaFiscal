<?php
/**
 * NotaFiscalEmitForm
 *
 * Stub para emitir notas fiscais
 */
class NotaFiscalEmitForm extends TPage
{
    public function __construct($param = null)
    {
        parent::__construct();

        $panel = new TPanelGroup('Emitir Nota Fiscal');
        $panel->add(new TAlert('info', 'Formulário para emissão de nota fiscal (stub).'));

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($panel);

        parent::add($container);
    }
}

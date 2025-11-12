<?php
/**
 * NotaFiscalReportForm
 *
 * Stub para relatórios de notas fiscais
 */
class NotaFiscalReportForm extends TPage
{
    public function __construct($param = null)
    {
        parent::__construct();

        $panel = new TPanelGroup('Relatórios de Notas Fiscais');
        $panel->add(new TAlert('info', 'Relatórios de notas fiscais (stub).'));

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($panel);

        parent::add($container);
    }
}

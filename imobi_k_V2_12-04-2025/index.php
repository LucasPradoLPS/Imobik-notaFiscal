<?php
require_once 'init.php';
// ensure a sane default language to avoid null warnings
// initialize session explicitly (previous condition prevented construction)
new TSession;
$userLang = TSession::getValue('user_language') ?: ($ini['general']['language'] ?? 'pt_BR');

$theme  = $ini['general']['theme'];
$class  = isset($_REQUEST['class']) ? $_REQUEST['class'] : '';
$public = in_array($class, $ini['permission']['public_classes']);

// AdiantiCoreApplication::setRouter(array('AdiantiRouteTranslator', 'translate'));

ApplicationTranslator::setLanguage( $userLang, true );
BuilderTranslator::setLanguage( $userLang, true );

$content = BuilderTemplateParser::init('layout');
$content = ApplicationTranslator::translateTemplate($content);

echo $content;

if (TSession::getValue('logged') OR $public)
{
    if ($class)
    {
        $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : NULL;
        AdiantiCoreApplication::loadPage($class, $method, $_REQUEST);
    }
}
else
{
    if (isset($ini['general']['public_view']) && $ini['general']['public_view'] == '1')
    {
        if (!empty($ini['general']['public_entry']))
        {
            AdiantiCoreApplication::loadPage($ini['general']['public_entry'], '', $_REQUEST);
        }
    }
    else
    {
        AdiantiCoreApplication::loadPage('LoginForm', '', $_REQUEST);
    }
}


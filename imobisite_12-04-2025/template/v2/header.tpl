<!doctype html>
<html lang="en">

<head>
    <!-- Meta Tag -->
    <base href="{$URLSITE}">    

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {if $FILEATUAL == "imovelview.php"}
        <meta property="og:url"           content="https://{$URLATUAL}" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="{$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})" />
        <meta property="og:description"   content="Os melhores imóveis você encontra aqui!" />
        <meta property="og:image"         content="{$IMGDESTAQUE1}" />
    {/if}

    {if $FILEATUAL == "imovelcorretor.php"}

        {$filenameFacebook = $URLSYSTEM|cat:"app/images/phsotos/"|cat:$VIEWCORRETOR->cnpjcpf|cat:".jpg"}
        {$file_headers = get_headers($filenameFacebook)}
        {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
            {$filenameFacebook = $URLSYSTEM|cat:$CONFIG->logomarca}
        {else}
            {$filenameFacebook = $URLSYSTEM|cat:"app/images/photos/"|cat:$VIEWCORRETOR->cnpjcpf|cat:".jpg"}
        {/if}
        <meta property="og:url"           content="{$URLSITE}{$URLSEO}" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="{$VIEWCORRETOR->pessoa}" />
        <meta property="og:description"   content="{$CONFIG->nomefantasia} | Veja aqui os melhores imóveis com os valores de mercado mais atraentes!" />
        <meta property="og:image"         content="{$filenameFacebook}" />
    {/if}

    <meta name="author" content="Kabongo">
    <title>{$SITE->title}</title>
    <meta name="description" content="{$SITE->description}" />
    <meta name="keywords" content="{$SITE->keywords}">
    <link rel="shortcut icon" href="{$URLSYSTEM}{$CONFIG->logomarca}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Required style of the theme -->
    <link rel="stylesheet" href="assets/v2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/v2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/v2/css/all.min.css">
    <link rel="stylesheet" href="assets/v2/css/animate.min.css">
    <link rel="stylesheet" href="assets/v2/webfonts/flaticon/flaticon.css">
    <link rel="stylesheet" href="assets/v2/css/owl.css">
    <link rel="stylesheet" href="assets/v2/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="assets/v2/css/layerslider.css">
    <link rel="stylesheet" href="assets/v2/css/template.css">
    <link rel="stylesheet" href="assets/v2/css/style.css">
    <link rel="stylesheet" href="assets/v2/css/colors/color.css">
    <link rel="stylesheet" href="assets/v2/css/loader.css">
    <link rel="stylesheet" href="assets/v2/css/tom-select.bootstrap5.css">

    <script src="assets/v2/js/tom-select.complete.js"></script>    
    <script src="assets/v2/js/dropzone/dist/min/dropzone.min.js"></script>    
    <script src="assets/v2/js/theme.min.js"></script>
    <style>
        :root {
            --theme-primary-color: {$SITE->collordefault};
        }    
        .btn-primary {
            color: {$SITE->collordefaulttext};
            background-color: {$SITE->collordefault};
            border-color: {$SITE->collordefault};
        }
        .btn-primary:focus {
            color: {$SITE->collordefaulttext};
            background-color: {$SITE->collordefault};
            border-color: {$SITE->collordefault};
        }        
        .bg-primary {
            --bs-bg-opacity: 1;
            background-color: {$SITE->collordefault};
        }      
        .bg-secondary-opacity {
            background-color: var(--theme-dark-opacity-color);
        }      
        .btn-soft-primary {
            color: {$SITE->collordefault};
            background-color: rgba(55, 125, 255, .1);
            border: 1px solid {$SITE->collordefault};
            margin-bottom: 5px;
        }
        .btn-check:focus+.btn-soft-primary, .btn-soft-primary:focus, .btn-soft-primary:hover {
            color: {$SITE->collordefaulttext};
            background-color: {$SITE->collordefault};
        }
        .btn-outline-primary {
            color: {$SITE->collordefault};
            border-color: {$SITE->collordefault};
        }
        .btn-outline-primary:hover {
            color: {$SITE->collordefaulttext};
            background-color: {$SITE->collordefault};
            border-color: {$SITE->collordefault};
        }
        .border-primary {
            border-color: {$SITE->collordefault};
        }
    </style>

    <script async src="https://www.googletagmanager.com/gtag/js?id={$SITE->idanalityc}"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){literal}{dataLayer.push(arguments);}{/literal}
        gtag('js', new Date());
        gtag('config', '{$SITE->idanalityc}');
    </script>

</head>

<body>
<form name="form_headergeral" id="form_headergeral" method="GET">
    <input type="hidden" name="situacaoImv" value="">
    <input type="hidden" name="zonaImv" value="">
    <input type="hidden" name="cidadeImv" value="">
    <input type="hidden" name="bairroImv" value="">
    <input type="hidden" name="tipoImovel[]" id="tipoImovelGeral" value="">
</form>        

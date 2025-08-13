<!DOCTYPE html>
<html lang="en">
<head>
  <base href="{$URLSITE}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  {if $FILEATUAL == "imovelview.php"}
    <meta property="og:url"           content="https://{$URLATUAL}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})" />
    <meta property="og:description"   content="Os melhores imóveis você encontra aqui!" />
    <meta property="og:image"         content="{$IMGDESTAQUE1}" />
  {/if}

  {if $FILEATUAL == "imovelcorretor.php"}

    {$filenameFacebook = $URLSYSTEM|cat:"app/images/photos/"|cat:$VIEWCORRETOR->cnpjcpf|cat:".jpg"}
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

  <title>{$SITE->title}</title>
  <meta name="description" content="{$SITE->description}" />
  <meta name="keywords" content="{$SITE->keywords}">
  <link rel="shortcut icon" href="{$URLSYSTEM}{$CONFIG->logomarca}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/v1/vendor/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/v1/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
  <link rel="stylesheet" href="assets/v1/vendor/chart.js/dist/Chart.min.css">
  <link rel="stylesheet" href="assets/v1/vendor/nouislider/dist/nouislider.min.css">
  <link rel="stylesheet" href="assets/v1/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
  <link rel="stylesheet" href="assets/v1/vendor/leaflet/dist/leaflet.css"/>
  <link rel="stylesheet" href="assets/v1/vendor/quill/dist/quill.snow.css">
  <link rel="stylesheet" href="assets/v1/vendor/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/v1/vendor/fancybox/jquery.fancybox.min.css">  
  <link rel="stylesheet" href="assets/v1/css/theme.min.css">
  <script src="assets/v1/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/v1/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="assets/v1/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
  <script src="assets/v1/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="assets/v1/vendor/nouislider/dist/nouislider.min.js"></script>
  <script src="assets/v1/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
  <script src="assets/v1/vendor/typed.js/lib/typed.min.js"></script>
  <script src="assets/v1/vendor/imask/dist/imask.min.js"></script>
  <script src="assets/v1/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
  <script src="assets/v1/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
  <script src="assets/v1/vendor/hs-count-characters/dist/js/hs-count-characters.js"></script>
  <script src="assets/v1/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="assets/v1/vendor/quill/dist/quill.min.js"></script>
  <script src="assets/v1/js/theme.min.js"></script>
  <script src="assets/v1/js/jquery-3.6.0.js"></script>
  <script src="assets/v1/js/jquery.maskMoney.js"></script>
  <style>
    .bg-primary {
      --bs-bg-opacity: 1;
      background-color: {$SITE->collordefault};
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
    .btn-soft-primary {
      color: {$SITE->collordefault};
      background-color: rgba(55, 125, 255, .1);
      border-color: transparent;
    }
    .btn-check:focus+.btn-soft-primary, .btn-soft-primary:focus, .btn-soft-primary:hover {
      color: {$SITE->collordefaulttext};
      background-color: {$SITE->collordefault};
    }
    .btn-primary:hover {
      color: {$SITE->collordefaulttext};
      background-color: {$SITE->collordefault};
      border-color: {$SITE->collordefault};
      opacity: 8;
    }
    .btn-white:hover {
      background-color: #fff;
      color: {$SITE->collordefault};
      border-color: rgba(33, 50, 91, .1);
    }
    .btn-white:focus {
      background-color: #fff;
      color: {$SITE->collordefault};
      border-color: rgba(33, 50, 91, .1);
    }
    .btn-ghost-secondary:hover, .btn-ghost-secondary:focus {
      color: {$SITE->collordefault};
    }

    .text-primary {
      --bs-text-opacity: 1;
      color: {$SITE->collordefault};
    }
    .page-item.active .page-link {
      z-index: 3;
      color: {$SITE->collordefaulttext};
      background-color: {$SITE->collordefault};
      border-color: {$SITE->collordefault};
    }
    .page-link:hover {
      z-index: 2;
      color: {$SITE->collordefault};
      background-color: #f8fafd;
      border-color: #e7eaf3;
    }
    .btn-check:active+.btn-primary, .btn-check:checked+.btn-primary, .btn-primary.active, .btn-primary:active, .show>.btn-primary.dropdown-toggle {
      color: #fff;
      background-color: {$SITE->collordefault};
      border-color: {$SITE->collordefault};
    }
    a {
      color: {$SITE->collordefault};
      text-decoration: none;
    }
    a:not([href]):not([class]), a:not([href]):not([class]):hover {
      color: {$SITE->collordefault};
      text-decoration: none;
    }
    a>code {
      color: {$SITE->collordefault};
    }
    a:hover {
      color: {$SITE->collordefault};
    }
    a:hover .text-inherit:hover {
      color: {$SITE->collordefault};
    }
    h4:hover {
      color: {$SITE->collordefault};
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
    .link-secondary:focus, .link-secondary:hover {
      color: {$SITE->collordefault};
    }
    .navbar-light .navbar-nav .nav-link:hover {
      color: {$SITE->collordefault};
    }
    .btn-check:hover+.btn {
      color: {$SITE->collordefault};
      box-shadow: 0 .1875rem .375rem rgba(140, 152, 164, .25);
    }
    .js-go-to:hover {
      background-color: {$SITE->collordefault};
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
<header id="header" class="navbar navbar-expand-lg navbar-end navbar-light bg-white">
  <div class="container">
    <nav class="js-mega-menu navbar-nav-wrap">
      <a class="navbar-brand" href="home/" aria-label="Front">
        <img class="navbar-brand-logo" src="{$URLSYSTEM}{$CONFIG->logomarca}" alt="Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-default">
          <i class="bi-list text-dark"></i>
        </span>
        <span class="navbar-toggler-toggled">
          <i class="bi-x text-dark"></i>
        </span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item {$HIDDENLOCACAO}">
            <a class="nav-link " href="javascript:js_MenuDireciona('1,5');">Imóveis para alugar</a>
          </li>
          <li class="nav-item {$HIDDENVENDA}">
            <a class="nav-link " href="javascript:js_MenuDireciona('3,5');">Imóveis para comprar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="anuncie-seu-imovel/">Anuncie seu imóvel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="sobre-nos/">Sobre Nós</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="contato/">Contato</a>
          </li>
          {if $SITE->customerbutton == true}
            <li class="nav-item">
              <a class="btn btn-primary btn-transition" onclick="window.open('http://portal.imobik.com.br')">Portal do Cliente</a>
            </li>
          {/if}
        </ul>
      </div>
    </nav>
  </div>
</header>
<form name="form_headergeral" id="form_headergeral" method="GET">
  <input type="hidden" name="situacaoImv" value="">
  <input type="hidden" name="zonaImv" value="">
  <input type="hidden" name="cidadeImv" value="">
  <input type="hidden" name="bairroImv" value="">
</form>
<!-- ========== END HEADER ========== -->
<div class="position-fixed end-0 bottom-12 zi-999 p-3">
  <div class="  avatar avatar-lg avatar-primary avatar-circle p-2" style="background-color:#dbdbdb;right:5px">
    <div class="d-grid text-center">
      <a class="text-center" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
        <i class="bi-whatsapp text-primary" style="font-size:35px;"></i>
      </a>
    </div>
  </div>
</div>

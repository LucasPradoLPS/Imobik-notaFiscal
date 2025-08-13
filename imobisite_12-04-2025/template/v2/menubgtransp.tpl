<header class="header-style nav-on-banner fixed-bg-secondary">
    <div class="main-nav">
        <div class="container">
            <div class="row row-cols-md-2 row-cols-1">
                <div class="col xs-mx-none">
                    <ul class="top-contact list-color-white">
                        <li><a role="button" onclick="location.href='tel:{$SITE->telefone}'"><small><i class="fa fa-phone me-2" aria-hidden="true"></i>{$SITE->telefone}</small></a></li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="nav-bar-top right list-color-white d-flex">
                        <li><a href="compare/"><small>Compare Imóveis</small></a></li>
                        <li><a href="favoritos/"><small>Meus Favoritos</small></a></li>
                        <!--<li><a href="signin.html">Login</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-nav">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg nav-white nav-primary-hover nav-line-active">
                        <a class="navbar-brand" href="home/"><img class="nav-logo" src="{$URLSYSTEM}{$CONFIG->logomarca}" alt=""></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon flaticon-menu flat-small text-primary"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)">Buscar Imóveis</a>
                                    <ul class="dropdown-menu">
                                        {if $USEMAP == true}
                                            <li {$HIDDENLOCACAO}><a class="dropdown-item" role="button" onclick="js_MenuDirecionaMap('1,5');">Imóveis para alugar</a></li>
                                        {else}
                                            <li {$HIDDENLOCACAO}><a class="dropdown-item" role="button" onclick="js_MenuDireciona('1,5');">Imóveis para alugar</a></li>
                                        {/if}
                                        {if $USEMAP == true}
                                            <li {$HIDDENVENDA}><a class="dropdown-item" role="button" onclick="js_MenuDirecionaMap('3,5');">Imóveis para comprar</a></li>
                                        {else}
                                            <li {$HIDDENVENDA}><a class="dropdown-item" role="button" onclick="js_MenuDireciona('3,5');">Imóveis para comprar</a></li>
                                        {/if}
                                        {if $USEMAP == true}
                                            <li {$HIDDENTEMPORADA}><a class="dropdown-item" role="button" onclick="js_MenuDirecionaMap('10');">Imóveis para Temporada</a></li>
                                        {else}
                                            <li {$HIDDENTEMPORADA}><a class="dropdown-item" role="button" onclick="js_MenuDireciona('10');">Imóveis para Temporada</a></li>
                                        {/if}
                                    </ul>    
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="anuncie-seu-imovel/">Anuncie seu imóvel</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="sobre-nos/">Sobre Nós</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="contato/">Contato</a>
                                </li>
                            </ul>
                            {if $SITE->customerbutton == true}
                                <ul class="navbar-nav border-start ps-3">
                                    <li class="nav-item">
                                        <a href="#" class="btn btn-primary add-listing-btn" onclick="window.open('http://portal.imobik.com.br')">Portal do Cliente</a>
                                    </li>
                                </ul>
                            {/if}
                            <br><br>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
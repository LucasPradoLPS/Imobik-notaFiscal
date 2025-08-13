<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-white">

    {include file="menubgtransp.tpl"}

    {if isset($SITESLIDE['v2-t03-header-1920x1280'])}
        <div class="full-row p-0" style="background-image: url({$URLSYSTEM}{$SITESLIDE['v2-t03-header-1920x1280']}); background-position: center center;">    
    {else}
        <div class="full-row p-0">
            <h1>IMG v2-t03-header-1920x1280</h1> 
    {/if}
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-10">
                    <div class="banner-search" style="padding-top: 300px; padding-bottom: 320px;">
                        {if isset($SITETEXT["v2-t03-header-text1"])}
                            <h2 class="text-center mx-auto text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t03-header-text1"]}
                            </h2>
                        {else}
                            <h2 class="text-center mx-auto text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t03-header-text1
                            </h2>
                        {/if}
                        {if isset($SITETEXT["v2-t03-header-text2"])}
                            <span class="d-table mx-auto text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t03-header-text2"]}
                            </span>
                        {else}
                            <span class="d-table mx-auto text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t03-header-text2
                            </span>
                        {/if}
                        <form class="banner-search-form quick-search bg-white p-4" name="form_imvgeral" id="form_imvgeral" method="GET">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <input type="text" class="form-control " id="buscaHero" name="buscaHero" placeholder="Faça sua pesquisa" aria-label="Faça sua pesquisa">
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    {if $USEMAP == true}
                                        <button class="btn btn-primary w-100" onclick="js_SearchMap(document.form_imvgeral.buscaHero.value)">Encontrar Imóveis</button>
                                    {else}
                                        <button class="btn btn-primary w-100" onclick="js_Search(document.form_imvgeral.buscaHero.value)">Encontrar Imóveis</button>
                                    {/if}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
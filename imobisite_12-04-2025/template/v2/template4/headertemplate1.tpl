<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-white">

    {include file="menubgtransp.tpl"}

    {if isset($SITESLIDE['v2-t04-header-1920x1280'])}
        <div class="full-row p-0" style="background-image: url({$URLSYSTEM}{$SITESLIDE['v2-t04-header-1920x1280']}); background-position: center center; background-size: cover;">
    {else}
        <div class="full-row p-0">
            <h1>IMG v2-t04-header-1920x1280</h1> 
    {/if}
        <div class="container">
            <div class="row justify-content-md-center py-8">
                <div class="col-md-10">
                    <div class="banner-search sm-p-0" style="padding-top: 170px; padding-bottom: 190px;">
                        {if isset($SITETEXT["v2-t04-header-text1"])}
                            <h2 class="text-center mx-auto text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t04-header-text1"]}
                            </h2>
                        {else}
                            <h2 class="text-center mx-auto text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t04-header-text1
                            </h2>
                        {/if}
                        {if isset($SITETEXT["v2-t04-header-text2"])}
                            <span class="d-table mx-auto text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t04-header-text2"]}
                            </span>
                        {else}
                            <span class="d-table mx-auto text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t04-header-text2
                            </span>
                        {/if}
                        <style>
                        .banner-search-form {
                            background: rgba(220, 220, 220, 0.5);
                            border-radius: 5px;
                        }                        
                        </style>
                        <form class="banner-search-form p-4 quick-search" name="form_imvgeral" id="form_imvgeral" method="GET">
                            <div class="row">
                                <div class="col-lg-3 my-2">
                                    <select id="cidadeImv" name="cidadeImv" class="form-control">
                                        <option value="0">Todas as cidades</option>
                                        {foreach from=$IMOVELCIDADE item="ITEMCIDADE"}
                                            <option value="{$ITEMCIDADE->idcidade}">{$ITEMCIDADE->cidade}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-lg-6 my-2">
                                    <input type="text" class="form-control " id="buscaHero" name="buscaHero" placeholder="Faça sua pesquisa" aria-label="Faça sua pesquisa">
                                </div>
                                <div class="col-lg-3 my-2">
                                    {if $USEMAP == true}
                                        <button class="btn btn-primary w-100" onclick="js_SearchCityMap(document.form_imvgeral.buscaHero.value,document.form_imvgeral.cidadeImv.value,)">Encontrar Imóveis</button>
                                    {else}
                                        <button class="btn btn-primary w-100" onclick="js_SearchCity(document.form_imvgeral.buscaHero.value,document.form_imvgeral.cidadeImv.value,)">Encontrar Imóveis</button>
                                    {/if}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
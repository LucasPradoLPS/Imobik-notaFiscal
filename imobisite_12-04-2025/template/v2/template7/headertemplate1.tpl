<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-light">
                                        
    {include file="menubgtransp.tpl"}

    {if isset($SITESLIDE['v2-t07-header-1920x1280'])}
        <div class="full-row p-0" style="background-image: url('{$URLSYSTEM}{$SITESLIDE['v2-t07-header-1920x1280']}');background-size: 100%;background-repeat: no-repeat;padding-top: 122px;">
    {else}
        <div class="full-row p-0">
            <h1>IMG v2-t07-header-1920x1280</h1> 
    {/if}

        <div class="container">
            <div class="row justify-content-left py-8">
                <div class="col-md-10">
                    <div class="quick-search banner-search sm-p-0" style="padding-top: 170px; padding-bottom: 190px;">
                        {if isset($SITETEXT["v2-t07-header-text1"])}
                            <h1 class="text-start text-white font-400" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t07-header-text1"]}                                
                            </h1>
                        {else}
                            <h1 class="text-start text-white font-400" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t07-header-text1
                            </h1>
                        {/if}
                        {if isset($SITETEXT["v2-t07-header-text2"])}
                            <span class="d-table text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t07-header-text2"]}                                
                            </span>
                        {else}
                            <span class="d-table text-white font-medium mb-4" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t07-header-text2
                            </span>
                        {/if}
                        <form class="banner-search-form bg-transparent" name="form_imvgeral" id="form_imvgeral" method="GET">                           
                            <div class="row g-3">
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
                        {if isset($SITETEXT["v2-t07-header-text3"])}
                            <span class="h6 mb-20 mt-20 d-table text-white font-400" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t07-header-text3"]}                                
                            </span>
                        {else}
                            <span class="h6 mb-20 mt-20 d-table text-white font-400" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t07-header-text3
                            </span>
                        {/if}
                        <div class="row row-cols-lg-6 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
                            {$aTypes = array('<span class="flaticon-home flat-medium text-primary"></span>','<span class="flaticon-sketch flat-medium text-primary"></span>','<span class="flaticon-online-booking flat-medium text-primary"></span>','<span class="flaticon-relationship flat-medium text-primary"></span>','<span class="flaticon-garage flat-medium text-primary"></span>','<span class="flaticon-house-plan flat-medium text-primary"></span>')}
                            {foreach from=$IMOVELTIPO key=xx item="TIPO"}
                                {if $xx < 6}
                                    {if $USEMAP == true}
                                        <div class="col" role="button" onclick="js_TipoImovelDirecionaMap({$TIPO->idimoveltipo})">
                                    {else}
                                        <div class="col" role="button" onclick="js_TipoImovelDireciona({$TIPO->idimoveltipo})">
                                    {/if}
                                        <div class="text-center py-30 px-10 bg-white text-dark transation hover-shadow h-100">
                                            {$aTypes[$xx]}
                                            <h6>                                                        
                                                <a href="javascript:void(0)" class="d-block text-dark hover-text-primary mt-3 font-400">{$TIPO->imoveltipo}</a>
                                            </h6>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row p-0 sm-m-0" style="margin-top: -200px;">
        <div class="container">
            <div class="row row-cols-md-3 row-cols-1 g-4 p-5 mx-0 bg-white">
                <div class="col">
                    <div class="mb-4"><i class="flaticon-life-insurance text-primary flat-medium"></i></div>
                    {if isset($SITETEXT["v2-t07-header-title1"])}
                        <h4 class="mb-3 font-400">
                            {$SITETEXT["v2-t07-header-title1"]}
                        </h4>
                    {else}
                        <h4 class="mb-3 font-400">
                            TXT v2-t07-header-title1
                        </h4>
                    {/if}
                    {if isset($SITETEXT["v2-t07-header-subtitle1"])}
                        <p>
                            {$SITETEXT["v2-t07-header-subtitle1"]}
                        </p>
                    {else}
                        <p>
                            TXT v2-t07-header-subtitle1
                        </p>
                    {/if}
                </div>
                <div class="col">
                    <div class="mb-4"><i class="flaticon-data text-primary flat-medium"></i></div>
                    {if isset($SITETEXT["v2-t07-header-title2"])}
                        <h4 class="mb-3 font-400">
                            {$SITETEXT["v2-t07-header-title2"]}
                        </h4>
                    {else}
                        <h4 class="mb-3 font-400">
                            TXT v2-t07-header-title2
                        </h4>
                    {/if}
                    {if isset($SITETEXT["v2-t07-header-subtitle2"])}
                        <p>
                            {$SITETEXT["v2-t07-header-subtitle2"]}
                        </p>
                    {else}
                        <p>
                            TXT v2-t07-header-subtitle2
                        </p>
                    {/if}
                </div>
                <div class="col">
                    <div class="mb-4"><i class="flaticon-id-card text-primary flat-medium"></i></div>
                    {if isset($SITETEXT["v2-t07-header-title3"])}
                        <h4 class="mb-3 font-400">
                            {$SITETEXT["v2-t07-header-title3"]}
                        </h4>
                    {else}
                        <h4 class="mb-3 font-400">
                            TXT v2-t07-header-title3
                        </h4>
                    {/if}
                    {if isset($SITETEXT["v2-t07-header-subtitle3"])}
                        <p>
                            {$SITETEXT["v2-t07-header-subtitle3"]}
                        </p>
                    {else}
                        <p>
                            TXT v2-t07-header-subtitle3
                        </p>
                    {/if}                    
                </div>
            </div>
        </div>
    </div>

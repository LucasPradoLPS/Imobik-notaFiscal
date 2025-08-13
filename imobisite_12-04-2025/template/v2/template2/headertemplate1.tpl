<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-light">

    {include file="menubglight.tpl"}

    {if isset($SITESLIDE['v2-t02-header-1920x1280'])}
        <div class="full-row p-0 overlay-secondary" style="background-image: url({$URLSYSTEM}{$SITESLIDE['v2-t02-header-1920x1280']}); background-position: center center;">
    {else}
        <div class="full-row p-0 overlay-secondary">    
            <h1>IMG v2-t02-header-1920x1280</h1> 
    {/if}
        <div class="container">
            <div class="banner-search" style="padding-top: 120px; padding-bottom: 120px;">
                <div class="row">
                    <div class="col-lg-7 position-relative">
                        {if isset($SITETEXT["v2-t02-header-text1"])}
                            <h2 class="text-white font-400">{$SITETEXT["v2-t02-header-text1"]}</h2>
                        {else}
                            <h2 class="text-white font-400">TXT v2-t02-header-text1</h2>                        
                        {/if}
                        {if isset($SITETEXT["v2-t02-header-text2"])}
                            <span class="h5 mb-50 d-table text-white font-400">
                                {$SITETEXT["v2-t02-header-text2"]}
                            </span>
                        {else}
                            <span class="h5 mb-50 d-table text-white font-400">
                                TXT v2-t02-header-text2
                            </span>
                        {/if}
                        {if isset($SITETEXT["v2-t02-header-text3"])}
                            <span class="h6 mb-20 d-table text-white font-400">
                                {$SITETEXT["v2-t02-header-text3"]}
                            </span>
                        {else}
                            <span class="h6 mb-20 d-table text-white font-400">
                                TXT v2-t02-header-text3
                            </span>
                        {/if}
                        
                        <div class="row">
                            {foreach from=$IMOVELTIPO key=xx item="TIPO"}
                                {if $xx < 3}
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="text-center p-35 bg-dark text-white transation hover-shadow h-100 rounded">
                                            <span class="flaticon-network flat-medium text-primary"></span>
                                            <h5 class="mb-3 font-400">
                                                {if $USEMAP == true}
                                                    <a href="javascript:js_TipoImovelDirecionaMap({$TIPO->idimoveltipo})" class="d-block text-white hover-text-primary mt-4">
                                                {else}
                                                    <a href="javascript:js_TipoImovelDireciona({$TIPO->idimoveltipo})" class="d-block text-white hover-text-primary mt-4">
                                                {/if}
                                                    {$TIPO->imoveltipo}
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        <!--
                        {if isset($SITETEXT["v2-t02-header-text4"])}
                            <p class="text-white">
                                {$SITETEXT["v2-t02-header-text4"]}
                            </p>
                        {else}
                            <p class="text-white">
                                TXT v2-t02-header-text4
                            </p>
                        {/if}
                        -->
                        <br>
                    </div>
                    <div class="col-lg-4 offset-lg-1">
                        {include file="$HEADERTEMPLATE/filterhome.tpl"}
                    </div>
                </div>
            </div>
        </div>
    </div>
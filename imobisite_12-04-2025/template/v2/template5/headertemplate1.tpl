<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-light">

    {include file="menufullbgwhite.tpl"}

    {if isset($SITESLIDE['v2-t05-header-1920x1280'])}
        <div class="full-row p-0" style="background-image: url({$URLSYSTEM}{$SITESLIDE['v2-t05-header-1920x1280']}); background-size: cover; background-position: center center;">
    {else}
        <div class="full-row p-0">
            <h1>IMG v2-t05-header-1920x1280</h1> 
    {/if}
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="banner-search">
                        {if isset($SITETEXT["v2-t05-header-text1"])}
                            <h2 class="text-start text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                {$SITETEXT["v2-t05-header-text1"]}
                            </h2>
                        {else}
                            <h2 class="text-start text-white" style="text-shadow: 0px 0px 10px rgba(0,0,0,1);">
                                TXT v2-t05-header-text1
                            </h2>
                        {/if}
                        {if isset($SITETEXT["v2-t05-header-text2"])}
                            <span class="d-table text-white mb-4 px-3 py-2 bg-primary rounded">
                                {$SITETEXT["v2-t05-header-text2"]}
                            </span>
                        {else}
                            <span class="d-table text-white mb-4 px-3 py-2 bg-primary rounded">
                                TXT v2-t05-header-text2
                            </span>
                        {/if}
                        {include file="$HEADERTEMPLATE/filterhome.tpl"}
                    </div>
                </div>
            </div>
        </div>
    </div>
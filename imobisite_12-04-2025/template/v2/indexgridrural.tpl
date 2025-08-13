<div class="full-row bg-light {$HIDDENRURAL}">
    <div class="container mb-0">
        <div class="row">
            <div class="col mb-4">
                <div class="align-items-center d-flex">
                    <div class="me-auto">
                        <h3 class="d-table down-line">{$SECAO->sitesecaotitulo}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-4">
                <div class="3block-carusel nav-disable owl-carousel">
                    {foreach from=$IMOVEL_RURAL item="GRIDIMOVELSHOW"}
                        <div class="item">           
                            {include file="imovelcardsingle.tpl"}                                 
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex text-center">
                {if $USEMAP == true}
                    <a role="button" onclick="js_MenuDirecionaFooterMap('','R');" class="ms-auto btn-link">Buscar mais imóveis rurais</a>
                {else}
                    <a role="button" onclick="js_MenuDirecionaFooter('','R');" class="ms-auto btn-link">Buscar mais imóveis rurais</a>
                {/if}
            </div>
        </div>
    </div>
</div>
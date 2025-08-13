<div class="full-row bg-light {$HIDDENLOCACAO}">
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
                    {foreach from=$IMOVEL_LOCACAO item="GRIDIMOVELSHOW"}
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
                    <a role="button" onclick="js_MenuDirecionaFooterMap('1,5','U');" class="ms-auto btn-link">Buscar mais imóveis para alugar</a>
                {else}
                    <a role="button" onclick="js_MenuDirecionaFooter('1,5','U');" class="ms-auto btn-link">Buscar mais imóveis para alugar</a>
                {/if}
            </div>
        </div>
    </div>
</div>
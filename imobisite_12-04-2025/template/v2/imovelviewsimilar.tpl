{if $IMOVELSIMILAR|count > 0}
    <div class="full-row bg-light {$HIDDENLOCACAO}">
        <div class="container mb-0">
            <div class="row">
                <div class="col mb-4">
                    <div class="align-items-center d-flex">
                        <div class="me-auto">
                            <h5 class="d-table down-line">Veja imóveis similares:</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <div class="3block-carusel nav-disable owl-carousel">
                        {foreach from=$IMOVELSIMILAR item="GRIDIMOVELSHOW"}
                            <div class="item">           
                                {include file="imovelcardsingle.tpl"}                                 
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
<input type="hidden" name="imvSelect" value="{$IMVSELECT}">
<input type="hidden" name="situacaoImv" value="">
<input type="hidden" name="cidadeImv" value="">
<input type="hidden" name="bairroImv" value="">
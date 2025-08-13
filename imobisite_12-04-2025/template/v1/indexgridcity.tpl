<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text-secondary text-center mb-5">
                    <h2 class="text-secondary mx-auto mb-4">{$SECAO->sitesecaotitulo}</h2>
                    <span class="d-table w-50 w-sm-100 sub-title mx-auto text-center">
                        Veja abaixo as cidades que oferecemos para você.
                    </span>
                </div>
            </div>
        </div>
        <div class="row row-cols-lg-5 row-cols-md-5 row-cols-sm-2 row-cols-1">
            <div class="5block-carusel nav-disable owl-carousel">           
            {foreach from=$IMOVELCIDADECOUNT item="CIDADE"}
                {if $USEMAP == true}
                    <div class="col" role="button" onclick="js_CidadeDirecionaMap({$CIDADE->idcidade})">
                {else}
                    <div class="col" role="button" onclick="js_CidadeDireciona({$CIDADE->idcidade})">
                {/if}
                    <div class="hover-img-zoom text-center mb-4">
                        <div class="overflow-hidden transation ">
                            <i class="flaticon-real-estate flat-large text-primary xy-center"></i>
                        </div>
                        <div class="mt-3">
                            <h5 class="transation font-400"><a href="#">{$CIDADE->cidade}</a></h5>
                            <p>{$CIDADE->count} {if $CIDADE->count > 1} imóveis {else} imóvel {/if}</p>
                        </div>
                    </div>
                </div>
            {/foreach}
            </div>
        </div>
    </div>
</div>
<div class="full-row bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col mb-5">
                <h2 class="down-line w-50 mx-auto mb-4 text-center text-white w-sm-100">{$SECAO->sitesecaotitulo}</h2>
                <span class="d-table w-50 w-sm-100 sub-title text-white fw-normal mx-auto text-center">Encontre o que você precisa pesquisando pelo tipo de imóvel</span>
            </div>
        </div>
        <div class="row row-cols-lg-5 row-cols-sm-4 row-cols-1 g-3 justify-content-center">
            <div class="4block-carusel nav-disable owl-carousel">
                {foreach from=$IMOVELTIPO item="TIPO"}
                    <div class="col p-2">
                        {if $USEMAP == true}
                            <a href="javascript:js_TipoImovelDirecionaMap({$TIPO->idimoveltipo})" class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        {else}
                            <a href="javascript:js_TipoImovelDireciona({$TIPO->idimoveltipo})" class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        {/if}
                            <div class="rounded-circle p-3 mb-3 mx-auto position-absolute" style="width:80px; height:80px; background: rgba(220, 220, 220, 0.8);"></div>
                            <div class="box-70px position-relative">
                                <i class="flaticon-shop flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                            </div>
                            <h6 class="d-block text-secondary mt-3">{$TIPO->imoveltipo}</h5>
                            <p>{$TIPO->count} {if $TIPO->count > 1} imóveis {else} imóvel {/if}</p>
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

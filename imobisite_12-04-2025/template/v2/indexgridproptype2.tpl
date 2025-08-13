<div class="full-row bg-light" style="padding-bottom: 150px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-5">
                <h2 class="main-title down-line w-50 mx-auto mb-4 text-center w-sm-100">{$SECAO->sitesecaotitulo}</h2>
                <span class="d-table w-50 w-sm-100 text-secondary sub-title mx-auto text-center">Encontre o que você precisa pesquisando pelo tipo de imóvel</span>
            </div>
        </div>
    </div>
</div>
<div class="full-row p-0 bg-light" style="margin-top: -150px; position: relative; z-index: 99">
    <div class="container">
        <div class="row row-cols-lg-5 row-cols-sm-4 row-cols-1 g-3 justify-content-center zommBox">
            <div class="4block-carusel nav-disable owl-carousel">
                {foreach from=$IMOVELTIPO item="TIPO"}
                    <div class="col p-0">
                        <div class="row m-0">
                            <div class="col p-0">
                                <div class="thumb-zoomer bg-white text-center px-4 py-5 y-center hover-bg-primary hover-text-white transation">
                                    <div class="box-100px rounded-circle p-4 mx-auto bg-primary mb-4"><i class="flaticon-life-insurance text-white flat-medium"></i></div>
                                    {if $USEMAP == true}
                                        <h4 class="my-3"><a href="javascript:js_TipoImovelDirecionaMap({$TIPO->idimoveltipo})" class="font-400">{$TIPO->imoveltipo}</a></h4>
                                    {else}
                                        <h4 class="my-3"><a href="javascript:js_TipoImovelDireciona({$TIPO->idimoveltipo})" class="font-400">{$TIPO->imoveltipo}</a></h4>
                                    {/if}
                                    <p>{$TIPO->count} {if $TIPO->count > 1} imóveis {else} imóvel {/if}</p>
                                    {if $USEMAP == true}
                                        <a href="javascript:js_TipoImovelDirecionaMap({$TIPO->idimoveltipo})" class="rounded-circle bg-white x-center"><i class="flaticon-next"></i></a>
                                    {else}
                                        <a href="javascript:js_TipoImovelDireciona({$TIPO->idimoveltipo})" class="rounded-circle bg-white x-center"><i class="flaticon-next"></i></a>
                                    {/if}
                                </div>
                            </div>                                
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
        <br><br>
    </div>
</div>

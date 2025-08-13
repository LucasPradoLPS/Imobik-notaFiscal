<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-white">

    {include file="menubglight.tpl"}

    <div class="full-row p-0 overflow-hidden" {$HIDDENLANCAMENTO}>
        <div id="slider-v2-t06" style="width:1200px; height:800px; margin:0 auto;margin-bottom: 0px;">
            {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
                {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                {$file_headers = get_headers($img_lancamento)}
                {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                    {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                {else}
                    {$img_destaque = $img_lancamento}
                {/if}
                {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
                <div class="ls-slide" data-ls="duration:8000; transition2d:4; kenburnsscale:1.2;">
                    <img width="1920" height="1280" src="{$img_destaque}" class="ls-l" alt="" style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                    <img width="1920" height="1280" src="{$img_destaque}" class="ls-tn" alt="">

                    <div style="top:50%; left:20%; width: 450px;" class="ls-l ls-hide-phone" data-ls="offsetxin:100; offsetyin:0; easingin:easeOutBack; rotatein:0; transformoriginin:30px 360px 0; offsetxout:-80; delayin:1300; durationout:400; parallax:false; parallaxlevel:1;">
                        <div class="property-grid-1 property-block bg-white transation-this hover-shadow">
                            <div class="property_text p-4 pb-4">
                                {if $LANCAMENTO->etiquetanome|trim != ""}
                                    <div class="cata mb-3">
                                        <span class="sale text-white {$ETIQUETAMODELO[$LANCAMENTO->etiquetamodelo]}">{$LANCAMENTO->etiquetanome}</span>
                                    </div>
                                {/if}      
                                <span class="d-inline-block text-primary">Código {$LANCAMENTO->idimovel} - {$LANCAMENTO->imoveldestino}</span>
                                <h3 class="mt-2"><a class="font-600 text-secondary" href="javascript:js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')">{$LANCAMENTO->imoveltipo}</a></h3>
                                {if $LANCAMENTO->exibelogradouro == true}
                                    <span class="my-3 d-block font-fifteen">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>{$LANCAMENTO->endereco}
                                    </span>
                                {/if}
                                <ul class="d-flex quantity font-fifteen mb-3">
                                    {if $LANCAMENTO->dormitorio+0 > 0}
                                        <li style="padding-right:10px;" title="Dormitórios"><span><i class="fa-solid fa-bed fa-xl"></i></span>{$LANCAMENTO->dormitorio+0}</li>
                                    {/if}
                                    {if $LANCAMENTO->banheiro+0 > 0}
                                        <li style="padding-right:10px;" title="Banheiros"><span><i class="fa-solid fa-shower fa-xl"></i></span>{$LANCAMENTO->banheiro+0}</li>                
                                    {/if}
                                    {if $LANCAMENTO->vagagaragem+0 > 0}
                                        <li style="padding-right:10px;" title="Vagas"><span><i class="fa-solid fa-car fa-xl"></i></span>{$LANCAMENTO->vagagaragem+0}</li>                
                                    {/if}
                                    {if $LANCAMENTO->area+0 > 0}
                                        <li style="padding-right:10px;" title="Área"><span><i class="fa-solid fa-vector-square fa-xl"></i></span>{$LANCAMENTO->area+0}
                                        {if $LANCAMENTO->perimetro == "U"}
                                            m²
                                        {else}
                                            hectare(s)
                                        {/if}
                                        </li>                
                                    {/if}
                                    <li title=""><span></span>&nbsp;</li>
                                </ul>
                                <div class="">
                                    {$exibeValorPrimario = ""}                                
                                    {if $LANCAMENTO->idimovelsituacao == "1"}
                                        {$valorPrimario = $LANCAMENTO->aluguel+$LANCAMENTO->iptu+$LANCAMENTO->condominio+$LANCAMENTO->outrataxavalor}
                                        {$valorPrimario = $valorPrimario|number_format:2:",":"."}
                                        {$valorPrimario = "Locação R$ "|cat:$valorPrimario}
                                        {if $LANCAMENTO->exibealuguel == false }
                                            {$exibeValorPrimario = "d-none"}
                                        {/if}
                                    {else}
                                        {$valorPrimario = $LANCAMENTO->venda|number_format:2:",":"."}
                                        {$valorPrimario = "Venda R$ "|cat:$valorPrimario}
                                        {if $LANCAMENTO->exibevalorvenda == false }
                                            {$exibeValorPrimario = "d-none"}
                                        {/if}
                                    {/if}
                                    <br>
                                    {if $exibeValorPrimario == "" }
                                        <span class="listing-price text-primary h4 font-700">{$valorPrimario}</small></span>                                    
                                    {else}
                                        <span class="listing-price text-primary h4 font-700">&nbsp;</small></span>                                    
                                    {/if}
                                </div>
                                <div class="">
                                    <br>
                                    <ul class="quick-meta ms-auto">
                                        <li class="compare-1" data-compare-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar para comparação"><i class="flaticon-transfer flat-mini"></i></a></li>
                                        <li class="favorite-1" data-favorite-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar aos Favoritos"><i class="flaticon-like-1 flat-mini"></i></a></li>
                                        <li class="md-mx-none"><a class="quick-view" href="{$LANCAMENTO->idimovel}" title="Detalhes do Imóvel"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="bg-primary">
                                <a href="javascript:js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')" class="btn btn-primary mx-auto w-100">
                                    Veja tudo sobre este imóvel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>

<div class="full-row px-4 pb-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="me-auto">
                    <h2 class="d-table mb-4 down-line">{$SECAO->sitesecaotitulo}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="full-row pt-5 px-4 sm-px-0">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="4block-carusel nav-disable owl-carousel">            
                    {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}                
                        {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                        {$file_headers = get_headers($img_lancamento)}
                        {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                            {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                        {else}
                            {$img_destaque = $img_lancamento}
                        {/if}
                        {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
                        <div class="property-grid-7 property-block bg-white transation-this">
                            <div class="overlay-secondary overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom"
                                style="min-height: 25rem; background-image: url('{$img_destaque}');background-size: cover;background-repeat: no-repeat;background-position: center center;">
                                {if $LANCAMENTO->etiquetanome|trim != ""}
                                    <div class="cata position-absolute">
                                        <span class="sale text-white {$ETIQUETAMODELO[$LANCAMENTO->etiquetamodelo]}">
                                            {$LANCAMENTO->etiquetanome}
                                        </span>
                                    </div>                                
                                {/if}      
                            </div>
                            <div class="property_text">
                                <h5 class="listing-title"><a href="javascript:js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')">{$LANCAMENTO->imoveltipo}</a></h5>
                                {if $LANCAMENTO->exibelogradouro == true}
                                    <span class="listing-location"><i class="fas fa-map-marker-alt me-2"></i>{$LANCAMENTO->endereco}</span>                                
                                {else}
                                    <span class="listing-location">&nbsp;</span>
                                {/if}
                                <ul class="d-flex quantity font-fifteen">
                                    {if $LANCAMENTO->dormitorio+0 > 0}
                                        <li style="padding-right:10px;" title="Dormitórios"><span><i class="fa-solid fa-bed"></i></span>{$LANCAMENTO->dormitorio+0}</li>
                                    {/if}
                                    {if $LANCAMENTO->banheiro+0 > 0}
                                        <li style="padding-right:10px;" title="Banheiros"><span><i class="fa-solid fa-shower"></i></span>{$LANCAMENTO->banheiro+0}</li>                
                                    {/if}
                                    {if $LANCAMENTO->vagagaragem+0 > 0}
                                        <li style="padding-right:10px;" title="Vagas"><span><i class="fa-solid fa-car"></i></span>{$LANCAMENTO->vagagaragem+0}</li>                
                                    {/if}
                                    {if $LANCAMENTO->area+0 > 0}
                                        <li style="padding-right:10px;" title="Área"><span><i class="fa-solid fa-vector-square"></i></span>{$LANCAMENTO->area+0}
                                        {if $LANCAMENTO->perimetro == "U"}
                                            m²
                                        {else}
                                            hectare(s)
                                        {/if}
                                        </li>                
                                    {/if}
                                    <li title=""><span></span>&nbsp;</li>                
                                </ul>
                                {if $LANCAMENTO->idimovelsituacao == "1"}
                                    {$valorPrimario = $LANCAMENTO->aluguel+$LANCAMENTO->iptu+$LANCAMENTO->condominio+$LANCAMENTO->outrataxavalor}
                                    {$valorPrimario = $valorPrimario|number_format:2:",":"."}
                                    {$valorPrimario = "Locação R$ "|cat:$valorPrimario}
                                {else}
                                    {$valorPrimario = $LANCAMENTO->venda|number_format:2:",":"."}
                                    {$valorPrimario = "Venda R$ "|cat:$valorPrimario}
                                {/if}
                                <br>
                                <span class="listing-price p-2 rounded" style="background-color:rgb(220,220,220,0.5)">
                                    {$valorPrimario}
                                </span>
                                <br><br>
                            <ul class="quick-meta">
                                <li class="compare-1" data-compare-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar para comparação"><i class="flaticon-transfer flat-mini"></i></a></li>
                                <li class="favorite-1" data-favorite-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar aos Favoritos"><i class="flaticon-like-1 flat-mini"></i></a></li>
                                <li class="md-mx-none"><a class="quick-view" href="{$LANCAMENTO->idimovel}" title="Detalhes do Imóvel"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                            </ul>

                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>

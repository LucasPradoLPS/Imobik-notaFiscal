<div class="full-row bg-secondary {$HIDDENLANCAMENTO}">
    <div class="container mb-0">
        <div class="row">
            <div class="col mb-4">
                <div class="align-items-center d-flex">
                    <div class="me-auto">
                        <h3 class="d-table text-white down-line">{$SECAO->sitesecaotitulo}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-4">
                <div class="3block-carusel nav-disable owl-carousel">
                    {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
                        <div class="item">           
                            <div class="property-grid-5 property-block rounded border transation-this bg-white hover-shadow">
                                <div class=" overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom">
                                    {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                                    {$file_headers = get_headers($img_lancamento)}
                                    {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                                        {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                                    {else}
                                        {$img_destaque = $img_lancamento}
                                    {/if}
                                    {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}

                                    {if $LANCAMENTO->etiquetanome|trim != ""}
                                        <div class="cata position-absolute">
                                            <span class="sale text-white {$ETIQUETAMODELO[$LANCAMENTO->etiquetamodelo]}">
                                                {$LANCAMENTO->etiquetanome}
                                            </span>
                                        </div>
                                    {/if}      
                                    <div class="item card-transition" style="min-height: 16rem; background-image: url('{$img_destaque}');background-size: cover;background-repeat: no-repeat;background-position: center center;" 
                                        role="button" onclick="js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')"></div>
                                    {if $LANCAMENTO->exibelogradouro == true}
                                        <a style="background-color:rgba(230,230,255,0.7);position:absolute;bottom:15px;top:inherit" href="#" class="listing-ctg text-black">
                                            <i style="color: var(--theme-primary-color);" class="fa-solid fa-location-arrow fa-xl"></i><span>&nbsp;{$LANCAMENTO->endereco}</span>
                                        </a>            
                                    {/if}
                                </div>
                                <div class="property_text p-3">
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
                                    <span role="button" onclick="js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')">                                    
                                        <h5 class="listing-title"><a href="javascript:void(0)">{$LANCAMENTO->imoveltipo}</a></h5>
                                        <span class="listing-location"><i style="color: var(--theme-primary-color);" class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;{$LANCAMENTO->bairro|lower|ucwords} - {$LANCAMENTO->cidade|lower|ucwords} ({$LANCAMENTO->uf})</span>
                                        <ul class="d-flex quantity font-fifteen">
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
                                        <div class="agent">
                                            <ul class="d-flex justify-content-between">
                                                <li><span>Finalidade</span><div class="text-dark">{$LANCAMENTO->imoveldestino}</div></li>
                                                <li><span>Código</span><div class="text-dark">{$LANCAMENTO->idimovel}</div></li>
                                                <li><span>Construção</span><div class="text-dark">{$LANCAMENTO->imovelmaterial}</div></li>
                                            </ul>
                                        </div>
                                        {if $exibeValorPrimario == "" }
                                            <div class="entry-footer">
                                                <span class="listing-price ">{$valorPrimario}</span>
                                            </div>
                                        {else}
                                            <div class="entry-footer">
                                                <span class="">&nbsp;</span>
                                            </div>
                                        {/if}
                                    </span>
                                    <ul class="position-absolute quick-meta">
                                        <li class="compare-1" data-compare-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar para comparação"><i class="flaticon-transfer flat-mini"></i></a></li>
                                        <li class="favorite-1" data-favorite-imovel="{$LANCAMENTO->idimovel}"><a href="#" title="Adicionar aos Favoritos"><i class="flaticon-like-1 flat-mini"></i></a></li>
                                        <li class="md-mx-none"><a class="quick-view" href="{$LANCAMENTO->idimovel}" title="Detalhes do Imóvel"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="property-overview border summary rounded bg-white p-30 mb-30">
    <div class="row mb-4">
        <div class="col-auto">
            <div class="post-meta font-small text-uppercase list-color-primary">
                <a class="listing-ctg"><i class="fa-solid fa-building"></i><span>{$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})</span></a>
            </div>
            <h4 class="listing-title"><a href="javascript:void(0)">{$IMOVELSHOW->imoveltipo}</a></h4>
            {if $IMOVELSHOW->exibelogradouro == true}
                <span class="listing-location"><i class="fas fa-map-marker-alt text-primary"></i> {$IMOVELSHOW->endereco|lower|ucwords}&nbsp;&nbsp;&nbsp;{$IMOVELSHOW->complemento|lower|ucwords}</span>            
            {/if}
            <a class="d-block text-light hover-text-primary font-small mb-2">( {$IMOVELSHOW->imoveldestino|lower|ucwords} )</a>
        </div>
        <div class="col-auto ms-auto xs-m-0 text-end xs-text-start pb-4">
            {$cifrao = "R$ "}
            {$isVenda = "Venda "}
            {$isLocacao = "Aluguel "}
            {$isBorda = ""}
            {$exibeValorPrimario = ""}
            {$exibeValorSecundario = ""}
            {if $IMOVELSHOW->idimovelsituacao == "1"}
                {$valorPrimario = $IMOVELSHOW->aluguel+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
                {if $valorPrimario != $IMOVELSHOW->aluguel}
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$IMOVELSHOW->aluguel}
                {else}
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "&nbsp;"}              
                {/if}  
                {$valorSecundario = ""}
                {$exibeValorSecundario = "d-none"}
                {$valorPrincipalTitulo = "Aluguel"}
                {if $valorPrimario == 0}
                    {$valorPrimario = 0.01}
                {/if}  
                {$barra1 = $IMOVELSHOW->aluguel/$valorPrimario*100}
                {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
                {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
                {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100}
                {if $IMOVELSHOW->exibealuguel == false }
                    {$exibeValorPrimario = "d-none"}
                {/if}
                {if $IMOVELSHOW->exibevalorvenda == false }
                    {$exibeValorSecundario = "d-none"}
                {/if}                
            {elseif $IMOVELSHOW->idimovelsituacao == "3"}
                {$valorPrimario = $IMOVELSHOW->venda+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
                {if $valorPrimario != $IMOVELSHOW->venda}          
                    {$valorPrimario2 = $IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}
                    {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}  
                    {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}              
                {else}  
                    {$valorPrimario2 = "&nbsp;"}              
                {/if}  
                {$valorPrimario1 = $IMOVELSHOW->venda|number_format:2:",":"."}
                {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                {$valorSecundario = ""}
                {$exibeValorSecundario = "d-none"}
                {$valorPrincipalTitulo = "Venda"}
                {if $valorPrimario == 0}
                    {$valorPrimario = 0.01}
                {/if}  
                {$barra1 = $IMOVELSHOW->venda/$valorPrimario*100}
                {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
                {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
                {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100} 
                {if $IMOVELSHOW->exibealuguel == false }
                    {$exibeValorSecundario = "d-none"}                
                {/if}
                {if $IMOVELSHOW->exibevalorvenda == false }
                    {$exibeValorPrimario = "d-none"}
                {/if}                
            {elseif $IMOVELSHOW->idimovelsituacao == "5"}
                {$valorPrimario = $IMOVELSHOW->aluguel+$IMOVELSHOW->iptu+$IMOVELSHOW->condominio+$IMOVELSHOW->outrataxavalor}            
                {if $valorPrimario != $IMOVELSHOW->aluguel}            
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$IMOVELSHOW->aluguel}
                {else}  
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "&nbsp;"}              
                {/if}  
                {$valorSecundario = $IMOVELSHOW->venda|number_format:2:",":"."}
                {$valorSecundario = $isVenda|cat:$cifrao|cat:$valorSecundario}
                {$valorPrincipalTitulo = "Aluguel"}
                {if $valorPrimario == 0}
                    {$valorPrimario = 0.01}
                {/if}  
                {$barra1 = $IMOVELSHOW->aluguel/$valorPrimario*100}
                {$barra2 = $IMOVELSHOW->iptu/$valorPrimario*100}
                {$barra3 = $IMOVELSHOW->condominio/$valorPrimario*100}
                {$barra4 = $IMOVELSHOW->outrataxavalor/$valorPrimario*100}          
                {if $IMOVELSHOW->exibealuguel == false }
                    {$exibeValorPrimario = "d-none"}
                {/if}
                {if $IMOVELSHOW->exibevalorvenda == false }
                    {$exibeValorSecundario = "d-none"}
                {/if}
            {/if}
            {if $valorPrimario == 0.01}
                {$valorPrimario1 = $IMOVELSHOW->labelnovalvalues}
                {if $valorPrimario1|trim == ""}
                    {$valorPrimario1 = "A Consultar"}
                {/if}
                {$valorSecundario = ""}
                {$exibeValorSecundario = "d-none"}
            {/if}
            <span class="listing-price {$exibeValorPrimario}">{$valorPrimario1}<small>{$valorPrimario2}</small></span>
            <span class="text-white font-mini px-2 rounded product-status ms-auto xs-m-0 py-1 bg-primary {$exibeValorSecundario}">{$valorSecundario}</span>
        </div>
        <div class="col-12">
            <div class="progress mb-3 {$exibeValorPrimario}" style="height:5px; ">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {$barra1}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-success" role="progressbar" style="width: {$barra2}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-info" role="progressbar" style="width: {$barra3}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                {if $IMOVELSHOW->outrataxa|trim != ""}
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {$barra4}%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                {/if}
            </div>
            <style>
                div.summary .idPrincipal:before {
                    color: var(--theme-primary-color);
                }
                div.summary .idIptu:before {
                    --bs-text-opacity: 1;
                    color: rgba(var(--bs-success-rgb), var(--bs-text-opacity)) !important;
                }
                div.summary .idCondominio:before {
                    --bs-text-opacity: 1;
                    color: rgba(var(--bs-info-rgb), var(--bs-text-opacity)) !important;
                }
                div.summary .idOutras:before {
                    --bs-text-opacity: 1;
                    color: rgba(var(--bs-warning-rgb), var(--bs-text-opacity)) !important;
                }
            </style>
            <div class="product-offers mt-2">
                <ul class="product-offers-list">
                    <li class="idPrincipal product-offer-item d-flex align-items-center"> 
                        <strong>{$valorPrincipalTitulo} </strong>
                        <div class="ms-auto {$exibeValorPrimario}">
                            {if $IMOVELSHOW->idimovelsituacao == "1" || $IMOVELSHOW->idimovelsituacao == "5"}
                                R$ {$IMOVELSHOW->aluguel|number_format:2:",":"."}
                            {else}
                                R$ {$IMOVELSHOW->venda|number_format:2:",":"."}
                            {/if}
                        </div>
                    </li>
                    <li class="idIptu product-offer-item d-flex align-items-center"> 
                        <strong>IPTU </strong> 
                        <div class="ms-auto {$exibeValorPrimario}">
                            R$ {$IMOVELSHOW->iptu|number_format:2:",":"."}
                        </div>
                    </li>
                    <li class="idCondominio product-offer-item d-flex align-items-center"> 
                        <strong>Condomínio </strong> 
                        <div class="ms-auto {$exibeValorPrimario}">
                            R$ {$IMOVELSHOW->condominio|number_format:2:",":"."}
                        </div>
                    </li>
                    {if $IMOVELSHOW->outrataxa|trim != ""}
                        <li class="idOutras product-offer-item d-flex align-items-center"> 
                            <strong>{$IMOVELSHOW->outrataxa} </strong> 
                            <div class="ms-auto {$exibeValorPrimario}">
                                R$ {$IMOVELSHOW->outrataxavalor|number_format:2:",":"."}
                            </div>
                        </li>
                    {/if}
                    {if $IMOVELSHOW->idimovelsituacao != "3"}
                        <hr class="my-2">
                        <li class="product-offer-item d-flex align-items-center"> 
                            <strong>Total </strong> 
                            <div class="ms-auto {$exibeValorPrimario}">
                                {$valorPrimario1}
                            </div>
                        </li>
                    {/if}
                </ul>
            </div>
            <ul class="quick-meta mt-4">
                <li class="compare-2 bg-light" data-compare-imovel="{$IMOVELSHOW->idimovel}"><a href="#" title="Adicionar para comparação" class="text-dark"><i class="flaticon-transfer flat-mini"></i></a></li>
                <li class="favorite-2 bg-light" data-favorite-imovel="{$IMOVELSHOW->idimovel}"><a href="#" title="Adicionar aos Favoritos" class="text-dark"><i class="flaticon-like-1 flat-mini"></i></a></li>
                <li class="bg-light">
                    <input type="hidden" id="url_copy" value="{$URLATUAL}">                
                    <a href="#" title="Compartilhar nas redes sociais" class="text-dark" id="jobOverviewShareDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                        <i class="flaticon-share flat-mini"></i>
                    </a>
                    <div class="dropdown-menu border" aria-labelledby="jobOverviewShareDropdown" role="button" style="background-color:white">
                        <a class="dropdown-item dz-dropzone text-dark" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://{$URLATUAL}%2F&amp;src=sdkpreparse')">
                            <i class="fa-brands fa-facebook fa-lg"></i> Facebook
                        </a>
                        <a class="dropdown-item dz-dropzone text-dark" onclick="window.open('https://api.whatsapp.com/send?text={$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf}) https://{$URLATUAL}')">
                            <i class="fa-brands fa-whatsapp fa-lg"></i> Whatsapp
                        </a>
                        <a class="dropdown-item dz-dropzone text-dark" onclick="js_AbreTwitter()">
                            <i class="fa-brands fa-twitter fa-lg"></i> Twitter
                        </a>
                        <a class="dropdown-item dz-dropzone text-dark" id="buttonShare" role="button" aria-expanded="false">
                            <i class="fa-solid fa-copy fa-lg"></i> Copiar URL
                        </a>
                    </div>
                </li>
                <!--
                <li class="compare-2 bg-light" data-compare-imovel="{$GRIDIMOVELSHOW->idimovel}"><a href="#" title="Print Data" class="text-dark"><i class="flaticon-printer flat-mini"></i></a></li>
                <li class="favorite-2 bg-light" data-favorite-imovel="{$GRIDIMOVELSHOW->idimovel}"><a href="#" title="Download PDF" class="text-dark"><i class="fas fa-download flat-mini"></i></a></li>
                -->
                {if $IMOVELSHOW->proposta == true}
                    <li class="bg-primary w-auto">
                        <a id="abrePropostaMobile" href="#" class="px-5 text-white" data-bs-toggle="modal" data-bs-target="#propostaModal">Fazer Proposta</a>
                    </li>
                {/if}
            </ul>
            <hr>
            <div class="mt-2">
                <ul class="d-flex quantity font-fifteen">
                    {if $IMOVELSHOW->dormitorio+0 > 0}
                        <li style="padding-right:10px;" title="Dormitórios"><span style="padding-right:3px;"><i class="fa-solid fa-bed fa-lg"></i></span>{$IMOVELSHOW->dormitorio+0}</li>
                    {/if}
                    {if $IMOVELSHOW->banheiro+0 > 0}
                        <li style="padding-right:10px;" title="Banheiros"><span style="padding-right:3px;"><i class="fa-solid fa-shower fa-lg"></i></span>{$IMOVELSHOW->banheiro+0}</li>                
                    {/if}
                    {if $IMOVELSHOW->vagagaragem+0 > 0}
                        <li style="padding-right:10px;" title="Vagas"><span style="padding-right:3px;"><i class="fa-solid fa-car fa-lg"></i></span>{$IMOVELSHOW->vagagaragem+0}</li>                
                    {/if}
                    {if $IMOVELSHOW->area+0 > 0}
                        <li style="padding-right:10px;" title="Área"><span style="padding-right:3px;"><i class="fa-solid fa-vector-square fa-lg"></i></span>{$IMOVELSHOW->area+0}
                        {if $IMOVELSHOW->perimetro == "U"}
                            m²
                        {else}
                            hectare(s)
                        {/if}
                        </li>                
                    {/if}
                    <li title=""><span></span>&nbsp;</li>                
                </ul>
            </div>
            <hr>            
        </div>
    </div>
    {if $IMOVELSHOW->caracteristicas|trim != ""}    
        <div class="row row-cols-1">
            <div class="col">
                <h5 class="mb-3">Sobre o imóvel</h5>
                <p>{$IMOVELSHOW->caracteristicas|nl2br}</p>
            </div>
        </div>
    {/if}    
</div>
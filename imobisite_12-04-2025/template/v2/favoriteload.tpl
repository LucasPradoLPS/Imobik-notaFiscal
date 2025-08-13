{if $NUMREGISTROS == 0}
    <div class="container content-space-b-2">
        <div class="text-center" style="padding-top: 2.5rem !important;padding-bottom: 2.5rem !important;background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
            <div class="mb-5">
                <h2>Ops...não achamos nada por aqui.</h2>
                <p>Nenhum imóvel adicionado como favorito.</p>
            </div>
        </div>
    </div>
{else}
    <div class="widget widget_recent_property">
        <h5 class="text-secondary mb-4">Imóveis:</h5>
        <ul>
            {foreach from=$IMOVELSHOW item="RECENTE"}        
                {if isset($RECENTE->imovel_images) && $RECENTE->imovel_images|trim != '{}'}
                    {$IMOVEL_IMAGES_REPLACE = $RECENTE->imovel_images|replace:'{':''}
                    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'}':''}
                    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'"':''}                    
                    {$IMOVEL_IMAGES_EXPLODE = ','|explode:$IMOVEL_IMAGES_REPLACE}
                    {$img_destaque = $URLSYSTEM|cat:$IMOVEL_IMAGES_EXPLODE[0]}
                    {$file_headers = get_headers($img_destaque)}
                    {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                        {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                    {/if}
                {else}
                    {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                {/if}
                {$nomeSeo = $RECENTE->imoveltipo|cat:" "|cat:$RECENTE->imoveldestino|cat:" "|cat:$RECENTE->cidade|cat:" "|cat:$RECENTE->bairro}
                <li class="favorite-li-{$RECENTE->idimovel} border-top py-10">
                    <i role="button" title="Remover dos favoritos" onclick="js_RemoveFavorite({$RECENTE->idimovel})" class="fas fa-trash text-primary me-2"></i>
                    <img src="{$img_destaque}" alt="" role="button" onclick="js_ImovelView({$RECENTE->idimovel},'{$nomeSeo}')">
                    <div class="thumb-body" role="button" onclick="js_ImovelView({$RECENTE->idimovel},'{$nomeSeo}')">
                        <div class="justify-content-center">
                            <h6 class="listing-title"><a href="javascript:js_ImovelView({$RECENTE->idimovel},'{$nomeSeo}')">{$RECENTE->imoveltipo|trim}</a></h6>
                            <small>{$RECENTE->bairro|lower|ucwords} - {$RECENTE->cidade|lower|ucwords}</small>
                        </div>
                        {$cifrao = "R$ "}
                        {$isVenda = "Venda<br>"}
                        {$isLocacao = "Aluguel<br>"}
                        {$isBorda = ""}
                        {$exibeValorPrimario = ""}
                        {$exibeValorSecundario = ""}
                        {if $RECENTE->idimovelsituacao == "1"}
                            {$valorPrimario = $RECENTE->aluguel+$RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                            {if $valorPrimario != $RECENTE->aluguel}
                                {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                                {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                                {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$RECENTE->aluguel}
                            {else}
                                {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                                {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                                {$valorPrimario2 = "&nbsp;"}
                            {/if}
                            {$valorSecundario = ""}
                            {$exibeValorSecundario = "d-none"}
                            {if $RECENTE->exibealuguel == false }
                                {$exibeValorPrimario = "d-none"}
                            {/if}
                        {elseif $RECENTE->idimovelsituacao == "3"}
                            {$valorPrimario = $RECENTE->venda+$RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                            {if $valorPrimario != $RECENTE->venda}
                                {$valorPrimario2 = $RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                                {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                                {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                            {else}
                                {$valorPrimario2 = "&nbsp;"}
                            {/if}
                            {$valorPrimario1 = $RECENTE->venda|number_format:2:",":"."}
                            {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                            {$valorSecundario = ""}
                            {$exibeValorSecundario = "d-none"}       
                            {if $RECENTE->exibevalorvenda == false }
                                {$exibeValorPrimario = "d-none"}
                            {/if}
                        {elseif $RECENTE->idimovelsituacao == "5"}
                            {if !isset($SITUACAOIMV)}
                                {$SITUACAOIMV = "1,5"}
                            {/if}
                            {if $SITUACAOIMV == "1,5"}
                                {$valorPrimario = $RECENTE->aluguel+$RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                                {if $valorPrimario != $RECENTE->aluguel}
                                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                                    {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                                    {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$RECENTE->aluguel}
                                {else}
                                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                                    {$valorPrimario2 = "&nbsp;"}
                                {/if}
                                {$valorSecundario = $RECENTE->venda|number_format:2:",":"."}
                                {$valorSecundario = $isVenda|cat:$cifrao|cat:$valorSecundario}
                                {if $RECENTE->exibealuguel == false }
                                    {$exibeValorPrimario = "d-none"}
                                {/if}
                                {if $RECENTE->exibevalorvenda == false }
                                    {$exibeValorSecundario = "d-none"}
                                {/if}
                            {else}
                                {$valorPrimario = $RECENTE->venda+$RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                                {if $valorPrimario != $RECENTE->venda}
                                    {$valorPrimario2 = $RECENTE->iptu+$RECENTE->condominio+$RECENTE->outrataxavalor}
                                    {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                                    {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                                {else}
                                    {$valorPrimario2 = "&nbsp;"}
                                {/if}
                                {$valorPrimario1 = $RECENTE->venda|number_format:2:",":"."}
                                {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                                {$valorSecundario = $RECENTE->aluguel|number_format:2:",":"."}
                                {$valorSecundario = $isLocacao|cat:$cifrao|cat:$valorSecundario}
                                {if $RECENTE->exibealuguel == false }
                                    {$exibeValorSecundario = "d-none"}
                                {/if}
                                {if $RECENTE->exibevalorvenda == false }
                                    {$exibeValorPrimario = "d-none"}
                                {/if}
                            {/if}
                            {$isBorda = "border border-2 rounded"}
                        {/if}
                        {if $valorPrimario == 0}
                            {$valorPrimario1 = $RECENTE->labelnovalvalues}
                            {if $valorPrimario1|trim == ""}
                                {$valorPrimario1 = "A Consultar"}
                            {/if}
                            {$valorSecundario = ""}
                            {$exibeValorSecundario = "d-none"}
                        {/if}                        

                        <span class="listing-price {$exibeValorPrimario}">
                            {$valorPrimario1}
                        </span>

                        <ul class="d-flex quantity font-fifteen">
                            {if $RECENTE->dormitorio+0 > 0}
                                <li style="padding-right:10px;" title="Dormitórios"><span><i class="fa-solid fa-bed"></i></span>{$RECENTE->dormitorio+0}</li>
                            {/if}
                            {if $RECENTE->banheiro+0 > 0}
                                <li style="padding-right:10px;" title="Banheiros"><span><i class="fa-solid fa-shower"></i></span>{$RECENTE->banheiro+0}</li>                
                            {/if}
                            {if $RECENTE->vagagaragem+0 > 0}
                                <li style="padding-right:10px;" title="Vagas"><span><i class="fa-solid fa-car"></i></span>{$RECENTE->vagagaragem+0}</li>                
                            {/if}
                            <li style="padding-right:10px;" title="">&nbsp;</li>                                            
                        </ul>
                    </div>
                </li>
            {/foreach}            
        </ul>
    </div>
{/if}

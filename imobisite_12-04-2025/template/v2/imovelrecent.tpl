<div class="widget widget_recent_property">
    <h5 class="text-secondary mb-4">Adicionados recentemente:</h5>
    <ul>
        {foreach from=$IMOVELRECENTE item="RECENTE"}        
            {if isset($RECENTE->imovel_images) && $RECENTE->imovel_images|trim != '{}'}
                {$IMOVEL_IMAGES_REPLACE = $RECENTE->imovel_images|replace:'{':''}
                {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'}':''}
                {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'"':''}
                {$IMOVEL_IMAGES_EXPLODE = ','|explode:$IMOVEL_IMAGES_REPLACE}
                {$img_destaque = $URLSYSTEM|cat:$IMOVEL_IMAGES_EXPLODE[0]}
            {else}
                {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
            {/if}
            {$nomeSeo = $RECENTE->imoveltipo|cat:" "|cat:$RECENTE->imoveldestino|cat:" "|cat:$RECENTE->cidade|cat:" "|cat:$RECENTE->bairro}
            {$file_headers = get_headers($img_destaque)}
            {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
            {/if}
            <li role="button" onclick="js_ImovelView({$RECENTE->idimovel},'{$nomeSeo}')">
                <img src="{$img_destaque}" alt="">
                <div class="thumb-body">
                    <div class="d-flex justify-content-center">
                        <h6 class="listing-title"><a>{$RECENTE->imoveltipo|trim}</a></h6>
                        <small>&nbsp;&nbsp; ({$RECENTE->bairro|lower|ucwords} - {$RECENTE->cidade|lower|ucwords})</small>
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
                    </ul>
                </div>
            </li>
        {/foreach}            
    </ul>
</div>

{if $NUMREGISTROS == 0}
    <div class="container content-space-b-2">
        <div class="text-center" style="padding-top: 2.5rem !important;padding-bottom: 2.5rem !important;background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
            <div class="mb-5">
                <h2>Ops...não achamos nada por aqui.</h2>
                <p>Nenhum imóvel adicionado para comparação.</p>
            </div>
        </div>
    </div>
{else}
    <table class="table table-striped compare-list-properties w-100">
        <tr align="center">
            <th></th>
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}
                {if isset($GRIDIMOVELSHOW->imovel_images) && $GRIDIMOVELSHOW->imovel_images|trim != '{}'}
                    {$IMOVEL_IMAGES_REPLACE = $GRIDIMOVELSHOW->imovel_images|replace:'{':''}
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
                {$cifrao = "R$ "}
                {$isVenda = "Venda<br>"}
                {$isLocacao = "Aluguel<br>"}
                {$isBorda = ""}
                {$exibeValorPrimario = ""}
                {$exibeValorSecundario = ""}
                {if $GRIDIMOVELSHOW->idimovelsituacao == "1"}
                    {$valorPrimario = $GRIDIMOVELSHOW->aluguel+$GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                    {if $valorPrimario != $GRIDIMOVELSHOW->aluguel}
                        {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                        {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                        {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$GRIDIMOVELSHOW->aluguel}
                    {else}
                        {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                        {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                        {$valorPrimario2 = "&nbsp;"}
                    {/if}
                    {$valorSecundario = ""}
                    {$exibeValorSecundario = "d-none"}
                    {if $GRIDIMOVELSHOW->exibealuguel == false }
                        {$exibeValorPrimario = "d-none"}
                    {/if}
                {elseif $GRIDIMOVELSHOW->idimovelsituacao == "3"}
                    {$valorPrimario = $GRIDIMOVELSHOW->venda+$GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                    {if $valorPrimario != $GRIDIMOVELSHOW->venda}
                        {$valorPrimario2 = $GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                        {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                        {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                    {else}
                        {$valorPrimario2 = "&nbsp;"}
                    {/if}
                    {$valorPrimario1 = $GRIDIMOVELSHOW->venda|number_format:2:",":"."}
                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                    {$valorSecundario = ""}
                    {$exibeValorSecundario = "d-none"}     
                    {if $GRIDIMOVELSHOW->exibevalorvenda == false }
                        {$exibeValorPrimario = "d-none"}
                    {/if}
                {elseif $GRIDIMOVELSHOW->idimovelsituacao == "5"}
                    {if !isset($SITUACAOIMV)}
                        {$SITUACAOIMV = "1,5"}
                    {/if}
                    {if $SITUACAOIMV == "1,5"}
                        {$valorPrimario = $GRIDIMOVELSHOW->aluguel+$GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                        {if $valorPrimario != $GRIDIMOVELSHOW->aluguel}
                            {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                            {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                            {$valorPrimario2 = "Aluguel "|cat:$cifrao|cat:$GRIDIMOVELSHOW->aluguel}
                        {else}
                            {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                            {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                            {$valorPrimario2 = "&nbsp;"}
                        {/if}
                        {$valorSecundario = $GRIDIMOVELSHOW->venda|number_format:2:",":"."}
                        {$valorSecundario = $isVenda|cat:$cifrao|cat:$valorSecundario}
                        {if $GRIDIMOVELSHOW->exibealuguel == false }
                            {$exibeValorPrimario = "d-none"}
                        {/if}
                        {if $GRIDIMOVELSHOW->exibevalorvenda == false }
                            {$exibeValorSecundario = "d-none"}
                        {/if}
                    {else}
                        {$valorPrimario = $GRIDIMOVELSHOW->venda+$GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                        {if $valorPrimario != $GRIDIMOVELSHOW->venda}
                            {$valorPrimario2 = $GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
                            {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                            {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                        {else}
                            {$valorPrimario2 = "&nbsp;"}
                        {/if}
                        {$valorPrimario1 = $GRIDIMOVELSHOW->venda|number_format:2:",":"."}
                        {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                        {$valorSecundario = $GRIDIMOVELSHOW->aluguel|number_format:2:",":"."}
                        {$valorSecundario = $isLocacao|cat:$cifrao|cat:$valorSecundario}
                        {if $GRIDIMOVELSHOW->exibealuguel == false }
                            {$exibeValorSecundario = "d-none"}
                        {/if}
                        {if $GRIDIMOVELSHOW->exibevalorvenda == false }
                            {$exibeValorPrimario = "d-none"}
                        {/if}
                    {/if}
                    {$isBorda = "border border-2 rounded"}
                {/if}
                {if $valorPrimario == 0}
                    {$valorPrimario1 = $GRIDIMOVELSHOW->labelnovalvalues}
                    {if $valorPrimario1|trim == ""}
                        {$valorPrimario1 = "A Consultar"}
                    {/if}
                    {$valorSecundario = ""}
                    {$exibeValorSecundario = "d-none"}
                {/if}
                {$nomeSeo = $GRIDIMOVELSHOW->imoveltipo|cat:" "|cat:$GRIDIMOVELSHOW->imoveldestino|cat:" "|cat:$GRIDIMOVELSHOW->cidade|cat:" "|cat:$GRIDIMOVELSHOW->bairro}
                <th class="coluna-compare-{$xx}">
                    <div class="clip-item" style="width:250px">
                        <div class="item card-transition" style="min-height: 12rem; background-image: url('{$img_destaque}');background-size: cover;background-repeat: no-repeat;background-position: center center;" >
                            <i role="button" title="Remover da comparação" onclick="js_RemoveCompare({$GRIDIMOVELSHOW->idimovel},{$xx})" class="fas fa-trash text-primary fa-xl" style="position:relative;opacity:1;left:108px;top:0px"></i>
                        </div>
                        <div class="text-center my-4" role="button" onclick="js_ImovelView({$GRIDIMOVELSHOW->idimovel},'{$nomeSeo}')">
                            <div class="text-secondary h5">
                                {$GRIDIMOVELSHOW->imoveltipo}
                            </div>
                            <div><small>{$GRIDIMOVELSHOW->bairro|lower|ucwords} - {$GRIDIMOVELSHOW->cidade|lower|ucwords} ({$GRIDIMOVELSHOW->uf})</small></div>
                            <span class="text-primary {$exibeValorPrimario}">{$valorPrimario1}</span> 
                        </div>
                    </div>
                </th>
            {/foreach}
        </tr>
        <tr>    
            <td>Área</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                <td class="coluna-compare-{$xx}">
                    {if $GRIDIMOVELSHOW->area+0 > 0}
                        {$GRIDIMOVELSHOW->area+0}
                        {if $GRIDIMOVELSHOW->perimetro == "U"}
                            m²
                        {else}
                            hectare(s)
                        {/if}
                    {/if}
                </td>
            {/foreach}
        </tr>
        <tr>    
            <td>Dormitórios</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                <td class="coluna-compare-{$xx}">        
                    {if $GRIDIMOVELSHOW->dormitorio+0 > 0}
                        {$GRIDIMOVELSHOW->dormitorio+0}
                    {/if}
                </td>
            {/foreach}
        </tr>
        <tr>    
            <td>Banheiros</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                <td class="coluna-compare-{$xx}">        
                    {if $GRIDIMOVELSHOW->banheiro+0 > 0}
                        {$GRIDIMOVELSHOW->banheiro+0}
                    {/if}
                </td>
            {/foreach}
        </tr>
        <tr>    
            <td>Vagas na Garagem</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                <td class="coluna-compare-{$xx}">
                    {if $GRIDIMOVELSHOW->vagagaragem+0 > 0}
                        {$GRIDIMOVELSHOW->vagagaragem+0}
                    {/if}
                </td>
            {/foreach}
        </tr>
        <tr>    
            <td>Churrasqueira</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->churrasqueira+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Closet</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->closet+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Escritório</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->escritorio+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Lareira</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->lareira+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Lavanderia</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->lavanderia+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Pátio</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->patio+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Piscina</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->piscina+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Quarto de casal</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->quartocasal+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Quarto de hóspede</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->quartohospede+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Quarto de solteiro</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->quartosolteiro+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Sacada</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->sacada+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Sala de estar</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->salaestar+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Sala de jantar</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->salajantar+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Suíte</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->suite+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
        <tr>    
            <td>Varanda</td>    
            {foreach from=$IMOVELSHOW key=xx item="GRIDIMOVELSHOW"}    
                {if $GRIDIMOVELSHOW->varanda+0 > 0}
                    <td class="available coluna-compare-{$xx}"></td>
                {else}
                    <td class="not-available coluna-compare-{$xx}"></td>
                {/if}
            {/foreach}
        </tr>
    </table>
{/if}

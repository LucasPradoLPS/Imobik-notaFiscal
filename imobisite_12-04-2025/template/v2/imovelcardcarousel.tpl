{if isset($GRIDIMOVELSHOW->imovel_images) && $GRIDIMOVELSHOW->imovel_images|trim != '{}'}
    {$IMOVEL_IMAGES_REPLACE = $GRIDIMOVELSHOW->imovel_images|replace:'{':''}
    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'}':''}
    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'"':''}
    {$IMOVEL_IMAGES_EXPLODE = ','|explode:$IMOVEL_IMAGES_REPLACE}
    {$tem_img = true}    
{else}
    {$IMOVEL_IMAGES_EXPLODE = []}
    {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
    {$tem_img = false}
{/if}
{$nomeSeo = $GRIDIMOVELSHOW->imoveltipo|cat:" "|cat:$GRIDIMOVELSHOW->imoveldestino|cat:" "|cat:$GRIDIMOVELSHOW->cidade|cat:" "|cat:$GRIDIMOVELSHOW->bairro}
<div class="property-grid-5 property-block rounded border transation-this bg-white hover-shadow">
    <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom">
        {if $GRIDIMOVELSHOW->etiquetanome|trim != ""}
            <a href="#" class="listing-ctg text-white {$ETIQUETAMODELO[$GRIDIMOVELSHOW->etiquetamodelo]}">
                <span>{$GRIDIMOVELSHOW->etiquetanome}</span>
            </a>
        {/if}
        <div class="owl-carousel single-carusel dot-disable nav-between-in">
            {if $tem_img == true}
                {$XX = 0}
                {foreach from=$IMOVEL_IMAGES_EXPLODE item="IMAGEM_ITEM"}
                    {$filename = $URLSYSTEM|cat:$IMOVEL_IMAGES_EXPLODE[$XX]}
                    {$file_headers = get_headers($filename)}
                    {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                        {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
                    {/if}
                    <div class="item card-transition" style="min-height: 16rem; background-image: url('{$filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;" ></div>
                    {$XX = $XX+1}
                {/foreach}
            {else}
                <div class="item card-transition" style="min-height: 16rem; background-image: url('{$filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;" ></div>
            {/if}
        </div>
        {if $GRIDIMOVELSHOW->exibelogradouro == true}
            <a style="background-color:rgba(230,230,255,0.7);position:absolute;bottom:15px;top:inherit" href="#" class="listing-ctg text-black">
                <i style="color: var(--theme-primary-color);" class="fa-solid fa-location-arrow fa-xl"></i><span>&nbsp;{$GRIDIMOVELSHOW->endereco}</span>
            </a>            
        {/if}
    </div>
    <div class="property_text p-3">
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
            {if $SITUACAOIMV == "1,5" || ( isset($arquivo) && $arquivo == "indexgridrent.tpl") }
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
        <span role="button" onclick="js_ImovelView({$GRIDIMOVELSHOW->idimovel},'{$nomeSeo}')">
            <span class="{$exibeValorSecundario}" style="float:right;color:#ABB2B9;border-radius:5px;border:1px solid #ABB2B9;padding: 0 10px 0 10px;text-align:center">{$valorSecundario}</span>
            <h5 class="listing-title"><a href="javascript:void(0)">{$GRIDIMOVELSHOW->imoveltipo}</a></h5>
            <span class="listing-location"><i style="color: var(--theme-primary-color);" class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;{$GRIDIMOVELSHOW->bairro|lower|ucwords} - {$GRIDIMOVELSHOW->cidade|lower|ucwords} ({$GRIDIMOVELSHOW->uf})</span>
            <ul class="d-flex quantity font-fifteen">
                {if $GRIDIMOVELSHOW->dormitorio+0 > 0}
                    <li style="padding-right:10px;" title="Dormitórios"><span><i class="fa-solid fa-bed fa-xl"></i></span>{$GRIDIMOVELSHOW->dormitorio+0}</li>
                {/if}
                {if $GRIDIMOVELSHOW->banheiro+0 > 0}
                    <li style="padding-right:10px;" title="Banheiros"><span><i class="fa-solid fa-shower fa-xl"></i></span>{$GRIDIMOVELSHOW->banheiro+0}</li>                
                {/if}
                {if $GRIDIMOVELSHOW->vagagaragem+0 > 0}
                    <li style="padding-right:10px;" title="Vagas"><span><i class="fa-solid fa-car fa-xl"></i></span>{$GRIDIMOVELSHOW->vagagaragem+0}</li>                
                {/if}
                {if $GRIDIMOVELSHOW->area+0 > 0}
                    <li style="padding-right:10px;" title="Área"><span><i class="fa-solid fa-vector-square fa-xl"></i></span>{$GRIDIMOVELSHOW->area+0}
                    {if $GRIDIMOVELSHOW->perimetro == "U"}
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
                    <li><span>Finalidade</span><div class="text-dark">{$GRIDIMOVELSHOW->imoveldestino}</div></li>
                    <li><span>Código</span><div class="text-dark">{$GRIDIMOVELSHOW->idimovel}</div></li>
                    <li><span>DesdConstruçãoe</span><div class="text-dark">{$GRIDIMOVELSHOW->imovelmaterial}</div></li>
                </ul>
            </div>
            <style>
            .listing-price1{
                padding: 6px;
                font-size: 15px;
                border-radius: 20px;
            }
            .listing-price2{
                padding: 6px 15px;
                font-size: 20px;
                font-weight: 700;
                background-color: var(--theme-light-color);
                color: var(--theme-primary-color);
                border-radius: 20px;
            }
            </style>
            <br>
            {if $exibeValorPrimario != ""}
                <div class="mb-2">
                    <span class="">&nbsp;</span>
                    <br>
                    <span class="">&nbsp;</span>
                </div>
            {else}
                <div class="mb-2">
                    <span class="listing-price1">&nbsp;&nbsp;{$valorPrimario2}</span>
                    <br>
                    <span class="listing-price2">{$valorPrimario1}</span>
                </div>
            {/if}
        </span>
        <ul class="position-absolute quick-meta">
            <li class="compare-1" data-compare-imovel="{$GRIDIMOVELSHOW->idimovel}"><a href="#" title="Adicionar para comparação"><i class="flaticon-transfer flat-mini"></i></a></li>
            <li class="favorite-1" data-favorite-imovel="{$GRIDIMOVELSHOW->idimovel}"><a href="#" title="Adicionar aos Favoritos"><i class="flaticon-like-1 flat-mini"></i></a></li>
            <li class="md-mx-none"><a class="quick-view" href="{$GRIDIMOVELSHOW->idimovel}" title="Detalhes do Imóvel"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
        </ul>
    </div>
</div>

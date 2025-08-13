<div class="col mb-3">
  {if isset($GRIDIMOVELSHOW->imovel_images) && $GRIDIMOVELSHOW->imovel_images|trim != '{}'}
    {$IMOVEL_IMAGES_REPLACE = $GRIDIMOVELSHOW->imovel_images|replace:'{':''}
    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'}':''}
    {$IMOVEL_IMAGES_REPLACE = $IMOVEL_IMAGES_REPLACE|replace:'"':''}
    {$IMOVEL_IMAGES_EXPLODE = ','|explode:$IMOVEL_IMAGES_REPLACE}
    {$img_array = '#'|explode:$IMOVEL_IMAGES_EXPLODE[0]}
    {$img_destaque = $URLSYSTEM|cat:$img_array[0]}
    {$legenda_destaque = $img_array[1]}
    {$tem_img = true}
  {else}
    {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
    {$legenda_destaque = ''}
    {$tem_img = false}
  {/if}
  {$nomeSeo = $GRIDIMOVELSHOW->imoveltipo|cat:" "|cat:$GRIDIMOVELSHOW->imoveldestino|cat:" "|cat:$GRIDIMOVELSHOW->cidade|cat:" "|cat:$GRIDIMOVELSHOW->bairro}
  {if $FILEATUAL|trim == "index.php"}
    <a class="card card-stretched-vertical card-transition shadow-none bg-img-center" href="javascript:js_ImovelView({$GRIDIMOVELSHOW->idimovel},'{$nomeSeo}')" style="background-image: url({$img_destaque}); min-height: 15rem;">
    {$displayCard = "d-none"}
  {else}
    <a class="card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$img_destaque}" style="background-image: url({$img_destaque}); min-height: 15rem;" data-fancybox="propertyGridGalleryL{$GRIDIMOVELSHOW->idimovel}" data-caption="{$legenda_destaque}">
    {$displayCard = ""}
  {/if}
    <div class="card-body">
      <div class="mb-1">
        {if $GRIDIMOVELSHOW->etiquetanome|trim != ""}
          <span class="badge text-white {$ETIQUETAMODELO[$GRIDIMOVELSHOW->etiquetamodelo]}">
            {$GRIDIMOVELSHOW->etiquetanome}
          </span>
        {/if}
      </div>
    </div>
    <div class="card-pinned-bottom-end">
      <span class="btn btn-light btn-xs btn-icon {$displayCard}">
        <i class="bi-images"></i>
      </span>
    </div>
    <img style="display:none" class="transation" src="{$img_destaque}" alt="">    
  </a>
  {$XX = 0}
  {if $tem_img == true}
    {foreach from=$IMOVEL_IMAGES_EXPLODE item="IMAGEM_ITEM"}
      {if $XX>0}
        {$img_array = '#'|explode:$IMOVEL_IMAGES_EXPLODE[$XX]}      
        <a class="d-none" href="{$URLSYSTEM}{$img_array[0]}" data-fancybox="propertyGridGalleryL{$GRIDIMOVELSHOW->idimovel}" data-caption="{$img_array[1]}">
          <img style="display:none" class="transation" src="{$URLSYSTEM}{$img_array[0]}" alt="">            
        </a>
      {/if}
      {$XX = $XX+1}
    {/foreach}
  {/if}
  <a class="card card-flush shadow-none" href="javascript:js_ImovelView({$GRIDIMOVELSHOW->idimovel},'{$nomeSeo}')">
    <div class="card-body">
      {$cifrao = "R$ "}
      {$isVenda = "Venda<br>"}
      {$isLocacao = "Locação<br>"}
      {$isBorda = ""}
      {$exibeValorPrimario = ""}
      {$exibeValorSecundario = ""}
      {if $GRIDIMOVELSHOW->idimovelsituacao == "1"}
        {$valorPrimario = $GRIDIMOVELSHOW->aluguel+$GRIDIMOVELSHOW->iptu+$GRIDIMOVELSHOW->condominio+$GRIDIMOVELSHOW->outrataxavalor}
        {if $valorPrimario != $GRIDIMOVELSHOW->aluguel}
          {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
          {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
          {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$GRIDIMOVELSHOW->aluguel}
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
            {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$GRIDIMOVELSHOW->aluguel}
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

      <div class="row align-items-center">
        <div class="col">
          <span class="text-body">{$GRIDIMOVELSHOW->bairro|lower|ucwords} - {$GRIDIMOVELSHOW->cidade|lower|ucwords} ({$GRIDIMOVELSHOW->uf})</span><br>
          <span class="text-dark small">{$GRIDIMOVELSHOW->imoveldestino}</span>
        </div>
        <div class="col-auto text-muted {$isBorda}" style="text-align:center">
          <span class="text-body small {$exibeValorSecundario}">{$valorSecundario}</span>
        </div>
      </div>
      <div class="row align-items-center mb-1">
        <div class="col">
          <h4 class="card-title">{$GRIDIMOVELSHOW->imoveltipo}</h4>
          <span class="text-body small">Código {$GRIDIMOVELSHOW->idimovel}</span>
        </div>
        <div class="col-auto text-end {$exibeValorPrimario}">
          <h4 class="card-title text-primary">{$valorPrimario1}</h4>
          <span class="text-body small">{$valorPrimario2}</span>
        </div>
      </div>
      <ul class="list-inline list-separator text-body">
        {if $GRIDIMOVELSHOW->dormitorio+0 > 0}
          <li class="list-inline-item">
            <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 512"><path d="M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z"/></svg>
            </span>
            {$GRIDIMOVELSHOW->dormitorio+0}
          </li>
        {/if}
        {if $GRIDIMOVELSHOW->banheiro+0 > 0}
          <li class="list-inline-item">
            <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512"><path d="M304,320a16,16,0,1,0,16,16A16,16,0,0,0,304,320Zm32-96a16,16,0,1,0,16,16A16,16,0,0,0,336,224Zm32,64a16,16,0,1,0-16-16A16,16,0,0,0,368,288Zm-32,32a16,16,0,1,0-16-16A16,16,0,0,0,336,320Zm-32-64a16,16,0,1,0,16,16A16,16,0,0,0,304,256Zm128-32a16,16,0,1,0-16-16A16,16,0,0,0,432,224Zm-48,16a16,16,0,1,0,16-16A16,16,0,0,0,384,240Zm-16-48a16,16,0,1,0,16,16A16,16,0,0,0,368,192Zm96,32a16,16,0,1,0,16,16A16,16,0,0,0,464,224Zm32-32a16,16,0,1,0,16,16A16,16,0,0,0,496,192Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,432,256Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,400,288Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,336,352Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,304,384Zm64-64a16,16,0,1,0,16,16A16,16,0,0,0,368,320Zm21.65-218.35-11.3-11.31a16,16,0,0,0-22.63,0L350.05,96A111.19,111.19,0,0,0,272,64c-19.24,0-37.08,5.3-52.9,13.85l-10-10A121.72,121.72,0,0,0,123.44,32C55.49,31.5,0,92.91,0,160.85V464a16,16,0,0,0,16,16H48a16,16,0,0,0,16-16V158.4c0-30.15,21-58.2,51-61.93a58.38,58.38,0,0,1,48.93,16.67l10,10C165.3,138.92,160,156.76,160,176a111.23,111.23,0,0,0,32,78.05l-5.66,5.67a16,16,0,0,0,0,22.62l11.3,11.31a16,16,0,0,0,22.63,0L389.65,124.28A16,16,0,0,0,389.65,101.65Z"/></svg>
            </span>
            {$GRIDIMOVELSHOW->banheiro+0}
          </li>
        {/if}
        {if $GRIDIMOVELSHOW->vagagaragem+0 > 0}
          <li class="list-inline-item">
            <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 28 28"><path d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
            </span>
            {$GRIDIMOVELSHOW->vagagaragem+0}
          </li>
        {/if}
        {if $GRIDIMOVELSHOW->area+0 > 0}
          <li class="list-inline-item">
            <i class="bi-rulers text-muted me-1"></i>  {$GRIDIMOVELSHOW->area+0}
            {if $GRIDIMOVELSHOW->perimetro == "U"}
              m²
            {else}
              hectare(s)
            {/if}
          </li>
        {/if}
      </ul>
    </div>
  </a>
</div>


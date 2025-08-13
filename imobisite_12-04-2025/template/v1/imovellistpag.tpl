<div class="container">
  <div class="mb-5">
    <div class="row align-items-center">
      <div class="col-sm mb-3 mb-sm-0">
        <span class="d-block"><h4 class="text-secondary">Foram encontrados {$NUMREGISTROS} registro(s)</h4></span>
      </div>
      {if $NUMREGISTROS > 0}
      <div class="col-sm-auto" onclick>
        <i id="botaoGrid" class="bi bi-grid-3x2-gap-fill" style="font-size:30px;color:black;cursor:pointer;"></i>
      </div>
      <div class="col-sm-auto">
        <select class="form-select form-select-sm" name="orderBy" id="orderBy" onChange="js_BuscaGridLista('{$FILEATUAL}')">
          <option value="1" {$SELECTEDORDERBY.1}>Mais Recentes</option>
          <option value="2" {$SELECTEDORDERBY.2}>Maior Valor</option>
          <option value="3" {$SELECTEDORDERBY.3}>Menor Valor</option>
        </select>
      </div>
      {/if}
    </div>
  </div>
  <div class="w-md-75 w-lg-50"></div>
  {foreach from=$IMOVELLIST item="LIST"}
    <div class="d-grid gap-5 mb-7">
      {if isset($LIST->imovel_images) && $LIST->imovel_images|trim != '{}'}
        {$IMOVEL_IMAGES_REPLACE = $LIST->imovel_images|replace:'{':''}
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
      <div class="card card-flush card-stretched-vertical">
        <div class="row">
          <div class="col-md-4">
            <a class="card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$img_destaque}" style="background-image: url({$img_destaque}); min-height: 15rem;" data-fancybox="propertyGridGalleryL{$LIST->idimovel}" data-caption="{$legenda_destaque}">
              <div class="card-body">
                <div class="mb-1">
                {if $LIST->etiquetanome|trim != ""}
                   &nbsp;&nbsp;&nbsp;&nbsp;
                   <span class="badge text-white {$ETIQUETAMODELO[$LIST->etiquetamodelo]}">
                     {$LIST->etiquetanome}
                   </span>
                {/if}
                </div>
              </div>
              <div class="card-pinned-bottom-end">
                <span class="btn btn-light btn-xs btn-icon">
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
                  <a class="d-none" href="{$URLSYSTEM}{$img_array[0]}" data-fancybox="propertyGridGalleryL{$LIST->idimovel}" data-caption="{$img_array[1]}">
                    <img style="display:none" class="transation" src="{$URLSYSTEM}{$img_array[0]}" alt="">            
                  </a>
                {/if}
                {$XX = $XX+1}
              {/foreach}
            {/if}
          </div>
          {$nomeSeo = $LIST->imoveltipo|cat:" "|cat:$LIST->imoveldestino|cat:" "|cat:$LIST->cidade|cat:" "|cat:$LIST->bairro}
          <div class="col-md-8">
            <div class="">
              <div class="row mb-1">
                <div class="col-md-7">
                  <span class="text-body">{$LIST->bairro|lower|ucwords} - {$LIST->cidade|lower|ucwords} ({$LIST->uf})</span><br>
                  <span class="text-body small">{$LIST->imoveldestino}</span><br>
                  <span class="text-body small mb-3">{$LIST->imovelsituacao} - Código {$LIST->idimovel}</span>
                  <h3 class="card-title">
                    <a class="text-dark dz-dropzone" onclick="js_ImovelView({$LIST->idimovel},'{$nomeSeo}')">{$LIST->imoveltipo}</a>
                  </h3>
                </div>
                {$cifrao = "R$ "}
                {$isVenda = "Venda "}
                {$isLocacao = "Locação "}
                {$isBorda = ""}
                {$exibeValorPrimario = ""}
                {$exibeValorSecundario = ""}
                {if $LIST->idimovelsituacao == "1"}
                  {$valorPrimario = $LIST->aluguel+$LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                  {if $valorPrimario != $LIST->aluguel}
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$LIST->aluguel}
                  {else}
                    {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                    {$valorPrimario2 = "&nbsp;"}
                  {/if}
                  {$valorSecundario = ""}
                  {$exibeValorSecundario = "d-none"}
                  {if $LIST->exibealuguel == false }
                    {$exibeValorPrimario = "d-none"}
                  {/if}
                {elseif $LIST->idimovelsituacao == "3"}
                  {$valorPrimario = $LIST->venda+$LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                  {if $valorPrimario != $LIST->venda}
                    {$valorPrimario2 = $LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                    {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                    {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                  {else}
                    {$valorPrimario2 = "&nbsp;"}
                  {/if}
                  {$valorPrimario1 = $LIST->venda|number_format:2:",":"."}
                  {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                  {$valorSecundario = ""}
                  {$exibeValorSecundario = "d-none"}
                  {if $LIST->exibevalorvenda == false }
                    {$exibeValorPrimario = "d-none"}
                  {/if}
                {elseif $LIST->idimovelsituacao == "5"}

                  {if $SITUACAOIMV == "1,5" || ( isset($arquivo) && $arquivo == "indexgridrent.tpl")}
                    {$valorPrimario = $LIST->aluguel+$LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                    {if $valorPrimario != $LIST->aluguel}
                      {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                      {$valorPrimario1 = "Total "|cat:$cifrao|cat:$valorPrimario1}
                      {$valorPrimario2 = "Locação "|cat:$cifrao|cat:$LIST->aluguel}
                    {else}
                      {$valorPrimario1 = $valorPrimario|number_format:2:",":"."}
                      {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                      {$valorPrimario2 = "&nbsp;"}
                    {/if}
                    {$valorSecundario = $LIST->venda|number_format:2:",":"."}
                    {$valorSecundario = $isVenda|cat:$cifrao|cat:$valorSecundario}
                    {if $LIST->exibealuguel == false }
                      {$exibeValorPrimario = "d-none"}
                    {/if}
                    {if $LIST->exibevalorvenda == false }
                      {$exibeValorSecundario = "d-none"}
                    {/if}
                  {else}
                    {$valorPrimario = $LIST->venda+$LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                    {if $valorPrimario != $LIST->venda}
                      {$valorPrimario2 = $LIST->iptu+$LIST->condominio+$LIST->outrataxavalor}
                      {$valorPrimario2 = $valorPrimario2|number_format:2:",":"."}
                      {$valorPrimario2 = "Taxas Mensais "|cat:$cifrao|cat:$valorPrimario2}
                    {else}
                      {$valorPrimario2 = "&nbsp;"}
                    {/if}
                    {$valorPrimario1 = $LIST->venda|number_format:2:",":"."}
                    {$valorPrimario1 = $cifrao|cat:$valorPrimario1}
                    {$valorSecundario = $LIST->aluguel|number_format:2:",":"."}
                    {$valorSecundario = $isLocacao|cat:$cifrao|cat:$valorSecundario}
                    {if $LIST->exibealuguel == false }
                      {$exibeValorSecundario = "d-none"}
                    {/if}
                    {if $LIST->exibevalorvenda == false }
                      {$exibeValorPrimario = "d-none"}
                    {/if}
                  {/if}
                  {$isBorda = "border border-2 rounded"}
                  
                {/if}
                {if $valorPrimario == 0}
                    {$valorPrimario1 = $LIST->labelnovalvalues}
                    {if $valorPrimario1|trim == ""}
                        {$valorPrimario1 = "A Consultar"}
                    {/if}
                    {$valorSecundario = ""}
                    {$exibeValorSecundario = "d-none"}
                {/if}
                <div class="col-md-5 text-md-end">
                  <span class="text-body small {$exibeValorPrimario}">{$valorPrimario2}</span>
                  <h4 class="card-title {$exibeValorPrimario}">
                    <a href="javascript:js_ImovelView({$LIST->idimovel},'{$nomeSeo}')">{$valorPrimario1}</a>
                  </h4>
                  <div class="p-1 w-auto {$isBorda}" style="float:right">
                    <span class="text-center text-body small {$exibeValorSecundario}">{$valorSecundario}</span>
                  </div>
                </div>
              </div>
              {if isset($LIST->imovel_corretores) && $LIST->imovel_corretores|trim != '{}'}
                {$IMOVEL_CORRETORES_REPLACE = $LIST->imovel_corretores|replace:'{':''}
                {$IMOVEL_CORRETORES_REPLACE = $IMOVEL_CORRETORES_REPLACE|replace:'}':''}
                {$IMOVEL_CORRETORES_REPLACE = $IMOVEL_CORRETORES_REPLACE|replace:'"':''}
                {$IMOVEL_CORRETORES_EXPLODE = ','|explode:$IMOVEL_CORRETORES_REPLACE}
                {$tem_corretor = true}
              {else}
                {$IMOVEL_CORRETORES_EXPLODE[] = ""}
                {$tem_corretor = false}
              {/if}
              {if $IMOVEL_CORRETORES_EXPLODE|count == 1}
                {$mbottom = "mb-8"}
              {else}
                {$mbottom = "mb-2"}
              {/if}
              <ul class="list-inline list-separator text-body {$mbottom}">
                {if $LIST->dormitorio+0 > 0}             
                  <li class="list-inline-item">
                    <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 512"><path d="M176 256c44.11 0 80-35.89 80-80s-35.89-80-80-80-80 35.89-80 80 35.89 80 80 80zm352-128H304c-8.84 0-16 7.16-16 16v144H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v352c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16v-48h512v48c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V240c0-61.86-50.14-112-112-112z"/></svg>
                    </span>
                    {$LIST->dormitorio+0}
                  </li>
                {/if}
                {if $LIST->banheiro+0 > 0}                             
                  <li class="list-inline-item">
                    <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512"><path d="M304,320a16,16,0,1,0,16,16A16,16,0,0,0,304,320Zm32-96a16,16,0,1,0,16,16A16,16,0,0,0,336,224Zm32,64a16,16,0,1,0-16-16A16,16,0,0,0,368,288Zm-32,32a16,16,0,1,0-16-16A16,16,0,0,0,336,320Zm-32-64a16,16,0,1,0,16,16A16,16,0,0,0,304,256Zm128-32a16,16,0,1,0-16-16A16,16,0,0,0,432,224Zm-48,16a16,16,0,1,0,16-16A16,16,0,0,0,384,240Zm-16-48a16,16,0,1,0,16,16A16,16,0,0,0,368,192Zm96,32a16,16,0,1,0,16,16A16,16,0,0,0,464,224Zm32-32a16,16,0,1,0,16,16A16,16,0,0,0,496,192Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,432,256Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,400,288Zm-64,64a16,16,0,1,0,16,16A16,16,0,0,0,336,352Zm-32,32a16,16,0,1,0,16,16A16,16,0,0,0,304,384Zm64-64a16,16,0,1,0,16,16A16,16,0,0,0,368,320Zm21.65-218.35-11.3-11.31a16,16,0,0,0-22.63,0L350.05,96A111.19,111.19,0,0,0,272,64c-19.24,0-37.08,5.3-52.9,13.85l-10-10A121.72,121.72,0,0,0,123.44,32C55.49,31.5,0,92.91,0,160.85V464a16,16,0,0,0,16,16H48a16,16,0,0,0,16-16V158.4c0-30.15,21-58.2,51-61.93a58.38,58.38,0,0,1,48.93,16.67l10,10C165.3,138.92,160,156.76,160,176a111.23,111.23,0,0,0,32,78.05l-5.66,5.67a16,16,0,0,0,0,22.62l11.3,11.31a16,16,0,0,0,22.63,0L389.65,124.28A16,16,0,0,0,389.65,101.65Z"/></svg>
                    </span>
                    {$LIST->banheiro+0}
                  </li>
                {/if}
                {if $LIST->vagagaragem+0 > 0}                               
                  <li class="list-inline-item">
                    <span class="svg-icon svg-icon-sm svg-inline text-muted me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 28 28"><path d="M23.5 7c.276 0 .5.224.5.5v.511c0 .793-.926.989-1.616.989l-1.086-2h2.202zm-1.441 3.506c.639 1.186.946 2.252.946 3.666 0 1.37-.397 2.533-1.005 3.981v1.847c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1h-13v1c0 .552-.448 1-1 1h-1.5c-.552 0-1-.448-1-1v-1.847c-.608-1.448-1.005-2.611-1.005-3.981 0-1.414.307-2.48.946-3.666.829-1.537 1.851-3.453 2.93-5.252.828-1.382 1.262-1.707 2.278-1.889 1.532-.275 2.918-.365 4.851-.365s3.319.09 4.851.365c1.016.182 1.45.507 2.278 1.889 1.079 1.799 2.101 3.715 2.93 5.252zm-16.059 2.994c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm10 1c0-.276-.224-.5-.5-.5h-7c-.276 0-.5.224-.5.5s.224.5.5.5h7c.276 0 .5-.224.5-.5zm2.941-5.527s-.74-1.826-1.631-3.142c-.202-.298-.515-.502-.869-.566-1.511-.272-2.835-.359-4.441-.359s-2.93.087-4.441.359c-.354.063-.667.267-.869.566-.891 1.315-1.631 3.142-1.631 3.142 1.64.313 4.309.497 6.941.497s5.301-.184 6.941-.497zm2.059 4.527c0-.828-.672-1.5-1.5-1.5s-1.5.672-1.5 1.5.672 1.5 1.5 1.5 1.5-.672 1.5-1.5zm-18.298-6.5h-2.202c-.276 0-.5.224-.5.5v.511c0 .793.926.989 1.616.989l1.086-2z"/></svg>
                    </span>
                    {$LIST->vagagaragem+0}
                  </li>
                {/if}
                {if $LIST->area+0 > 0}                               
                  <li class="list-inline-item">
                    <i class="bi-rulers text-muted me-1"></i>  {$LIST->area+0} m²
                  </li>
                {/if}                  
              </ul>
              {if $tem_corretor == true}
                {$YY = 0}
                {foreach from=$IMOVEL_CORRETORES_EXPLODE item="CORRETOR_ITEM"}
                  {$IMOVEL_CORRETORES_LINHA = '#'|explode:$IMOVEL_CORRETORES_EXPLODE[$YY]}
                  <div class="mb-2">
                    <div class="row align-items-center">
                      <div class="col-lg mb-2 mb-lg-0">
                         <div class="d-flex">
                          <div class="flex-shrink-0">
                            {$filename = $URLSYSTEM|cat:"app/images/photos/"|cat:$IMOVEL_CORRETORES_LINHA[2]|cat:".jpg"}
                            {$file_headers = get_headers($filename)}
                            {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                              <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$URLSYSTEM}{$FILENOIMAGE}" target="_blank" style="background-image: url({$URLSYSTEM}{$FILENOIMAGE}); width:50px; min-height: 3rem;"></a>
                            {else}
                              <a class="avatar-circle card card-stretched-vertical card-transition shadow-none bg-img-center" href="{$filename}" target="_blank" style="background-image: url({$filename}); width:50px; min-height: 3rem;"></a>
                            {/if}
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <a class="card-link dz-dropzone" onclick="js_CorretorView({$IMOVEL_CORRETORES_LINHA[0]},'{$IMOVEL_CORRETORES_LINHA[1]}')">{$IMOVEL_CORRETORES_LINHA[1]|lower|ucwords}</a>
                            <p class="card-text small mb-0">Corretor</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-auto">
                        <div class="d-flex small gap-2">
                          {if $IMOVEL_CORRETORES_LINHA[3]|trim != ""}
                            <a class="btn-ghost-secondary dz-dropzone p-1" onclick="location.href='tel:{$IMOVEL_CORRETORES_LINHA[3]}'">
                              <i class="bi-telephone-inbound-fill me-1"></i> {$IMOVEL_CORRETORES_LINHA[3]}
                            </a>
                          {/if}
                          {if $IMOVEL_CORRETORES_LINHA[4]|trim != ""}
                            <a class="btn-ghost-secondary dz-dropzone p-1" onclick="location.href='https://api.whatsapp.com/send?phone=+55{$IMOVEL_CORRETORES_LINHA[4]}&text=Olá, quero mais informações sobre o imóvel código {$LIST->idimovel}'" target="_blank">
                              <i class="bi-whatsapp me-1"></i> {$IMOVEL_CORRETORES_LINHA[4]}
                            </a>
                          {/if}
                        </div>
                      </div>
                    </div>
                  </div>
                  {$YY = $YY+1}
                {/foreach}
              {/if}
            </div>
          </div>
        </div>
      </div>
    </div>
  {/foreach}
  {if $NUMREGISTROS == 0}
    <div class="container content-space-b-2">
      <div class="text-center bg-img-start py-6" style="background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
        <div class="mb-5">
          <h2>Ops...não achamos nada por aqui.</h2>
          <p>Redefina os filtros utilizados para encontrar o que você precisa.</p>
        </div>
      </div>
    </div>
  {/if}
  {if $NUMREGISTROS > 0}
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item {$PAGINATIONDISABLED.prev}">
          <a class="page-link" aria-label="Primeiro" onclick="js_Pagination(0)">
            <span aria-hidden="true">
              <i class="bi-chevron-double-left"></i>
            </span>
          </a>
        </li>
        <li class="page-item {$PAGINATIONDISABLED.prev}">
          <a class="page-link" aria-label="Anterior" onclick="js_Pagination({$PAGINATIONID-1})">
            <span aria-hidden="true">
              <i class="bi-chevron-left"></i>
            </span>
          </a>
        </li>
        <li class="page-item active"><a class="page-link">{$PAGINATIONID+1}</a></li>
        <li class="page-item {$PAGINATIONDISABLED.next}">
          <a class="page-link" aria-label="Próximo" onclick="js_Pagination({$PAGINATIONID+1})">
            <span aria-hidden="true">
              <i class="bi-chevron-right"></i>
            </span>
          </a>
        </li>
        <li class="page-item {$PAGINATIONDISABLED.next}">
          <a class="page-link" aria-label="Último" onclick="js_Pagination({$MAXPAGINATION})">
            <span aria-hidden="true">
              <i class="bi-chevron-double-right"></i>
            </span>
          </a>
        </li>
      </ul>
    </nav>
  {/if}
</div>
<input type="hidden" name="paginationId" id="paginationId" value="{$PAGINATIONID}">
<input type="hidden" name="imvSelect" value="">

<div class="full-row py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        {if $USEMAP == true}
                            <li class="breadcrumb-item"><a href="javascript:js_CaminhoMap('S','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idimovelsituacao}')">{$IMOVELSHOW->imovelsituacao|lower|ucwords}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:js_CaminhoMap('C','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idcidade}')">{$IMOVELSHOW->cidade|lower|ucwords}</a></li>
                            <!--<li class="breadcrumb-item"><a href="javascript:js_CaminhoMap('B','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->bairro}')">{$IMOVELSHOW->bairro|lower|ucwords}</a></li>-->
                        {else}
                            <li class="breadcrumb-item"><a href="javascript:js_Caminho('S','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idimovelsituacao}')">{$IMOVELSHOW->imovelsituacao|lower|ucwords}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:js_Caminho('C','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->idcidade}')">{$IMOVELSHOW->cidade|lower|ucwords}</a></li>
                            <!--<li class="breadcrumb-item"><a href="javascript:js_Caminho('B','{$IMOVELSHOW->idimovelsituacao}','{$IMOVELSHOW->bairro}')">{$IMOVELSHOW->bairro|lower|ucwords}</a></li>-->
                        {/if}
                        <li class="breadcrumb-item active">{$IMOVELSHOW->bairro|lower|ucwords}</li>
                        <li class="breadcrumb-item active" aria-current="page">Cód. {$IMVZEROS}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
{$file_headers = get_headers($IMGDESTAQUE1)}
{if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
    {$IMGDESTAQUE1 = $URLSYSTEM|cat:$FILENOIMAGE}
{/if}
{$file_headers = get_headers($IMGDESTAQUE2)}
{if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
    {$IMGDESTAQUE2 = $URLSYSTEM|cat:$FILENOIMAGE}
{/if}
{$file_headers = get_headers($IMGDESTAQUE3)}
{if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
    {$IMGDESTAQUE3 = $URLSYSTEM|cat:$FILENOIMAGE}
{/if}
<style>
.height-div-img-1{
    min-height: 34.25rem;
}
.height-div-img-2{
    min-height: 17rem;
}
@media (max-width: 767px) {
    .height-div-img-1{
        min-height: 11.25rem;
    }
    .height-div-img-2{
        min-height: 5.5rem;
    }
}             
</style>
<div class="full-row pt-0 bg-light">
    <div class="container">
        <div class="row g-1">
            <div class="col-8">
                <div class="hover-img-zoom overflow-hidden transation">
                    <a href="{$IMGDESTAQUE1}" data-fancybox="gallery" data-caption="{$IMGLEGENDA1}">
                        <div class="item card-transition height-div-img-1" style="background-image: url('{$IMGDESTAQUE1}');background-size: cover;background-repeat: no-repeat;background-position: center center;">
                            <div class="position-absolute" style="margin-left:30px;margin-top:30px;">
                                {if $IMOVELSHOW->etiquetanome|trim != ""}
                                  <span class="badge text-white {$ETIQUETAMODELO[$IMOVELSHOW->etiquetamodelo]}">              
                                    {$IMOVELSHOW->etiquetanome}
                                  </span>                
                                {/if}      
                            </div>
                        </div>
                        <img style="display:none" class="transation" src="{$IMGDESTAQUE1}" alt="{$IMGLEGENDA1}">
                    </a>
                </div>
            </div>
            <div class="col-4">
                <div class="row row-cols-1 g-1">
                    <div class="col">
                        <div class="hover-img-zoom overflow-hidden transation">
                            <a href="{$IMGDESTAQUE2}" data-fancybox="gallery" data-caption="{$IMGLEGENDA2}">
                                <div class="item card-transition height-div-img-2" style="background-image: url('{$IMGDESTAQUE2}');background-size: cover;background-repeat: no-repeat;background-position: center center;"></div>
                                <img style="display:none" class="transation" src="{$IMGDESTAQUE2}" alt="{$IMGLEGENDA2}">
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="hover-img-zoom overflow-hidden transation">
                            <a href="{$IMGDESTAQUE3}" data-fancybox="gallery" data-caption="{$IMGLEGENDA3}">
                                <div class="item card-transition height-div-img-2" style="background-image: url('{$IMGDESTAQUE3}');background-size: cover;background-repeat: no-repeat;background-position: center center;"></div>
                                <img style="display:none" class="transation" src="{$IMGDESTAQUE3}" alt="{$IMGLEGENDA3}">
                            </a>
                        </div>
                    </div>
                    {$XX = 0}
                    {foreach from=$IMOVELIMAGEMEXPLODE item="IMAGEM_ITEM"}
                        {if $XX>2}
                            {$array_imagem = "#"|explode:$IMOVELIMAGEMEXPLODE[$XX]}
                            <div class="col d-none">
                                <div class="hover-img-zoom overflow-hidden transation">
                                    {$imgOthers = $URLSYSTEM|cat:$array_imagem[0]}
                                    {$file_headers = get_headers($imgOthers)}
                                    {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                                        {$imgOthers = $URLSYSTEM|cat:$FILENOIMAGE}
                                    {/if}                                
                                    <a href="{$imgOthers}" data-fancybox="gallery" data-caption="{$array_imagem[1]}">
                                        <div class="item card-transition height-div-img-2" style="background-image: url('{$imgOthers}');background-size: cover;background-repeat: no-repeat;background-position: center center;"></div>
                                        <img style="display:none" class="transation" src="{$imgOthers}" alt="{$array_imagem[2]}">
                                    </a>
                                </div>
                            </div>
                        {/if}
                        {$XX = $XX+1}
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function js_AbreTwitter(){

  sText = encodeURI("{$IMOVELSHOW->imoveltipo} {$IMOVELSHOW->imoveldestino|lower|ucwords} - {$IMOVELSHOW->bairro|lower|ucwords} | {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})");
  sUrl  = encodeURI("https://{$URLATUAL}");
  window.open("https://twitter.com/intent/tweet?url="+sUrl+"&text="+sText);

}
</script>

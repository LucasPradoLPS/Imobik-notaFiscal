{$file_headers = get_headers($IMGDESTAQUE1)}
{if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
    {$IMGDESTAQUE1 = $URLSYSTEM|cat:$FILENOIMAGE}
{/if}
{$nomeSeo = $IMOVELSHOW->imoveltipo|cat:" "|cat:$IMOVELSHOW->imoveldestino|cat:" "|cat:$IMOVELSHOW->cidade|cat:" "|cat:$IMOVELSHOW->bairro}
<div class="row row-cols-xl-2 row-cols-1">
    <div class="col" style="width:40%">
        <div class="overflow-hidden position-relative transation thumbnail-img hover-img-zoom m-2">
            {if $IMOVELSHOW->etiquetanome|trim != ""}
                <div class="cata position-absolute">
                    <span class="sale text-white {$ETIQUETAMODELO[$IMOVELSHOW->etiquetamodelo]}">
                        <h6 class="text-white">{$IMOVELSHOW->etiquetanome}</h6>
                    </span>
                </div>
            {/if}
            <div class="item card-transition" style="min-height: 50rem; background-image: url('{$IMGDESTAQUE1}');background-size: cover;background-repeat: no-repeat;background-position: center center;" ></div>
        </div>
    </div>
    <div class="col" style="width:60%">
        {include file="imovelviewmodaldetails.tpl"}        
    </div>
</div>
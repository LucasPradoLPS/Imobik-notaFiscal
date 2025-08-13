{if $IMOVELSHOW->mapa|trim != ""}
    <div class="property-overview border rounded bg-white p-30 mb-30">
        <div class="row row-cols-1">
            <div class="col">
                <h5 class="mb-3 down-line">Mapa</h5>
                {if $IMOVELSHOW->mapa|strpos:"iframe"}
                    {$IMOVELSHOW->mapa}
                {elseif $IMOVELSHOW->mapa|strpos:"@"}
                    {$arrayCoordenadas = '@'|explode:$IMOVELSHOW->mapa}
                    <iframe 
                        width="100%"
                        height="450"
                        src="//maps.google.com/maps?q={$arrayCoordenadas[0]},{$arrayCoordenadas[1]}+('aaaaaaaaaa')&z=14&output=embed">
                    </iframe>
                {/if}
            </div>
        </div>
    </div>
{/if}
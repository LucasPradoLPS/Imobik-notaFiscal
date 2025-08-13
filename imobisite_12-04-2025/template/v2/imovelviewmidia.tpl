{if count($IMOVELVIDEO) > 0 || count($IMOVELTOUR) > 0 || count($IMOVELPLANTA) > 0}
    <div class="property-overview border rounded bg-white p-30 mb-30">
        <div class="row row-cols-1">
            <div class="col">
                <h5 class="mb-3 down-line">Mídias</h5>
                <div class="tab-simple tab-action">
                    <ul class="nav-tab-line list-color-secondary d-table mb-3">
                        {if count($IMOVELVIDEO) > 0}
                            <li class="active" data-target="#tb-panel-1">Vídeo</li>
                        {/if}                       
                        {if count($IMOVELTOUR) > 0} 
                            <li data-target="#tb-panel-2">Tour 360°</li>
                        {/if}                       
                        {if count($IMOVELPLANTA) > 0}
                            <li data-target="#tb-panel-3">Planta</li>
                        {/if}                       
                    </ul>
                    <div class="tab-element">
                        <div class="tab-pane tab-hide" id="tb-panel-1" style="display: block;">
                            {include file="imovelviewvideo.tpl"}
                        </div>
                        <div class="tab-pane tab-hide" id="tb-panel-2" style="display: block;">
                            {include file="imovelviewtour.tpl"}
                        </div>
                        <div class="tab-pane tab-hide" id="tb-panel-3" style="display: block;">
                            {include file="imovelviewplanta.tpl"}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
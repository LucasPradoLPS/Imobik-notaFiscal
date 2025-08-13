{if count($IMOVELPLANTA) > 0}
    <div class="property-overview border summary rounded bg-white p-30 mb-30">
        <h5 class="mb-3">Planta(s)</h5>    
        <div class="full-row p-0 overflow-hidden">
            <div id="sliderPlanta" style="width:1200px; height:960px; margin:0 auto;margin-bottom: 0px;">
                {foreach from=$IMOVELPLANTA item="PLANTA"}
                    <div class="ls-slide" data-ls="duration:8000; transition2d:4; kenburnsscale:1.2;">
                        <img width="1920" height="960" src="{$URLSYSTEM}{$PLANTA->patch}" class="ls-l" alt="" style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                        <img width="1920" height="960" src="{$URLSYSTEM}{$PLANTA->patch}" class="ls-tn" alt="">
                        <div style="top:90%; left:25%; width: 450px;" class="ls-l" data-ls="offsetxin:100; offsetyin:0; easingin:easeOutBack; rotatein:0; transformoriginin:30px 360px 0; offsetxout:-80; delayin:1300; durationout:400; parallax:false; parallaxlevel:1;">
                            <div class="bg-primary">
                                <span class="btn text-white">{$PLANTA->legenda}</span>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}
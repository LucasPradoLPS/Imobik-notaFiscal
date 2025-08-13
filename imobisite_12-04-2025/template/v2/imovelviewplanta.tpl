{if count($IMOVELPLANTA) > 0}
    <div class="row row-cols-1">
        <div class="col">
            {foreach from=$IMOVELPLANTA item="PLANTA"}
                <div class="simple-collaps mb-2">
                    <span class="accordion bg-light text-secondary d-block px-4 py-2">{$PLANTA->legenda}</span>
                    <div class="panel">
                        <div class="px-4 py-3">
                            <div class="sliderPlanta" style="width:1200px; height:960px; margin:0 auto;margin-bottom: 0px;">
                                <div class="ls-slide" data-ls="duration:8000; transition2d:4; kenburnsscale:1.2;">
                                    <img width="1920" height="960" src="{$URLSYSTEM}{$PLANTA->patch}" class="ls-l" alt="" style="top:50%; left:50%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; width:100%;" data-ls="showinfo:1; durationin:2000; easingin:easeOutExpo; scalexin:1.5; scaleyin:1.5; position:fixed;">
                                    <img width="1920" height="960" src="{$URLSYSTEM}{$PLANTA->patch}" class="ls-tn" alt="">
                                    <div style="top:80%; left:5%;" class="ls-l ls-hide-phone" data-ls="offsetxin:100; offsetyin:0; easingin:easeOutBack; rotatein:0; transformoriginin:30px 360px 0; offsetxout:-80; delayin:1300; durationout:400; parallax:false; parallaxlevel:1;">
                                        <div class="bg-primary text-white p-2" style="width: 35px; height: 35px;">
                                            <i class="flaticon-zoom-increasing-symbol"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/if}
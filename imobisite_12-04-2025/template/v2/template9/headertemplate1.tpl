<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-light">

    {include file="menubgtransp.tpl"}
    
    <div class="full-row p-0 overflow-hidden bg-light">
        <div id="slider-v2-t09" class="overflow-hidden" style="width:1200px; height:720px; margin:0 auto;margin-bottom: 0px;">
            {foreach from=$IMOVEL_LANCAMENTO item="LANCAMENTO"}
                {$img_lancamento = $URLSYSTEM|cat:$LANCAMENTO->lancamentoimg|trim}
                {$file_headers = get_headers($img_lancamento)}
                {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
                    {$img_destaque = $URLSYSTEM|cat:$FILENOIMAGE}
                {else}
                    {$img_destaque = $img_lancamento}
                {/if}
                {$nomeSeo = $LANCAMENTO->imoveltipo|cat:" "|cat:$LANCAMENTO->imoveldestino|cat:" "|cat:$LANCAMENTO->cidade|cat:" "|cat:$LANCAMENTO->bairro}
                <div class="ls-slide" data-ls="kenburnsscale:1.2; duration:7000;">
                    <img width="1920" height="1080" src="{$img_destaque}" class="ls-bg" alt="">
                    <div style="width:100%; height:100%; background:rgba(37, 40, 43, 0.49); top:50%; left:50%;" class="ls-l" data-ls="easingin:easeOutQuint; durationin:1500; durationout:400; parallaxlevel:0; position:fixed;"></div>
                    <div style="top:-100px; left:-7%; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; height:140%; width:100%; opacity:1; border-radius: 50px; transform: rotate(20deg)" class="ls-l bg-primary"
                        data-ls="showinfo:1; delayin:0; fadein:false; offsetxin:-100lw; offsetxout:left; easingout:easeInQuint; skewxout:-10;"></div>

                    <div style="letter-spacing: -7px; top:90px; left:60px; text-align:initial; font-weight:400; font-style:normal; text-decoration:none; mix-blend-mode:normal; font-family:Verdana; font-size:40px; height:2px; width:55px; opacity:.75; border-radius:10px;"
                        class="ls-l bg-primary " data-ls="showinfo:1; durationin:1500; delayin:1000; fadein:false; clipin:0 100% 0 0; offsetxout:left;"></div>

                    <p style="top:240px; left:20px; text-align:initial; text-decoration:none; mix-blend-mode:normal; padding-right:20px; font-size: 20px; font-weight: 500" class="ls-l text-white" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:500; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->bairro|lower|ucwords} - {$LANCAMENTO->cidade|lower|ucwords} ({$LANCAMENTO->uf})
                    </p>

                    <h2 style="top:280px; left:20px; text-align:initial; white-space: normal; width: 500px; text-decoration:none; mix-blend-mode:normal; color:#fff; padding-right:20px;" class="ls-l font-400" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:1000; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->imoveltipo}
                    </h2>
                    <p style="top:320px; left:20px; width:500px; text-align:initial; text-decoration:none; font-size: 15px; white-space:normal; mix-blend-mode:normal; line-height:28px; color:#fff; padding-right:20px;" class="ls-l " data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:2700; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        Código {$LANCAMENTO->idimovel}
                    </p>
                    <p style="top:380px; left:20px; text-align:initial; text-decoration:none; mix-blend-mode:normal; padding-right:20px; font-size: 15px; font-weight: 500" class="ls-l text-white" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:500; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                            {if $LANCAMENTO->dormitorio+0 > 0}
                                <span style="padding-right:20px;"><i class="fa-solid fa-bed fa-xl me-2"></i>{$LANCAMENTO->dormitorio+0}</span>
                            {/if}
                            {if $LANCAMENTO->banheiro+0 > 0}
                                <span style="padding-right:20px;"><i class="fa-solid fa-shower fa-xl me-2"></i>{$LANCAMENTO->banheiro+0}</span>
                            {/if}
                            {if $LANCAMENTO->vagagaragem+0 > 0}
                                <span style="padding-right:20px;"><i class="fa-solid fa-car fa-xl me-2"></i>{$LANCAMENTO->vagagaragem+0}</span>
                            {/if}
                            {if $LANCAMENTO->area+0 > 0}
                                <span style="padding-right:20px;"><i class="fa-solid fa-vector-square fa-xl me-2"></i>{$LANCAMENTO->area+0}
                                    {if $LANCAMENTO->perimetro == "U"}
                                        m²
                                    {else}
                                        hectare(s)
                                    {/if}
                                </span>
                            {/if}
                    </p>

                    <div onclick="js_ImovelView({$LANCAMENTO->idimovel},'{$nomeSeo}')" style="top:440px; left:20px;" class="ls-l" data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:2500; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        <button type="submit" class="btn btn-light" style="width:150px;height:50px">Veja mais</button>
                    </div>

                    <p style="top:510px; left:20px; width:300px; text-align:initial; text-decoration:none; font-size: 15px; white-space:normal; mix-blend-mode:normal; line-height:28px; color:#fff; padding-right:20px;" class="ls-l " data-ls="showinfo:1; offsetxin:100lw; durationin:1500; delayin:2700; transformoriginin:0% 50% 0; clipin:0 100% 0 0; offsetxout:left;">
                        {$LANCAMENTO->caracteristicas|substr:0:300|nl2br}
                    </p>
                </div>
            {/foreach}
        </div>
    </div>
    {include file="$HEADERTEMPLATE/filterhome.tpl"}
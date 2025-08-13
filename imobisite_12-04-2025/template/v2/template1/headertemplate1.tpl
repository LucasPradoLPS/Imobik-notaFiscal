<!--
<div class="preloader">
    <div class="loader xy-center"></div>
</div>
-->
<div id="page_wrapper" class="bg-white">

    {include file="menubgtransp.tpl"}
    
    <div class="full-row p-0 overflow-hidden">
        <div id="slider-v2-t01" class="overflow-hidden" style="width:1200px; height:780px; margin:0 auto;margin-bottom: 0px;">
            {if isset($SITESLIDE['v2-t01-header-1-1920x1080'])}
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{$URLSYSTEM}{$SITESLIDE['v2-t01-header-1-1920x1080']}" class="ls-bg" alt="" />
                    {if isset($SITETEXT["v2-t01-header-slide1-text1"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide1-text1"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            TXT v2-t01-header-slide1-text1
                        </p>
                    {/if}
                    {if isset($SITETEXT["v2-t01-header-slide1-text2"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide1-text2"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            TXT v2-t01-header-slide1-text2
                        </p>
                    {/if}
                </div>
            {else}
                <p><h1>IMG v2-t01-header-1-1920x1080</h1></p>
            {/if}
            {if isset($SITESLIDE['v2-t01-header-2-1920x1080'])}
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{$URLSYSTEM}{$SITESLIDE['v2-t01-header-2-1920x1080']}" class="ls-bg" alt="" />
                    {if isset($SITETEXT["v2-t01-header-slide2-text1"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide2-text1"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            TXT v2-t01-header-slide2-text1
                        </p>
                    {/if}
                    {if isset($SITETEXT["v2-t01-header-slide2-text2"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide2-text2"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            v2-t01-header-slide2-text2
                        </p>
                    {/if}
                </div>
            {else}
                <p>IMG v2-t01-header-2-1920x1080</p>
            {/if}              
            {if isset($SITESLIDE['v2-t01-header-3-1920x1080'])}
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{$URLSYSTEM}{$SITESLIDE['v2-t01-header-3-1920x1080']}" class="ls-bg" alt="" />
                    {if isset($SITETEXT["v2-t01-header-slide3-text1"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide3-text1"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;" class="ls-l text-white" data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            TXT v2-t01-header-slide3-text1
                        </p>
                    {/if}
                    {if isset($SITETEXT["v2-t01-header-slide3-text2"])}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            {$SITETEXT["v2-t01-header-slide3-text2"]}
                        </p>
                    {else}
                        <p style="text-shadow: 0px 0px 10px rgba(0,0,0,1);top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;" class="ls-l" data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                            TXT v2-t01-header-slide3-text2
                        </p>
                    {/if}
                </div>
            {else}
                <p>IMG v2-t01-header-3-1920x1080</p>
            {/if}                  
        </div>
    </div>
    {include file="$HEADERTEMPLATE/filterhome.tpl"}
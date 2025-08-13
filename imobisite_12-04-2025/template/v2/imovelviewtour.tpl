{if count($IMOVELTOUR) > 0}
    <div class="row row-cols-1">
        <div class="col">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-simple text-center">
                        <div class="text-carusel owl-carousel">
                            {foreach from=$IMOVELTOUR item="TOUR"}
                                <div class="item">
                                    <div class="mt-md-30 position-relative overlay-secondary">
                                        <img src="assets/v2/images/fundo-video.jpg" alt="uniland">
                                        <a data-fancybox="" class="video-popup" href="{$TOUR->patch}" title="video popup">
                                            <span class="flaticon-play-button bg-primary text-white xy-center"></span>
                                        </a>
                                        <div class="loader position-absolute xy-center">
                                            <div class="loader-inner ball-scale-multiple">
                                                <div style="background: var(--theme-primary-color);"></div>
                                                <div style="background: var(--theme-primary-color);"></div>
                                            </div><span class="tooltip"><b>ball-scale-multiple</b></span>
                                        </div>
                                    </div>
                                    <p></p>
                                    <p>{$TOUR->legenda}</p>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
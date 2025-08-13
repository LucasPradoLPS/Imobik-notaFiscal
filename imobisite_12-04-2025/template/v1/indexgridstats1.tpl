<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="fact-counter bg-secondary pt-5 pb-4 rounded">
                    <div class="row row-cols-lg-3 row-cols-sm-1 row-cols-1">
                        <div class="col {$HIDDENLOCACAO}">
                            <div class="mb-30 text-center count wow fadeIn animate" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeIn;">
                                <span class="count-num text-primary h2" data-speed="3000" data-stop="{$TOTALIMVLOCACAO}">{$TOTALIMVLOCACAO}</span>
                                <h5 class="text-white font-400 pt-2">Imóveis(s) para alugar</h5>
                            </div>
                        </div>
                        <div class="col {$HIDDENVENDA}">
                            <div class="mb-30 text-center count wow fadeIn animate" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeIn;">
                                <span class="count-num text-primary h2" data-speed="3000" data-stop="{$TOTALIMVVENDA}">{$TOTALIMVVENDA}</span>
                                <h5 class="text-white font-400 pt-2">Imóveis(s) para comprar</h5>
                            </div>
                        </div>
                        <div class="col {$HIDDENGERAL}">
                            <div class="mb-30 text-center count wow fadeIn animate" data-wow-duration="300ms" style="visibility: visible; animation-duration: 300ms; animation-name: fadeIn;">
                                <span class="count-num text-primary h2" data-speed="3000" data-stop="{$TOTALIMVGERAL}">{$TOTALIMVGERAL}</span>
                                <h5 class="text-white font-400 pt-2">Imóveis(s) totais</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
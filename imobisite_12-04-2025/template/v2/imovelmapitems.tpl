{foreach from=$IMOVELGRID item="GRIDIMOVELSHOW"}
    {include file="imovelcardcarouselmap.tpl"}
{/foreach}
<div class="data-nothing">
{if $NUMREGISTROS == 0}
    <div class="container content-space-b-2">
        <div class="text-center" style="padding-top: 2.5rem !important;padding-bottom: 2.5rem !important;background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
        <div class="mb-5">
            <h2>Ops...não achamos nada por aqui.</h2>
            <p>Redefina os filtros utilizados para encontrar o que você precisa.</p>
        </div>
        </div>
    </div>
{/if}
</div>
<input type="hidden" name="imvSelect" value="">
<div class="full-row pt-0 bg-light">
    <div class="container">
        <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1">
            {foreach from=$IMOVELGRID item="GRIDIMOVELSHOW"}
                <div class="col mb-3">
                    {include file="imovelcardcarousel.tpl"}
                </div>
            {/foreach}
        </div>
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
        {if $NUMREGISTROS > 0}
        <div class="row">
            <div class="col mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-dotted-active justify-content-center">
                        <li class="page-item {$PAGINATIONDISABLED.prev}">
                            <a class="page-link" aria-label="Primeiro" href="javascript:js_Pagination(0)">
                              <span aria-hidden="true">
                                <i class="fa fa-angle-double-left fa-xl" aria-hidden="true"></i>
                              </span>
                            </a>
                        </li>
                        <li class="page-item {$PAGINATIONDISABLED.prev}">
                            <a class="page-link" aria-label="Anterior" href="javascript:js_Pagination({$PAGINATIONID-1})">
                              <span aria-hidden="true">
                                <i class="fa fa-angle-left fa-xl" aria-hidden="true"></i>
                              </span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link">{$PAGINATIONID+1}</a></li>
                        <li class="page-item {$PAGINATIONDISABLED.next}">
                            <a class="page-link" aria-label="Próximo" href="javascript:js_Pagination({$PAGINATIONID+1})">
                              <span aria-hidden="true">
                                <i class="fa fa-angle-right fa-xl" aria-hidden="true"></i>
                              </span>
                            </a>
                        </li>
                        <li class="page-item {$PAGINATIONDISABLED.next}">
                            <a class="page-link" aria-label="Último" href="javascript:js_Pagination({$MAXPAGINATION})">
                              <span aria-hidden="true">
                                <i class="fa fa-angle-double-right fa-xl" aria-hidden="true"></i>
                              </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>  
        </div>  
        {/if}
    </div>
</div>
<input type="hidden" name="paginationId" id="paginationId" value="{$PAGINATIONID}">
<input type="hidden" name="imvSelect" value="">

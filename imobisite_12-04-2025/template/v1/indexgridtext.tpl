<div class="container content-space-1">
  <div class="w-md-75 w-lg-50 text-center mx-md-auto">
    <h2>{$SECAO->sitesecaotitulo}</h2>
  </div>
</div>
<div class="position-relative">
  <div class="container content-space-lg-3 mb-7">
    <div class="row align-items-center">
      <div class="col-12 col-lg-9 mb-7 mb-md-0">
        <div class="w-md-65 mb-7 text-dark">
          {$SITE->textsectionmain}        
        </div>
        <div class="row">
          <div class="col-md-4 mb-3 mb-md-0 {$HIDDENLOCACAO}">
            <div class="card h-100">
              <div class="card-body">
                <span class="svg-icon text-primary mb-3">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="#035A4B"/>
                </svg>
                </span>
                </span>
                <h4 class="card-title">Encontre imóveis para alugar</h4>
                <p class="card-text">Aqui você encontra {$TOTALIMVLOCACAO} propriedade(s) para alugar.</p>
                <a class="card-link" href="javascript:js_MenuDirecionaFooter('1,5','');"> Veja tudo aqui<i class="bi-chevron-right small ms-1"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0 {$HIDDENVENDA}">
            <div class="card h-100">
              <div class="card-body">
                <span class="svg-icon text-primary mb-3">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 3C5.67157 3 5 3.67157 5 4.5V6H3.5C2.67157 6 2 6.67157 2 7.5C2 8.32843 2.67157 9 3.5 9H5V19.5C5 20.3284 5.67157 21 6.5 21C7.32843 21 8 20.3284 8 19.5V9H20.5C21.3284 9 22 8.32843 22 7.5C22 6.67157 21.3284 6 20.5 6H8V4.5C8 3.67157 7.32843 3 6.5 3Z" fill="#035A4B"/>
                  <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M20.5 11H10V17.5C10 18.3284 10.6716 19 11.5 19H15.5C17.3546 19 19.0277 18.2233 20.2119 16.9775C20.1436 16.9922 20.0727 17 20 17C19.4477 17 19 16.5523 19 16V13C19 12.4477 19.4477 12 20 12C20.5523 12 21 12.4477 21 13V15.9657C21.6334 14.9626 22 13.7741 22 12.5C22 11.6716 21.3284 11 20.5 11Z" fill="#035A4B"/>
                  </svg>
                </span>
                <h4 class="card-title">Encontre imóveis à venda</h4>
                <p class="card-text">Aqui você encontra {$TOTALIMVVENDA} propriedade(s) para comprar.</p>
                <a class="card-link" href="javascript:js_MenuDirecionaFooter('3,5','');">Veja tudo aqui<i class="bi-chevron-right small ms-1"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0 {$HIDDENGERAL}">
            <div class="card h-100">
              <div class="card-body">
                <span class="svg-icon text-primary mb-3">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18V21.6Z" fill="#035A4B"/>
                  <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="#035A4B"/>
                  <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="#035A4B"/>
                </svg>
                </span>
                <h4 class="card-title">Encontre todos os Imóveis</h4>
                <p class="card-text">Aqui você encontra um total de {$TOTALIMVGERAL} propriedade(s).</p>
                <a class="card-link" href="javascript:js_MenuDirecionaFooter('','');">Veja tudo aqui<i class="fas bi-chevron-right small ms-1"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {if isset($SITESLIDE['v1-t01-main-1-900x900'])}
    <div class="banner-half-middle-x bg-img-start d-none d-md-block" style="background-image: url({$URLSYSTEM}{$SITESLIDE['v1-t01-main-1-900x900']});"></div>
  {else}
    <div class="banner-half-middle-x bg-img-start d-none d-md-block">IMG v1-t01-main-1-900x900</div>  
  {/if}
</div>

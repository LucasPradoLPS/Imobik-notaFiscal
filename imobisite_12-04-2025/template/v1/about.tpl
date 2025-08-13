{include file="header.tpl"}
<main id="content" role="main">
  <form name="form_imvgeral" id="form_imvgeral" method="POST">
    <div class="container content-space-2">
      <div class="row">
        <div class="col-lg-8">
          {$SITE->about}
          <!-- Sticky Block End Point -->
          <div id="stickyBlockEndPointEg4"></div>
        </div>
        <div class="col-lg-4">
          <div class="ps-lg-4">
            <div id="stickyBlockStartPointEg4">
              <div class="js-sticky-block"
                   data-hs-sticky-block-options='{
                     "parentSelector": "#stickyBlockStartPointEg4",
                     "breakpoint": "lg",
                     "startPoint": "#stickyBlockStartPointEg4",
                     "endPoint": "#stickyBlockEndPointEg4",
                     "stickyOffsetTop": 20,
                     "stickyOffsetBottom": 20
                   }'>
                <div class="card card-bordered">
                  <div class="card-body">
                    <div class="mb-5 text-center">
                      <h3>Fique sempre à frente de seu tempo. Entre em contato com a gente.</h3>
                    </div>
                    <div class="d-grid mb-5 text-center">
                      <a class="text-center" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
                        <i class="bi-whatsapp text-primary" style="font-size:50px;"></i>
                      </a>
                    </div>
                    <img class="card-img-bottom" src="assets/v1/img/illustrations/chat.png" alt="Image Description">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>
{include file="footer.tpl"}
{include file="scripts.tpl"}

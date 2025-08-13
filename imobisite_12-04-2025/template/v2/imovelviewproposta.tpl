<div class="modal fade" id="propostaModal" tabindex="-1" aria-labelledby="propostaModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content quick-search">
      <div class="modal-header">
        <h5 class="modal-title" id="propostaModalLabel">Crie sua proposta customizada</h5>
        <div class="close view-close" data-bs-dismiss="modal">
            <span aria-hidden="true">&times;</span>
        </div>
      </div>
      <div class="modal-body">
        <label for="banheiroImv" class="form-label text-muted">Informações do Imóvel</label>
        <div class="mb-4 border border-1 rounded shadow-sm p-3">
          <div class="row">
            <div class="col-4">
              <a class="w-40 card card-stretched-vertical card-transition shadow-none bg-img-start" style="background-image: url({$IMGDESTAQUE1}); min-height:7rem; max-width:10rem;background-size: cover;background-repeat: no-repeat;background-position: center center;"></a>
            </div>
            <div class="col-6 small">
              <span class="text-body">Imóvel Código {$IMOVELSHOW->idimovel|lower|ucwords}</span><br>
              <span class="text-body">{$IMOVELSHOW->imoveltipo|lower|ucwords}</span><br>
              <span class="text-body">{$IMOVELSHOW->endereco|lower|ucwords}</span><br>
              <span class="text-body">{$IMOVELSHOW->bairro|lower|ucwords} - {$IMOVELSHOW->cidade|lower|ucwords} ({$IMOVELSHOW->uf})</span>
            </div>
          </div>
        </div>
        <div class="mb-4">
          <div class="row align-items-center">
            <div class="col">
              <label for="formPropostaSituacao" class="form-label text-muted">Valor atual do anúncio</label>
              <select id="formPropostaSituacao" name="formPropostaSituacao" class="form-select text-muted">
                {if $IMOVELSHOW->idimovelsituacao == "1"}
                  <option class="{$HIDDENLOCACAO}" value="L">Locação (R$ {$IMOVELSHOW->aluguel|number_format:2:",":"."})</option>
                {elseif $IMOVELSHOW->idimovelsituacao == "3"}
                  <option class="{$HIDDENVENDA}" value="V">Venda (R$ {$IMOVELSHOW->venda|number_format:2:",":"."})</option>
                {elseif $IMOVELSHOW->idimovelsituacao == "5"}
                  <option value=" ">Selecione a sua opção</option>
                  <option class="{$HIDDENLOCACAO}" value="L">Locação (R$ {$IMOVELSHOW->aluguel|number_format:2:",":"."})</option>
                  <option class="{$HIDDENVENDA}" value="V">Venda (R$ {$IMOVELSHOW->venda|number_format:2:",":"."})</option>
                {/if}
              </select>
            </div>
          </div>
        </div>
        <div class="mb-4 border border-1 rounded shadow-sm p-3 bg-light">
          <div class="row align-items-center">
            <div class="col-7">
              <span class="small text-dark fw-semi-bold card-subtitle   ">Sua nova proposta </span>
            </div>
            <div class="col-5 text-sm-end" style="float:right">
              <label for="formPropostaValor" class="form-label visually-hidden">Sua nova proposta</label>
              <input name="formPropostaValor" type="text" class="form-control text-sm-end" id="formPropostaValor" placeholder="R$ 0,00" aria-label="" value="">
            </div>
          </div>
        </div>
        <label for="detalheImv2" class="form-label text-muted">Aproveite o espaço abaixo para explicar e/ou justiticar a sua proposta</label>
        <div class="mb-4 border border-1 rounded shadow-sm p-3 bg-light">
          <div class="row align-items-center">
            <div class="col">
              <textarea name="formPropostaMensagem" class="form-control" id="formPropostaMensagem" placeholder="Eu gostaria de..." aria-label="Eu gostaria de..." rows="4"></textarea>
            </div>
          </div>
        </div>
        <div class="mb-2">
          <label for="formPropostaNome" class="form-label visually-hidden">Nome Completo</label>
          <input name="formPropostaNome" type="text" class="form-control" id="formPropostaNome" placeholder="Nome Completo" aria-label="Nome Completo">
        </div>
        <div class="mb-2">
          <label for="formPropostaEmail" class="form-label visually-hidden">Email</label>
          <input name="formPropostaEmail" type="email" class="form-control" id="formPropostaEmail" placeholder="Email" aria-label="Email">
        </div>
        <div class="mb-2">
          <label for="formPropostaFone" class="form-label visually-hidden">Telefone</label>
          <input name="formPropostaFone" type="tel" class="js-input-mask form-control" id="formPropostaFone" placeholder="(xx)xxxxx-xxxx"
          data-hs-mask-options='{
          "mask": "(00)00000-0000"
          }'>
        </div>
        <div class="mb-2" id="div_captcha_proposta">
          <div class="g-recaptcha mt-2" data-sitekey="{$SITE->sitekeyemail}"></div>        
        </div>
        <div class="mb-4">
          <div class="row gx-3">
            <div class="col-12 text-center">
              <button type="button" class="btn btn-primary" onclick="js_ValidaPropostaForm()">Enviar Proposta</button>
              <button type="button" class="btn btn-outline-primary border-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ========== SECONDARY CONTENTS ========== -->
<a style="display:none" id="idPropostaModalMsg" class="btn btn-outline-primary border-primary" href="#" data-bs-toggle="modal" data-bs-target="#propostaModalMsg">Modal</a>
<div class="modal fade" id="propostaModalMsg" tabindex="-1" aria-labelledby="propostaModalLabelMsg" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="border border-1 rounded shadow-sm p-3 bg-light text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="modal-title" id="propostaModalLabelMsg">Enviando sua proposta...aguarde</h3>
      </div>
    </div>
  </div>
</div>

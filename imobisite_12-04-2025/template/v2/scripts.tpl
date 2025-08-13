</div>
    <span id="liveToastBtn" class="d-none">Toast</span>
    <div id="liveToast" class="position-fixed toast hide bg-light" role="alert" aria-live="assertive" aria-atomic="true" style="top: 20px; right: 20px; z-index: 999999;">
        <div class="toast-header bg-light">
            <div class="d-flex align-items-center flex-grow-1">
                <div class="flex-shrink-0" id="toast-icon">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0" id="toast-text-1"></h5>
                    <small class="ms-auto" id="toast-text-2"></small>
                </div>
                <div class="text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="toast-body" id="toast-text-3">
        </div>
    </div>
    
    <!-- Javascript Files -->
    <script src="assets/v2/js/jquery.min.js"></script>
    <script src="assets/v2/js/greensock.js"></script>
    <script src="assets/v2/js/layerslider.transitions.js"></script>
    <script src="assets/v2/js/layerslider.kreaturamedia.jquery.js"></script>
    <script src="assets/v2/js/popper.min.js"></script>
    <script src="assets/v2/js/bootstrap.min.js"></script>
    <script src="assets/v2/js/bootstrap-select.min.js"></script>
    <script src="assets/v2/js/jquery.fancybox.min.js"></script>
    <script src="assets/v2/js/owl.js"></script>
    <script src="assets/v2/js/range/tmpl.js"></script>
    <script src="assets/v2/js/range/jquery.dependClass.js"></script>
    <script src="assets/v2/js/range/draggable.js"></script>
    <script src="assets/v2/js/range/jquery.slider.js"></script>
    <script src="assets/v2/js/wow.js"></script>
    <script src="assets/v2/js/mixitup.min.js"></script>
    <script src="assets/v2/js/paraxify.js"></script>
    <script src="assets/v2/js/custom.js"></script>
    <script src="assets/v2/js/jquery.maskMoney.js"></script>
    <script src="assets/v2/js/jquery.mask.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script src="assets/v2/js/map/custom-map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={$SITE->apikeygooglemaps}"></script>
    <script src="assets/v2/js/map/markerwithlabel_packed.js"></script>
    <script src="assets/v2/js/map/infobox.js"></script>
    <script src="assets/v2/js/map/markerclusterer_packed.js"></script>
        
    <script>
  
    $(document).ready(function () {

        $('.sliderPlanta').layerSlider({
            sliderVersion: '6.0.0',
            responsiveUnder: 0,
            maxRatio: 1,
            slideBGSize: 'auto',
            hideUnder: 0,
            hideOver: 100000,
            skin: 'outline',
            fitScreenWidth: true,
            fullSizeMode: 'fitheight',
            navButtons: true,
            navStartStop: false,
            height:700,
            skinsPath: 'assets/v2/skins/'
        });
        
        $('#slider-v2-t01').layerSlider({
            sliderVersion: '6.0.0',
            type: 'fullwidth',
            responsiveUnder: 0,
            maxRatio: 1,
            slideBGSize: 'auto',
            hideUnder: 0,
            hideOver: 100000,
            skin: 'numbers',
            fitScreenWidth: true,
            fullSizeMode: 'fitheight',
            navButtons: true,
            navStartStop: false,
            height:750,
            skinsPath: 'assets/v2/skins/'
        });        

        $('#slider-v2-t06').layerSlider({
            sliderVersion: '6.0.0',
            type: 'fullwidth',
            responsiveUnder: 0,
            layersContainer: 1200,
            pauseOnHover: 'enabled',
            navPrevNext: true,
            hideUnder: 0,
            hideOver: 100000,
            skin: 'numbers',
            navButtons: true,
            globalBGColor: '#ffffff',
            navStartStop: true,
            skinsPath: 'assets/v2/skins/',
            height: 800
        });

        $('#slider-v2-t08').layerSlider({
            sliderVersion: '6.0.0',
            type: 'fullwidth',
            responsiveUnder: 0,
            pauseOnHover: 'enabled',
            navPrevNext: true,
            hideUnder: 0,
            hideOver: 100000,
            skin: 'numbers',
            navButtons: true,
            globalBGColor: '#ffffff',
            navStartStop: true,
            skinsPath: 'assets/v2/skins/',
            thumbnailNavigation: 'disabled',
            height: 750
        });

        $('#slider-v2-t09').layerSlider({
            sliderVersion: '6.0.0',
            type: 'fullwidth',
            responsiveUnder: 0,
            maxRatio: 1,
            slideBGSize: 'auto',
            hideUnder: 0,
            hideOver: 100000,
            skin: 'numbers',
            fitScreenWidth: true,
            fullSizeMode: 'fitheight',
            thumbnailNavigation: 'disabled',
            height: 860,
            skinsPath: 'assets/v2/skins/'
        });

        var struct = window.localStorage.getItem('imobi-compare');        
        if(struct){
            struct = JSON.parse(struct);
            arrayImoveis = struct.imovel_list;
            $(".compare-1,.compare-2").each(function(index) {
                idImovelCompare = $(this).data("compare-imovel");
                if(arrayImoveis.includes(idImovelCompare)){
                    if ($(this).hasClass("compare-1")) {
                        $("li[data-compare-imovel='" + idImovelCompare +"']").removeClass("bg-secondary compare-1-not").addClass("bg-primary compare-1-yes");
                    }else{
                        $("li[data-compare-imovel='" + idImovelCompare +"']").removeClass("bg-light compare-1-not").addClass("bg-primary compare-1-yes");
                        $("li[data-compare-imovel='" + idImovelCompare +"'] > a").removeClass("text-dark").addClass("text-white");
                    }
                }
            });            
        }

        var struct = window.localStorage.getItem('imobi-favorite');        
        if(struct){
            struct = JSON.parse(struct);
            arrayImoveis = struct.imovel_list;
            $(".favorite-1,.favorite-2").each(function(index) {
                idImovelFavorite = $(this).data("favorite-imovel");
                if(arrayImoveis.includes(idImovelFavorite)){
                    if ($(this).hasClass("favorite-1")) {
                        $("li[data-favorite-imovel='" + idImovelFavorite +"']").removeClass("bg-secondary favorite-1-not").addClass("bg-primary favorite-1-yes");
                    }else{
                        $("li[data-favorite-imovel='" + idImovelFavorite +"']").removeClass("bg-light favorite-1-not").addClass("bg-primary favorite-1-yes");
                        $("li[data-favorite-imovel='" + idImovelFavorite +"'] > a").removeClass("text-dark").addClass("text-white");
                    }                    
                }
            });            
        }

    });

    function js_BuscaBairro(codeCity){
        $("#selectBairro").load("filterload.php","idCidade="+codeCity);
    }

    function js_BuscaGridLista(file){
        event.preventDefault();
        document.form_imvgeral.paginationId.value = 0;
        if(file=="imovelgrid.php"){
            if(document.form_imvgeral.situacaoImv.value == "1,5"){
                document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
            }else if(document.form_imvgeral.situacaoImv.value == "3,5"){
                document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
            }else{
                document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
            }
        }else if(file=="imovellist.php"){
            if(document.form_imvgeral.situacaoImv.value == "1,5"){
                document.getElementById('form_imvgeral').action = 'list-busca-imoveis/locacao/';
            }else if(document.form_imvgeral.situacaoImv.value == "3,5"){
                document.getElementById('form_imvgeral').action = 'list-busca-imoveis/venda/';
            }else{
                document.getElementById('form_imvgeral').action = 'list-busca-imoveis/geral/';
            }
        }
        document.form_imvgeral.submit();
    }

    function js_BuscaMap(){
        event.preventDefault();
        if(document.form_imvgeral.situacaoImv.value == "1,5"){
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/locacao/';
        }else if(document.form_imvgeral.situacaoImv.value == "3,5"){
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/venda/';
        }else{
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/geral/';
        }
        document.form_imvgeral.submit();
    }

    function js_limpaFiltro(opt,campo){
        if(opt=="1"){
            eval("document.form_imvgeral."+campo+"[0].checked = false");
            eval("document.form_imvgeral."+campo+"[1].checked = false");
        }
        if(opt=="2"){
            eval("document.form_imvgeral."+campo+".value = ''");
        }
        if(opt=="3"){
            document.form_imvgeral.areaImvMin.value = "";
            document.form_imvgeral.areaImvMax.value = "";
        }
        if(opt=="4"){
            eval("document.form_imvgeral."+campo+"[4].checked = true");
        }
        if(opt=="5"){
            $("#"+campo).val("0");
        }
        if(opt=="6"){
            document.form_imvgeral.valorMinimo.value = "";
            document.form_imvgeral.valorMaximo.value = "";
        }
        if(opt=="7"){
            eval("document.form_imvgeral."+campo+".checked = false");
        }
        $('#encontrarImv').click();
    }

    function js_MenuDireciona(code){
        event.preventDefault();
        if(code=="1,5"){
            location.href = 'grid-busca-imoveis/locacao/?situacaoImv=1,5';
        }else if(code=="3,5"){
            location.href = 'grid-busca-imoveis/venda/?situacaoImv=3,5';
        }else if(code=="10"){
            location.href = 'grid-busca-imoveis/geral/?imoveldestinoImv=1';
        }else{
            location.href = 'grid-busca-imoveis/geral/';
        }
    }  

    function js_MenuDirecionaMap(code){
        event.preventDefault();
        if(code=="1,5"){
            location.href = 'map-busca-imoveis/locacao/?situacaoImv=1,5';
        }else if(code=="3,5"){
            location.href = 'map-busca-imoveis/venda/?situacaoImv=3,5';
        }else if(code=="10"){
            location.href = 'map-busca-imoveis/geral/?imoveldestinoImv=1';
        }else{
            location.href = 'map-busca-imoveis/geral/';
        }
    }  

    function js_RolaTela(elem){
        $('html,body').animate({literal}{scrollTop: ($(elem).offset().top)-150}{/literal},700);
    }

    $("#botaoGrid").click(function () {
        if(document.form_imvgeral.situacaoImv[0].checked == true){
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
        }else if(document.form_imvgeral.situacaoImv[1].checked == true){
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
        }else{
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
        }
        document.getElementById('form_imvgeral').submit();
    });

    $("#botaoLista").click(function () {
        if(document.form_imvgeral.situacaoImv[0].checked == true){
            document.getElementById('form_imvgeral').action = 'list-busca-imoveis/locacao/';
        }else if(document.form_imvgeral.situacaoImv[1].checked == true){
            document.getElementById('form_imvgeral').action = 'list-busca-imoveis/venda/';
        }else{
            document.getElementById('form_imvgeral').action = 'list-busca-imoveis/geral/';
        }
        document.getElementById('form_imvgeral').submit();
    });

    function js_Pagination(pg){
        document.form_imvgeral.paginationId.value = pg;
        document.form_imvgeral.submit();
    }    

    function js_MenuDirecionaFooter(code,code2){
        event.preventDefault();
        if(code=="1,5"){
            location.href = 'grid-busca-imoveis/locacao/?situacaoImv=1,5&zonaImv='+code2;
        }else if(code=="3,5"){
            location.href = 'grid-busca-imoveis/venda/?situacaoImv=3,5&zonaImv='+code2;
        }else if(code=="10"){
            location.href = 'grid-busca-imoveis/geral/?imoveldestinoImv=1&zonaImv='+code2;
        }else{
            location.href = 'grid-busca-imoveis/geral/?zonaImv='+code2;
        }
    }

    function js_MenuDirecionaFooterMap(code,code2){
        event.preventDefault();
        if(code=="1,5"){
            location.href = 'map-busca-imoveis/locacao/?situacaoImv=1,5&zonaImv='+code2;
        }else if(code=="3,5"){
            location.href = 'map-busca-imoveis/venda/?situacaoImv=3,5&zonaImv='+code2;
        }else if(code=="10"){
            location.href = 'map-busca-imoveis/geral/?imoveldestinoImv=1&zonaImv='+code2;
        }else{
            location.href = 'map-busca-imoveis/geral/?zonaImv='+code2;
        }
    }

    function js_ImovelView(code,nomeseo){
        url = 'imovel/'+code+'/'+js_GeraNomeSeo(nomeseo)+'/';
        location.href = url;
    }

    function js_GeraNomeSeo(txt){
        txt = txt.replace(/[\s]/gi, '-'); //Transforma espaço em traço
        txt = txt.toLowerCase();
        txt = txt.replace(/[^a-z--]/gi, ''); //Remove tudo que não for letras, números ou traço
        return txt;
    }

    function js_TipoImovelDireciona(code){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [code];
        document.getElementById('form_headergeral').action = 'grid-busca-imoveis/geral/';
        document.getElementById('form_headergeral').submit();
    }  

    function js_TipoImovelDirecionaMap(code){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [code];
        document.getElementById('form_headergeral').action = 'map-busca-imoveis/geral/';
        document.getElementById('form_headergeral').submit();
    }  

    function js_CidadeDireciona(code){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [0];
        document.form_headergeral.cidadeImv.value = code;
        document.getElementById('form_headergeral').action = 'grid-busca-imoveis/geral/';
        document.getElementById('form_headergeral').submit();
    }  

    function js_CidadeDirecionaMap(code){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [0];
        document.form_headergeral.cidadeImv.value = code;
        document.getElementById('form_headergeral').action = 'map-busca-imoveis/geral/';
        document.getElementById('form_headergeral').submit();
    }  

    $(document).on('click', "#buttonShare", function(){
        copyToClipboard(document.getElementById("url_copy").value);
        $("#toast-icon").html('<i class="fa-solid fa-copy fa-xl me-2" style="color:black"></i>');
        $("#toast-text-1").html('URL copiada');
        $("#toast-text-2").html('para área de transferência');
        $("#toast-text-3").html('Compartilhe este imóvel nas sua redes sociais.');
        $("#liveToastBtn").click();
    })

    $(document).on('click', "#buttonShareModal", function(){
        copyToClipboard(document.getElementById("url_copy_modal").value);
        $("#toast-icon").html('<i class="fa-solid fa-copy fa-xl me-2" style="color:black"></i>');
        $("#toast-text-1").html('URL copiada');
        $("#toast-text-2").html('para área de transferência');
        $("#toast-text-3").html('Compartilhe este imóvel nas sua redes sociais.');
        $("#liveToastBtn").click();
    })

    function copyToClipboard(text) {
        if (window.clipboardData && window.clipboardData.setData) {
            return window.clipboardData.setData("Text", text);
        }else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            try {
                return document.execCommand("copy");
            } catch (ex) {
                console.warn("Falha na cópia!", ex);
                return false;
            } finally {
                document.body.removeChild(textarea);
            }
        }
    }

    function validacaoEmail(field){
        usuario = field.value.substring(0, field.value.indexOf("@"));
        dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
        if ((usuario.length >=1) &&
            (dominio.length >=3) &&
            (usuario.search("@")==-1) &&
            (dominio.search("@")==-1) &&
            (usuario.search(" ")==-1) &&
            (dominio.search(" ")==-1) &&
            (dominio.search(".")!=-1) &&
            (dominio.indexOf(".") >=1)&&
            (dominio.lastIndexOf(".") < dominio.length - 1)) {
            return true;
        }else{
            return false;
        }
    }    

    function js_ValidaInfoImovelForm(form){

        if(document.form_imvgeral.formInfoImovelNome.value==""){
            alert("Informe o Nome");
            js_RolaTela("#formInfoImovelNome");
            document.form_imvgeral.formInfoImovelNome.focus();
            return false;
        }
        if(document.form_imvgeral.formInfoImovelEmail.value==""){
            alert("Informe o Email");
            js_RolaTela("#formInfoImovelEmail");
            document.form_imvgeral.formInfoImovelEmail.focus();
            return false;
        }
        if(validacaoEmail(document.form_imvgeral.formInfoImovelEmail)==false){
            alert("Email Inválido");
            js_RolaTela("#formInfoImovelEmail");
            document.form_imvgeral.formInfoImovelEmail.focus();
            return false;
        }
        if(document.form_imvgeral.formInfoImovelFone.value==""){
            alert("Informe o Telefone");
            js_RolaTela("#formInfoImovelFone");
            document.form_imvgeral.formInfoImovelFone.focus();
            return false;
        }
        if(document.form_imvgeral.formInfoImovelMensagem.value==""){
            alert("Informe a Mensagem");
            js_RolaTela("#formInfoImovelMensagem");
            document.form_imvgeral.formInfoImovelMensagem.focus();
            return false;
        }
        var v = grecaptcha.getResponse(0);
        if(v.length == 0){
            alert("Você não pode deixar o captcha vazio [0]");
            return false;
        }
        document.form_imvgeralProposta.formPropostaEmail.value = "";
        document.getElementById("idInfoImovelModal").click();

        sForm1 = $('#form_imvgeral').serialize();
        sForm2 = $("[name='imvSelect']").serialize();
        sForm = sForm1+"&"+sForm2;
        var sFile   = 'ajaxsendmail.php';
        {literal}$.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaInfoImovelForm(data);}}){/literal};

    }

    function js_retornoValidaInfoImovelForm(retorno){
        msg = retorno.split("|");
        alert(msg[0]);
        js_ImovelView(msg[1],msg[2]);
    }  

    function js_Caminho(tipo,situacao,valor){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [0];        
        if(situacao=="1"){
            situacao = "1,5";
            redir = "locacao";
        }else{
            situacao = "3,5";
            redir = "venda";
        }
        if(tipo=="S"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.cidadeImv.value = "";
            document.form_headergeral.bairroImv.value = "";
        }else if(tipo=="C"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.cidadeImv.value = valor;
        }else if(tipo=="B"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.bairroImv.value = valor;
        }
        document.getElementById('form_headergeral').action = 'grid-busca-imoveis/'+redir+'/';
        document.getElementById('form_headergeral').submit();
    }

    function js_CaminhoMap(tipo,situacao,valor){
        document.getElementById('form_headergeral').reset();
        document.getElementById('tipoImovelGeral').value = [0];        
        if(situacao=="1"){
            situacao = "1,5";
            redir = "locacao";
        }else{
            situacao = "3,5";
            redir = "venda";
        }
        if(tipo=="S"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.cidadeImv.value = "";
            document.form_headergeral.bairroImv.value = "";
        }else if(tipo=="C"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.cidadeImv.value = valor;
        }else if(tipo=="B"){
            document.form_headergeral.situacaoImv.value = situacao;
            document.form_headergeral.bairroImv.value = valor;
        }
        document.getElementById('form_headergeral').action = 'map-busca-imoveis/'+redir+'/';
        document.getElementById('form_headergeral').submit();
    }

    function js_ValidaPropostaForm(form){
        if(document.form_imvgeralProposta.formPropostaSituacao.value==" "){
            alert("Selecione a opção para a proposta");
            document.form_imvgeralProposta.formPropostaSituacao.focus();
            return false;
        }
        if(document.form_imvgeralProposta.formPropostaValor.value=="" || parseInt(document.form_imvgeralProposta.formPropostaValor.value=="0")){
            alert("Informe um valor");
            document.form_imvgeralProposta.formPropostaValor.focus();
            return false;
        }
        if(document.form_imvgeralProposta.formPropostaMensagem.value==""){
            alert("Justifique a sua proposta");
            document.form_imvgeralProposta.formPropostaMensagem.focus();
            return false;
        }
        if(document.form_imvgeralProposta.formPropostaNome.value==""){
            alert("Informe o Nome");
            document.form_imvgeralProposta.formPropostaNome.focus();
            return false;
        }
        if(document.form_imvgeralProposta.formPropostaEmail.value==""){
            alert("Informe o Email");
            document.form_imvgeralProposta.formPropostaEmail.focus();
            return false;
        }
        if(validacaoEmail(document.form_imvgeralProposta.formPropostaEmail)==false){
            alert("Email Inválido");
            return false;
        }
        if(document.form_imvgeralProposta.formPropostaFone.value==""){
            alert("Informe o Telefone");
            document.form_imvgeralProposta.formPropostaFone.focus();
            return false;
        }
        var v = grecaptcha.getResponse(1);
        if(v.length == 0){
            alert("Você não pode deixar o captcha vazio [1]");
            return false;
        }
        document.form_imvgeral.formInfoImovelEmail.value = "";
        document.getElementById("propostaModal").style.display = "none";
        document.getElementById("idPropostaModalMsg").click();

        sForm1 = $('#form_imvgeralProposta').serialize();
        sForm2 = $("[name='imvSelect']").serialize();
        sForm = sForm1+"&"+sForm2;
        var sFile   = 'ajaxsendmail.php';
        {literal}$.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaPropostaForm(data);}}){/literal};
    }

    function js_retornoValidaPropostaForm(retorno){
        msg = retorno.split("|");
        alert(msg[0]);
        js_ImovelView(msg[1],msg[2]);
    }

    function js_CorretorView(code,nomeseo){
        url = 'corretor/'+code+'/'+js_GeraNomeSeo(nomeseo)+'/';
        location.href = url;
    }

    function js_LimpaFiltro(base,code,name){
        location.href = base+'corretor/'+code+'/'+js_GeraNomeSeo(name);
    }

    function js_BuscaGridCorretor(base,code,name){
        document.form_imvgeral.paginationId.value = 0;
        a = $("input:not(.exclude)").serialize()+"&";
        b = $("select:not(.exclude)").serialize();
        url = base+'corretor/'+code+'/'+js_GeraNomeSeo(name)+'/'+a+b;
        location.href = url;
    }

    function js_PaginationCorretor(pg,base,code,name){
        document.form_imvgeral.paginationId.value = pg;
        a = $("input:not(.exclude)").serialize()+"&";
        b = $("select:not(.exclude)").serialize();
        url = base+'corretor/'+code+'/'+js_GeraNomeSeo(name)+'/'+a+b;
        location.href = url;
    }

    function js_ValidaCorretorForm(form){
        if(document.form_imvgeral.formCorretorAssunto.value==""){
            alert("Informe como quer ser contatado");
            document.form_imvgeral.formCorretorAssunto.focus();
            js_RolaTela("#formCorretorAssunto");
            return false;
        }
        if(document.form_imvgeral.formCorretorNome.value==""){
            alert("Informe o Nome Completo");
            document.form_imvgeral.formCorretorNome.focus();
            js_RolaTela("#formCorretorNome");
            return false;
        }
        if(document.form_imvgeral.formCorretorEmail.value==""){
            alert("Informe o Email");
            document.form_imvgeral.formCorretorEmail.focus();
            js_RolaTela("#formCorretorEmail");
            return false;
        }
        if(validacaoEmail(document.form_imvgeral.formCorretorEmail)==false){
            alert("Email Inválido");
            js_RolaTela("#formCorretorEmail");
            return false;
        }
        if(document.form_imvgeral.formCorretorFone.value==""){
            alert("Informe o Telefone");
            document.form_imvgeral.formCorretorFone.focus();
            js_RolaTela("#formCorretorFone");
            return false;
        }
        if(document.form_imvgeral.formCorretorMensagem.value==""){
            alert("Informe a Mensagem");
            document.form_imvgeral.formCorretorMensagem.focus();
            js_RolaTela("#formCorretorMensagem");
            return false;
        }
        var v = grecaptcha.getResponse();
        if(v.length == 0){
            alert("Você não pode deixar o captcha vazio");
            return false;
        }
        document.getElementById("idCorretorModal").click();

        sForm1 = $('#form_imvgeral').serialize();
        sForm2 = $("[name='imvCorretor']").serialize();
        sForm = sForm1+"&"+sForm2;
        var sFile   = 'ajaxsendmail.php';
        {literal}$.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaCorretorForm(data);}}){/literal};
    }

    function js_retornoValidaCorretorForm(retorno){
        msg = retorno.split("|");
        alert(msg[0]);
        js_CorretorView(msg[1],msg[2]);
    }  

    HSCore.components.HSDropzone.init('.js-dropzone', {
        url: 'ajaxsendmail.php',
        paramName: 'imageFile',
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 10,
        maxFiles: 10,
        maxFilesize: 2, //MB
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictInvalidFileType: 'Tipo de arquivo não permitido. Use somente imagens!',
        dictFileTooBig: '{literal}Arquivo muito grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MiB.{/literal}',
        dictRemoveFile: 'Remover',
        dictMaxFilesExceeded: "{literal}Limite de {{maxFiles}} arquivos excedido. Removendo arquivo!{/literal}",
        init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit-all").addEventListener("click", function(e) {

            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            if(document.form_imvgeral.formAnuncioNome.value==""){
            alert("Informe o nome completo");
            js_RolaTela("#formAnuncioNome");
            document.form_imvgeral.formAnuncioNome.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioFone.value==""){
            alert("Informe o Telefone");
            js_RolaTela("#formAnuncioFone");
            document.form_imvgeral.formAnuncioFone.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioEmail.value==""){
            alert("Informe o Email");
            js_RolaTela("#formAnuncioEmail");
            document.form_imvgeral.formAnuncioEmail.focus();
            return false;
            }
            if(validacaoEmail(document.form_imvgeral.formAnuncioEmail)==false){
            alert("Email Inválido");
            js_RolaTela("#formAnuncioEmail");
            document.form_imvgeral.formAnuncioEmail.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioSituacao.value==""){
            alert("Informe a finalidade");
            js_RolaTela("#formAnuncioSituacao");
            document.form_imvgeral.formAnuncioSituacao.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioSituacao.value=="L"){
            if(document.form_imvgeral.formAnuncioLocacao.value=="" || parseInt(document.form_imvgeral.formAnuncioLocacao.value)=="0"){
                alert("Informe o Valor do aluguel");
                js_RolaTela("#formAnuncioLocacao");
                document.form_imvgeral.formAnuncioLocacao.focus();
                return false;
            }
            }else if(document.form_imvgeral.formAnuncioSituacao.value=="V"){
            if(document.form_imvgeral.formAnuncioVenda.value=="" || parseInt(document.form_imvgeral.formAnuncioVenda.value)=="0"){
                alert("Informe o Valor para venda");
                js_RolaTela("#formAnuncioVenda");
                document.form_imvgeral.formAnuncioVenda.focus();
                return false;
            }
            }else if(document.form_imvgeral.formAnuncioSituacao.value=="LV"){
            if(document.form_imvgeral.formAnuncioLocacao.value=="" || parseInt(document.form_imvgeral.formAnuncioLocacao.value)=="0"){
                alert("Informe o Valor do aluguel");
                js_RolaTela("#formAnuncioLocacao");
                document.form_imvgeral.formAnuncioLocacao.focus();
                return false;
            }
            if(document.form_imvgeral.formAnuncioVenda.value=="" || parseInt(document.form_imvgeral.formAnuncioVenda.value)=="0"){
                alert("Informe o Valor para venda");
                js_RolaTela("#formAnuncioVenda");
                document.form_imvgeral.formAnuncioVenda.focus();
                return false;
            }
            }

            if(document.form_imvgeral.formAnuncioEndereco.value==""){
            alert("Informe o endereço");
            js_RolaTela("#formAnuncioEndereco");
            document.form_imvgeral.formAnuncioEndereco.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioBairro.value==""){
            alert("Informe o bairro");
            js_RolaTela("#formAnuncioBairro");
            document.form_imvgeral.formAnuncioBairro.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioCidade.value==""){
            alert("Informe a cidade");
            js_RolaTela("#formAnuncioCidade");
            document.form_imvgeral.formAnuncioCidade.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioCep.value==""){
            alert("Informe o CEP");
            js_RolaTela("#formAnuncioCep");
            document.form_imvgeral.formAnuncioCep.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioQuarto.value==""){
            alert("Informe a quantidade de quartos");
            js_RolaTela("#formAnuncioQuarto");
            document.form_imvgeral.formAnuncioQuarto.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioBanheiro.value==""){
            alert("Informe a quantidade de banheiros");
            js_RolaTela("#formAnuncioBanheiro");
            document.form_imvgeral.formAnuncioBanheiro.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioVaga.value==""){
            alert("Informe a quantidade de vagas");
            js_RolaTela("#formAnuncioVaga");
            document.form_imvgeral.formAnuncioVaga.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioArea.value=="" || parseInt(document.form_imvgeral.formAnuncioArea.value)=="0"){
            alert("Informe a área");
            js_RolaTela("#formAnuncioArea");
            document.form_imvgeral.formAnuncioArea.focus();
            return false;
            }
            if(document.form_imvgeral.formAnuncioMensagem.value==""){
            alert("Informe a descrição");
            js_RolaTela("#formAnuncioMensagem");
            document.form_imvgeral.formAnuncioMensagem.focus();
            return false;
            }
            if(dzClosure.getAcceptedFiles().length=="0"){
            alert("Informe alguma imagem");
            return false;
            }
            var v = grecaptcha.getResponse();
            if(v.length == 0){
            alert("Você não pode deixar o captcha vazio");
            return false;
            }
            document.getElementById("idModal").click();
            dzClosure.processQueue();

        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("formAnuncioNome", $("#formAnuncioNome").val());
            formData.append("formAnuncioFone", $("#formAnuncioFone").val());
            formData.append("formAnuncioEmail", $("#formAnuncioEmail").val());
            formData.append("formAnuncioTipo", document.form_imvgeral.formAnuncioTipo.value);
            formData.append("formAnuncioSituacao", $("#formAnuncioSituacao").val());
            if($("#formAnuncioSituacao").val()=="L"){
                formData.append("formAnuncioLocacao", $("#formAnuncioLocacao").val());
            }else if($("#formAnuncioSituacao").val()=="V"){
                formData.append("formAnuncioVenda", $("#formAnuncioVenda").val());
            }else if($("#formAnuncioSituacao").val()=="LV"){
                formData.append("formAnuncioLocacao", $("#formAnuncioLocacao").val());
                formData.append("formAnuncioVenda", $("#formAnuncioVenda").val());
            }
            formData.append("formAnuncioEndereco", $("#formAnuncioEndereco").val());
            formData.append("formAnuncioBairro", $("#formAnuncioBairro").val());
            formData.append("formAnuncioCidade", $("#formAnuncioCidade").val());
            formData.append("formAnuncioCep", $("#formAnuncioCep").val());

            formData.append("formAnuncioQuarto", $("#formAnuncioQuarto").val());
            formData.append("formAnuncioBanheiro", $("#formAnuncioBanheiro").val());
            formData.append("formAnuncioVaga", $("#formAnuncioVaga").val());
            formData.append("formAnuncioArea", $("#formAnuncioArea").val());
            formData.append("formAnuncioMensagem", $("#formAnuncioMensagem").val());
            formData.append("g-recaptcha-response", $("#g-recaptcha-response").val());
        });
        this.on('successmultiple', function(files, response) {
            alert(response);
            location.href = "anuncie-seu-imovel/";
        });
        this.on('maxfilesexceeded', function(file) {
            dzClosure.removeFile(file);
        });
        this.on('errormultiple', function(files, response) {
            alert(response);
            dzClosure.removeFile(files[0]);
        });
        this.on("thumbnail", function (file) {
            if (file.height > 5 && file.width > 5) {
            /*alert("Tamanho máximo permitido é X x Y ");
            dzClosure.removeFile(file);*/
            }
        });
        }

    })

    function js_SetaInputValores(valor){
        if(valor=="L"){
            $("#divLocacao").css("display","block");
            $("#divVenda").css("display","none");
        }else if(valor=="V"){
            $("#divLocacao").css("display","none");
            $("#divVenda").css("display","block");
        }else if(valor=="LV"){
            $("#divLocacao").css("display","block");
            $("#divVenda").css("display","block");
        }else if(valor==""){
            $("#divLocacao").css("display","block");
            $("#divVenda").css("display","block");
        }
    }

    function js_ValidaContatoForm(form){
        if(document.form_imvgeral.formContatoNome.value==""){
            alert("Informe o Nome");
            js_RolaTela("#formContatoNome");
            document.form_imvgeral.formContatoNome.focus();
            return false;
        }
        if(document.form_imvgeral.formContatoEmail.value==""){
            alert("Informe o Email");
            js_RolaTela("#formContatoEmail");
            document.form_imvgeral.formContatoEmail.focus();
            return false;
        }
        if(validacaoEmail(document.form_imvgeral.formContatoEmail)==false){
            alert("Email Inválido");
            js_RolaTela("#formContatoEmail");
            document.form_imvgeral.formContatoEmail.focus();
            return false;
        }
        if(document.form_imvgeral.formContatoFone.value==""){
            alert("Informe o Telefone");
            js_RolaTela("#formContatoFone");
            document.form_imvgeral.formContatoFone.focus();
            return false;
        }
        if(document.form_imvgeral.formContatoMensagem.value==""){
            alert("Informe a Mensagem");
            js_RolaTela("#formContatoMensagem");
            document.form_imvgeral.formContatoMensagem.focus();
            return false;
        }
        var v = grecaptcha.getResponse();
        if(v.length == 0){
            alert("Você não pode deixar o captcha vazio");
            return false;
        }
        document.getElementById("idContatoModal").click();

        sForm = $('#form_imvgeral').serialize();
        var sFile   = 'ajaxsendmail.php';
        {literal}$.ajax({type:'post',url:sFile,data:sForm,dataType:'html',success:function(data){js_retornoValidaContatoForm(data);}}){/literal};
    }

    function js_retornoValidaContatoForm(retorno){
        alert(retorno);
        location.href = "contato/";
    }    

    if(document.querySelector('#liveToast')){
        const liveToast = new bootstrap.Toast(document.querySelector('#liveToast'))
        document.querySelector('#liveToastBtn').addEventListener('click', () => liveToast.show())
    }
    
    $(document).on("click", ".compare-1,.compare-2", function (ev){
        ev.preventDefault();        
        idImovel = $(this).data("compare-imovel");        
        if ($(this).hasClass("compare-1-yes")) {
            if(js_CompareUpdate(idImovel, 'D')){
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-1']").removeClass("bg-primary compare-1-yes").addClass("bg-secondary-opacity compare-1-not");
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-2']").removeClass("bg-primary compare-1-yes").addClass("bg-light compare-1-not");
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-2'] > a").removeClass("text-white").addClass("text-dark");
                $("#toast-icon").html('<i class="fa-solid fa-square-minus fa-xl me-2" style="color:black"></i>');
                $("#toast-text-1").html('Imóvel removido');
                $("#toast-text-2").html('da área de comparação');
                $("#toast-text-3").html('<a href="compare/">Clique aqui e compare os imóveis adicionados.</a>');
                $("#liveToastBtn").click();
            }
        } else {
            if(js_CompareUpdate(idImovel, 'A')){
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-1']").removeClass("bg-secondary-opacity compare-1-not").addClass("bg-primary compare-1-yes");
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-2']").removeClass("bg-light compare-1-not").addClass("bg-primary compare-1-yes");
                $("li[data-compare-imovel='" + idImovel +"'][class*='compare-2'] > a").removeClass("text-dark").addClass("text-white");
                $("#toast-icon").html('<i class="fa-solid fa-square-plus fa-xl me-2" style="color:black"></i>');
                $("#toast-text-1").html('Imóvel adicionado');
                $("#toast-text-2").html('para área de comparação');
                $("#toast-text-3").html('<a href="compare/">Clique aqui e compare os imóveis adicionados.</a>');
                $("#liveToastBtn").click();
            }
        }
    });

    function js_CompareUpdate(idImovel, action){
        var struct = window.localStorage.getItem('imobi-compare');
        if (!struct) {
            struct = {
                'imovel_list': []
            };
            window.localStorage.setItem('imobi-compare', JSON.stringify(struct));
        } else {
            struct = JSON.parse(struct);
        }
        if(action == 'A'){
            if(struct.imovel_list.length == 4){
                $("#toast-icon").html('<i class="fa-solid fa-triangle-exclamation fa-xl me-2" style="color:black"></i>');
                $("#toast-text-1").html('Limite de 4 imóveis');
                $("#toast-text-2").html('para comparação já atingido');
                $("#toast-text-3").html('<a href="compare/">Clique aqui e compare os imóveis adicionados.</a>');
                $("#liveToastBtn").click();
                return false;
            }else{
                struct.imovel_list.push(idImovel);
            }
        }else{
            idx = struct.imovel_list.indexOf(idImovel);
            if (idx > -1) {
                struct.imovel_list.splice(idx, 1);
            }            
        }
        window.localStorage.setItem('imobi-compare', JSON.stringify(struct));        
        return true;
    }

    function js_RemoveCompare(idImovel, idx){
        js_CompareUpdate(idImovel, 'D');
        $('.coluna-compare-'+idx).hide();
        var struct = window.localStorage.getItem('imobi-compare');
        if(struct){
            struct = JSON.parse(struct);
            if(struct.imovel_list.length == 0){
                $("#compareLoad").load("compareload.php","idImoveis=0");
            }
        } 
    }

    function js_LoadCompare(idImoveis){
        $("#compareLoad").load("compareload.php","idImoveis="+idImoveis);
    }

    $(document).on("click", ".favorite-1,.favorite-2", function (ev){
        ev.preventDefault();        
        idImovel = $(this).data("favorite-imovel");        
        if ($(this).hasClass("favorite-1-yes")) {
            if(js_FavoriteUpdate(idImovel, 'D')){
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-1']").removeClass("bg-primary favorite-1-yes").addClass("bg-secondary-opacity favorite-1-not");
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-2']").removeClass("bg-primary favorite-1-yes").addClass("bg-light favorite-1-not");                    
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-2'] > a").removeClass("text-white").addClass("text-dark");
                $("#toast-icon").html('<i class="fa-solid fa-square-minus fa-xl me-2" style="color:black"></i>');
                $("#toast-text-1").html('Imóvel removido');
                $("#toast-text-2").html('da área dos favoritos');
                $("#toast-text-3").html('<a href="favoritos/">Clique aqui e veja os imóveis adicionados.</a>');
                $("#liveToastBtn").click();
            }
        } else {
            if(js_FavoriteUpdate(idImovel, 'A')){
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-1']").removeClass("bg-secondary-opacity favorite-1-not").addClass("bg-primary favorite-1-yes");
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-2']").removeClass("bg-light favorite-1-not").addClass("bg-primary favorite-1-yes");
                $("li[data-favorite-imovel='" + idImovel +"'][class*='favorite-2'] > a").removeClass("text-dark").addClass("text-white");
                $("#toast-icon").html('<i class="fa-solid fa-square-plus fa-xl me-2" style="color:black"></i>');
                $("#toast-text-1").html('Imóvel adicionado');
                $("#toast-text-2").html('para área dos favoritos');
                $("#toast-text-3").html('<a href="favoritos/">Clique aqui e veja os imóveis adicionados.</a>');
                $("#liveToastBtn").click();
            }
        }
    });

    function js_FavoriteUpdate(idImovel, action){
        var struct = window.localStorage.getItem('imobi-favorite');
        if (!struct) {
            struct = {
                'imovel_list': []
            };
            window.localStorage.setItem('imobi-favorite', JSON.stringify(struct));
        } else {
            struct = JSON.parse(struct);
        }
        if(action == 'A'){
            struct.imovel_list.push(idImovel);
        }else{
            idx = struct.imovel_list.indexOf(idImovel);
            if (idx > -1) {
                struct.imovel_list.splice(idx, 1);
            }            
        }
        window.localStorage.setItem('imobi-favorite', JSON.stringify(struct));        
        return true;
    }

    function js_RemoveFavorite(idImovel){
        js_FavoriteUpdate(idImovel, 'D');
        $('.favorite-li-'+idImovel).hide();
        var struct = window.localStorage.getItem('imobi-favorite');
        if(struct){
            struct = JSON.parse(struct);
            if(struct.imovel_list.length == 0){
                $("#favoriteLoad").load("favoriteload.php","idImoveis=0");
            }
        } 
    }

    function js_LoadFavorite(idImoveis){
        $("#favoriteLoad").load("favoriteload.php","idImoveis="+idImoveis);
    }

    function js_BuscaGeral(){
        if(document.form_imvgeral.situacaoImv[0].checked == true){
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/locacao/';
        }else if(document.form_imvgeral.situacaoImv[1].checked == true){
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/venda/';
        }else{
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
        }
        document.form_imvgeral.submit();
    }  

    function js_BuscaGeralMap(){
        if(document.form_imvgeral.situacaoImv[0].checked == true){
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/locacao/';
        }else if(document.form_imvgeral.situacaoImv[1].checked == true){
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/venda/';
        }else{
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/geral/';
        }
        document.form_imvgeral.submit();
    }  

    function js_Search(busca){
        if(busca == ""){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvgeral.reset();
            document.form_imvgeral.buscaHero.value = busca;
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
            document.form_imvgeral.submit();
        }
    }

    function js_SearchMap(busca){
        if(busca == ""){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvgeral.reset();
            document.form_imvgeral.buscaHero.value = busca;
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/geral/';
            document.form_imvgeral.submit();
        }
    }

    function js_SearchCity(busca, city){
        if(busca == "" && city == "0"){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvgeral.reset();
            document.form_imvgeral.buscaHero.value = busca;
            document.form_imvgeral.cidadeImv.value = city;
            document.getElementById('form_imvgeral').action = 'grid-busca-imoveis/geral/';
            document.form_imvgeral.submit();
        }
    }

    function js_SearchCityMap(busca, city){
        if(busca == "" && city == "0"){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvgeral.reset();
            document.form_imvgeral.buscaHero.value = busca;
            document.form_imvgeral.cidadeImv.value = city;
            document.getElementById('form_imvgeral').action = 'map-busca-imoveis/geral/';
            document.form_imvgeral.submit();
        }
    }

    function js_SearchMenu(busca){
        if(busca == ""){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvmenu.reset();
            document.form_imvmenu.buscaHero.value = busca;
            document.getElementById('form_imvmenu').action = 'grid-busca-imoveis/geral/';
            document.form_imvmenu.submit();
        }
    }

    function js_SearchMenuMap(busca){
        if(busca == ""){
            event.preventDefault();
            alert("Informe algum termo para pesquisa!");
            return false;
        }else{
            document.form_imvmenu.reset();
            document.form_imvmenu.buscaHero.value = busca;
            document.getElementById('form_imvmenu').action = 'map-busca-imoveis/geral/';
            document.form_imvmenu.submit();
        }
    }


    $("#property-type-imoveldestino").click(function () {
        $("#property-type-alugar").prop('checked', false);
        $("#property-type-comprar").prop('checked', false);
    });

    $("#property-type-alugar, #property-type-comprar").click(function () {
        $("#property-type-imoveldestino").prop('checked', false);
    });

    function js_VerMapa(){
        event.preventDefault();
        $('.div-show-map').show();
        $('.div-show-list').hide();
    }

    function js_VerList(){
        event.preventDefault();
        $('.div-show-map').hide();
        $('.div-show-list').show();
    }

    function js_aceitaCookie(){
        event.preventDefault();
        var sUrl    = 'sAction=TRUE';
        var sFile   = 'ajaxcookie.php';
        {literal}jQuery.ajax({type:'post',url:sFile,data:sUrl,dataType:'html',success:function(data){js_retornoAceitaCookie(data);}}){/literal};
        $('#lgpd-accept').hide();
    }    
    function js_retornoAceitaCookie(retorno){}    

    $('#formInfoImovelFone').mask('(00) 00009-0000');
    $('#formPropostaFone').mask('(00) 00009-0000');
    $('#formCorretorFone').mask('(00) 00009-0000');
    $('#formAnuncioFone').mask('(00) 00009-0000');
    $('#formContatoFone').mask('(00) 00009-0000');
    $('#formAnuncioCep').mask('00000-000');
    $('#codigoImv').mask('0000000000');
    $("#valorMinimo").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#valorMaximo").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});    
    $("#areaImvMin").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#areaImvMax").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#formPropostaValor").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#formAnuncioLocacao").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#formAnuncioVenda").maskMoney({literal}{prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});
    $("#formAnuncioArea").maskMoney({literal}{prefix:'m² ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false}{/literal});

    {if $ACCEPTCOOKIE == false}
        $('#lgpd-accept').css({literal}{"left":"3000px", "display":"flex", "z-index":"999"}{/literal}).animate({literal}{"left":"50%"}{/literal}, 700);
    {/if}

    {if {$FILEATUAL} == "imovelmap.php"}
        (function($) {
            var _latitude = {$CENTERMAPA[0]};
            var _longitude = {$CENTERMAPA[1]};
            createHomepageGoogleMap(_latitude, _longitude);
        })(jQuery);
    {/if}

    </script>

</body>
</html>

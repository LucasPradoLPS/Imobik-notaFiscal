loading = true;

Application = {};
Application.translation = {
    'en' : {
        'loading' : 'Loading',
        'close'   : 'Close',
        'insert'  : 'Insert',
        'open_new_tab' : 'Open on a new tab'
    },
    'pt' : {
        'loading' : 'Carregando',
        'close'   : 'Fechar',
        'insert'  : 'Inserir',
        'open_new_tab' : 'Abrir em uma nova aba'
    },
    'es' : {
        'loading' : 'Cargando',
        'close'   : 'Cerrar',
        'insert'  : 'Insertar',
        'open_new_tab' : 'Abrir en una nueva pestaña'
    }
};

Adianti.onClearDOM = function(){
	/* $(".select2-hidden-accessible").remove(); */
	/* $(".colorpicker-hidden").remove(); */
	$(".pcr-app").remove();
	$(".select2-display-none").remove();
	$(".tooltip.fade").remove();
	$(".select2-drop-mask").remove();
	/* $(".autocomplete-suggestions").remove(); */
	$(".datetimepicker").remove();
	$(".note-popover").remove();
	$(".dtp").remove();
	$("#window-resizer-tooltip").remove();
};


function showLoading() 
{ 
    if(loading)
    {
        try {
            var hasAdianti = (typeof Adianti !== 'undefined' && Adianti !== null);
            var lang = 'pt';
            if (hasAdianti && typeof Adianti.language === 'string' && Application.translation[Adianti.language]) {
                lang = Adianti.language;
            }
            var msg = (Application.translation[lang] && Application.translation[lang]['loading']) ? Application.translation[lang]['loading'] : 'Loading';
            if (typeof __adianti_block_ui === 'function') {
                __adianti_block_ui(msg);
            }
        } catch (e) {
            if (typeof __adianti_block_ui === 'function') {
                __adianti_block_ui('Loading');
            }
        }
    }
}

Adianti.onBeforeLoad = function(url) 
{ 
    if (url.indexOf('&show_loading=false') > 0) {
        return true;
    }

    loading = true; 
    setTimeout(function(){showLoading()}, 400);
    if (url.indexOf('&static=1') == -1) {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }
};

Adianti.onAfterLoad = function(url, data)
{ 
    loading = false; 
    __adianti_unblock_ui( true );
    
    // Fill page tab title with breadcrumb
    // window.document.title  = $('#div_breadcrumbs').text();
};

// set select2 language
$.fn.select2.defaults.set('language', $.fn.select2.amd.require("select2/i18n/pt"));

// Debug global de falhas AJAX (apenas se Adianti.debug == 1)
if (typeof jQuery !== 'undefined') {
    jQuery(document).ajaxError(function(event, jqxhr, settings){
        try {
            if (typeof Adianti !== 'undefined' && Adianti.debug == 1) {
                console.warn('[AJAX FAIL]', settings.url, 'status=', jqxhr.status, 'responseLength=', (jqxhr.responseText||'').length);
                if (jqxhr.responseText && jqxhr.responseText.length < 800) {
                    console.warn('[AJAX BODY]', jqxhr.responseText);
                }
            }
        } catch(e) { /* silencioso */ }
    });
}

// Função utilitária para testar backend manualmente via console
window.__testEndpoint = function(rel){
    var base = window.location.origin;
    var url = base + (rel.startsWith('/')? rel : '/' + rel);
    return fetch(url,{headers:{'Accept':'application/json'}})
        .then(r => r.text().then(t => ({status:r.status, body:t.substring(0,500)})))
        .catch(err => ({error: err.message}));
};

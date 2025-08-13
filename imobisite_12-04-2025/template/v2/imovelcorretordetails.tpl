<style>
.agent-style-1.list-view .entry-wrapper .entry-thumbnail-wrapper {
    width:30%;
}
@media (max-width: 767px) {
    .agent-style-1.list-view .entry-wrapper{
        display: block;
    }
    .agent-style-1.list-view .entry-wrapper .entry-thumbnail-wrapper{
        width:100%;
    }
    .agent-style-1.list-view .entry-wrapper .entry-content-wrapper{
        width:100%;    
    }
}
</style>
<div class="col-12 agent-style-1 list-view agent-details">
    <div class="entry-wrapper bg-white transation-this hover-shadow mb-4">
        {if isset($VIEWCORRETOR->selfie)}
            {$filename = $URLSYSTEM|cat:$VIEWCORRETOR->selfie}
        {else}
            {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
        {/if}
        {$file_headers = get_headers($filename)}
        {if (stripos($file_headers[0],"404 Not Found") > 0  || (stripos($file_headers[0], "302 Found") > 0 && stripos($file_headers[7],"404 Not Found") > 0))}
            {$filename = $URLSYSTEM|cat:$FILENOIMAGE}
        {/if}
        <div class="entry-thumbnail-wrapper transation bg-secondary hover-img-zoom width-photo-agent" style="min-height: 16rem; background-image: url('{$filename}');background-size: cover;background-repeat: no-repeat;background-position: center center;" >
        </div>
        <div class="entry-content-wrapper">
            <div class="entry-header d-flex pb-2">
                <div class="me-auto">
                    <h6 class="agent-name text-dark mb-0"><a href="#">{$VIEWCORRETOR->pessoa|lower|ucwords}</a></h6>
                    {if isset($VIEWCORRETOR->creci)}
                        <span class="text-primary font-fifteen">Creci:&nbsp;&nbsp;{$VIEWCORRETOR->creci}</span>
                    {/if}
                </div>
            </div>
            <div class="enrey-content">
                <ul class="agent-contact py-1">
                    {if $VIEWCORRETOR->fones|trim != ""}
                        <li>
                            <small>
                                <a class="btn-ghost-secondary dz-dropzone" href="tel:{$VIEWCORRETOR->fones}">
                                    <i class="fa-solid fa-phone fa-md"></i>&nbsp;&nbsp;{$VIEWCORRETOR->fones}
                                </a>
                            </small>
                        </li>
                    {/if}
                    {if $VIEWCORRETOR->celular|trim != ""}
                        <li>
                            <small>
                                <a class="btn-ghost-secondary dz-dropzone" href="https://api.whatsapp.com/send?phone=+55{$VIEWCORRETOR->celular}&text=Ol%C3%A1">
                                    <i class="fa-brands fa-whatsapp fa-md"></i>&nbsp;&nbsp;{$VIEWCORRETOR->celular}
                                </a>
                            </small>
                        </li>
                    {/if}
                    {if $VIEWCORRETOR->email|trim != ""}
                        <li>
                            <small>
                                <a class="btn-ghost-secondary dz-dropzone" href="mailto:{$VIEWCORRETOR->email}">
                                    <i class="fa-solid fa-envelope fa-md"></i>&nbsp;&nbsp;{$VIEWCORRETOR->email}
                                </a>
                            </small>
                        </li>
                    {/if}                                        
                </ul>
                <br>
                Compartilhar:
                <div class="social-media">
                    <input type="hidden" id="url_copy" value="{$URLATUAL}">                
                    <a title="Facebook" href="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u={$URLSITE}{$URLSEO}%2F&amp;src=sdkpreparse')"><i class="fab fa-facebook-f fa-xl"></i></a>
                    <a title="Whatsapp" href="javascript:window.open('https://api.whatsapp.com/send?text={$VIEWCORRETOR->pessoa} {$URLSITE}{$URLSEO}')"><i class="fab fa-whatsapp fa-xl"></i></a>
                    <a title="Twitter" href="javascript:js_AbreTwitterCorretor()"><i class="fab fa-twitter fa-xl"></i></a>
                    <a title="Copiar URL" href="javascript:js_ButtonShare()"><i class="fa-solid fa-copy fa-xl"></i></a>
                </div>
            </div>
            <br><br>
            <div class="entry-footer d-flex align-items-center post-meta py-2 border-top">
                {$VIEWCORRETOR->cidade}
            </div>
        </div>
    </div>
</div>

<script>
function js_AbreTwitterCorretor(){

  sText = encodeURI("{$VIEWCORRETOR->pessoa} - {$CONFIG->nomefantasia}");
  sUrl  = encodeURI("{$URLSITE}{$URLSEO}");
  window.open("https://twitter.com/intent/tweet?url="+sUrl+"&text="+sText);

}

function js_ButtonShare(){

  copyToClipboard("{$URLSITE}{$URLSEO}");
  $("#liveToastBtn").click();

}

</script>

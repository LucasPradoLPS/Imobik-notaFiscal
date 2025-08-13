{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
<div class="full-row bg-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="text-secondary">Sobre nós</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="home/">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Sobre nós</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="full-row pb-0 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="">
                    <span class="tagline-2 text-primary">"</span>
                    {$SITE->about}
                </div>
                <br>
            </div>
            <div class="col-lg-6">
                <div class="card card-bordered">
                    <div class="card-body">
                    <div class="mb-5 text-center">
                        <h3>Fique sempre à frente de seu tempo. Entre em contato com a gente.</h3>
                    </div>
                    <div class="d-grid mb-5 text-center">
                        <a class="text-center" target="_blank" href="https://api.whatsapp.com/send?phone=+55{$SITE->whatsapp}&text=Ol%C3%A1">
                        <i class="fa-brands fa-whatsapp text-primary" style="font-size:50px;"></i>
                        </a>
                    </div>
                    <img class="card-img-bottom" src="assets/v1/img/illustrations/chat.png" alt="Image Description">
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
<div class="full-row pb-0 bg-secondary">
    <div class="container">
        <div class="row">
            {include file="indexgridtestemunho3.tpl"}
        </div>
    </div>
</div>
{include file="footer.tpl"}
{include file="scripts.tpl"}
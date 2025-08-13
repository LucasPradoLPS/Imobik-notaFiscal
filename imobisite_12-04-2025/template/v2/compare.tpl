{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
<div class="full-row bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="text-secondary">Compare Imóveis</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="home/">Home</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">Compare Imóveis</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="full-row bg-light pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 table-responsive" id="compareLoad">

            </div>
        </div>
    </div>
</div>
{include file="footer.tpl"}
{include file="scripts.tpl"}
<script>
    var struct = window.localStorage.getItem('imobi-compare');
    if (!struct) {
        struct = {
            'imovel_list': []
        };
        window.localStorage.setItem('imobi-compare', JSON.stringify(struct));
    } else {
        struct = JSON.parse(struct);
    }
    js_LoadCompare(struct.imovel_list);
</script>

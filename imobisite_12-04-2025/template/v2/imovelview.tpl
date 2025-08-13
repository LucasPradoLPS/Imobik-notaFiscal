{include file="header.tpl"}
{include file="$HEADERTEMPLATE/headertemplate2.tpl"}
    {include file="imovelviewimg.tpl"}
    <div class="full-row pt-30 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 order-xl-1">
                    {include file="imovelviewhead.tpl"}
                    {include file="imovelviewdetails.tpl"}
                    {include file="imovelviewmap.tpl"}
                    {include file="imovelviewmidia.tpl"}
                    {include file="imovelviewagent.tpl"}
                </div>
                <div class="col-xl-4 order-xl-2">
   		    <form name="form_imvgeral" id="form_imvgeral" method="GET">
                        {include file="imovelviewcontact.tpl"}
		    </form>                    
                    {include file="imovelrecent.tpl"}
                </div>
            </div>
        </div>
    </div>
    {include file="imovelviewsimilar.tpl"}
    <form name="form_imvgeralProposta" id="form_imvgeralProposta" method="GET">    
     	{include file="imovelviewproposta.tpl"}
    </form> 
{include file="footer.tpl"}
{include file="scripts.tpl"}

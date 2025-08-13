<style>
.div-show-list{
    display: block;
}
.div-show-map{
    display: block;
}
.show-button-list{
    display: none;
    position: absolute; 
    bottom: 30px;
    left: 30px;
}
.show-button-map{
    display: none;
}
@media screen and (max-width: 767px) {
    .show-button-list{
        display: block;
    }
    .show-button-map{
        display: block;
    }
    .div-show-map{
        display: none;
    }    
}
</style>
<div class="full-row p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 ps-0 div-show-map">
                <div id="map-banner">
                    <div class="homepage-map">
                        <div id="map" style="height: calc(100vh - 150px);"></div>
                        <input type="hidden" name="fileLocations" id="fileLocations" value="{$FILEMAPA}">                                
                    </div>
                    <div class="show-button-list">
                        <button class="w-100 btn btn-primary btn-transition" onclick="js_VerList();">Ver Lista</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7 div-show-list">
                <div class="overflow-auto map-view-grid px-0 pb-4" style="height: calc(100vh - 150px);">
                    <div class="row">
                        <div class="col">
                            {include file="filtersearchmap.tpl"}
                        </div>
                    </div>
                    <div class="row row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-1 g-2">
                        {include file="imovelmapitems.tpl"}
                    </div>
                    <div class="row">
                        <div class="col mt-5">
                            {include file="footernap.tpl"}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

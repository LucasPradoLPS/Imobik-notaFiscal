var mapStyles = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#46bcec"
            },
            {
                "visibility": "on"
            }
        ]
    }
];

$.ajaxSetup({
    cache: true
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Google Map - Homepage
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function createHomepageGoogleMap(_latitude, _longitude){

    /* setMapHeight(); */
    if( document.getElementById('map') != null ){
        $.getScript( document.getElementById('fileLocations').value , function(){
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                scrollwheel: true,
                center: new google.maps.LatLng(_latitude, _longitude),
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                //styles: mapStyles
            });
            var i;
            var newMarkers = [];
            for (i = 0; i < locations.length; i++) {
                var pictureLabel = document.createElement("img");
                pictureLabel.src = locations[i][7];
                var boxText = document.createElement("div");
                infoboxOptions = {
                    content: boxText,
                    disableAutoPan: false,
                    //maxWidth: 210,
                    pixelOffset: new google.maps.Size(-100, 0),
                    zIndex: null,
                    alignBottom: true,
                    boxClass: "infobox-wrapper",
                    enableEventPropagation: true,
                    closeBoxMargin: "0px 0px -8px 0px",
                    closeBoxURL: "assets/v2/images/map/close.png",
                    infoBoxClearance: new google.maps.Size(1, 1)
                };
                var marker = new MarkerWithLabel({
                    title: locations[i][2],
                    position: new google.maps.LatLng(locations[i][3], locations[i][4]),
                    map: map,
                    icon: 'assets/v2/images/map/marker.png',
                    labelContent: pictureLabel,
                    labelAnchor: new google.maps.Point(50, 0),
                    labelClass: "marker-style",
                    id: locations[i][8]
                });
                newMarkers.push(marker);
                boxText.innerHTML =
                    '<div class="property-grid-1 property-block transation-this" style="width:200px;">' +
                        '<a href="'+locations[i][5]+'">' +                    
						    '<div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom m-2" style="min-height: 7rem; background-image: url('+ locations[i][6] +');background-size: cover;background-repeat: no-repeat;background-position: center center;">' +
						    '</div>' +
                        '</a>' +                        
						'<div class="property_text p-3">'+
                            '<span class="d-inline-block text-primary">'+ locations[i][9] +'</span>'+
                            '<h6 class="mt-0"><a class="font-600 text-secondary" href="'+locations[i][5]+'">' + locations[i][0] + '</a></h6>'+
							'<span class="my-0 d-block">' + locations[i][1] + '</span>'+
                            '<h6 class="mt-0 text-primary" style="font-size:16px;">' + locations[i][2] + '</h6>'+
						'</div>'+
                    '</div>';
                //Define the infobox
                newMarkers[i].infobox = new InfoBox(infoboxOptions);
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        for (h = 0; h < newMarkers.length; h++) {
                            newMarkers[h].infobox.close();
                        }
                        newMarkers[i].infobox.open(map, this);
                    }
                })(marker, i));

            }
            var clusterStyles = [
                {
                    url: 'assets/v2/images/map/marker.png',
                    height: 50,
                    width: 50
                }
            ];
            var markerCluster = new MarkerClusterer(map, newMarkers, {styles: clusterStyles, maxZoom: 15});
            $('body').addClass('loaded');
            setTimeout(function() {
                $('body').removeClass('has-fullscreen-map');
            }, 1000);
            $('#map').removeClass('fade-map');

            //  Dynamically show/hide markers --------------------------------------------------------------
            
            google.maps.event.addListener(map, 'idle', function() {

                totalItems = 0;
                for (var i=0; i < locations.length; i++) {
                    if ( map.getBounds().contains(newMarkers[i].getPosition()) ){
                        $('#mapItem'+newMarkers[i].id).show();
                        //newMarkers[i].setVisible(true); // <- Uncomment this line to use dynamic displaying of markers

                        //newMarkers[i].setMap(map);
                        //markerCluster.setMap(map);
                    } else {
                        $('#mapItem'+newMarkers[i].id).hide();
                        totalItems--;                        
                        //newMarkers[i].setVisible(false); // <- Uncomment this line to use dynamic displaying of markers

                        //newMarkers[i].setMap(null);
                        //markerCluster.setMap(null);
                    }
                }
                $('#mapItemsSearch').html(parseInt($('#mapTotalSearch').html()) + totalItems);

                if ( (parseInt($('#mapTotalSearch').html()) + totalItems) == 0) {
                    nothingHTML =
                    '<div class="container content-space-b-2">'+
                        '<div class="text-center" style="padding-top: 2.5rem !important;padding-bottom: 2.5rem !important;background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">'+
                            '<div class="mb-5">'+
                                '<h2>Ops...não achamos nada por aqui.</h2>'+
                                '<p>Redefina os filtros utilizados para encontrar o que você precisa.</p>'+
                            '</div>'+
                        '</div>'+
                     '</div>';
                     $('.data-nothing').html(nothingHTML);
                } else {
                    $('.data-nothing').html("");
                }
            });

            // Function which set marker to the user position
            function success(position) {
                var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.panTo(center);
                $('#map').removeClass('fade-map');
            }

        }).done(function() {
            var sUrl  = 'sRmvFl='+document.getElementById('fileLocations').value;
            var sFile = 'ajaxcookie.php';
            jQuery.ajax({type:'post',url:sFile,data:sUrl,dataType:'html',success:function(data){ }});
            document.getElementById('fileLocations').value = "";
        });
        // Enable Geo Location on button click
        $('.geo-location').on("click", function() {
            if (navigator.geolocation) {
                $('#map').addClass('fade-map');
                navigator.geolocation.getCurrentPosition(success);
            } else {
                error('Geo Location is not supported');
            }
        });
    }
}



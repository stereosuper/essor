var $ = require('jquery');
var mapboxgl = require('mapbox-gl');


module.exports = function(slider){

    if( !$('#map').length ) return;

    var map, icon, layers = [],
        initialCenter = [2.5377, 46.718],   // Centre de la France (ça dépend) https://fr.wikipedia.org/wiki/Centre_de_la_France
        initialZoom = 5;


    var init = function(){

        mapboxgl.accessToken = 'pk.eyJ1Ijoic3RlcmVvc3VwZXIiLCJhIjoiY2lyM2JnMDIwMDAxM2k0bWNndmUzeTFhbSJ9.UZ-XuPASxGVtYFSqdVyppg';

        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/stereosuper/cj5ksn2tg1v3p2splo1o3fymc',
            center: initialCenter,
            zoom: initialZoom
        });

        // Disable zoom on scroll
        map.scrollZoom.disable();

        // Add zoom and rotation controls to the map.
        map.addControl(new mapboxgl.NavigationControl());

        // Load l'icône pour les marqueurs
        loadMarkerIcon();

        // Affiche les marqueurs sur la carte
        map.on('load', setMarkers);
    }


    var loadMarkerIcon = function() {

        icon = new Image();

        icon.setAttribute('src', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAArCAYAAABvhzi8AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OTRGRTEyRjk4NzREMTFFN0I4QTdCNTcwRDY0Q0I5ODYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OTRGRTEyRkE4NzREMTFFN0I4QTdCNTcwRDY0Q0I5ODYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo5NEZFMTJGNzg3NEQxMUU3QjhBN0I1NzBENjRDQjk4NiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo5NEZFMTJGODg3NEQxMUU3QjhBN0I1NzBENjRDQjk4NiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv5SZjYAAAIpSURBVHja7JY7SFxREIbvXo34IoI2QiT4BN8gyDYpglUEnwTsgl3AlFEEcVV8opUS0qaMYAqRuFgpaqE2Bi00Ygo3IRaCWviOorD5R2ZhPc6592YthHAGPvYyZ87898w5c+769hqzLQ+WCmpAFagANCkNhMEx+AnWwQKYARduCX0uws9BB2gGKZY3OwOfwTD4rQuyNf540AW2wbt/EI1Up4Xn0kvHeRVOB3NgACRZsVsSr3qWczoK074tgpcuSf+AHRACly6xVbz3GTphKskXUKZJcAi6QSFIBvkgj1dWCvrAkWZuOfgKEiThIfBKM/ETKACD4Icw/h30csy4JscLjrkjTG/cpplA/rcOq1Gr8oYPpmTtoCRauIdPsmofwGgMB4uq91HTLd2RPs7E764gHOL9vI7xVCeCLZCj+G9AFq24SbPafo1oHZgHpww91wpxdNpHNKt+bWta5wpMCn46XNPcIqkMPQd5TLUJznWvxUi4SBhY5qsv2mhVAYfSBrga0XYC1oTYYhJ+Jgz8EnytHvb1veDbFXy3e5wmDBwIvkoPwlLMvuB7agsltR5wR/s0p1u1c5ubXrUCwffNg/Cq4MuVKkrCm8KAHzxRfGMehMeEyvmFuA0SXhIG6EtSrfiCfCM53VZBxdfILafaCglPObSHumd0BzfwZy5i9Fwv3M+Uu1OTe8rn8T+XZGGHA+VqtvVIZoSNsBE2wkbYCBthI2yE/2PhvwIMAMoPYfo8MwxQAAAAAElFTkSuQmCC');

        icon.onload = function() {
            map.addImage('essor-icon', icon);
        }
    }


    var setMarkers = function() {

        var features = window.wp.essor_places;
        var layer = {
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': features,
            }
        };

        // Ajoute les marqueurs à la map
        map.addSource('implantations', layer);

        // Ajoute le layer affichant tous les points
        var layerId = 'layer---all--';
        layers.push(layerId);
        map.addLayer({
            "id": layerId,
            "type": "symbol",
            "source": "implantations",
            "layout": {
                "icon-image": "essor-icon",
                "icon-allow-overlap": true,
                'icon-offset': [-15, -40]
            },
            "visibility": "visible",
        });
        handleMarkerClick(layerId);

        // Ajoute les layers de marqueurs filtrés par métiers
        for (var idx in features) {
            if (features.hasOwnProperty(idx)) {
                var feature = features[idx];
                var metiers = feature.properties.metiers;
                if (metiers) {
                    for (var idx in metiers) {
                        if( metiers.hasOwnProperty( idx ) ) {
                            var metier = metiers[idx];
                            if (!map.getLayer('layer-'+metier)) {
                                layerId = 'layer-'+metier;
                                layers.push(layerId);
                                map.addLayer({
                                    "id": layerId,
                                    "type": "symbol",
                                    "source": "implantations",
                                    "layout": {
                                        "icon-image": "essor-icon",
                                        "icon-allow-overlap": true
                                    },
                                    "visibility": "none",
                                    "filter": ["has", metier]
                                });
                                handleMarkerClick(layerId);
                            }
                        }
                    }
                }
            }
        }

        // Filtre une première fois la map
        filterMap();
    }


    var handleMarkerClick = function(layerId) {
        // Gère le click sur les marqueurs du layer
        map.on('click', layerId, function(e){
            new mapboxgl.Popup()
            .setLngLat(e.features[0].geometry.coordinates)
            .setHTML(
                '<h2>' + e.features[0].properties.name + '</h2>' +
                '<span>' +
                e.features[0].properties.address_l1 +
                '</span><span>' +
                e.features[0].properties.address_l2 +
                '</span>' +
                '<span>' +
                e.features[0].properties.phone +
                '</span>' +
                e.features[0].properties.email
            )
            .addTo(map);
        }).on('mouseenter', layerId, function(){
            map.getCanvas().style.cursor = 'pointer';
        }).on('mouseleave', layerId, function(){
            map.getCanvas().style.cursor = '';
        });
    }


    var filterMap = function() {
        // Récupère la sélection
        var $select = $('#map-filter');
        var selectedValue = $select.find('.active').data('value');

        // Applique le filtre
        for (var idx in layers) {
            if (layers.hasOwnProperty(idx)) {
                var layerId = layers[idx];
                map.setLayoutProperty(layerId, 'visibility', (layerId == 'layer-'+selectedValue) ? 'visible' : 'none');
            }
        }
    }


    init();
}

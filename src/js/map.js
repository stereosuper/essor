var $ = require('jquery');
var mapboxgl = require('mapbox-gl');

module.exports = function(slider){

    var map,
        icon,
        layers = [],
        initialCenter = [2.5377, 46.718],   // Centre de la France (ça dépend) https://fr.wikipedia.org/wiki/Centre_de_la_France
        initialZoom = 3                     // $(window).width() > 1200 ? 6 : 5
        ;

    var init = function() {

        // Crée la map
        mapboxgl.accessToken = 'pk.eyJ1Ijoic3RlcmVvc3VwZXIiLCJhIjoiY2lyM2JnMDIwMDAxM2k0bWNndmUzeTFhbSJ9.UZ-XuPASxGVtYFSqdVyppg';

        map = new mapboxgl.Map({
            container: 'map',
            style:  'mapbox://styles/stereosuper/cj5ksn2tg1v3p2splo1o3fymc',
            center: initialCenter,
            zoom: initialZoom
        });

        // Load l'icône pour les marqueurs
        loadMarkerIcon();

        // Affiche les marqueurs sur la carte
        map.on('load', setMarkers);

        // S'intéresse au select des filtres par métier
        $('#map-filter').change(filterMap);
    }

    var loadMarkerIcon = function() {

        icon = new Image();

        icon.setAttribute('src', 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8cGF0aCBkPSJNMjU2LDBDMTY3LjY0MSwwLDk2LDcxLjYyNSw5NiwxNjBjMCwyNC43NSw1LjYyNSw0OC4yMTksMTUuNjcyLDY5LjEyNUMxMTIuMjM0LDIzMC4zMTMsMjU2LDUxMiwyNTYsNTEybDE0Mi41OTQtMjc5LjM3NSAgIEM0MDkuNzE5LDIxMC44NDQsNDE2LDE4Ni4xNTYsNDE2LDE2MEM0MTYsNzEuNjI1LDM0NC4zNzUsMCwyNTYsMHogTTI1NiwyNTZjLTUzLjAxNiwwLTk2LTQzLTk2LTk2czQyLjk4NC05Niw5Ni05NiAgIGM1MywwLDk2LDQzLDk2LDk2UzMwOSwyNTYsMjU2LDI1NnoiIGZpbGw9IiNGRkRBNDQiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K');

        icon.onload = function() {
            map.addImage('essor-icon', icon, {width: 32, height: 32});
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
            }
            ;

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
                    "icon-allow-overlap": true
                },
                "visibility": "visible",
            });

        // Ajoute les layers de marqueurs filtrés par métiers
        features.forEach(function(feature) {
            var metiers = feature.properties.metiers;
            if (metiers) {
                for (var idx in metiers) {
                    if( metiers.hasOwnProperty( idx ) ) {
                        var metier = metiers[idx];
                        if (!map.getLayer(metier)) {
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
                        }
                    }
                }
            }
        });

        // Gère le click sur les marqueurs
        map.on('click', 'implantations', function (e) {
            new mapboxgl.Popup()
                .setLngLat(e.features[0].geometry.coordinates)
                .setHTML(
                    '<h2>' + e.features[0].properties.name + '</h2>' +
                    '<ul class="address">' +
                        '<li class="address">' +
                            '<div class="address-l1">' +
                                e.features[0].properties.address_l1 +
                            '</div>' +
                            '<div class=address-l2"">' +
                                e.features[0].properties.address_l2 +
                            '</div>' +
                        '</li>' +
                        '<li class="phone">' +
                            e.features[0].properties.phone +
                        '</li>' +
                        '<li class="email">' +
                            e.features[0].properties.email +
                        '</li>' +
                    '</ul>'
                )
                .addTo(map);
        });
    }

    var filterMap = function(e) {
        var $select = $(this);
        var selected_value = $select.val();
        for (var idx in layers) {
            if (layers.hasOwnProperty(idx)) {
                var layerId = layers[idx];
                map.setLayoutProperty(layerId, 'visibility', (layerId == 'layer-'+selected_value) ? 'visible' : 'none');
            }
        }
    }

    init();
}

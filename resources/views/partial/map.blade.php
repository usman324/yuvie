<script>
    var map;
    $(document).ready(function() {
        (
             map = new GMaps({
                div: "#gmaps-markers",
                lat: @json(isset($lat) ? $lat : 0),
                lng: @json(isset($lng) ? $lng : 0),
            })).addMarker({
                lat: @json(isset($lat) ? $lat : 0),
                lng: @json(isset($lng) ? $lng : 0),
                title: "Lima",
                details: {
                    database_id: 42,
                    author: "HPNeo"
                },
                click: function(a) {
                    console.log && console.log(a)
                }
            }), (
                map = new GMaps({
                    div: "#gmaps-overlay",
                    lat: @json(isset($lat) ? $lat : 0),
                    lng: @json(isset($lng) ? $lng : 0),
                })).drawOverlay({
                lat: map.getCenter().lat(),
                lng: map.getCenter().lng(),
                content: '<div class="gmaps-overlay">Lima<div class="gmaps-overlay_arrow above"></div></div>',
                verticalAlign: "top",
                horizontalAlign: "center"
            }),
            map = GMaps.createPanorama({
                el: "#panorama",
                lat: @json(isset($lat) ? $lat : 0),
                lng: @json(isset($lng) ? $lng : 0),
            }), (
                map = new GMaps({
                    div: "#gmaps-types",
                    lat: @json(isset($lat) ? $lat : 0),
                    lng: @json(isset($lng) ? $lng : 0),
                    mapTypeControlOptions: {
                        mapTypeIds: ["hybrid", "roadmap", "satellite", "terrain", "osm"]
                    }
                })).addMapType("osm", {
                getTileUrl: function(a, e) {
                    return "https://a.tile.openstreetmap.org/" + e + "/" + a.x + "/" + a.y + ".png"
                },
                tileSize: new google.maps.Size(256, 256),
                name: "OpenStreetMap",
                maxZoom: 18
            }), map.setMapTypeId("osm")
    });
</script>

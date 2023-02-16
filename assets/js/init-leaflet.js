( function() {
    // variables
    const mapContainerId = wonkode_leaflet_args.map_container_id;
    const loc_lat = ( ! isNaN( wonkode_leaflet_args.loc_lat ) ) ? parseFloat( wonkode_leaflet_args.loc_lat ) : 0;
    const loc_long = ( ! isNaN( wonkode_leaflet_args.loc_long ) ) ? parseFloat( wonkode_leaflet_args.loc_long ) : 0;
    const zoom_level = ( ! isNaN( wonkode_leaflet_args.zoom_level ) && ( parseInt( wonkode_leaflet_args.zoom_level ) >= 1 && parseInt( wonkode_leaflet_args.zoom_level ) <= 22 ) ) ? parseInt( wonkode_leaflet_args.zoom_level ) : 12;
    const tile_max_zoom = ( ! isNaN( wonkode_leaflet_args.tile_max_zoom ) && ( parseInt( wonkode_leaflet_args.tile_max_zoom ) >= 1 && parseInt( wonkode_leaflet_args.tile_max_zoom ) <= 22 ) ) ? parseInt( wonkode_leaflet_args.tile_max_zoom ) : 18;

    const mapContainer = document.getElementById( mapContainerId );
    mapContainer.style.height = '600px';

    // initialize Leaflet map
    if ( loc_lat > 0 && loc_long > 0 ) {
        var map = L.map( mapContainerId ).setView( [loc_lat, loc_long], zoom_level );

        // add tile layer to add to our map
        L.tileLayer( 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: tile_max_zoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        } ).addTo( map );
    } else {
        console.log( "loc_lat and loc_long are not proper latitude and longitude values" );
    }
    
} )();
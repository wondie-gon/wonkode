( function() {
    // variables
    const mapContainerId = wonkode_leaflet_args.map_container_id;
    const loc_lat = ( ! isNaN( wonkode_leaflet_args.loc_lat ) ) ? parseFloat( wonkode_leaflet_args.loc_lat ) : 0;
    const loc_long = ( ! isNaN( wonkode_leaflet_args.loc_long ) ) ? parseFloat( wonkode_leaflet_args.loc_long ) : 0;
    const zoom_level = ( ! isNaN( wonkode_leaflet_args.zoom_level ) && ( parseInt( wonkode_leaflet_args.zoom_level ) >= 1 && parseInt( wonkode_leaflet_args.zoom_level ) <= 22 ) ) ? parseInt( wonkode_leaflet_args.zoom_level ) : 12;
    const tile_max_zoom = ( ! isNaN( wonkode_leaflet_args.tile_max_zoom ) && ( parseInt( wonkode_leaflet_args.tile_max_zoom ) >= 1 && parseInt( wonkode_leaflet_args.tile_max_zoom ) <= 22 ) ) ? parseInt( wonkode_leaflet_args.tile_max_zoom ) : 18;

    const assets_url = wonkode_leaflet_args.assets_url;
    const repeatFieldsNonce = wonkode_leaflet_args.repeatFieldsNonce;

    const mapContainer = document.getElementById( mapContainerId );
    mapContainer.style.height = '600px';

    // open hours
    const hrsOpen = `<span class="working-hrs">MON - THU  5:30-20:00</span><span class="working-hrs">FRI  5:30-18:00</span><span class="working-hrs">SAT  7:00-14:30</span><span class="working-hrs">SUN  10:00-13:00</span>`;

    // popup content settings
    const popup_cont_settings = {
        specific_name: wonkode_leaflet_args.specific_name,
        full_address: wonkode_leaflet_args.full_address,
        phone_num: wonkode_leaflet_args.phone_num,
        working_hrs: hrsOpen
    };

    // initialize Leaflet map
    if ( loc_lat > 0 && loc_long > 0 ) {
        var map = L.map( mapContainerId ).setView( [loc_lat, loc_long], zoom_level );

        // add tile layer to add to our map
        L.tileLayer( 'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: tile_max_zoom,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        } ).addTo( map );

        // marker
        const loc_marker = pinAddMarker( [loc_lat, loc_long], 'biz-location-marker', 'black' );

        // icon image selectors
        const markerSelector = document.querySelector( 'img.leaflet-marker-icon.biz-location-marker' );
        /**
        * Adding click event handlers for 
        * marker icons
        */
        markerSelector.addEventListener( 'click', function( event ) {

            event.preventDefault();

            toggleActiveIcon( markerSelector );
            toggleIconImages( markerSelector );
        } );

        // run marker and binding the assciated popup functionalities
        initMarkerPopup( loc_marker, popup_cont_settings );

    } else {
        console.log( "loc_lat and loc_long are not proper latitude and longitude values" );
    }

    // pin a marker on passed location
    function pinAddMarker( loc = [], clsNm = null, color = 'black' ) {
        if ( ! Array.isArray( loc ) ) {
            return false;
        }
        const cls_name = ( clsNm !== null && typeof clsNm !== 'undefined' ) ? clsNm : 'wonkode-marker';

        const icn_url = color === 'orange' ? assets_url + '/images/marker-selected.png' : assets_url + '/images/marker.png';

        // defining icon class
        const markerPinIcon = L.Icon.extend({
            options: {
                iconUrl: 		icn_url,
                iconSize: 		[93, 82],
                iconAnchor: 	[46, 81],
                popupAnchor: 	[220, 80],
                className: 		cls_name
            }
        });

        const adr_marker = new markerPinIcon();

        // return marker
        return L.marker( loc, {icon: adr_marker} ).addTo( map );
    }

    // marker using divIcon on passed location
    // ***Note***
    // By default, it has a 'leaflet-div-icon' CSS class 
    // and is styled as a little white square with a shadow.
    function pinDivIconMarker( loc = [], clsNm = null, color = 'black' ) {
        if ( ! Array.isArray( loc ) ) {
            return false;
        }
        const cls_name = ( clsNm !== null && typeof clsNm !== 'undefined' ) ? clsNm : 'wonkode-marker';

        const icn_url = color === 'orange' ? assets_url + '/images/marker-selected.png' : assets_url + '/images/marker.png';

        const pinOpts = {
            iconUrl: 		icn_url,
            // html: 			'',
            bgPos: 			[0, 0],
            iconSize: 		[93, 82],
            iconAnchor: 	[46, 81],
            popupAnchor: 	[220, 80],
            className: 		cls_name
        };

        const wonkode_div_icon = L.divIcon( pinOpts );

        // return marker
        return L.marker( loc, {icon: wonkode_div_icon} ).addTo( map );
    }

    // image src toggler
    function toggleIconImages( elem ) {
        if ( elem.classList.contains( 'active' ) === true ) {
            elem.src = assets_url + '/images/marker-selected.png';
        } else {
            elem.src = assets_url + '/images/marker.png';
        }
    }

    // icon active toggler
    function toggleActiveIcon( elem ) {
        elem.classList.toggle( 'active' );
    }

    /**
    * Function binds popup for passed marker 
    * by populating contents.
    * 
    * @var m 			Marker object
    * @var settings 	Object containing 
    * 					popup cotent for the 
    * 					passed marker.
    */
    function initMarkerPopup( m, settings = {} ) {
        var specific_name = settings.specific_name,
            full_address = settings.full_address,
            phone_num = settings.phone_num,
            working_hrs = settings.working_hrs;

        var popup_content = `<h2 class="popup-biz-title">${specific_name}</h2>`;
        popup_content += `<p class="popup-biz-address">${full_address}</p>`;
        popup_content += `
                        <a class="popup-phone-num" href="tel:${phone_num}">
                            <span class="fa-stack" style="vertical-align: top;">
                                <i class="far fa-circle fa-stack-2x"></i>
                                <i class="fas fa-phone fa-stack-1x"></i>
                            </span>
                        </a>
                        `;
        popup_content += working_hrs;

        m.bindPopup( popup_content ).openPopup();
    }
    
} )();
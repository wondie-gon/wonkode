/**
 * Scripts within the customizer controls window.
 */
( function( $ ) {
    wp.customize.bind( 'ready', function() {
        // wonkode customize api
        var wkCustomizeApi = this; // alias for wp.customize

        // ----Common Variables----
        var name_prefix = 'wonkode'; // theme name

        /**
         * ----------social media customize controls----------
         */
        var socialLinksSection = name_prefix + '_social_media_link_section',
            socialLinksSectionToggler = 'enable_' + name_prefix + '_social_media_link_nav';

        /*
            var allSocialControls = getTogglerDependentControls( socialLinksSection, socialLinksSectionToggler );

            ['wonkode_facebook_link_username', 'wonkode_twitter_link_username', 'wonkode_googleplus_link_username', 'wonkode_pinterest_link_username', 'wonkode_linkedin_link_username', 'wonkode_github_link_username', 'wonkode_instagram_link_username', 'wonkode_youtube_link_username', 'wonkode_display_social_media_nav_title', 'wonkode_social_media_nav_title']
        */

        // enabling single control based on toggler control
        wkCustomizeApi( socialLinksSectionToggler, function( setting ) {
            /*
            // ---for single inputs---
            var faceBookInput = wkCustomizeApi.control( name_prefix + '_facebook_link_username' ).container.find( 'input' );

            // disable on loading. 
		    faceBookInput.prop( 'disabled', ! setting.get() );

            // binding to value change of toggle control
            setting.bind( function( value ) {
                faceBookInput.prop( 'disabled', ! value );
            } );
            */

            // get all controls except toggler
            var allSocialControls = getTogglerDependentControls( socialLinksSection, socialLinksSectionToggler );

            $.each( allSocialControls, function( index, id ) {
                wkCustomizeApi.control( id, function( control ) {
                    // toggle visibility function
                    var toggleVisibility = function( value ) {
                        control.toggle( value );
                    };
                    // disable on loading.
                    toggleVisibility( setting.get() );
                    // binding to value change of toggle control
                    setting.bind( toggleVisibility );
                } );
            } );
        } );

        /**
         * ----------Frontpage customize controls----------
         */
        var selected_posts_section = name_prefix + '_customize_section_selected_posts',
            selected_posts_section_activator = name_prefix + '_front_selected_posts_enabled',
            categorized_posts_section = name_prefix + '_customize_section_categorized_latest_posts', 
            categorized_posts_section_activator = name_prefix + '_front_categorized_latest_posts_enabled';

        // toggle visibility of _customize_section_selected_posts
        wkToggleSectionControlsVisibility( selected_posts_section, selected_posts_section_activator, getTogglerDependentControls );

        // listen to change events
        wkCustomizeApi.bind( "change", function ( setting ) {
            // Target the Setting
            if ( 0 === setting.id.indexOf( name_prefix + '_num_of_front_selected_posts' ) ) {
            // if ( $.inArray( name_prefix + '_num_of_front_selected_posts', setting.id ) != -1 ) {
                var numOfPostsInput = wkCustomizeApi.control( name_prefix + '_num_of_front_selected_posts' ).container.find( 'input' );
                var selected_num = parseInt( setting._value );
                numOfPostsInput.val( setting._value );
                for ( var i = 0; i < selected_num; i++ ) {
                    // const inpElem = name_prefix + '_front_selected_post_' + i;
                    wkCustomizeApi.control( name_prefix + '_front_selected_post_' + i ).activate();
                }
            }
        } );

        // toggle visibility of _customize_section_selected_posts
        wkToggleSectionControlsVisibility( categorized_posts_section, categorized_posts_section_activator, getTogglerDependentControls );
        
        /**
         * Function toggles visibility of controls in section 
         * 
         * @param {string} sectionId Section id 
         * @param {string} toggleControlID Activator/toggler control id of section.
         * @param {function} callback_fn Callback function to get controls to be displayed
         */
        function wkToggleSectionControlsVisibility( sectionId, toggleControlID, callback_fn ) {
            if ( typeof sectionId !== "string" || typeof toggleControlID !== "string" ) {
                return;
            }
            var theControls = [];
            wkCustomizeApi( toggleControlID, function( setting ) {
                // get controls in section except toggler
                if ( typeof callback_fn === "function" ) {
                    // get all controls except toggler
                    theControls = callback_fn( sectionId, toggleControlID );
                } else {
                    theControls = wkCustomizeApi.section( sectionId ).controls();
                }

                setTimeout( function() {
                    // toggle each control
                    $.each( theControls, function( index, id ) {
                        wkCustomizeApi.control( id, function( control ) {
                            // toggle visibility function
                            var toggleVisibility = function( value ) {
                                control.toggle( value );
                            };
                            // disable on loading.
                            toggleVisibility( setting.get() );
                            // binding to value change of toggle control
                            setting.bind( toggleVisibility );
                        } );
                    } );
                }, 500 );
            } );
        }
        /**
         * Returns all controls of section 
         * except toggler control if passed.
         * 
         * @param {string} sectionId Section id 
         * @param {string} toggleControlID Activator/toggler control id of section.
         * @return {object} object of controls of section except that enables all other controls
         */
        function getTogglerDependentControls( sectionId, toggleControlID = '' ) {
            // get all controls in the passed section
            var allControls = wkCustomizeApi.section( sectionId ).controls();
            // just excluding activator control
            if ( '' !== toggleControlID || typeof toggleControlID !== "undefined" ) {
                return allControls.filter( function( item ) {
                    if ( item.id !== toggleControlID ) {
                        return item;
                    }
                } ).map( function( elem ) {
                    return elem.id;
                } );
            } else {
                return allControls.map( function( elem ) {
                    return elem.id;
                } );
            }
        }

/*
        function wkCheckEnablerContol( control_id ) {
            var checkInput = wkCustomizeApi.control( control_id ).container.find( 'input[type="checkbox"]' );
            // disable on loading. 
		    checkInput.prop( 'checked', setting.get() );

            // binding to value change of toggle control
            setting.bind( function( value ) {
                checkInput.prop( 'checked', value );
            } );
        }
*/

    } ); // Ends customize ready state

} )( jQuery );
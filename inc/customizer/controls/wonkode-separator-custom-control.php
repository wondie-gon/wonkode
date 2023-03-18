<?php
/**
* Separator custom control
*
* @package WonKode
* 
* @since 1.0
*/
if ( ! class_exists( 'WonKode_Separator_Custom_Control' ) && class_exists( 'WP_Customize_Control' ) ) {
	class WonKode_Separator_Custom_Control extends WP_Customize_Control {
		/**
		 * Renders custom separator 
		 * controls.
		 *
		 */
		public function render_content() {
			switch ( $this->type ) {
				default:
				case 'section_text':
					echo '<p class="customize-separator-description description">' . wp_kses_post( $this->description ) . '</p>';
					break;
				
				case 'sub_section_text':
					echo '<p class="customize-sub_section_text">' . wp_kses_post( $this->description ) . '</p>';
					break;
	
				case 'section_heading':
					echo '<span class="customize-section_heading">' . esc_html( $this->label ) . '</span>';
					break;

				case 'sub_section_heading':
					echo '<span class="customize-sub_section_heading">' . esc_html( $this->label ) . '</span>';
					break;
	
				case 'hr_divider':
					echo '<hr style="margin: 1rem 0; border-color: #0091c8; opacity: 0.2;" />';
					break;
			}
		}
	}
}
<?php
/**
 * Class for custom comments templating
 * 
 * @package WonKode
 * @since 1.0
 */
// restricting direct access of class file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WonKode_Comments_Feature' ) ) {
    class WonKode_Comments_Feature {
        /**
         * Theme identifier, text domain
         * 
         * @since 1.0
         * @var string
         */
        public static $txt_dom = WK_TXTDOM;

        /**
         * Initializes comment feature by adding filter 
         * that modifies comment form default fields, 
         * and hook to 'comment_form_comments_closed' 
         * action of the core. 
         * 
         * @since 1.0
         */
        public static function init_hooks() {
            // add hook to enable threaded comments reply
            add_action( 'get_header', array( 'WonKode_Comments_Feature', 'enable_threaded_comments_reply' ) );

            // filter to comment form defaults
            add_filter( 'comment_form_defaults', array( 'WonKode_Comments_Feature', 'get_floating_label_form_fields' ) );

            // filter to comment closing note
            add_action( 'comment_form_comments_closed', array( 'WonKode_Comments_Feature', 'closed_note' ) );
        }

        /**
         * Displays comments feature template
         * 
         * @since 1.0
         * @return void
         */
        public static function show_template() {
            // start comments template
            self::template_start();
            if ( have_comments() ) { 
                // comments title
                self::comments_title();
                // comments list
                self::comments_list();
                // comments pagination
                self::pagination( 'comment-nav-below' );
            } // End of if have_comments(). 
            // comment form
            self::form_area();
            // end comments template
            self::template_end();
        }

        /**
         * Starts comment area template
         * 
         * @access private
         * 
         * @since 1.0
         * @return void
         */
        private static function template_start() {
            ?>
            <div id="comments" class="comments-area">
            <?php
        }
        /**
         * Ends comment area template
         * 
         * @access private
         * 
         * @since 1.0
         * @return void
         */
        private static function template_end() {
            ?>
            </div><!-- #comments -->
            <?php
        }

        /**
         * Displays comments title
         * 
         * @access private
         * 
         * @since 1.0
         * @return void
         */
        private static function comments_title() {
            ?>
            <h2 class="comments-title">
            <?php
                $comments_number = get_comments_number();
                if ( 1 === (int) $comments_number ) {
                    printf(
                        /* translators: %s: post title */
                        esc_html_x( 'One thought on &ldquo;%s&rdquo;', 'comments title', self::$txt_dom ),
                        '<span>' . get_the_title() . '</span>'
                    );
                } else {
                    printf(
                        esc_html(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s thought on &ldquo;%2$s&rdquo;',
                                '%1$s thoughts on &ldquo;%2$s&rdquo;',
                                $comments_number,
                                'comments title',
                                self::$txt_dom
                            )
                        ),
                        number_format_i18n( $comments_number ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        '<span>' . get_the_title() . '</span>'
                    );
                }
            ?>
            </h2><!-- .comments-title -->
            <?php
        }

        /**
         * Displays comments list
         * 
         * @access private
         * 
         * @since 1.0
         * @return void
         */
        private static function comments_list() {
            ?>
            <ol class="comment-list commentlist">
            <?php
                wp_list_comments(
                    array(
                        'style'      => 'ol',
                        'short_ping' => true,
                    )
                );
            ?>
            </ol><!-- .comment-list -->
            <?php
        }
        /**
         * Renders comment template block.
         * 
         * @since 1.0
         * @param string $class_additions String list of classes to add 
         *                                  to block. Defaults: ''
         * @return void
         */
        public static function show_comments_block( $class_additions = '' ) {
            // default class for comments block
            $def_classes = array( 'comments-wrapper' );
            // if additonal classes passed
            if ( ! empty( $class_additions ) ) {
                WonKode_Helper::add_to_classes( $class_additions, $def_classes );
            }
            $block_cls_list = WonKode_Helper::list_classes( $def_classes );
            ?>
            <div class="<?php echo esc_attr( $block_cls_list ); ?>">
                <?php comments_template(); ?>
            </div>
            <?php
        }

        /**
         * Displays comment feature form block
         * 
         * @access private
         * 
         * @since 1.0
         * @return void
         */
        private static function form_area() {
            // Render comments form
            comment_form();
        }

        /**
         * Displays the comment pagination.
         *
         * @access private
         * 
         * @since 1.0
         * @param string $nav_id The ID of the comment navigation.
         * @return void
         */
        private static function pagination( $nav_id ) {
            if ( get_comment_pages_count() <= 1 ) {
                // Return early if there are no comments to navigate through.
                return;
            }
            ?>
            <nav class="comment-navigation" id="<?php echo esc_attr( $nav_id ); ?>">
                <h1 class="screen-reader-text">
                    <?php esc_html_e( 'Comment navigation', self::$txt_dom ); ?>
                </h1>
                <?php if ( get_previous_comments_link() ) { ?>
                <div class="nav-previous">
                    <?php previous_comments_link( __( '&larr; Older Comments', self::$txt_dom ) ); ?>
                </div>
                <?php } ?>
                <?php if ( get_next_comments_link() ) { ?>
                <div class="nav-next">
                    <?php next_comments_link( __( 'Newer Comments &rarr;', self::$txt_dom ) ); ?>
                </div>
                <?php } ?>
            </nav><!-- #<?php echo esc_attr( $nav_id ); ?> -->
            <?php
        }

        /**
         * Modifies the default $args of comment_form() core 
         * by adding some Bootstrap classes to comment form fields 
         * and more
         * 
         * @since 1.0
         * @param string[] $args Comment form arguments and fields.
         * @return array Arguments for comment form fields
         */
        public static function get_floating_label_form_fields( $args ) {
            // get commenter data
            $commenter = wp_get_current_commenter();
            
            // check if name and email set to required
            $req = get_option( 'require_name_email' );
            // check html5 supported
            $is_html5 = current_theme_supports( 'html5', 'comment-form' );
            // change default $args['format']
            $args['format'] = $is_html5 ? 'html5' : 'xhtml';
            // Define attributes in HTML5 or XHTML syntax.
            $required_attribute = ( $is_html5 ? ' required' : ' required="required"' );
            $checked_attribute  = ( $is_html5 ? ' checked' : ' checked="checked"' );

            // Identify required fields visually.
            $required_indicator = ' <span class="required" aria-hidden="true">*</span>';
            // arguments of comment form
            $args = array(
                'comment_field'	=>	sprintf(
                                            '<div class="comment-form-comment form-floating mb-3">%s %s</div>', 
                                            sprintf(
                                                '<textarea class="form-control" placeholder="%s" id="comment" name="comment" aria-required="true" style="height: 150px;"></textarea>', 
                                                __( 'Leave your comment here', self::$txt_dom )
                                            ), 
                                            sprintf(
                                                '<label for="comment">%s%s</label>', 
                                                _x( 'Comment', 'noun', self::$txt_dom ), 
                                                $required_indicator
                                            )
                                        ), 
                'fields'	=>	array(
                    'author'	=>	sprintf(
                                        '<div class="comment-form-author form-floating mb-3">%s %s</div>', 
                                        sprintf(
                                            '<input type="text" class="form-control" id="author" name="author" value="%s" placeholder="%s"%s />', 
                                            esc_attr( $commenter['comment_author'] ), 
                                            __( 'Name', self::$txt_dom ), 
                                            ( $req ? $required_attribute : '' )
                                        ), 
                                        sprintf(
                                            '<label for="author">%s%s</label>', 
                                            __( 'Your Name', self::$txt_dom ), 
                                            ( $req ? $required_indicator : '' )
                                        )
                                    ),
                    'email'		=>	sprintf(
                                        '<div class="row">
                                            <div class="col-md">
                                                <div class="comment-form-email form-floating mb-3">%s %s</div>
                                            </div>', 
                                        sprintf(
                                            '<input type="email" class="form-control" id="email" name="email" value="%s" placeholder="email@example.com"%s />', 
                                            esc_attr( $commenter['comment_author_email'] ), 
                                            ( $req ? $required_attribute : '' )
                                        ), 
                                        sprintf(
                                            '<label for="email">%s%s</label>', 
                                            __( 'Email address', self::$txt_dom ), 
                                            ( $req ? $required_indicator : '' )
                                        )
                                    ),
                    'url'		=>	sprintf(
                                            '<div class="col-md">
                                                <div class="comment-form-url form-floating mb-3">%s %s</div>
                                            </div>
                                        </div>', 
                                        sprintf(
                                            '<input type="url" class="form-control" id="url" name="url" value="%s" placeholder="https://www.example.com" />', 
                                            esc_attr( $commenter['comment_author_url'] )
                                        ), 
                                        sprintf(
                                            '<label for="url">%s</label>', 
                                            __( 'Website', self::$txt_dom )
                                        )
                                    ), 
                ),
                'class_submit'	=>	'btn btn-primary',
                'label_submit'	=>	__( 'Submit Comment', self::$txt_dom ),
                'title_reply'	=>	__( 'Leave a <span>Comment</span>', self::$txt_dom ),
            );

            // modifying cookies consent checkbox field
            if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
                $consent = empty( $commenter['comment_author_email'] ) ? '' : $checked_attribute;
                
                // consent checkbox label text
                $consent_text = __( 'Save my name, email, and website in this browser for the next time I comment.', self::$txt_dom );

                // setting cookies consent
                $args['fields']['cookies'] = sprintf(
                    '<div class="comment-form-cookies-consent mb-3 form-check">%s %s</div>',
                    sprintf(
                        '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" class="form-check-input" value="yes"%s />', 
                        $consent
                    ),
                    sprintf(
                        '<label for="wp-comment-cookies-consent" class="form-check-label">%s</label>',
                        $consent_text
                    )
                );
            }

            /**
             * Filters the returned comment form fields' arguments
             * 
             * @since 1.0
             * @param array $args {
             *      Arguments to set comment form fields
             *      
             *      @type string/html 'comment_field' Textarea comment field
             *      @type array 'fields' {
             *          key value pairs of other comment form fields
             *          @type string/html 'author' String of html author field
             *          @type string/html 'email' String of html email field
             *          @type string/html 'url' String of html email field
             *          @type string/html 'cookies' String of html cookies consent field
             *      }
             *      @type string 'class_submit' Class for submit button
             *      @type string 'label_submit' Label for submit button
             *      @type string 'title_reply'  Title for a comment area
             * }
             * @param string/html $required_indicator Indicator or mark for required fields
             * @param string $consent_text Label for consent checkbox field 
             */
            return apply_filters( 'wonkode_comment_fields', $args, $required_indicator, $consent_text );
        }

        /**
         * Callback function that displays closed note which is 
         * hooked to 'comment_form_comments_closed' action
         * 
         * @since 1.0
         */
        public static function closed_note() {
            echo self::get_closed_notice();
        }

        /**
         * Returns comments closed note 
         * when comments are closed
         * 
         * @since 1.0
         * @return html/string Note of comments are closed
         */
        public static function get_closed_notice() {
            $closed_note = '';
            if ( get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) {
                $closed_note .= sprintf( 
                    '<p class="no-comments">%s</p>',
                    esc_html__( 'Comments are closed.', self::$txt_dom ) 
                );
            }

            /**
             * Filters returned value of comments closed note
             * 
             * @since 1.0
             * @param string $closed_note Notice text to display when comments
             * closed
             */
            return apply_filters( 'wonkode_comments_closed_note', $closed_note );
        }
        /**
         * Callback function for action that enqueues 
         * script to enable threaded comment reply.
         * 
         * @since 1.0
         * @return void 
         */
        public static function enable_threaded_comments_reply() {
            if ( ! is_admin() ) {
                if ( is_singular() && comments_open() && ( get_option('thread_comments') == 1 ) ) {
                    wp_enqueue_script( 'comment-reply' );
                }
            }
        }

    } // ENDS -- class
}
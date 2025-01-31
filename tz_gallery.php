<?php
/*
Plugin Name: TZ PlusGallery
Plugin URI: http://www.templaza.com/tz-plus-gallery/593.html
Description: TZ PlusGallery get your album from your facebook, Google plus, Flickr, Instagram and WordPress albums.
Version: 1.5.5
Author: tuyennv, templaza
Author URI: http://templaza.com
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/


add_action('media_buttons_context', 'add_tz_gallery_custom_button');

function add_tz_gallery_custom_button($context) {

    $img = plugins_url( '/images/post.button.png' , __FILE__ );
    $container_id = 'tz_plusgallery';

    $title = 'Select Album to insert into post';

    $context .= '<a class="button thickbox" title="Select Album to insert into post"    href="?page=tz_plusgallery&task=tz_plusgallery_add_shortcode_post&TB_iframe=1&width=300&inlineId='.$container_id.'">
		<span class="wp-media-buttons-icon" style="background: url('.$img.'); background-repeat: no-repeat; background-position: left bottom;"></span>
	Add Album
	</a>';

    return $context;
}
add_action('init', 'tz_gallery_do_output_buffer');
function tz_gallery_do_output_buffer() {
    ob_start();
}

add_action('admin_menu', 'tz_gallery_options_panel');

function tz_gallery_options_panel()
{
    $page_cat = add_menu_page('Theme page title', 'TZ PlusGallery', 'delete_pages', 'tz_plusgallery', 'tz_plusgallery', plugins_url('images/tzsidebar.png', __FILE__));
    add_submenu_page('tz_plusgallery', 'All Albums', 'All Albums', 'delete_pages', 'tz_plusgallery', 'tz_plusgallery');
    add_submenu_page('tz_plusgallery', 'pro', '<span class="tz-pro"><em>Go Pro</em></span>', 'delete_pages', 'tz_plusgallery_pro', 'tz_plusgallery_pro');
    add_submenu_page('tz_plusgallery', 'About', 'About TZ Plus Gallery', 'delete_pages', 'tz_plusgallery_about', 'tz_plusgallery_about');

    add_action('admin_print_styles-' . $page_cat, 'tz_plusgallery_style');
    add_action('admin_print_scripts-'. $page_cat, 'tz_plusgallery_script');
}
function tz_gallery_addto_header() {
    ?>
    <script type="text/javascript">
        var imgpath = "<?php echo plugins_url();?>/tz-plus-gallery/";
    </script>
<?php
}
add_action('wp_head', 'tz_gallery_addto_header');
/*
 * Add css and js in admin
 * */

function tz_plusgallery_style(){
    //wp_enqueue_media();
    wp_enqueue_style("admin_css", plugins_url("css/admin.style.css", __FILE__), FALSE);
    wp_enqueue_style("tz_gallery_admin", plugins_url("css/tz_gallery_admin.css", __FILE__), FALSE);
    wp_enqueue_style("component", plugins_url("css/component.css", __FILE__), FALSE);
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_style('thickbox');
}

function tz_plusgallery_script(){
    wp_enqueue_script("modernizr_custom_js",  plugins_url("js/modernizr.custom.js", __FILE__), FALSE);
    wp_enqueue_script( 'classie', plugins_url("js/classie.js", __FILE__), array(), '1.0.0', true );
    wp_enqueue_script( 'modalEffects', plugins_url("js/modalEffects.js", __FILE__), array(), '1.0.0', true );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script( 'tzgallerycustom', plugins_url("js/tz_gallery_custom.js", __FILE__), array(), '1.0.0', false );
}

function tz_plusgallery()
{

    require_once("gallery.php");
    require_once("tz_plusgallery.html.php");

    if (isset($_GET["task"]))
        $task = $_GET["task"];
    else
        $task = '';
    if (isset($_GET["id"]))
        $id = $_GET["id"];
    else
        $id = 0;
    global $wpdb;

    switch ($task) {

        case 'add_gallery':
            add_tz_plusgallery();
            break;
        case 'tz_plusgallery_add_shortcode_post':
            tz_plusgallery_add_shortcode_post();
            break;
        case 'edit_cat':
            if ($id)
                edits_tzplusgallery($id);
            else {
                $id = $wpdb->get_var("SELECT MAX( id ) FROM " . $wpdb->prefix . "tz_plusgallery_item");
                edits_tzplusgallery($id);
            }
            break;

        case 'apply':
            if ($id) {
                tz_gallery_apply($id);
               // edits_tzplusgallery($id);
            }
            break;
        case 'remove_album':
            tz_gallery_remove($id);
            shows_tzgallery();
            break;
        default:
            shows_tzgallery();
            break;
    }
}



function tz_plusgallery_about(){
    wp_enqueue_style("bootstrap_tab", plugins_url("css/bootstrap-tabs.css", __FILE__), FALSE);
    wp_enqueue_style("tz_gallery_admin", plugins_url("css/tz_gallery_admin.css", __FILE__), FALSE);
    wp_enqueue_script( 'bootstrap_tabs', plugins_url("js/bootstrap-tab.js", __FILE__), array(), '1.0.0', true );

    ?>
    <?php $path_img = plugins_url("images", __FILE__); ?>
    <style>

    </style>
    <!-- Tabs Options -->
    <h3 class="about">TZ PLUS GALLERY</h3>
    <div class="go-pro">
        <a href="http://www.templaza.com/tz-plus-gallery/593.html#tz_portfolio-pricing-table">
            Go Pro only $22
        </a>
    </div>
    <div class="tz-tabs">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="TzTab">
            <li><a href="#tz_about" data-toggle="tab">About TZ Plus Gallery</a></li>
            <li><a href="#tz_support" data-toggle="tab">Support</a></li>
            <li><a href="#tz_document" data-toggle="tab">User Guide</a></li>
            <li><a href="#tz_pro" class="pro" data-toggle="tab">Pro Version</a></li>
        </ul>

        <div class="tab-content">
            <!-- Details -->
            <div class="tab-pane fade in" id="tz_about">
                <div class="img_about">
                    <a href="#"><img src="<?php echo $path_img; ?>/intro.png" alt="Plus Gallery"/> </a>
                    <h3>TZ Plus Gallery - Display social gallery like Facebook, Flickr, Instagram and Google+. </h3>
                    <p class="des"><strong>TZ Plus Gallery</strong> display all your albums from social source Facebook, Flickr, Instagram, Google+ on your site.
                    You can post your photos every where, every time from your mobile device to Facebook, Flickr, Instagram and Google+. it will auto added on your website. </p>
                    <h4>Features</h4>
                    <ul>
                        <li>Display your albums from online source like Facebook, Instagram, Google + or Flickr to your site's gallery.</li>
                        <li>Manage gallery by including/excluding albums, limit the number of pictures to be display in each album.</li>
                        <li>Unlimited gallery display on your site.</li>
                        <li>Display multiple albums in one page or post.</li>
                        <li>Compatible with Tablet, Smart phone.</li>
                        <li>Compatible with Visual Composer plugin.</li>
                        <li>Options choose number of columns.</li>
                        <li>Options choose color style.</li>
                        <li>Options padding of albums or photos.</li>
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade in" id="tz_support">
                <div class="tz_support">
                    <p class="des"><strong>Thanks for using TZ Plus Gallery plugin.</strong> </p>
                    <p>You can contact with us to get best support:</p>
                    <ul>
                        <li><a href="http://www.templaza.com/Forum/tz-plus-gallery.html">Forum support</a> </li>
                    </ul>

                </div>
            </div>

            <div class="tab-pane fade in" id="tz_document">
                <div class="tz_document">
                    <p class="des"><strong>Thanks for using TZ Plus Gallery plugin.</strong> </p>
                    <ol>
                        <li><p><strong>How to insert Facebook Album?</strong></p>
                        <div class="iframe-video">
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/kJPisKHOCEE?rel=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                        </li>
                        <li><p><strong>How to insert Flickr Album?</strong></p>
                        <div>
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/7rxgcHemo4g" frameborder="0" allowfullscreen></iframe>
                        </div>
                        </li>
                        <li><p><strong>How to insert Instagram Album?</strong></p>
                        <div>
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/mdlxe_XUFG4?rel=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                        </li>
                        <li><p><strong>How to insert Google+ Album?</strong></p>
                        <div>
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/YFHPPALjGcY?rel=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                        </li>

                    </ol>
                </div>
            </div>

            <div class="tab-pane fade in" id="tz_pro">
                <div class="tz_document">
                    <p class="des"><strong> TZ Plus Gallery Pro version has supported 14 awesome layouts for Facebook, Flickr, Google Plus and Instagram.  </strong> </p>

                    <div class="layout-content">
                        <div class="content-pro">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_mirror">
                                        <a target="_blank" href="http://plusgallery.templaza.net/zumion-grid/" class="view_more">
                                            <img alt="Mirror" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/mirror.jpg">
                                        </a>
                                        <h3>Mirror Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_zumi">
                                        <a target="_blank" href="http://plusgallery.templaza.net/zumion-masonry/" class="view_more">
                                            <img alt="Zumi" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/zumi.jpg">
                                        </a>
                                        <h3>Zumion Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_rolly">
                                        <a target="_blank" href="http://plusgallery.templaza.net/rolly-grid/" class="view_more">
                                            <img alt="Rolly" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/rolly.jpg">
                                        </a>
                                        <h3>Rolly Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_ming">
                                        <a target="_blank" href="http://plusgallery.templaza.net/ming-conner-grid/" class="view_more">
                                            <img alt="Ming" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/ming.jpg">
                                        </a>
                                        <h3>Ming Conner Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_lily">
                                        <a target="_blank" href="http://plusgallery.templaza.net/nice-lily-masonry/" class="view_more">
                                            <img alt="Lily" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/lily.jpg">
                                        </a>
                                        <h3>Lily Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/folio-grid-flickr/" class="view_more">
                                            <img alt="Folio" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/folio.jpg">
                                        </a>
                                        <h3>Folio Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/everline-grid-facebook/" class="view_more">
                                            <img alt="Everline" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/everline.jpg">
                                        </a>
                                        <h3>Everline Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/lania-masonry-facebook/" class="view_more">
                                            <img alt="Lania" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/lania.jpg">
                                        </a>
                                        <h3>Lania Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/swift-masonry-facebook/" class="view_more">
                                            <img alt="Swift" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/swift.jpg">
                                        </a>
                                        <h3>Swift Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/aragon-masonry-facebook/" class="view_more">
                                            <img alt="Aragon" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/aragon.jpg">
                                        </a>
                                        <h3>Aragon Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/elegant-grid/" class="view_more">
                                            <img alt="Elegant" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/elegant.jpg">
                                        </a>
                                        <h3>Elegant Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/pinme-masonry-facebook/" class="view_more">
                                            <img alt="Pinme" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/pinme.jpg">
                                        </a>
                                        <h3>Pinme Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/simple-grid/" class="view_more">
                                            <img alt="Simple" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/simple.jpg">
                                        </a>
                                        <h3>Simple Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/black-white/" class="view_more">
                                            <img alt="Black &amp; White" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/black.jpg">
                                        </a>
                                        <h3>Black &amp; White Layout</h3>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(jQuery){
            jQuery('#TzTab a:first').tab('show');
        });
    </script>
        <?php
}
function tz_plusgallery_pro(){
    wp_enqueue_style("tz_gallery_admin", plugins_url("css/tz_gallery_admin.css", __FILE__), FALSE);
    ?>
    <?php $path_img = plugins_url("images", __FILE__); ?>

    <!-- Tabs Options -->
    <h3 class="about">TZ PLUS GALLERY</h3>
    <div class="go-pro">
        <a href="http://www.templaza.com/tz-plus-gallery/593.html#tz_portfolio-pricing-table">
            Go Pro only $22
        </a>
    </div>
    <div class="tz-tabs">
        <div class="tab-content">
            <!-- Details -->

            <div class=" fade in" id="tz_pro">
                <div class="tz_document">
                    <p class="des"><strong> TZ Plus Gallery Pro version has supported 14 awesome layouts for Facebook, Flickr, Google Plus and Instagram.  </strong> </p>
                    <div class="layout-content">
                        <div class="content-pro">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_mirror">
                                        <a target="_blank" href="http://plusgallery.templaza.net/zumion-grid/" class="view_more">
                                            <img alt="Mirror" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/mirror.jpg">
                                        </a>
                                        <h3>Mirror Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_zumi">
                                        <a target="_blank" href="http://plusgallery.templaza.net/zumion-masonry/" class="view_more">
                                            <img alt="Zumi" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/zumi.jpg">
                                        </a>
                                        <h3>Zumion Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_rolly">
                                        <a target="_blank" href="http://plusgallery.templaza.net/rolly-grid/" class="view_more">
                                            <img alt="Rolly" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/rolly.jpg">
                                        </a>
                                        <h3>Rolly Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_ming">
                                        <a target="_blank" href="http://plusgallery.templaza.net/ming-conner-grid/" class="view_more">
                                            <img alt="Ming" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/ming.jpg">
                                        </a>
                                        <h3>Ming Conner Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_lily">
                                        <a target="_blank" href="http://plusgallery.templaza.net/nice-lily-masonry/" class="view_more">
                                            <img alt="Lily" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/lily.jpg">
                                        </a>
                                        <h3>Lily Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/folio-grid-flickr/" class="view_more">
                                            <img alt="Folio" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/folio.jpg">
                                        </a>
                                        <h3>Folio Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/everline-grid-facebook/" class="view_more">
                                            <img alt="Everline" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/everline.jpg">
                                        </a>
                                        <h3>Everline Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/lania-masonry-facebook/" class="view_more">
                                            <img alt="Lania" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/lania.jpg">
                                        </a>
                                        <h3>Lania Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/swift-masonry-facebook/" class="view_more">
                                            <img alt="Swift" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/swift.jpg">
                                        </a>
                                        <h3>Swift Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/aragon-masonry-facebook/" class="view_more">
                                            <img alt="Aragon" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/aragon.jpg">
                                        </a>
                                        <h3>Aragon Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/elegant-grid/" class="view_more">
                                            <img alt="Elegant" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/elegant.jpg">
                                        </a>
                                        <h3>Elegant Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/pinme-masonry-facebook/" class="view_more">
                                            <img alt="Pinme" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/pinme.jpg">
                                        </a>
                                        <h3>Pinme Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/simple-grid/" class="view_more">
                                            <img alt="Simple" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/simple.jpg">
                                        </a>
                                        <h3>Simple Layout</h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-12 gallery_item">
                                    <div class="item item_masonry">
                                        <a target="_blank" href="http://plusgallery.templaza.net/black-white/" class="view_more">
                                            <img alt="Black &amp; White" src="http://plusgallery.templaza.net/wp-content/themes/tz_extension/images/black.jpg">
                                        </a>
                                        <h3>Black &amp; White Layout</h3>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
        <?php
}

/*
 * Create table for TZ Plus Gallery
 * */

function tz_plusgallery_activate(){
    global $wpdb;
    $sql_tz_plusgallery_type = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "tz_plusgallery_type`(
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(50)
CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
 `description` text CHARACTER SET utf8 NOT NULL,
  `value` varchar(200) CHARACTER SET utf8 NOT NULL,

 PRIMARY KEY (`id`)

) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ";

    $sql_tz_plusgallery_item = "
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "tz_plusgallery_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `data_type` varchar(200) NOT NULL,
  `data_userid` text,
  `album_type` varchar(200) NOT NULL,
  `album_id` text,
  `album_include` text,
  `album_exclude` text,
  `data_api_key` text,
  `data_limit` int(11) unsigned DEFAULT NULL,
  `album_limit` int(11) unsigned DEFAULT NULL,
  `description` text,
  `ordering` int(11) NOT NULL,
  `published` text,

  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)

) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ";

    $sql_tz_plusgallery_options = "
    CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "tz_plusgallery_options` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_item_id` int(11) NOT NULL,
  `options_background` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_color` varchar(200) NOT NULL,
  `options_columns` int(11) NOT NULL,
  `options_css` text CHARACTER SET utf8 NOT NULL,
  `options_width` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_description` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_nav` varchar(100) CHARACTER SET utf8 NOT NULL,
  `options_scroll` varchar(100) CHARACTER SET utf8 NOT NULL,
  `options_layouts` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_detail_view` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_padding` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_album1` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_album2` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_album3` varchar(200) CHARACTER SET utf8 NOT NULL,
  `options_album4` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

    $sql_tz_plusgallery_images = "
    CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "tz_plusgallery_images` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `image_title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `image_url` text CHARACTER SET utf8 NOT NULL,
  `image_description` text CHARACTER SET utf8 NOT NULL,
  `image_link` text CHARACTER SET utf8 NOT NULL,
  `link_target` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `image_type` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";



    $wpdb->query($sql_tz_plusgallery_type);
    $wpdb->query($sql_tz_plusgallery_item);
    $wpdb->query($sql_tz_plusgallery_options);
    $wpdb->query($sql_tz_plusgallery_images);

    $table_name = $wpdb->prefix . "tz_plusgallery_type";
    $table_item_name = $wpdb->prefix . "tz_plusgallery_item";
    $table_options_name = $wpdb->prefix . "tz_plusgallery_options";
    $table_item_images = $wpdb->prefix . "tz_plusgallery_images";

    $sql_demo = "
INSERT INTO `$table_name` (`id`, `name`, `title`, `description`) VALUES
(1, 'flickr', 'Flickr','Flickr album'),
(2, 'facebook', 'FaceBook','Facebook album'),
(3, 'googleplus', 'Google Plus','Google plus album'),
(4, 'instagram', 'Instagram','Instagram album')";

    $sql_2 = "

INSERT INTO `$table_item_name` ( `id` , `name` , `data_type` , `data_userid` , `album_type` ,`album_id` , `album_include` , `album_exclude` , `data_api_key` , `data_limit` , `album_limit` , `description` , `ordering` , `published` )
VALUES
(1, 'Facebook album 01', 'facebook', 'templazaplusgallery', 'single_album', '990501374316007', '', '', 'EAAD6lxvZC5C0BALLoj13vopVYcRiCnkx1cbxG9HnmuIqn9f74qQm5QOpZCe6LWLBzZCkLApIrZARkRYHX5PNdLuzyvKyYgsOLnQhv7ZBwFSyyPoZBX5u4Tovn4jSxKyFKhojJ7zMiZC7Bl6yqNnfWNy0G2ZAKpyYDoEZD', 50, 20, 'Album', 1, 'published'),
(2, 'Flickr Album', 'flickr', '132840201@N02', 'single_album', '72157653231921093', '72157655489748886, 72157655138380589', '', 'e45987ec860dbba1d50b6ee8395bf1c7', 20, 30, 'Album', 2, 'published'),
(3, 'Instagram', 'instagram', '2071051508', '', '', '', '', '2071051508.d6f085d.a7d20d5ffe7645a0826f52b831ecc740', 0, 20, '', 1, 'published'),
(4, 'Google Album', 'googleplus', '114850163104214677218', 'single_album', '6171685831739518689', '', '', '', 0, 20, '', 1, 'published')";


    $sql_3 = "
    INSERT INTO `$table_options_name` (`id`, `gallery_item_id`, `options_background`, `options_color`, `options_columns`, `options_css`, `options_width`, `options_description`, `options_nav`, `options_scroll`, `options_layouts`, `options_detail_view`, `options_padding`, `options_album1`, `options_album2`, `options_album3`, `options_album4`)
     VALUES
(1, 1, '#38BEEA', '#38BEEA', 5, '', '', '', '', '', '', '', '15px', '', '', '', ''),
(2, 2, '#38BEEA', '#38BEEA', 5, '', '', '', '', '', '', '', '15px', '', '', '', ''),
(3, 3, '#38BEEA', '#38BEEA', 5, '', '', '', '', '', '', '', '15px', '', '', '', ''),
(4, 4, '#38BEEA', '#38BEEA', 5, '', '', '', '', '', '', '', '15px', '', '', '', '')";

    $wpdb->query($sql_demo);
    $wpdb->query($sql_2);
    $wpdb->query($sql_3);
}

register_activation_hook(__FILE__, 'tz_plusgallery_activate');

function tz_plusgallery_list_shotrcode($atts)
{
    extract(shortcode_atts(array(
        'id' => 'no album_id',

    ), $atts));
    return tz_plusgallery_list($atts['id']);

}

add_shortcode('tz_plusgallery', 'tz_plusgallery_list_shotrcode');


function   tz_plusgallery_list($id)
{
    global $wpdb;
    require_once("album_front_end.html.php");
    require_once("wp_album_front_end.html.php");
    $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item WHERE id = '%d' ORDER BY ordering ASC",$id);
    $query1=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_options WHERE gallery_item_id = '%d' ",$id);
    $albums=$wpdb->get_results($query);
    $albums_options=$wpdb->get_results($query1);
    foreach ($albums as $row) {
        $album_ids = $row->id;
        $album_name = $row->name;
        $album_type = $row->data_type;
        $album_id   = $row->data_userid;
        $album_data_type   = $row->album_type;
        $album_single_id   = $row->album_id;
        $album_include   = $row->album_include;
        $album_exclude   = $row->album_exclude;
        $album_limit   = $row->data_limit;
        $album_single_limit   = $row->album_limit;
        $album_api_key      = $row->data_api_key;
    }
    foreach ($albums_options as $row_options) {
        $options_color = $row_options->options_color;
        $options_columns = $row_options->options_columns;
        $options_padding   = $row_options->options_padding;
    }
    if($album_type=='wordpress'){
     return  wp_front_end_base_album($album_ids,$options_color,$options_columns,$options_padding);
    }else{
    return front_end_base_album($album_ids,$album_name, $album_type, $album_id,$album_data_type,$album_single_id,$album_include,
        $album_exclude, $album_limit, $album_single_limit,$options_color,$options_columns,$options_padding, $album_api_key);
    }
}
function head_css(){
    wp_enqueue_style("prettyphoto", plugins_url("css/prettyPhoto.css", __FILE__), FALSE);
    wp_enqueue_style("tzplusgallerycss", plugins_url("css/plusgallery.css", __FILE__), FALSE);
}
add_action('wp_head','head_css');

function tz_plusgallery_add_shortcode_post()
{
    ?>
<script type="text/javascript">
				jQuery(document).ready(function() {
				  jQuery('#tzplusgalleryinsert').on('click', function() {
					jQuery('#save-buttom').click();
					var id = jQuery('#tz_plus_gallery_select option:selected').val();
					if(window.parent.tinyMCE && window.parent.tinyMCE.activeEditor)
					{
						window.parent.send_to_editor('[tz_plusgallery id="'+id+'"]');
					}
					tb_remove();
				  })
				});
</script>
<style>
#wpadminbar,.auto-fold #adminmenu, .auto-fold #adminmenu li.menu-top, .auto-fold #adminmenuback, .auto-fold #adminmenuwrap,
.updated, .is-dismissible, .notice{
	display: none;
}

#wpcontent {
	margin-top: -55px;
}

.wp-core-ui .button {margin:0px 0px 0px 10px !important;}

#slider-unique-options-list li {
	clear:both;
	margin:10px 0px 5px 0px;
}

#slider-unique-options-list li label {width:130px;}

#save-buttom {display:none;}

h3 {
	margin:30px 0px 15px 0px;
}
</style>
<div class="clear"></div>
<h3 style="padding-top: 30px;">Select the Album</h3>
<div id="tz_plusgallery">
  <?php
    global $wpdb;

    $query="SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item order by id ASC";
    $shortcodesliders=$wpdb->get_results($query);
    ?>
<form action="" method="post" name="adminForm" id="adminForm">
 <?php 	if (count($shortcodesliders)) {
    echo "<select id='tz_plus_gallery_select' name='hugeit_slider_id'>";
    foreach ($shortcodesliders as $shortcodeslider) {
        $selected='';
        if($shortcodeslider->id == $_POST["hugeit_slider_id"]){$selected='selected="selected"';}
        echo "<option ".$selected." value='".$shortcodeslider->id."'>".$shortcodeslider->name."</option>";
    }
    echo "</select>";
    echo "<button class='button primary' id='tzplusgalleryinsert'>Insert Album</button>";
} else {
    echo "No Albums found", "tz_plusgallery";}
    ?>


</form>
</div>
<?php
}


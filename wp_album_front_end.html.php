<?php

function wp_front_end_base_album($album_ids,$options_color,$options_columns,$options_padding)
{
    wp_enqueue_script( 'prettyphoto', plugins_url("js/jquery.prettyPhoto.js", __FILE__), array(), '1.0.0', true );
    $width = 100/$options_columns;

    global $wpdb;
    $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_images WHERE album_id = '%d' ORDER BY ordering ASC",$album_ids);
    $wpimages=$wpdb->get_results($query);
 ob_start();
    ?>

    <style type="text/css">
        body #wp-gallery<?php echo esc_attr($album_ids);?> .wp-gallery-item .wp-gallery-image a:hover{
            background-color:<?php echo esc_attr($options_color); ?>
        }
        body #wp-gallery<?php echo esc_attr($album_ids);?> .wp-gallery-item{
            width:<?php echo esc_attr($width);?>%;
            margin:0;
            padding:<?php echo esc_attr($options_padding);?>;
            max-width:none;
            height:auto;
        }

    </style>

    <div id="wp-gallery<?php echo esc_attr($album_ids);?>">
        <div class="wp-gallery-content">
            <?php foreach($wpimages as $wpimage): ?>
                <div class="wp-gallery-item">
                    <div class="wp-gallery-image">
                        <?php if($wpimage->image_link){ ?>
                            <a href="<?php echo esc_url($wpimage->image_link);?>" <?php if($wpimage->link_target){ ?> target="_blank" <?php } ?>>
                        <?php } else{ ?>
                                <a href="<?php echo esc_url($wpimage->image_url);?>" rel="prettyPhoto[<?php echo esc_attr($album_ids);?>]">
                        <?php } ?>
                        <img src="<?php echo plugins_url("images/plusgallery/square.png",__FILE__) ?>"  alt="" style="background:url(<?php echo esc_url($wpimage->image_url);?>) no-repeat scroll 50% 50% / cover;"/>
                        <?php if($wpimage->image_link){ ?>
                            </a>
                        <?php } else{ ?>
                            </a>
                        <?php } ?>
                        <?php if($wpimage->image_title || $wpimage->image_description){ ?>
                            <div class="image-info">
                                <?php if($wpimage->image_title){
                                  echo "<h3>$wpimage->image_title</h3>";
                                } ?>

                                <?php if($wpimage->image_description){
                                  echo "<p>$wpimage->image_description</p>";
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("a[rel^='prettyPhoto']").prettyPhoto({
                social_tools:''
            });
        })
    </script>

 	  <?php
	return ob_get_clean();
}  
?>


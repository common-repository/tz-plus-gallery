<?php	
if(function_exists('current_user_can'))
//if(!current_user_can('manage_options')) {
    
if(!current_user_can('delete_pages')) {
    die('Access Denied');
}	
if(!function_exists('current_user_can')){
	die('Access Denied');
}

function html_showgallery($rows, $pageNav){
	global $wpdb;
	?>

<div class="wrap">
	<?php $path_site2 = plugins_url("images", __FILE__); ?>
	<div class="slider-options-head">
        <div class="go-pro">
            <a href="https://www.templaza.com/wordpress/wordpress-plugins/tz-plus-gallery/593.html">
                Go Pro
            </a>
        </div>
		<div style="float: right;">
			<a class="header-logo-text" href="http://www.templaza.com/" target="_blank">
				<div><img src="<?php echo $path_site2; ?>/tz_plusgallery.png" /></div>
			</a>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div id="poststuff">
        <div class="md-modal md-effect-1" id="modal-1">
            <div class="md-content">
                <h3>Create New Album</h3>
                <div>
                    <p>Please click your album type you want to create.</p>
                    <ul>

                        <li><a class="tzbutton  button--rayen button--inverted tz-wordpress" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=wordpress'">
                                <span><?php echo __('WordPress Album','TZGALLERY');?></span></a>
                        </li>
                        <li><a class="tzbutton  button--rayen button--inverted tz-face" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=facebook'">
                                <span><?php echo __('Facebook Album','TZGALLERY');?></span></a>
                        </li>
                        <li><a class="tzbutton  button--rayen button--inverted tz-google" data-text="Add Album"  onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=googleplus'">
                                <span><?php echo __('Google Album','TZGALLERY');?></span></a>
                        </li>
                        <li><a class="tzbutton  button--rayen button--inverted tz-flickr" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=flickr'">
                                <span><?php echo __('Flickr Album','TZGALLERY');?></span></a>
                        </li>
                        <li><a class="tzbutton  button--rayen button--inverted tz-instagram" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=instagram'">
                                <span><?php echo __('Instagram Album','TZGALLERY');?></span></a>
                        </li>
                    </ul>
                    <div class="clr"></div>
                    <button class="md-close"><img src="<?php echo $path_site2; ?>/cancel.png" alt="close"/> </button>
                </div>
            </div>
        </div>
        <div class="md-modal md-effect-1" id="modal-2">
            <div class="md-content">
                <h3>Delete Album</h3>
                <div>
                    <p>Are you sure want to delete your album?</p>
                    <ul>
                        <li><a class="tzbutton button--rayen button--inverted tz-delete tz-face tz-delete-yes"
                               href="admin.php?page=tz_plusgallery&task=remove_album&id=">
                                <span><?php echo __('Delete','TZGALLERY');?></span></a>
                        </li>
                        <li><a class="tzbutton button--rayen  tz-delete tz-delete-no button--inverted tz-google">
                                <span><?php echo __('Cancel','TZGALLERY');?></span></a>
                        </li>

                    </ul>
                    <div class="clr"></div>
                    <button class="md-close"><img src="<?php echo $path_site2; ?>/cancel.png" alt="close"/> </button>
                </div>
            </div>
        </div>
		<div id="albums-list-page">
			<form method="post"  action="admin.php?page=tz_plusgallery" id="admin_form" name="admin_form">
                <h2 class="plus-gallery-logo">TZ Plus Gallery
                    <a class="md-trigger tz_album_addnew" data-modal="modal-1"><?php echo __('Add new album','TZGALLERY');?></a>
                </h2>
			<table class="wp-list-table widefat fixed pages" style="width:95%">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span><?php echo __('ID','TZGALLERY');?></span><span class="sorting-indicator"></span></th>
					<th scope="col" id="type" style="width:30px" ><span><?php echo __('Album Type','TZGALLERY');?></span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span><?php echo __('Name','TZGALLERY');?></span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span><?php echo __('User ID','TZGALLERY');?></span><span class="sorting-indicator"></span></th>
					<th scope="col" id="shortcode"  style="width:75px;" ><span><?php echo __('Shortcode','TZGALLERY');?></span><span class="sorting-indicator"></span></th>
					<th style="width:10px"><?php echo __('Delete','TZGALLERY');?></th>
				 </tr>
				</thead>
				<tbody>
				 <?php $count = 1; foreach($rows as $row_item){
                     ?>
                     <tr <?php if($count%2==0){ echo 'class="tz-background"';}?>>
                         <td><?php echo esc_attr($row_item->id); ?></td>
                         <td><?php  if($row_item->data_type=='wordpress'){ ?>
                                 <img src="<?php echo $path_site2; ?>/wordpress.png" alt="WordPress"/>
                             <?php } ?>
                             <?php  if($row_item->data_type=='facebook'){ ?>
                                 <img src="<?php echo $path_site2; ?>/Facebook_logo_24.png" alt="facebook"/>
                             <?php } ?>
                             <?php  if($row_item->data_type=='flickr'){ ?>
                                 <img src="<?php echo $path_site2; ?>/Flickr__24.png" alt="Flickr"/>
                             <?php } ?>
                             <?php  if($row_item->data_type=='instagram'){ ?>
                                 <img src="<?php echo $path_site2; ?>/Instagram_logo_24.png" alt="Instagram"/>
                             <?php } ?>
                             <?php  if($row_item->data_type=='googleplus'){ ?>
                                 <img src="<?php echo $path_site2; ?>/google_plus_24.png" alt="Google+"/>
                             <?php } ?>

                         </td>
                         <td><a  href="admin.php?page=tz_plusgallery&task=edit_cat&id=<?php echo esc_attr($row_item->id);?>"><?php echo esc_html(stripslashes($row_item->name)); ?></a></td>
                         <td><?php echo esc_attr($row_item->data_userid);?></td>
                         <td><textarea class="full" readonly="readonly">[tz_plusgallery id="<?php echo $row_item->id; ?>"]</textarea></td>
                         <td><a class="md-trigger tz_delete" data-modal="modal-2" data-value="<?php echo esc_attr($row_item->id)?>"><?php echo __('Delete','TZGALLERY');?></a></td>
                     </tr>
                 <?php

                     $count++; }

                 ?>
				</tbody>
			</table>
			 <input type="hidden" name="oreder_move" id="oreder_move" value="" />
			 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo esc_html($_POST['asc_or_desc']);?>"  />
			 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo esc_html($_POST['order_by']);?>"  />
			 <input type="hidden" name="saveorder" id="saveorder" value="" />

			 <?php
			?>
			
			
		   
			</form>
		</div>
        <div class="md-overlay"></div>

    </div>
</div>
    <script type="text/javascript">
        jQuery('.tz-delete-no').on('click', function(){
            jQuery('#modal-2').removeClass('md-show');
        })
    </script>
    <?php

}
function load_media_scripts() {
if (is_admin ())
        wp_enqueue_media ();
}

add_action( 'admin_enqueue_scripts', 'load_media_scripts' );


/*
 * Function edit TZ Plus gallery
 * */

function Html_edit_tzplusgallery($row, $row_items,$row_options,$row_images)

{
 global $wpdb;

?>
<script type="text/javascript">
function submitbutton(pressbutton) 
{
	if(!document.getElementById('name').value){
	alert("Name is required.");
	return;
	}
	document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
	document.getElementById("adminForm").submit();
	
}
function change_select()
{
		submitbutton('apply');
}
</script>
<!--    add  media button-->
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;


            jQuery('.tz-plusgallery-uploader .button').click(function(e) {
                var send_attachment_bkp = wp.media.editor.send.attachment;

                var button = jQuery(this);
                var id = button.attr('id').replace('_button', '');
                _custom_media = true;

                jQuery("#"+id).val('');
                wp.media.editor.send.attachment = function(props, attachment){
                    if ( _custom_media ) {
                        jQuery("#"+id).val(attachment.url+';;;'+jQuery("#"+id).val());
                        jQuery("#save-buttom").click();
                    } else {
                        return _orig_send_attachment.apply( this, [props, attachment] );
                    };
                }

                wp.media.editor.open(button);

                return false;
            });

            jQuery('.add_media').on('click', function(){
                _custom_media = false;

            });
        });
    </script>
<div class="wrap">
	<?php $path_site2 = plugins_url("images", __FILE__); ?>
	<div class="albums-options-head">
		<div style="float: left;">
			<div><h3><a href="javascript: " onclick="window.location.href='admin.php?page=tz_plusgallery'">TZ Plus Gallery</a></h3></div>
		</div>

		<div style="float: right;">
			<a class="header-logo-text" href="http://www.templaza.com/" target="_blank">
				<div><img src="<?php echo $path_site2; ?>/tz_plusgallery.png" /></div>
			</a>
		</div>
        <div class="go-pro">
            <a href="https://www.templaza.com/wordpress/wordpress-plugins/tz-plus-gallery/593.html">
                Go Pro
            </a>
        </div>
	</div>
	<div style="clear:both;"></div>
    <div class="md-modal md-effect-1" id="modal-1">
        <div class="md-content">
            <h3>Create New Album</h3>
            <div>
                <p>Please click your album type you want to create.</p>
                <ul>

                    <li class="wp-albums"><a class="tzbutton  button--rayen button--inverted tz-wordpress" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=wordpress'">
                            <span><?php echo __('WordPress Album','TZGALLERY');?></span></a>
                    </li>
                    <li><a class="tzbutton  button--rayen button--inverted tz-face" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=facebook'">
                            <span><?php echo __('Facebook Album','TZGALLERY');?></span></a>
                    </li>
                    <li><a class="tzbutton  button--rayen button--inverted tz-google" data-text="Add Album"  onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=googleplus'">
                            <span><?php echo __('Google Album','TZGALLERY');?></span></a>
                    </li>
                    <li><a class="tzbutton  button--rayen button--inverted tz-flickr" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=flickr'">
                            <span><?php echo __('Flickr Album','TZGALLERY');?></span></a>
                    </li>
                    <li><a class="tzbutton  button--rayen button--inverted tz-instagram" data-text="Add Album" onclick="window.location.href='admin.php?page=tz_plusgallery&task=add_gallery&type=instagram'">
                            <span><?php echo __('Instagram Album','TZGALLERY');?></span></a>
                    </li>
                </ul>
                <div class="clr"></div>
                <button class="md-close"><img src="<?php echo $path_site2; ?>/cancel.png" alt="close"/> </button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>

    <div class="md-modal md-effect-1" id="modal-2">
        <div class="md-content">
            <h3>Delete Album</h3>
            <div>
                <p>Are you sure want to delete your album?</p>
                <ul>
                    <li><a class="tzbutton button--rayen button--inverted tz-delete tz-face tz-delete-yes"
                           href="admin.php?page=tz_plusgallery&task=remove_album&id=">
                            <span><?php echo __('Delete','TZGALLERY');?></span></a>
                    </li>
                    <li><a class="tzbutton button--rayen  tz-delete tz-delete-no button--inverted tz-google">
                            <span><?php echo __('Cancel','TZGALLERY');?></span></a>
                    </li>

                </ul>
                <div class="clr"></div>
                <button class="md-close"><img src="<?php echo $path_site2; ?>/cancel.png" alt="close"/> </button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>

<form action="admin.php?page=tz_plusgallery&id=<?php echo $row->id; ?>" method="post" name="adminForm" id="adminForm">
	<div id="poststuff" >
        <?php
            if(isset($_GET["save"])){
                $save = $_GET["save"];
                if($save==1){?>
                    <div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
        <?php
                }
            }

        ?>


        <div id="slider-header">
		<ul id="albums-list">

			<?php
			foreach($row_items as $row_item){
				if($row_item->id != $row->id){
				?>
					<li>
						<a href="#" onclick="window.location.href='admin.php?page=tz_plusgallery&task=edit_cat&id=<?php echo $row_item->id; ?>'" ><?php echo $row_item->name; ?></a>
					</li>
				<?php
				}
				else{ ?>
					<li class="active" style="background-image:url(<?php echo plugins_url('images/edit.png', __FILE__) ;?>)">
						<input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text"  readonly="readonly" name="name" id="tzname" maxlength="250" value="<?php echo esc_attr($row_item->name);?>" />
					</li>
				<?php
				}
			}
		?>
			<li class="add-new">
				<a class="md-trigger" data-modal="modal-1" >+</a>
			</li>
		</ul>
		</div>
		<div id="post-body" class="metabox-holder columns-2">
			<!-- Content -->
			<div id="post-body-content">
				<div id="gallery-body">
					<ul id="gallery-content">
                        <?php if($row->data_type=='wordpress'){ ?>
                        <li class="tztop-button">
                            <input type="button" onclick="submitbutton('apply')" value="Save Album" id="save-buttom" class="button button-primary button-large">
                            <a class="md-trigger button_delete_album button button-primary button-large" data-modal="modal-2" data-value="<?php echo esc_attr($row->id)?>" >Delete Album</a>
                        </li>
                        <?php } ?>
                        <li>
                            <label for="name">Album Name</label>
                            <input type="text" name="name" id="name" value="<?php echo $row->name; ?>" class="text_area" />
                            <div class="clr"></div>
                        </li>
                        <li>
                            <?php if($row->data_type=='instagram'){ ?>
                            <label for="data_userid">Instagram ID</label>
                            <div class="info">
                                Please insert Your Instagram ID <a href="http://jelled.com/instagram/lookup-user-id" target="_blank">Get Instagram ID </a>
                            </div>
                            <?php } ?>
                            <?php if($row->data_type=='googleplus'){ ?>
                            <label for="data_userid">Google+ ID</label>
                            <div class="info">
                                Please insert Your Google+ ID <a href="<?php echo plugins_url( '/images/googleID.jpg' , __FILE__ );?>" target="_blank">Get Google+ ID </a>
                            </div>
                            <?php } ?>
                            <?php if($row->data_type=='flickr'){ ?>
                            <label for="data_userid">Flickr ID</label>
                            <div class="info">
                                Please insert Your Flickr ID <a href="http://idgettr.com/" target="_blank">Get Flickr ID </a>
                            </div>
                            <?php } ?>
                            <?php if($row->data_type=='facebook'){ ?>
                            <label for="data_userid">Facebook ID</label>
                            <div class="info">
                                Your ID Fanpage Facebook<a href="<?php echo plugins_url( '/images/facebookID.jpg' , __FILE__ );?>" target="_blank">Get Fanpage ID </a>
                            </div>
                            <?php } ?>
                            <?php if($row->data_type!='wordpress'){ ?>
                            <input type="text" name="data_userid" id="data_userid" value="<?php echo $row->data_userid; ?>" class="text_area" />
                            <?php } ?>
                            <div class="clr"></div>

                        </li>
                        <?php if($row->data_type=='flickr'){?>
                            <li>
                                <label for="data_userid">Flickr API KEY</label>
                                <div class="info">
                                    Please insert Your Flickr API KEY <a href="https://www.flickr.com/services/api/misc.api_keys.html" target="_blank">Get Flickr API KEY </a>
                                </div>
                                <input type="text" name="data_api_key" id="data_userid" value="<?php echo $row->data_api_key; ?>" class="text_area" />
                            </li>
                        <?php }?>
                        <?php if($row->data_type=='facebook'){?>
                            <li>
                                <label for="data_userid">Facebook Access Token</label>
                                <div class="info">
                                    Please insert Your Facebook Access Token<a href="https://www.templaza.com/blog/how-to-generate" target="_blank">Get Facebook Access Token </a>
                                </div>
                                <input type="text" name="data_api_key" id="data_userid" value="<?php echo $row->data_api_key; ?>" class="text_area" />
                            </li>
                        <?php }?>
                        <?php if($row->data_type=='flickr' || $row->data_type=='googleplus' || $row->data_type=='facebook'){ ?>
                        <li>
                            <label for="album_type">Album Type</label>
                            <select name="album_type" class="album_type">
                                <option value="single_album" <?php if($row->album_type=='single_album'){?>selected<?php }?>>Single Album</option>
                                <option value="multi_album" <?php if($row->album_type=='multi_album'){?>selected<?php }?>>Multiple Albums</option>
                                <option value="all_albums" <?php if($row->album_type=='all_albums'){?>selected<?php }?>>Show all Albums</option>
                            </select>
                            <div class="single_album gallery_padding">
                                <label for="album_id">Album ID</label>
                                <input type="text" name="album_id" id="album_id" value="<?php echo $row->album_id; ?>" class="text_area" />
                                <?php if($row->data_type=='flickr'){ ?>
                                <div class="info">
                                    Insert only one Album ID <a href="<?php echo plugins_url( '/images/flickr_album_id.jpg' , __FILE__ );?>" target="_blank">Get Flickr Album ID </a>
                                </div>
                                <?php } ?>
                                <?php if($row->data_type=='googleplus'){ ?>
                                    <div class="info"><a href="https://youtu.be/3FsR41BtRBg">Video help</a>
                                        Insert only one Album ID <a href="<?php echo esc_url( 'http://photos.googleapis.com/data/feed/api/user/Google+ ID?alt=json');?>" target="_blank">Get Google Album ID </a>
                                    </div>
                                <?php } ?>
                                <?php if($row->data_type=='facebook'){ ?>
                                    <div class="info">
                                        Insert only one Album ID <a href="<?php echo plugins_url( '/images/facebook_album.jpg' , __FILE__ );?>" target="_blank">Get facebook Album ID </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="multi_album gallery_padding">
                                <label for="album_include">Include Album ID</label>
                                <input type="text" name="album_include" id="album_include" value="<?php echo $row->album_include; ?>" class="text_area" />
                                <?php if($row->data_type=='flickr'){ ?>
                                    <div class="info">
                                        Insert multiple Albums ID to display: Example (Album1 ID, Album2 ID,...) <a href="<?php echo plugins_url( '/images/flickr_album_id.jpg' , __FILE__ );?>" target="_blank">Get Flickr Album ID </a>
                                    </div>
                                <?php } ?>
                                <?php if($row->data_type=='googleplus'){ ?>
                                    <div class="info">
                                        Insert multiple Albums ID to display: Example (Album1 ID, Album2 ID,...) <a href="https://youtu.be/3FsR41BtRBg" target="_blank">Get Google Album ID </a>
                                    </div>
                                <?php } ?>
                                <?php if($row->data_type=='facebook'){ ?>
                                    <div class="info">
                                        Insert multiple Albums ID to display: Example (Album1 ID, Album2 ID,...) <a href="<?php echo plugins_url( '/images/facebook_album.jpg' , __FILE__ );?>" target="_blank">Get facebook Album ID </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="multi_album gallery_padding">
                                <label for="album_exclude">Exclude Album ID</label>
                                <input type="text" name="album_exclude" id="album_exclude" value="<?php echo $row->album_exclude; ?>" class="text_area" />
                                <?php if($row->data_type=='flickr'){ ?>
                                    <div class="info">
                                        Insert Albums ID you don't want to display: Example (Album1 ID, Album2 ID,...) <a href="<?php echo plugins_url( '/images/flickr_album_id.jpg' , __FILE__ );?>" target="_blank">Get Flickr Album ID </a>
                                    </div>
                                <?php } ?>
                                <?php if($row->data_type=='googleplus'){ ?>
                                    <div class="info">
                                        Insert Albums ID you don't want to display: Example (Album1 ID, Album2 ID,...) <a href="https://youtu.be/3FsR41BtRBg" target="_blank">Get Google Album ID </a>
                                    </div>
                                <?php } ?>
                                <?php if($row->data_type=='facebook'){ ?>
                                    <div class="info">
                                        Insert Albums ID you don't want to display: Example (Album1 ID, Album2 ID,...) <a href="<?php echo plugins_url( '/images/facebook_album.jpg' , __FILE__ );?>" target="_blank">Get facebook Album ID </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="multi_album gallery_padding">
                                <label for="data_limit">Album Limit</label>
                                <input type="text" name="data_limit" id="data_limit" value="<?php echo $row->data_limit; ?>" class="text_area" />
                                <div class="info">
                                    An integer to limit the number of albums in gallery.
                                    </br> <em>If value (0) it will display all photos.</em>
                                </div>
                            </div>
                            <div class=" gallery_padding photo_limit">
                                <label for="data_limit">Photo Limit</label>
                                <input type="text" name="album_limit" id="album_limit" value="<?php echo $row->album_limit; ?>" class="text_area" />
                                <div class="info">
                                    An integer to limit the number of photos in album.
                                    </br> <em>If value (0) it will display all photos.</em>
                                </div>
                            </div>

                        </li>
                        <?php } ?>
                        <?php if($row->data_type=='instagram'){ ?>
                        <li>
                            <div class="multi_album gallery_padding">
                                <label for="album_include">Access Token</label>
                                <input type="text" name="album_include" id="album_include" value="<?php echo $row->album_include; ?>" class="text_area" />
                                <div class="info"><a href="https://youtu.be/HxhG6mpdRHU">Video help</a>
                                    How to get Access Token.
                                    </br> <a href="https://rudrastyh.com/tools/access-token" target="_blank">Get Access Token</a>
                                </div>
                            </div>
                            <div class="single_album gallery_padding">
                                <label for="data_limit">Photo Limit</label>
                                <input type="text" name="album_limit" id="album_limit" value="<?php echo $row->album_limit; ?>" class="text_area" />
                                <div class="info">
                                    An integer to limit the number of photos in album.
                                    </br> <em>If value (0) it will display all photos.</em>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                        <?php if($row->data_type=='wordpress'){ ?>
                        <li>
                            <input type="hidden" name="imagess" id="_unique_name" />
                            <div class="tz-plusgallery-uploader uploader button button-primary add-new-image">
                                <input type="button" class="button wp-media-buttons-icon" name="_unique_name_button" id="_unique_name_button" value="Add Image Gallery" />
                            </div>
                            <ul id="images-list">
                                <?php $i=2; foreach ($row_images as $key=>$rowimages){ ?>
                                    <li <?php if($i%2==0){echo "class='tz-background'";}$i++; ?>>
                                        <input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
                                        <div class="image-box">
                                            <img src="<?php echo $rowimages->image_url; ?>" />
                                            <div>
                                                <script type="text/javascript">
                                                    jQuery(document).ready(function($){
                                                        var _custom_media = true,
                                                            _orig_send_attachment = wp.media.editor.send.attachment;

                                                        jQuery('.tzuploader .button<?php echo $rowimages->id; ?>').click(function(e) {
                                                            var send_attachment_bkp = wp.media.editor.send.attachment;
                                                            var button = jQuery(this);
                                                            var id = button.attr('id').replace('_button', '');
                                                            _custom_media = true;
                                                            wp.media.editor.send.attachment = function(props, attachment){
                                                                if ( _custom_media ) {
                                                                    jQuery("#"+id).val(attachment.url);
                                                                    jQuery("#save-buttom").click();
                                                                } else {
                                                                    return _orig_send_attachment.apply( this, [props, attachment] );
                                                                }
                                                            }

                                                            wp.media.editor.open(button);
                                                            return false;
                                                        });

                                                        jQuery('.add_media').on('click', function(){
                                                            _custom_media = false;
                                                        });
                                                    });
                                                </script>
                                                <input type="hidden" name="imagess<?php echo $rowimages->id; ?>" id="_unique_name<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
                                                <span class="wp-media-buttons-icon"></span>
                                                <div class="tzuploader button<?php echo $rowimages->id; ?> add-new-image">
                                                    <input type="button" class="button<?php echo $rowimages->id; ?> wp-media-buttons-icon editimageicon" name="_unique_name_button<?php echo $rowimages->id; ?>" id="_unique_name_button<?php echo $rowimages->id; ?>" value="Edit image" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="image-options">
                                                <input  placeholder="Title" class="text_area" type="text" name="image_title<?php echo $rowimages->id; ?>" id="image_title<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->image_title;?>">
                                                <textarea placeholder="Description" id="image_description<?php echo $rowimages->id; ?>" name="image_description<?php echo $rowimages->id; ?>" ><?php echo $rowimages->image_description; ?></textarea>
                                                <input placeholder="Image Link (Available in pro version)" readonly class="text_area url-input" type="text" id="image_link<?php echo $rowimages->id; ?>" name="image_link<?php echo $rowimages->id; ?>"  value="<?php //echo $rowimages->image_link;?>" >
                                                <input type="hidden" name="link_target<?php echo $rowimages->id; ?>" value="" />
                                                <input   <?php //if($rowimages->link_target == 'on'){ echo 'checked="checked"'; } ?>  class="link_target" type="checkbox" id="link_target<?php echo $rowimages->id; ?>" name="link_target<?php echo $rowimages->id; ?>" />
                                                <label class="long" for="sl_link_target<?php echo $rowimages->id; ?>">Open in new tab <span>(Available in pro version)</span></label>

                                            <div class="remove-image-container">
                                                <a class="button remove-image" href="admin.php?page=tz_plusgallery&id=<?php echo $row->id; ?>&task=edit_cat&removeimage=<?php echo $rowimages->id; ?>">Remove Image</a>
                                            </div>
                                        </div>

                                        <div class="clear"></div>
                                    </li>
                                <?php } ?>
                            </ul>

                        </li>
                        <?php } ?>
                        <li>
                            <label for="description">Description</label>
                            <textarea  name="description" id="description_id" value="<?php echo $row->description; ?>" class="text_area"><?php echo $row->description; ?></textarea>
                            <div class="clr"></div>
                        </li>

                        <input type="button" onclick="submitbutton('apply')" value="Save Album" id="save-buttom" class="button button-primary button-large">
                        <a class="md-trigger button_delete_album button button-primary button-large" data-modal="modal-2" data-value="<?php echo esc_attr($row->id)?>" >Delete Album</a>
                        <li class="clr"></li>
					</ul>

<!--                    <a class="tz_gallery_cancel" href="admin.php?page=tz_plusgallery"><img src="--><?php //echo $path_site2; ?><!--/cancel.png"/> </a>-->
				</div>
                <div id="plusgallery_demo" class="plusgallery_preview">
                    <h3 class="preview_title">Demo layout <span>Default</span></h3>
                    <iframe class="plusgallery_layout" src="http://plusgallery.templaza.net/default-layout/" width="100%" height="1000px">

                    </iframe>
                </div>
			</div>
				
			<!-- SIDEBAR -->
			<div id="tz_gallery-container-1" class="tz_gallery-container">
                <div id="tz_gallery-shortcode-box" class="tz_gallery_box shortcode ms-toggle">

                </div>

				<div id="tz_gallery-shortcode-box" class="tz_gallery_box shortcode ms-toggle tz_gallery-shortcode-box">
                    <div class="tz_gallery_box_options">
                        <h3 class="hndle"><span>Basic Options</span></h3>
                        <div class="inside">
                            <ul>
                                <li rel="tab-1" class="selected">
                                    <h4>Box Color</h4>
                                    <input data-default-color="#38beea" type="text" id="boxColor" value="<?php echo esc_attr($row_options->options_color);?>" name="options_color" />
                                    <p class="description"><?php _e('Set color for box gallery thumbnails.') ?></p>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($){
                                            $("#boxColor").wpColorPicker();
                                        });
                                    </script>
                                </li>
                                <li rel="tab-2">
                                    <h4>Columns Layout</h4>
                                    <select name="options_columns" class="options_columns">
                                        <option value="2" <?php if($row_options->options_columns==2){?>selected <?php }?>>2 Columns</option>
                                        <option value="3" <?php if($row_options->options_columns==3){?>selected <?php }?>>3 Columns</option>
                                        <option value="4" <?php if($row_options->options_columns==4){?>selected <?php }?>>4 Columns</option>
                                        <option value="5" <?php if($row_options->options_columns==5){?>selected <?php }?>>5 Columns</option>
                                        <option value="6" <?php if($row_options->options_columns==6){?>selected <?php }?>>6 Columns</option>
                                        <option value="7" <?php if($row_options->options_columns==7){?>selected <?php }?>>7 Columns</option>
                                        <option value="8" <?php if($row_options->options_columns==8){?>selected <?php }?>>8 Columns</option>
                                    </select>
                                </li>

                                <li rel="tab-3">
                                    <h4>Album Padding</h4>
                                    <input type="text" value="<?php echo esc_attr($row_options->options_padding);?>" name="options_padding" class="text_area"/>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tz_gallery_box_options pro_version">
                        <div class="inside">
                            <div id="accordion">
                                <span class="info">Available in pro version</span>
                                <h3 class="acc"><span>Advanced Options</span><em></em></h3>
                                <div>
                                    <h4>Layout</h4>
                                    <select name="options_layout" class="options_layout">
                                        <option value="http://plusgallery.templaza.net/default-layout/" selected> Default</option>
                                        <option value="http://plusgallery.templaza.net/mirror-grid/">Mirror</option>
                                        <option value="http://plusgallery.templaza.net/zumion-grid/">Zumion</option>
                                        <option value="http://plusgallery.templaza.net/rolly-grid/">Rolly</option>
                                        <option value="http://plusgallery.templaza.net/ming-conner-masonry/">Ming Corner</option>
                                        <option value="http://plusgallery.templaza.net/nice-lily-grid/">Nice Lily</option>
                                        <option value="http://plusgallery.templaza.net/folio-grid-flickr/">Folio</option>
                                        <option value="http://plusgallery.templaza.net/everline-grid-facebook/">Everline</option>
                                        <option value="http://plusgallery.templaza.net/lania-grid/">Lania</option>
                                        <option value="http://plusgallery.templaza.net/swift-grid/">Swift</option>
                                        <option value="http://plusgallery.templaza.net/aragon-grid/">Aragon</option>
                                        <option value="http://plusgallery.templaza.net/elegant-grid/">Elegant</option>
                                        <option value="http://plusgallery.templaza.net/pinme-grid/">Pinme</option>
                                        <option value="http://plusgallery.templaza.net/simple-grid/">Simple</option>
                                        <option value="http://plusgallery.templaza.net/black-white/">Black & White</option>
                                        <option value="http://plusgallery.templaza.net/coffee-grid-flickr/">Coffee</option>
                                    </select>
                                    <h4>Row Height <span>(Example: 300)</span></h4>
                                    <input type="text" value="300" name="options_height" class="text_area" readonly/>
                                </div>
                                <h3 class="acc responsive_options">Responsive Options <i class="fa fa-sort-up"></i><i class="fa fa-sort-down"></i></h3>
                                <div>

                                    <div class="options_block">
                                        <label>Small Desktop</label>
                                        <select name="desktop_columns" class="desktop_columns">
                                            <option value="2">2 Columns</option>
                                            <option value="3" selected>3 Columns</option>
                                            <option value="4">4 Columns</option>
                                            <option value="5">5 Columns</option>
                                            <option value="6">6 Columns</option>
                                            <option value="7">7 Columns</option>
                                            <option value="8">8 Columns</option>
                                        </select>
                                    </div>

                                    <div class="options_block">
                                        <label>Tablet Columns</label>
                                        <select name="tablet_columns" class="tablet_columns">
                                            <option value="2">2 Columns</option>
                                            <option value="3">3 Columns</option>
                                            <option value="4">4 Columns</option>
                                            <option value="5">5 Columns</option>
                                            <option value="6">6 Columns</option>
                                            <option value="7">7 Columns</option>
                                            <option value="8">8 Columns</option>
                                        </select>
                                    </div>
                                    <div class="options_block">
                                        <label>Mobile Columns</label>
                                        <select name="mobile_columns" class="mobile_columns">
                                            <option value="1">1 Columns</option>
                                            <option value="2">2 Columns</option>
                                            <option value="3">3 Columns</option>
                                            <option value="4">4 Columns</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="tz_gallery_box_options">
                        <h3 class="hndle"><span>Usage</span></h3>
                        <div class="inside">
                            <ul>
                                <li rel="tab-3" class="selected">
                                    <h4>Shortcode</h4>
                                    <p>Copy &amp; paste the shortcode directly into any WordPress post or page.</p>
                                    <textarea class="full" readonly="readonly">[tz_plusgallery id="<?php echo $row->id; ?>"]</textarea>
                                </li>
                                <li rel="tab-4">
                                    <h4>Template Include</h4>
                                    <p>Copy &amp; paste this code into a template file to include the slideshow within your theme.</p>
                                    <textarea class="full" readonly="readonly">&lt;?php echo do_shortcode("[tz_plusgallery id='<?php echo $row->id; ?>']"); ?&gt;</textarea>
                                </li>
                            </ul>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="task" value="" />
</form>
</div>

    <script type="text/javascript">

        jQuery('select.options_layout').on('change', function(){
            var layour_href = jQuery(this).val();
            var layout_text = jQuery(this).find('option:selected').text();
            jQuery("html, body").animate({ scrollTop: jQuery(document).height() }, 1000);
            jQuery('.preview_title span').html(layout_text);
            jQuery('iframe.plusgallery_layout').attr('src',layour_href);

        })
        jQuery('.tz-delete-no').on('click', function(){
            jQuery('#modal-2').removeClass('md-show');
        })

        var album_type_val = jQuery('.album_type').val();
        var xTriggered = 0;
        if(album_type_val=='multi_album'){
            jQuery('.single_album').addClass('album_hide');
        }
        if(album_type_val=='single_album'){
            jQuery('.multi_album').addClass('album_hide');
        }
        if(album_type_val=='all_albums'){
            jQuery('.multi_album').addClass('album_hide');
            jQuery('.single_album').addClass('album_hide');
        }
        jQuery('.album_type').on('change',function(){
            var album_type = jQuery(this).val();
            if(album_type=='multi_album'){
                jQuery('.multi_album').slideDown();
                jQuery('.single_album').slideUp();
            }
            if(album_type=='single_album'){
                jQuery('.single_album').slideDown();
                jQuery('.multi_album').slideUp();
            }
            if(album_type=='all_albums'){
                jQuery('.single_album').slideUp();
                jQuery('.multi_album').slideUp();
            }
        })

        jQuery('#gallery-content input.text_area').on('focus',function(){
            jQuery(this).parent().find('.info').addClass('info_active');
        })

        jQuery('#gallery-content input.text_area').on('focusout',function(){
            jQuery(this).parent().find('.info').removeClass('info_active');
        })

        jQuery( "#gallery-content input.text_area" ).keydown(function( event ) {
            xTriggered++;
            if(xTriggered>3){
                jQuery(this).parent().find('.info').removeClass('info_active');
            }
        })
    </script>

    <script>
        jQuery(document).ready(function ($) {

            jQuery("#slideup").click(function () {
                window.parent.uploadID = jQuery(this).prev('input');
                formfield = jQuery('.upload').attr('name');
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                return false;
            });
            window.send_to_editor = function (html) {
                imgurl = jQuery('img', html).attr('src');
                if(imgurl) {
                    window.parent.uploadID.val(imgurl);
                    tb_remove();
                    jQuery("#save-buttom").click();
                }
                else {
                    imgurl = jQuery('#embed-url-field').val();
                    if(imgurl) {


                        window.parent.jQuery("#_unique_name").val(imgurl+';;;');
                        jQuery("#save-buttom").click();

                        tb_remove();
                    }
                }
            };
        });
    </script>

<?php


}

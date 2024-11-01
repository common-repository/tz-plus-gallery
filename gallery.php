<?php


if(function_exists('current_user_can'))
//if(!current_user_can('manage_options')) {

    if(!current_user_can('delete_pages')) {
        die('Access Denied');
    }
if(!function_exists('current_user_can')){
    die('Access Denied');
}

/*
 * Show list gallery in admin
 * */
function shows_tzgallery()
{
    global $wpdb;


    if(isset($_POST['page_number']))
    {
        if($_POST['asc_or_desc'])
        {
            $sort["sortid_by"]=$_POST['order_by'];
            if($_POST['asc_or_desc']==1)
            {
                $sort["custom_style"]="manage-column column-title sorted asc";
                $sort["1_or_2"]="2";
                $order="ORDER BY ".$sort["sortid_by"]." ASC";
            }
            else
            {
                $sort["custom_style"]="manage-column column-title sorted desc";
                $sort["1_or_2"]="1";
                $order="ORDER BY ".$sort["sortid_by"]." DESC";
            }
        }
        if($_POST['page_number'])
        {
            $limit=($_POST['page_number']-1)*20;
        }
        else
        {
            $limit=0;
        }
    }
    else
    {
        $limit=0;
    }

    $query = "
SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item
WHERE published = 'published'
ORDER BY id ASC

    ";

    $rows = $wpdb->get_results($query);

    $total = $wpdb->get_var($query);
    $pageNav['total'] =$total;
    $pageNav['limit'] =	 $limit/20+1;

    html_showgallery( $rows, $pageNav);
}


/*
 * Add new Album
 * */
function add_tz_plusgallery()
{
    global $wpdb;
    if(isset($_GET["type"])){
        $type = $_GET["type"];
    }
    $table_item_name = $wpdb->prefix . "tz_plusgallery_item";
    $table_options_name = $wpdb->prefix . "tz_plusgallery_options";

    $sql_2 = "
    INSERT INTO `$table_item_name` ( `name` , `data_type` , `data_userid` , `album_type` , `album_id` , `album_include` , `album_exclude` , `data_api_key` , `data_limit` , `album_limit` , `description` , `ordering` , `published` )
    VALUES
    ('Album', '$type', '', 'single_album', '', '', '', '', 30, 30, '', 1, 'published')";

    $wpdb->query($sql_2);

    $query="SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item order by id ASC";
    $query1 = "SELECT id FROM ".$wpdb->prefix."tz_plusgallery_item order by id DESC LIMIT 1";
    $rowsldcc=$wpdb->get_results($query);
    $max_id = $wpdb->get_row($query1);
    $id_max_item = $max_id->id;
    $last_key = key( array_slice( $rowsldcc, -1, 1, TRUE ) );

    $sql_3 = "
INSERT INTO `$table_options_name` (`gallery_item_id`, `options_background`, `options_color`, `options_columns`, `options_css`, `options_width`, `options_description`, `options_nav`, `options_scroll`, `options_layouts`, `options_detail_view`, `options_padding`, `options_album1`, `options_album2`, `options_album3`, `options_album4`)
 VALUES ($id_max_item, '#38BEEA', '#38BEEA', 4, ' ', ' ', ' ', ' ', ' ', ' ', ' ', '15px', ' ', ' ', ' ', ' ')";

    $wpdb->query($sql_3);

//    if($type == 'wordpress'){
//        $table_item_images = $wpdb->prefix . "tz_plusgallery_images";
//    $sql_4="
//    INSERT INTO `$table_item_images` (`album_id`, `image_title`, `image_url`, `image_description`, `image_link`, `link_target`, `ordering`, `published`, `image_type`)
//     VALUES ($id_max_item, ' ', ' ', ' ', ' ', ' ', 0, 0, ' ');
//    ";
//        $wpdb->query($sql_4);
//    }

    foreach($rowsldcc as $key=>$rowsldccs){
        if($last_key == $key){
            header('Location: admin.php?page=tz_plusgallery&id='.$rowsldccs->id.'&task=edit_cat');
        }
    }
}


function edits_tzplusgallery($id)
{

    global $wpdb;

    if(isset($_GET["removeimage"])){
        if($_GET["removeimage"] != ''){

            $wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."tz_plusgallery_images  WHERE id = %d ", $_GET["removeimage"]));
        }
    }
    $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item WHERE id= %d",$id);
    $query1=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_options WHERE gallery_item_id= %d",$id);
    $row=$wpdb->get_row($query);
    $row_options=$wpdb->get_row($query1);

    $query_item="SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item WHERE 1 ORDER BY id ASC";
    $row_items=$wpdb->get_results($query_item);

    $query_images=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_images WHERE album_id= %d",$id);
    $row_images=$wpdb->get_results($query_images);



    Html_edit_tzplusgallery($row,$row_items,$row_options,$row_images);
}




function tz_gallery_apply($id)
{
    global $wpdb;
    if(!is_numeric($id)){
        echo 'insert numerc id';
        return '';
    }

    $album_include = str_replace(' ','',$_POST["album_include"]);
    $album_exclude = str_replace(' ','',$_POST["album_exclude"]);

    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  name = '%s'  WHERE ID = %d ", $_POST["name"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  data_userid = '%s'  WHERE ID = %d ", $_POST["data_userid"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  album_type = '%s'  WHERE ID = %d ", $_POST["album_type"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  album_id = '%s'  WHERE ID = %d ", $_POST["album_id"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  album_include = '%s'  WHERE ID = %d ", $album_include, $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  album_exclude = '%s'  WHERE ID = %d ", $album_exclude, $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  data_api_key = '%s'  WHERE ID = %d ", $_POST["data_api_key"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  data_limit = '%s'  WHERE ID = %d ", $_POST["data_limit"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  album_limit = '%s'  WHERE ID = %d ", $_POST["album_limit"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_item SET  description = '%s'  WHERE ID = %d ", $_POST["description"], $id));

    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_options SET  options_color = '%s'  WHERE gallery_item_id = %d ", $_POST["options_color"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_options SET  options_columns = '%s'  WHERE gallery_item_id = %d ", $_POST["options_columns"], $id));
    $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_options SET  options_padding = '%s'  WHERE gallery_item_id = %d ", $_POST["options_padding"], $id));

    $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_item WHERE id = %d", $id);
    $row=$wpdb->get_row($query);
    $query_images=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_images WHERE album_id = %d", $id);
    $rowim=$wpdb->get_results($query_images);
    foreach ($rowim as $key=>$rowimages){
        if(isset($_POST["order_by_".$rowimages->id.""])){
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  ordering = '".esc_html($_POST["order_by_".$rowimages->id.""])."'  WHERE id = %d ", $rowimages->id));
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  link_target = '".esc_html($_POST["link_target".$rowimages->id.""])."'  WHERE id = %d ", $rowimages->id));
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  image_link = '".esc_html($_POST["image_link".$rowimages->id.""])."' WHERE id = %d ", $rowimages->id));
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  image_title = '".esc_html($_POST["image_title".$rowimages->id.""])."'  WHERE id = %d ", $rowimages->id));
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  image_description = '".$_POST["image_description".$rowimages->id.""]."'  WHERE id = %d ", $rowimages->id));
            if(isset($_POST["imagess".$rowimages->id.""]))
                $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  image_url = '".esc_html($_POST["imagess".$rowimages->id.""])."'  WHERE id = %d ", $rowimages->id));
        }
    }

    if($_POST["imagess"] != ''){
        $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tz_plusgallery_images where album_id = %d order by id ASC", $row->id);
        $rowim=$wpdb->get_results($query);

        foreach ($rowim as $key=>$rowimages){
            $orderingplus = $rowimages->ordering+1;
            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tz_plusgallery_images SET  ordering = %d  WHERE ID = %d ", $orderingplus, $row->id));
        }
        $table_name = $wpdb->prefix . "tz_plusgallery_images";
        $imagesnewuploader = explode(";;;", $_POST["imagess"]);
        array_pop($imagesnewuploader);
        foreach($imagesnewuploader as $imagesnewupload){
            $sql_2="
            INSERT INTO `$table_name` (`album_id`, `image_title`, `image_url`, `image_description`, `image_link`, `link_target`, `ordering`, `published`, `image_type`)
             VALUES ($row->id, '', '$imagesnewupload', '', '', '', 0, 0, '');
            ";
            $wpdb->query($sql_2);
           }
    }
    ?>
    <?php

    header('Location:admin.php?page=tz_plusgallery&task=edit_cat&id='.$id.'&save=1');

}
function tz_gallery_remove($id)
{
    global $wpdb;
    $sql_remov_tag=$wpdb->prepare("DELETE FROM ".$wpdb->prefix."tz_plusgallery_item WHERE id = %d", $id);
    $sql_remov_tag1=$wpdb->prepare("DELETE FROM ".$wpdb->prefix."tz_plusgallery_options WHERE gallery_item_id = %d", $id);
    $sql_remov_tag2=$wpdb->prepare("DELETE FROM ".$wpdb->prefix."tz_plusgallery_images WHERE album_id = %d", $id);

    if(!$wpdb->query($sql_remov_tag) || !$wpdb->query($sql_remov_tag1))
    {
        ?>
        <div id="message" class="error"><p>slider Not Deleted</p></div>
    <?php
    }
    else{
        ?>
        <div class="updated"><p><strong><?php _e('Item Deleted.' ); ?></strong></p></div>
    <?php
    }
}
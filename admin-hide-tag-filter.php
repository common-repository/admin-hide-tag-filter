<?php
/*
Plugin Name: Admin Hide Tag Filter
Plugin URI: http://yourdomain.com/
Description: Filters on a Tag in Admin Post Page
Version: 1.2
Author: Don Kukral
Author URI: http://yourdomain.com
License: GPL
*/

$tag_to_hide = "printed";

add_action('restrict_manage_posts', 'admin_hide_tag_restrict_manage_posts');
add_filter('posts_where', 'admin_hide_tag_posts_where');

function admin_hide_tag_restrict_manage_posts() {
    global $tag_to_hide;
    echo '<input type="checkbox" id="hide_tag" name="hide_tag" value="yes" '; if ($_GET['hide_tag'] == 'yes') { echo 'checked="checked"; '; } echo '/>';
     
    echo " Hide " . ucwords($tag_to_hide) . " ";
}

function admin_hide_tag_posts_where($where) {
    global $wpdb;
    global $tag_to_hide;
    if (is_admin()) {
        if ($_GET['hide_tag'] == 'yes') {
            $where .= " AND ID NOT IN (SELECT r.object_id FROM {$wpdb->terms} e, {$wpdb->term_taxonomy} t, {$wpdb->term_relationships} r where e.name='{$tag_to_hide}' and t.taxonomy='post_tag' and e.term_id=t.term_id and t.term_taxonomy_id=r.term_taxonomy_id)";
        }
    }
    return $where;
}

?>

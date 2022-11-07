<?php

// POSTMETA ************************************************

// video **********************************

function field_box_post_video()
{
    add_meta_box('post_video_id', 'ID do Vídeo (apenas o ID)', 'field_post_video', 'post','post_video','high',null);
}
add_action('add_meta_boxes', 'field_box_post_video');

function field_post_video($post)
{
    $value = get_post_meta($post->ID, 'post_video', true);
?>
    <input class="postmeta-post" type="text" name="post_video" value="<?php echo $value; ?>">
<?php
}

function move_postmeta_to_top_post() {
    global $post, $wp_meta_boxes;
    do_meta_boxes( get_current_screen(), 'post_video', $post );
    unset($wp_meta_boxes['post']['post_video']);
}
add_action('edit_form_after_title', 'move_postmeta_to_top_post');


// SAVE ALL **********************************

function save_postmeta_post($post_id)
{
    if (isset($_POST['post_video'])) {
        $post_video = sanitize_text_field($_POST['post_video']);
        update_post_meta($post_id, 'post_video', $post_video);
    }  
}
add_action('save_post', 'save_postmeta_post');

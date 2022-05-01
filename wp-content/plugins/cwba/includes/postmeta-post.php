<?php

// Descrição **********************************

function field_box_post_descricao()
{
    add_meta_box('post_descricao_id', 'Descrição', 'field_post_descricao', 'post','advanced');
}
add_action('add_meta_boxes', 'field_box_post_descricao');

function field_post_descricao($post)
{
?>
    <p><input class="postmeta-post" type="text" name="post_descricao" value="<?php echo get_post_meta($post->ID, 'post_descricao', true); ?>"></p>        
<?php
}

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});


// SAVE **********************************

function save_postmeta_post($post_id)
{
    if (isset($_POST['post_descricao'])) {
        $post_descricao = sanitize_text_field($_POST['post_descricao']);
        update_post_meta($post_id, 'post_descricao', $post_descricao);
    }
}
add_action('save_post', 'save_postmeta_post');

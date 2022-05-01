<?php

// PDF do Curso **********************************

function field_box_curso_video()
{
    add_meta_box('curso_video_id', 'Vídeo do Curso', 'field_curso_video', 'product', 'advanced');
}
add_action('add_meta_boxes', 'field_box_curso_video');

function field_curso_video($post)
{
?>
    <input type="text" name="curso_video_1" id="curso_video_1" value="<?php echo get_post_meta($post->ID, 'curso_video_1', true); ?>" /></td>
<?php
}

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function () {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});


// SAVE **********************************

function save_productmeta_product($post_id)
{
    if (isset($_POST['curso_video_1'])) {
        $curso_video_1 = $_POST['curso_video_1'];
        update_post_meta($post_id, 'curso_video_1', $curso_video_1);
    }
}
add_action('save_post', 'save_productmeta_product');

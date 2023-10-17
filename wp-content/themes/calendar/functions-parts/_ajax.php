<?php function load_modal_info()
{
    $id = $_POST['id'];

    $query = new WP_Query([
        'post_type' => 'events',
        'posts_per_page' => -1,
        'p' => $id,
    ]);

    if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post(); ?>
        <h2 class="modal__title" data-id="<?php echo get_the_ID(); ?>"><?php the_title(); ?></h2>
        <p>Початок: <?php the_field('date_start'); ?></p>
        <?php $end = get_field('date_end');
        if($end) : ?>
        <p>Кінець: <?php echo $end ?></p>
        <?php endif; ?>

        <?php $img = get_field('image');
        if($img) : ?>
        <div class="modal__img">
            <img src="<?php echo $img['sizes']['large']; ?>" alt="">
        </div>
        <?php endif; ?>


        <?php endwhile;
        wp_reset_postdata();

    endif;

    die();
}
add_action('wp_ajax_load_modal_info', 'load_modal_info');
add_action('wp_ajax_nopriv_load_modal_info', 'load_modal_info');

function leads_form()
{
    $id = sanitize_text_field($_POST['id']);
    $name = sanitize_text_field($_POST['name']);
    $phone = sanitize_text_field($_POST['phone']);
    $email = sanitize_text_field($_POST['email']);


    // Create a new post array for the custom post type "leads"
    $new_post = array(
        'post_title'    => $name,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'leads',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($new_post);

    // Check if the post was successfully inserted
    if ($post_id) {
        update_field('name', $name, $post_id);
        update_field('phone', $phone, $post_id);
        update_field('email', $email, $post_id);
        update_field('event', $id, $post_id);
        

        echo "Lead created successfully.";
    } else {
        echo "Error creating lead.";
    }
}
add_action('wp_ajax_leads_form', 'leads_form');
add_action('wp_ajax_nopriv_leads_form', 'leads_form');

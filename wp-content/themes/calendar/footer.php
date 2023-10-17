<div class="modal__overlay">
	<div class="modal__window-wrap">
  <div class="modal__close"></div>
  <div class="modal__content"></div>


  <form id="form" class="modal__form">
    <h2 class="form__title">Форма</h2>
    <fieldset>
      <label for="name" id="label-name" class="form__input form__input_text form__input_full">
        <input type="text" id="name" autocomplete="off" placeholder="Full Name" />
      </label>
      <label for="phone" id="label-phone" class="form__input form__input_text">
        <input type="tel" id="phone" autocomplete="off" placeholder="Phone" />
      </label>
      <label for="email" id="label-email" class="form__input form__input_text">
        <input type="text" id="email" autocomplete="off" placeholder="Email" />
      </label>
    </fieldset>

    <button class="form__submit" type="submit">Відправити</button>
  </form>
	</div>
</div>



<footer id="footer" class="footer"></footer>

</body>

<?php $args = array(
  'post_type' => 'events',
  'posts_per_page' => -1,
  'post_status'=>'publish'
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) :
  $counter = 0;
  while ($query->have_posts()):$query->the_post();
  $counter++;
  
  $events[$counter] = [
    "title" => get_the_title(),
    "start" => get_field('date_start'),
    "end" => get_field('date_end'),
    "img" => get_field('image')['link'],
    "post_id" => get_the_ID(),
  ];

  endwhile;
endif; 
wp_reset_postdata(); 
$js_array = json_encode($events);
?>


<script>
  var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
  var events = Object.values(<?php echo $js_array; ?>);
</script>


<?php wp_footer(); ?>


</html>

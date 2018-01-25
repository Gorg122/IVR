<?php
/**
 * Displays the user interface for the Testimonial Shortcode Manager meta box.
 *
 * This is a partial template that is included by the Testimonial Shortcode Manager
 * Admin class that is used to display all of the information that is related
 * to the post meta data for the given post.
 *
 * @package wp-easy-testimonial
 */
?>

<?php 
global $post;
?>
<label><?php _e('Copy this shortoce and paste in post or pages to show your testimonial.','wp-easy-testimonial'); ?></label>
<p>
	<input style="width:100%;" type="text" value="[wbr-single-testimonial id='<?php esc_attr_e( get_the_ID() ); ?>']" onfocus="this.select();">
</p>
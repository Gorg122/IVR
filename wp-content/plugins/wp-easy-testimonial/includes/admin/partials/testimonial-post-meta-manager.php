<?php
/**
 * Displays the user interface for the Testimonial Post Meta Manager meta box.
 *
 * This is a partial template that is included by the Testimonial Post Meta Manager
 * Admin class that is used to display all of the information that is related
 * to the post meta data for the given post.
 *
 * @package wp-easy-testimonial
 */
?>

<?php 
global $post;
		
$wtclientname = sanitize_text_field( get_post_meta( get_the_ID(), 'wtclientname', true ));
$wtclientemail = sanitize_email( get_post_meta( get_the_ID(), 'wtclientemail', true ));
$wtclientdesignation = sanitize_text_field( get_post_meta( get_the_ID(), 'wtclientdesignation', true ));
$wtclientrate2 = sanitize_text_field( get_post_meta( get_the_ID(), 'wtclientrate2', true ));
?>
<div class="form-field form-required">
	<label for="wtclientname">
		<b><?php _e('User Name :','wp-easy-testimonial'); ?></b>
	</label>
	<p><input type="text" name="wtclientname" id="wtclientname" value="<?php esc_attr_e($wtclientname); ?>"></p>						
	<p style="font-size:13px; font-style: italic;"><?php _e('Please enter testimonial user name.','wp-easy-testimonial'); ?></p>
</div>

<div class="form-field form-required">
	<label for="wtclientemail">
		<b><?php _e('Email Address :','wp-easy-testimonial'); ?></b>
	</label>
	<p><input type="email" name="wtclientemail" id="wtclientemail" value="<?php esc_attr_e($wtclientemail); ?>"></p>					
	<p style="font-size:13px; font-style: italic;"><?php _e('Please enter valid email address.','wp-easy-testimonial'); ?></p>
</div>

<div class="form-field form-required">
	<label for="wtclientdesignation">
		<b><?php _e('Designation :','wp-easy-testimonial'); ?></b>
	</label>
	<p><input type="text" name="wtclientdesignation" id="wtclientdesignation" value="<?php esc_attr_e($wtclientdesignation); ?>"></p>						
	<p style="font-size:13px; font-style: italic;"><?php _e('Please enter client position for testimonial.','wp-easy-testimonial'); ?></p>
</div>

<div class="form-field form-required">
	<label>
		<b><?php _e('Ratings :','wp-easy-testimonial'); ?></b>
		<p></p>
		<input name="wtclientrate2" id="wtclientrate2" value="<?php esc_attr_e($wtclientrate2); ?>" type="number" class="rating" min=0 max=5 step=1.0 data-size="xs" >
		<p style="font-size:13px; font-style: italic;"><?php _e('Please select client rating.','wp-easy-testimonial'); ?></p>
	</label>
</div><!-- .form-field .form-required -->
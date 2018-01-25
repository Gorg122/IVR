<?php 
	
/**
 * Admin shortcode option page HTML contents
 */
 
/**
 * Exit if accessed directly.
 *
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap wt-wrapper">
	
	<div class="format-setting-label">
		<h1><?php _e('Shortcodes Attributes','wp-easy-testimonial'); ?></h1>
	</div>
	
	<h3><?php _e('Short code attributes for showing list of testimonials','wp-easy-testimonial'); ?></h3>
	<p><?php echo sprintf(__("For displaying list of testimonials use shortcode along with required parameters <strong>[wbr-list-testimonials theme='testimonial-default light']</strong>. Below find all the attributes and their respective values which can be used along with this shortcode.",'wp-easy-testimonial')); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">theme</td>
			<td class="wff-att-name"><strong>testimonial-default | testimonial-default light | testimonial-default dark | testimonial-default shadow</strong></td>
			<td class="wff-att-uses">testimonial-default is the default theme. You can use other themes by specifying they respective values to get the desired look.
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name">cat</td>
			<td class="wff-att-name"><strong>cat-slug</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show all the testimonials of specific category.','wp-easy-testimonial'); ?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name">width</td>
			<td class="wff-att-name"><strong>px or %</strong></td>
			<td class="wff-att-uses"><?php _e('For example use 400px or 80%','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">show_thumbnail</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Show testimonial author image.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">thumbnail_align</td>
			<td class="wff-att-name"><strong>left | center | right</strong></td>
			<td class="wff-att-uses"><?php _e('	Select the alignment value to align testimonial author image. Default value is left.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">thumbnail_size</td>
			<td class="wff-att-name"><strong>default | small | medium | large</strong></td>
			<td class="wff-att-uses"><?php _e('	Use for specifying testimonial author image.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">thumbnail_type</td>
			<td class="wff-att-name"><strong>circle | rounded | thumbnail</strong></td>
			<td class="wff-att-uses"><?php _e('Use for adding frame to author image.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">gravatar</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('You can also use Gravatar for author image. This can be fetched via email id added in testimonial. If you did not want to use either gravatar or image than this attribure is for you.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">class</td>
			<td class="wff-att-name"><strong>abc</strong></td>
			<td class="wff-att-uses"><?php _e('Use additional class for testimonials.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">order</td>
			<td class="wff-att-name"><strong>ASC | DESC</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show tesimonials in ascending or descending order.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">orderby</td>
			<td class="wff-att-name"><strong>none | ID | date | modified </strong></td>
			<td class="wff-att-uses"><?php _e('Use for ordering users testimonials by testimonial post id, date published and modified.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">count</td>
			<td class="wff-att-name"><strong>5</strong></td>
			<td class="wff-att-uses"><?php _e('Use for displaying limited number of testimonials. By default all the testimonials are shown.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">show_title</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show tesimonial title which is on by default.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">show_date</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show tesimonial published date which is on by default.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">excerpt_length</td>
			<td class="wff-att-name"><strong>30</strong></td>
			<td class="wff-att-uses"><?php _e('Use for limiting tesimonial content length. By default 45 words will be shown.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">excerpt_text</td>
			<td class="wff-att-name"><strong>Read More</strong></td>
			<td class="wff-att-uses"><?php _e('Use for changing text of read more button generated after crossing excerpt length. By default it show "Read More".','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">more_button</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show All Testimonials button. ','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
	<h3><?php echo sprintf(__("Short code for displaying <i>Single Testimonial</i>", 'wp-easy-testimonial')); ?></h3>
	<p><strong><?php _e('Use Shortcode:','wp-easy-testimonial'); ?> [wbr-single-testimonial id="5"]</strong> <?php _e('although id is the main attribute here but you can also use above parameters with this shortcode.','wp-easy-testimonial'); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">id</td>
			<td class="wff-att-name"><strong>5</strong></td>
			<td class="wff-att-uses"><?php _e('Use for showing particular tesimonial. Specify the testimonial type post id of the one you want to display.','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
	<h3><?php echo sprintf(__("Short code for displaying <i>Random Testimonials</i>", 'wp-easy-testimonial')); ?></h3>
	<p><strong><?php _e('Shortcode:','wp-easy-testimonial'); ?> [wbr-random-testimonials cat="cat-slug"] </strong><?php _e('This shortcode also supports many attributes.','wp-easy-testimonial'); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">count</td>
			<td class="wff-att-name"><strong>Any Numeric Value</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show set of random testimonials. By default 1 is shown. For showing 2 testimonials randomly assign 2 as a value of count attribute.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">cat</td>
			<td class="wff-att-name"><strong>cat-slug</strong></td>
			<td class="wff-att-uses"><?php _e('Use to show random testimonials of specific category.','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
	<h3><?php echo sprintf(__("Short code for displaying <i>Testimonials in Grid Layout</i>", 'wp-easy-testimonial')); ?></h3>
	<p><strong><?php _e('Shortcode:','wp-easy-testimonial'); ?> [wbr-grid-testimonials cat="cat-slug"] </strong> <?php _e('The main attribute of this shortcode is column.','wp-easy-testimonial'); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">column</td>
			<td class="wff-att-name"><strong>1,2,3,4</strong></td>
			<td class="wff-att-uses"><?php _e('Use for showing testimonials in a grid layout. Use value 3 for showing testimonials in a 3 column grid.','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
	<h3><?php echo sprintf(__("Short code for displaying <i>Testimonials Slider</i>", 'wp-easy-testimonial')); ?></h3>
	<p><strong><?php _e('Shortcode:','wp-easy-testimonial'); ?> [wbr-slider-testimonials cat="cat-slug"]</strong> <?php _e('Below find the main attributes','wp-easy-testimonial'); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">column</td>
			<td class="wff-att-name"><strong>1,2,3,4,5</strong></td>
			<td class="wff-att-uses"><?php _e('Number of columns to show in tesimonial slider.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">type</td>
			<td class="wff-att-name"><strong>slide | fade</strong></td>
			<td class="wff-att-uses"><?php _e('Use to change slider effects.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">nav</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Use to manage navigation buttons.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">next</td>
			<td class="wff-att-name"><strong>Next</strong></td>
			<td class="wff-att-uses"><?php _e('Use to change label of <i>Next Button</i>','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">prev</td>
			<td class="wff-att-name"><strong>Prev</strong></td>
			<td class="wff-att-uses"><?php _e('Use to change label of <i>Previous Button</i>','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">pagination</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Use for showing slider pagination.','wp-easy-testimonial'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name">mousedrag</td>
			<td class="wff-att-name"><strong>1 or 0</strong></td>
			<td class="wff-att-uses"><?php _e('Useful for mobile devices. Scroll the slide by swiping fingure on your mobile device.','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
	<h3><?php echo sprintf(__("Short code for displaying <i>Count of Testimonials</i>", 'wp-easy-testimonial')); ?></h3>
	<p><strong><?php _e('Shortcode:','wp-easy-testimonial'); ?> [wbr-testimonials-count cat="cat-slug"]</strong> </p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode Attribute','wp-easy-testimonial'); ?></th>
		<th class="wff-att-name" scope="col"><?php _e('Values','wp-easy-testimonial'); ?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Theme attribute use','wp-easy-testimonial'); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr id="menu-locations-row">
			<td class="wff-att-name">cat</td>
			<td class="wff-att-name"><strong>cat-slug</strong></td>
			<td class="wff-att-uses"><?php _e('Use this attribute for fetching number of testimonials of specific category.','wp-easy-testimonial'); ?></td>
		</tr>
		
		</tbody>
	</table>
	
</div>
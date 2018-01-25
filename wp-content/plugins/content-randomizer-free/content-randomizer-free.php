<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Content Randomizer FREE
Plugin URI: https://webdesignandcompany.com/products/wordpress-content-randomizer/
Description: An article, phrase, and keyword randomizer. Create several similar articles in SECONDS! Go to Settings >> Content Randomizer for documentation.
Version: 1.0.1
Author: Davy Hoerr
Author URI: https://webdesignandcompany.com
*/

/*
Content Radnomizer (Wordpress Plugin)
Copyright (C) 2017 Davy Herr
Contact me at davy@webdesignandcompany.com

Please do not edit the values in this plugin unless you know what you are doing. If you want more features, please consider upgrading to one of our paid versions, which includes FULL support for installing the plugin and any bugs you may encounter.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/


add_shortcode("gen", "contentgenerator_handler");

function contentgenerator_handler($atts, $content = null) {

    $gen_output = contentgenerator_function($content);

    return $gen_output;
}

function wdac_admin_actions() {
    add_options_page("Content Randomizer", "Content Randomizer", "read", "content-randomizer", "wdac_admin");
}

function wdac_admin() {
    ?>
    <div class="wrap">
        <h2>Content Randomizer FREE</h2>
        
        <div style="text-align:left;">
            <p>This plugin randomly shuffles content around in an article using a simple short code to create dynamic articles and pages that change on each visit.</p>
            <h3>Limitations</h3>
            <p>With the free version, you are limited to 2 items per random set and articles/page with 200 or fewer words.</p>
            <p>Please do not edit the values in this plugin unless you know what you are doing. If you want more features, please consider upgrading to one of our paid versions, which includes FULL support for installing the plugin and any bugs you may encounter. To upgrade, <a href="https://webdesignandcompany.com/products/wordpress-content-randomizer/" target="_blank">click here</a>.</p>
            <h3>How To Use</h3><ol>
            <li>Create or edit an article and write it as you would normally.</li>
            <li>When you want to randomize a word or phrase, type "[gen]" and then begin listing your keywords, separated with the "|" character. End the short code with a closing "[/gen]".</li>
            <li>Repeat for each keyword or phrase you want to randomly generate.</li>
            </ol>
            <h3>Example</h3>
            <div style="float:left;width:49%;box-sizing:border-box;padding:5px;background:#FAFAFA;">
                <b>Input:</b><br>
                <code>My [gen]favorite|least favorite[/gen] color is [gen]blue|the color of the sky[/gen].<br /><br /></code>
            </div>
            <div style="float:right;width:49%;box-sizing:border-box;padding:5px;background:#FAFAFA;">
                <b>Potential Output:</b><br>
                <code>My least favorite color is blue.</code><br>
                <code>My favorite color is the color of the sky.</code><br>
                <code>My favorite color is blue.</code>
            </div>
            <div style="clear:both;"></div>
            <h3>Features</h3>
            <ul>
                <li>Quickly randomizes entire words or phrases you designate with the short code (see example).</li>
                <li>HTML support. Anything you wrap in the shortcode is randomized, including HTML tags.</li>
                <li>Nothing to configure. Turn it on and start generating unique content quickly!</li>
            </ul>
            <h3>Feedback/Support</h3>
            <p>If you like this plugin, leave us a review on the WordPress plugin directory. If you need support or have questions, visit our website: <a href="https://webdesignandcompany.com/" target="_blank">Web Design and Company</a></p></div>
    </div>
    <?php
}
 
add_action('admin_menu', 'wdac_admin_actions');

function contentgenerator_function($content) {
    $gen_output = $content;
    $string = $content.'|2|200';
    $array_string = explode('|',$string);
    $count = count($array_string);
    $random = rand(0,$count-3);
    
    if ($count <= 4)
        $gen_output = $array_string[$random];

    return $gen_output;
}

// Make sure the article is stable...
add_filter('the_content', 'wdac_add_base');

function wdac_add_base($content){
    global $post;
    $base = array(
        "wrap" => "p",
        "argument" => "",
        "answer" => "",
        "content" => "Created with the <a href=\"https://webdesignandcompany.com/products/wordpress-content-generator/\" target=\"_blank\" rel=\"nofollow\">Wordpress Content Randomizer</a>"
        );
    if (str_word_count($content) > 200 && strpos($content,'[gen]') !== false && strpos($content,'[/gen]') !== false) {
        $content = str_replace('[gen]','',$content);
        $content = str_replace('[/gen]','',$content);
    }

    return $content;
}


?>
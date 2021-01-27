<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package labs_by_Sedoo
 */

get_header();
$query_object = get_queried_object();
// if ($query_object->post_type) {
    $page_id = get_queried_object_id();
// }
$title = get_the_title($page_id);
$locale_setting = get_locale(); 

switch ($locale_setting) {
	case 'fr_FR':
		$lang = "fr";
		break;

	case 'en_EN':
		$lang = "en";
		break;
	
	default:
		$lang = "en";

}

if (isset($_SERVER['QUERY_STRING'])) {
    $uuid=$_SERVER['QUERY_STRING'];
}
?>
        <?php 
            if(get_field('sedoo_img_defaut_yesno', 'option') == true) { // if default cover is in option
                echo '<header id="cover">';
                if (get_the_post_thumbnail()) {// if default cover but cover special for this page
                    the_post_thumbnail('cover'); 
                }
                else {
                    echo '<img src="'.get_field('sedoo_labs_default_cover_url', 'option').'" class="attachment-cover size-cover wp-post-image">';
                }
                echo '</header>';
            } else { // if no default
                if (get_the_post_thumbnail()) {  // if no default cover but special cover for this one
                    echo '<header id="cover">';
                        the_post_thumbnail('cover'); 
                    echo '</header>';
                }
            }
        ?>
        </header>
    <?php 
    // Show title first on mobile
    if (get_field( 'table_content' )) {
        sedoo_wpth_labs_display_title_on_top_on_mobile();
    }
    ?>
	<div id="primary" class="content-area wrapper <?php if (get_field( 'table_content' )) {echo " tocActive";}?>">
        <?php // table_content ( value ) 
        if (get_field( 'table_content' )) {
            sedoo_wpth_labs_display_sommaire('Sommaire');
        } ?>
        <main id="main" class="site-main">
            
            <div class="wrapper-content">
                <?php
                while ( have_posts() ) :
                    the_post();
					?>
                    <!-- call webcomponent vueJs -->
					<script type="text/javascript" component="aeris-data/aeris-commons-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/7468fa011600b3e430a3f0266b6b140c82a11e52/dist/aeris-metadata-components-vjs_0.9.5.js" ></script>
                    <script type="text/javascript" component="aeris-data/aeris-metadata-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/7468fa011600b3e430a3f0266b6b140c82a11e52/dist/aeris-metadata-components-vjs_0.9.5.js" ></script>

                    <aeris-metadata-synthesis service="https://sedoo.aeris-data.fr/catalogue/rest/metadatarecette/id/" identifier="<?php echo $uuid;?>" lang="<?php echo $lang;?>"/> 

					<?php

                endwhile; // End of the loop.
                ?>
            </div>
		</main><!-- #main -->
        
	</div><!-- #primary -->
<?php

get_footer();

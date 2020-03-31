<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sedoo
 */


get_header(); 

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
// 2a053c64-259a-3ad3-8b94-a150d6c84223

while ( have_posts() ) : the_post();
	$post_slug=$post->post_name;

	get_template_part( 'template-parts/header-content', 'page' );
?>

	<div id="content-area" class="fullwidth">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<section class="wrapper-content">
					<!-- call webcomponent vueJs -->
					<script type="text/javascript" component="aeris-data/aeris-commons-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/b446f1cdf25d081f60376ea281affc5ebd4ba0c4/dist/aeris-metadata-components-vjs_0.9.4.js" ></script>
                    <script type="text/javascript" component="aeris-data/aeris-metadata-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/b446f1cdf25d081f60376ea281affc5ebd4ba0c4/dist/aeris-metadata-components-vjs_0.9.4.js" ></script>

                    <aeris-metadata-synthesis service="https://sedoo.aeris-data.fr/catalogue/rest/metadatarecette/id/" identifier="<?php echo $uuid;?>" lang="<?php echo $lang;?>"/> 

		        </section>				
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
endwhile; // End of the loop.

// get_sidebar();
get_footer();

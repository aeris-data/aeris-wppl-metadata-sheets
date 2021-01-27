<?php
/**
 * The template for displaying all one metadata sheet
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


// get the current taxonomy term
$term = get_queried_object();
$code_color=labs_by_sedoo_main_color();
$tax_layout = get_field('tax_layout', $term);
$cover = get_field( 'tax_image', $term);
$no_result_text = get_field('no_results_text_tax');	
$affichage_portfolio = get_field('sedoo_affichage_en_portfolio', $term);
?>

	<div id="content-area" class="wrapper archives">
		<main id="main" class="site-main">
		<?php
		if ( !empty($cover)) {
				$coverStyle = "background-image:url(".$cover['url'].")";
			 
			// else {
			// 	$coverStyle = "border-top:5px solid ".$code_color.";height:auto;";
			// }
			?>
			
			<header id="cover" class="page-header" style="<?php echo $coverStyle;?>">
				
			</header><!-- .page-header -->
			<?php
			}
			?>				
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<section class="wrapper-content">
					<!-- call webcomponent vueJs -->
					<script type="text/javascript" component="aeris-data/aeris-commons-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/7468fa011600b3e430a3f0266b6b140c82a11e52/dist/aeris-metadata-components-vjs_0.9.5.js" ></script>
                    <script type="text/javascript" component="aeris-data/aeris-metadata-components-vjs@latest" src="https://rawcdn.githack.com/aeris-data/aeris-metadata-components-vjs/7468fa011600b3e430a3f0266b6b140c82a11e52/dist/aeris-metadata-components-vjs_0.9.5.js" ></script>

                    <aeris-metadata-synthesis service="https://sedoo.aeris-data.fr/catalogue/rest/metadatarecette/id/" identifier="<?php echo $uuid;?>" lang="<?php echo $lang;?>"/> 

		        </section>				
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();


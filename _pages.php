<?php
/*
Plugin Name: Child Pages Shortcode 2
Author: Takayuki Miyauchi
Plugin URI: https://github.com/miya0001/miya-underscore-pagess-shortcode
Description: A WordPress shotcode plugin which displays child pages.
Version: nightly
Author URI: http://miya.io/
*/

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

add_action( 'init', '_pages_activate_updater' );

function _pages_activate_updater() {
	$plugin_slug = plugin_basename( __FILE__ );
	$gh_user = 'miya0001';
	$gh_repo = '_pages';
	// Activate automatic update.
	new Miya\WP\GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );
}

$child_pages_shortcode = new _Pages();

class _Pages
{
	const version = "nightly";

	function __construct()
	{
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	function plugins_loaded()
	{
		add_shortcode( "pages", array( $this, "shortcode" ) );
	}

	public function shortcode( $p )
	{
		$default = apply_filters( '_pages_defaults', array(
			'id' => get_the_ID(),
			'size' => 'post-thumbnail',
			'col' => 3,
		) );

		$p = shortcode_atts( $default, $p, '_pages' );

		wp_enqueue_script(
			'underscore-pages',
			plugins_url( 'js/script.min.js', __FILE__ ),
			array(),
			self::version,
			true
		);

		return $this->display( $p );
	}

	private function display( $p )
	{
		global $post;

		$html = '';

		$args = array(
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $p['id'],
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'nopaging' => true,
		);

		/*
		 * Filter the query args for the get_posts()
		 *
		 * @since none
		 * @param array $args Query args. See http://codex.wordpress.org/Class_Reference/WP_Query#Parameters.
		 */
		$args = apply_filters( '_pages_query', $args, $p );

		$pages = get_posts( $args );
		foreach ( $pages as $post ) {
			setup_postdata( $post );

			/*
			 * Filter the $post data.
			 *
			 * @since none
			 * @param object $post Post data.
			 */
			$post = apply_filters( '_pages_object', $post );
			$url = get_permalink( $post->ID );
			$img = get_the_post_thumbnail( $post->ID, $p['size'] );

			$tpl = $this->get_template();
			$tpl = str_replace( '%post_id%', intval( $post->ID ), $tpl );
			$tpl = str_replace( '%post_title%', esc_html( $post->post_title ), $tpl );
			$tpl = str_replace( '%post_url%', esc_url( $url ), $tpl );
			$tpl = str_replace( '%post_thumbnail%', $img, $tpl );
			$tpl = str_replace( '%thumbnail_size%', esc_attr( $p['size'] ), $tpl );
			$tpl = str_replace( '%post_excerpt%', esc_html( $post->excerpt ), $tpl );

			foreach ( $p as $key => $value ) {
				$tpl = str_replace( '%' . $key . '%', esc_html( $value ), $tpl );
			}

			$html .= $tpl;
		}

		wp_reset_postdata();

		return sprintf(
			'<div class="underscore-pages col-%d">%s</div>',
			esc_attr( $p['col'] ),
			$html
		);
	}

	private function get_template()
	{
		$html = '<section class="item page-%post_id% thumbnail-size-%thumbnail_size%">';
		$html .= '<a href="%post_url%">';
		$html .= '<div class="post-thumbnail">%post_thumbnail%</div>';
		$html .= '<h3 class="post-title">%post_title%</h3>';
		$html .= '</a>';
		$html .= '</section>';

		return apply_filters( '_pages_template', $html );
	}

} // end class

// eof

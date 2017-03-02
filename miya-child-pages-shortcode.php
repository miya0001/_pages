<?php
/*
Plugin Name: Child Pages Shortcode 2
Author: Takayuki Miyauchi
Plugin URI: https://github.com/miya0001/miya-child-pages-shortcode
Description: A WordPress shotcode plugin which displays child pages.
Version: nightly
Author URI: http://miya.io/
*/

$child_pages_shortcode = new Child_Pages_Shortcode();

class Child_Pages_Shortcode
{
	function __construct()
	{
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	function plugins_loaded()
	{
		add_shortcode( "child_pages", array( $this, "shortcode" ) );
	}

	public function shortcode( $p )
	{
		$default = apply_filters( 'child_pages_shortcode_defaults', array(
			'id' => get_the_ID(),
			'size' => 'post-thumbnail',
			'width' => '33%',
		) );

		$p = shortcode_atts( $default, $p, 'child_pages' );

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
		$args = apply_filters( 'child_pages_shortcode_query', $args, $p );

		$pages = get_posts( $args );
		foreach ( $pages as $post ) {
			setup_postdata( $post );

			/*
			 * Filter the $post data.
			 *
			 * @since none
			 * @param object $post Post data.
			 */
			$post = apply_filters( 'child_pages_shortcode_post', $post );
			$url = get_permalink( $post->ID );
			$img = get_the_post_thumbnail( $post->ID, $p['size'] );

			$tpl = $this->get_template();
			$tpl = str_replace( '%post_id%', intval( $post->ID ), $tpl );
			$tpl = str_replace( '%post_title%', esc_html( $post->post_title ), $tpl );
			$tpl = str_replace( '%post_url%', esc_url( $url ), $tpl );
			$tpl = str_replace( '%post_thumbnail%', $img, $tpl );
			$tpl = str_replace( '%post_excerpt%', esc_html( $post->excerpt ), $tpl );

			foreach ( $p as $key => $value ) {
				$tpl = str_replace( '%' . $key . '%', $value, $tpl );
			}

			$html .= $tpl;
		}

		wp_reset_postdata();

		$container = apply_filters(
			'child_pages_shortcode_container',
			'<div class="child-pages">%content%</div>'
		);

		foreach ( $p as $key => $value ) {
			$container = str_replace( '%' . $key . '%', $value, $container );
		}

		$html = str_replace( '%content%', $html, $container );

		/*
		 * Filter the output.
		 *
		 * @since none
		 * @param string $html	 Output of the child pages.
		 * @param array  $pages	An array of child pages.
		 * @param string $template Template HTML for output.
		 */
		return apply_filters( "child_pages_shortcode_output", $html, $pages, $p );
	}

	private function get_template()
	{
		$html = '<section id="child-page-%post_id%" class="child-page" style="width: %width%;"><div class="child-page-container">';
		$html .= '<div class="post-thumbnail"><a href="%post_url%">%post_thumbnail%</a></div>';
		$html .= '<h2 class="post-title"><a href="%post_url%">%post_title%</a></h2>';
		$html .= '<p class="post-excerpt">%post_excerpt%</p>';
		$html .= '</div></section>';

		return apply_filters( 'child_pages_shortcode_template', $html );
	}

} // end class

// eof

<?php
/**
 * Class SampleTest
 *
 * @package Child_Pages_Shortcode
 */

/**
 * Sample test case.
 */
class _Pages_Test extends WP_UnitTestCase
{
	/**
	 * A single example test.
	 */
	function test_display()
	{
		$this->factory()->post->create_many( 20 );

		$query = array(
			'posts_per_page' => 6,
			'post_status' => 'publish',
			'post_type' => 'post',
		);

		$result = _Pages::get_instance()->display( $query, 3 );

		$this->assertMaybeValidHTML( $result );

		$dom = $this->dom( $result );

		$this->assertSame( 1, count( $dom->filter( '.col-3' ) ) );
		$this->assertSame( 6, count( $dom->filter( 'section.item' ) ) );
	}

	private function dom( $html )
	{
		$dom = new Symfony\Component\DomCrawler\Crawler();
		$dom->addHTMLContent( $html, "UTF-8" );
		return $dom;
	}

	private function assertMaybeValidHTML( $html )
	{
		$html = str_replace( 'section', 'div', $html );
		$html = str_replace( 'aside', 'div', $html );
		$dom = new DOMDocument();
		$dom->loadHTML( '<html><body>' . $html . '</body></html>' );
	}
}

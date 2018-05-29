<?php

namespace Dashiki;

use JsonConfig\JCContent;
use JsonConfig\JCDefaultContentView;
use Html;
use MediaWiki\Shell\Shell;
use ParserOptions;
use ParserOutput;
use Title;

/**
 * Used to render Dashiki JSON configuration pages to HTML
 * @package Dashiki
 */
class DashikiView extends JCDefaultContentView {

	/**
	 * Customizes valueToHtml() for Dashiki
	 *
	 * @param JCContent $content
	 * @param Title $title Context title for parsing
	 * @param int|null $revId Revision ID (for {{REVISIONID}})
	 * @param ParserOptions $options Parser options
	 * @param bool $generateHtml Whether or not to generate HTML
	 * @param ParserOutput &$output The output object to fill (reference).
	 * @return string
	 */
	public function valueToHtml(
		JCContent $content, Title $title, $revId, ParserOptions $options, $generateHtml,
		ParserOutput &$output
	) {
		$header = $this->renderHeader( $title->getDBKey() );
		$tableDisplay = parent::valueToHtml(
			$content, $title, $revId, $options, $generateHtml, $output
		);
		return $header . $tableDisplay;
	}

	/**
	 * @param string $dbkey
	 * @return string HTML
	 */
	public function renderHeader( $dbkey ) {
		$buildMessage = wfMessage( 'dashiki-build' );
		$span = Html::element( 'span', null, $buildMessage );
		$pre = Html::element( 'pre', null,
			'gulp --config ' . Shell::escape( $dbkey ) . ' --layout /*...*/' );
		return $span . $pre;
	}
}

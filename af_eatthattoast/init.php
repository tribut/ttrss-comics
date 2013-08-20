<?php
class af_eatthattoast extends Plugin {
	function about() {
		return array(0.1,
			'Add large images for comic "Eat That Toast"',
			'dxbi');
	}

	function init($host) {
		$host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
	}

	function hook_article_filter($article) {
		if (strpos($article['link'], 'eatthattoast.com/comic/') !== FALSE) {
			$article['content'] = preg_replace('#(/[0-9-]+)-150x150\.gif#', '$1.gif', $article['content']);
			$article['content'] = preg_replace('#(width|height)="150"#', '', $article['content']);
		}

		return $article;
	}

	function api_version() {
		return 2;
	}
}


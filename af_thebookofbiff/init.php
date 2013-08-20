<?php
class af_thebookofbiff extends Plugin {
	function about() {
		return array(0.1,
			'Add large images for comic "Eat Book of Biff"',
			'dxbi');
	}

	function init($host) {
		$host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
	}

	function hook_article_filter($article) {
		if (strpos($article['link'], 'www.thebookofbiff.com/20') !== FALSE) {
			$article['content'] = preg_replace('#/archives/([0-9a-zA-Z-]+)\.png#', '/comics/$1.png', $article['content']);
		}

		return $article;
	}

	function api_version() {
		return 2;
	}
}


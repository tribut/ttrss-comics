<?php
class af_gucomics extends Plugin {
	function about() {
		return array(0.1,
			'Add images to GU Comics feed',
			'dxbi');
	}

	function init($host) {
		$host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
	}

	function hook_article_filter($article) {
		if (strpos($article['link'], 'gucomics.com/comic') !== FALSE) {
			if (preg_match(
				'/(?P<year>[0-9]{4})(?P<month>[0-9]{2})(?P<day>[0-9]{2})$/',
				$article['link'],
				$match
			)) {
				// move short descriptions to the title
				if (preg_match('/[^<>]{0,50}/', $article['content'])) {
					$article['title'] = $article['content'];
					$article['content'] = '';
				}
				// add image inline
				$article['content'] = '<p><img src="http://www.gucomics.com/comics/' .
					$match['year'] . '/gu_' .
					$match['year'] . $match['month'] . $match['day'] .
					'.jpg"></p>' . $article['content'];
			}
		}

		return $article;
	}

	function api_version() {
		return 2;
	}
}


<?php
class af_toothpaste extends Plugin {
	function about() {
		return array(
			0.1,
			'Add images for comic "Toothpaste for dinner"',
			'dxbi'
		);
	}

	function api_version() {
		return 2;
	}

	function init($host) {
		$host->add_hook($host::HOOK_RENDER_ARTICLE_CDM, $this);
		$host->add_hook($host::HOOK_RENDER_ARTICLE, $this);
	}

	function hook_render_article_cdm($article) {
		return $this->hook_render_article($article);
	}

	function hook_render_article($article) {
		if (strpos($article['link'], 'toothpastefordinner.com') !== FALSE) {
			$datestr = date('mdy', strtotime($article['updated']));
			$urltitle = preg_replace('/[^a-zA-Z]/', '-', $article['title']);
			$article['content'] = '<p><img src="http://www.toothpastefordinner.com/' .
				$datestr . '/' . $urltitle .
				'.gif"></p>' . $article['content'];
		}
		return $article;
	}
}


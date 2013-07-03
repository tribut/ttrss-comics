<?php
class af_npccomic extends Plugin {
	function about() {
		return array(0.1,
			'Add im	ages to NPC comic feeds',
			'dxbi');
	}

	function init($host) {
		$host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
	}

	function hook_article_filter($article) {
		$owner_uid = $article['owner_uid'];

		if (strpos($article['guid'], 'npccomic.com/20') !== FALSE) {
			if (strpos($article['plugin_data'], "npccomic,$owner_uid:") === FALSE) {
				$doc = new DOMDocument();
				@$doc->loadHTML(fetch_file_contents($article["link"]));

				$basenode = false;
				if ($doc) {
					$xpath = new DOMXPath($doc);
					$entries = $xpath->query("(//div[@class='comic-content']//img[@src])");

					if ($entries) {
						foreach ($entries as $entry) {
							if (preg_match("#/comics/[0-9]{4}-[0-9]{2}-[0-9]{2}_[a-z]+#i", $entry->getAttribute("src"))) {
								$basenode = $entry;
								break;
							}
						}
					}

					if ($basenode) {
						$article["content"] = $doc->saveXML($basenode) . $article["content"];
						$article["plugin_data"] = "npccomic,$owner_uid:" . $article["plugin_data"];
					}
				}
			} else if (isset($article["stored"]["content"])) {
				$article["content"] = $article["stored"]["content"];
			}
		}

		return $article;
	}

	function api_version() {
		return 2;
	}
}
?>

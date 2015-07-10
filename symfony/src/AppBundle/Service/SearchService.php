<?php
namespace AppBundle\Service;

use AppBundle\Model\SearchResult;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerAware;

class SearchService extends ContainerAware {

	private static $SERVER = 'http://en.wikipedia.org/w/';

	/**
	 * @param string $term The search term
	 * @return array With SearchResult elements or empty array of no pages where found
	 */
	public function findWikipediaPages($term) {
		$client = new Client();
		$response = $client->get(self::$SERVER . 'api.php', array(
			'query' => array(
				'action' => 'opensearch',
				'search' => $term,
				'format' => 'json',
				'limit' => 20
			),
			'headers' => $this->buildClientHeaders()
		));

		$body = $response->getBody();
		$parsedBody = json_decode($body, true);
		return $this->markFavorites($this->convertResponseToArrayOfSearchResultObjects($parsedBody), $parsedBody[3]);
	}

	/**
	 * @param array $results The parsed results
	 * @param array $urls Array with just urls
	 * @return array With SearchResult elements or empty array of no pages where found
	 */
	private function markFavorites(array $results, array $urls) {
		return $this->getFavoriteSearchResultService()->markFavorites($results, $urls);
	}

	/**
	 * @param array $response The api response
	 * @return array With SearchResult elements or empty array of no pages where found
	 */
	private function convertResponseToArrayOfSearchResultObjects(array $response) {
		$results = array();

		$numResults = count($response[1]);
		for ($i = 0; $i < $numResults; $i++) {
			$results[] = new SearchResult($response[1][$i], $response[2][$i], $response[3][$i]);
		}

		return $results;
	}

	/**
	 * @return array
	 */
	private function buildClientHeaders() {
		return array(
			'User-Agent' => 'WikipediaViewer/1.0'
		);
	}

	/**
	 * @return \AppBundle\Service\FavoriteSearchResultService
	 */
	private function getFavoriteSearchResultService() {
		return $this->container->get('app.favorite_search_result');
	}
}

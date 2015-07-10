<?php
namespace AppBundle\Service;

use AppBundle\Entity\FavoriteSearchResult;
use AppBundle\Entity\User;
use AppBundle\Model\SearchResult;
use AppBundle\Repository\FavoriteSearchResultRepository;
use Symfony\Component\DependencyInjection\ContainerAware;

class FavoriteSearchResultService extends ContainerAware {


	/**
	 * @param array $results The parsed results
	 * @param array $urls Array with just urls
	 * @return array With SearchResult elements or empty array of no pages where found
	 */
	public function markFavorites(array $results, array $urls) {
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		if(!($user instanceof User)) {
			return $results;
		}

		/** @var FavoriteSearchResultRepository $repository */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:FavoriteSearchResult');
		$urls = $repository->findAllFavoredUrls($user, $urls);
		$urlsArray = $this->favoriteSearchResultToUrlArray($urls);

		foreach($results as $result) {
			/** @var SearchResult $result */
			if(in_array($result->getUrl(), $urlsArray)) {
				$result->setFavorite(true);
			}
		}
		return $results;
	}

	private function favoriteSearchResultToUrlArray(array $results) {
		$urls = array();
		foreach($results as $result) {
			/** @var FavoriteSearchResult $result */
			$urls[] = $result->getUrl();
		}
		return $urls;
	}

}

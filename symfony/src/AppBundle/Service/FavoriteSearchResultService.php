<?php
namespace AppBundle\Service;

use AppBundle\Entity\FavoriteSearchResult;
use AppBundle\Entity\User;
use AppBundle\Model\SearchResult;
use AppBundle\Repository\FavoriteSearchResultRepository;
use Doctrine\Common\Persistence\ObjectManager;
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

	/**
	 * @param $url string The url
	 * @param $title string The title
	 */
	public function markAsFavorite($url, $title) {
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		if(!($user instanceof User)) {
			return;
		}

		/** @var FavoriteSearchResultRepository $repository */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:FavoriteSearchResult');
		$favorite = $repository->findFavoredUrl($user, $url, $title);
		if($favorite == null) {
			$favorite = new FavoriteSearchResult();
			$favorite->setUser($user);
			$favorite->setUrl($url);
			$favorite->setTitle($title);

			/** @var ObjectManager $registry */
			$om = $this->container->get('doctrine')->getManager();
			$om->persist($favorite);
			$om->flush();
		}
	}

	/**
	 * @param $url string The url
	 * @param $title string The title
	 */
	public function unMarkAsFavorite($url, $title) {
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		if(!($user instanceof User)) {
			return;
		}

		/** @var FavoriteSearchResultRepository $repository */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:FavoriteSearchResult');
		$favorite = $repository->findFavoredUrl($user, $url, $title);
		if($favorite != null) {
			/** @var ObjectManager $registry */
			$om = $this->container->get('doctrine')->getManager();
			$om->remove($favorite);
			$om->flush();
		}
	}

	/**
	 * @param array $results The FavoriteSearchResult array
	 * @return array string array with just the urls
	 */
	private function favoriteSearchResultToUrlArray(array $results) {
		$urls = array();
		foreach($results as $result) {
			/** @var FavoriteSearchResult $result */
			$urls[] = $result->getUrl();
		}
		return $urls;
	}

}

<?php
namespace AppBundle\Controller;

use AppBundle\Entity\FavoriteSearchResult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FavoriteSearchResultController extends Controller {

	/**
	 * @Route("/favorites")
	 * @Template()
	 *
	 * @param Request $request The symfony request
	 * @return Response
	 */
	public function listAction(Request $request) {
		$favorites = $this->getFavoriteSearchResultService()->getFavorites();

		$link = null;
		if(count($favorites) > 0) {
			$link = $request->get('link', '');
			$link = $this->findResultForLink($favorites, $link);
			if($link == null) {
				$link = $favorites[0];
			}
		}

		return array(
			'favorites' => $favorites,
			'link' => $link
		);
	}

	/**
	 * @Route("/search-favorite-mark")
	 *
	 * @param Request $request The symfony request
	 * @return Response
	 */
	public function markAction(Request $request) {
		$url = $request->get('url');
		$title = $request->get('title');
		if(empty($url) || empty($title)) {
			throw new BadRequestHttpException('url and title are required!');
		}

		$this->getFavoriteSearchResultService()->markAsFavorite($url, $title);
		return $this->createResponse($request, $url);
	}

	/**
	 * @Route("/search-favorite-un-mark")
	 *
	 * @param Request $request The symfony request
	 * @return Response
	 */
	public function unMarkAction(Request $request) {
		$url = $request->get('url');
		$title = $request->get('title');
		if(empty($url) || empty($title)) {
			throw new BadRequestHttpException('url and title are required!');
		}

		$this->getFavoriteSearchResultService()->unMarkAsFavorite($url, $title);
		return $this->createResponse($request, $url);
	}

	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request The symfony request
	 * @param $url string The article url
	 * @return Response
	 */
	private function createResponse(Request $request, $url) {
		$ajax = $request->get('ajax', false);
		if($ajax) {
			return Response::create('', 201);
		}

		$q = $request->get('q');
		if(!empty($q)) {
			return $this->redirectToRoute('app_search_search', array(
				'q' => $q,
				'link' => $url
			));
		}
		else {
			return $this->redirectToRoute('app_favoritesearchresult_list');
		}
	}

	/**
	 * @return \AppBundle\Service\FavoriteSearchResultService
	 */
	private function getFavoriteSearchResultService() {
		return $this->container->get('app.favorite_search_result');
	}

	/**
	 * @param array $favorites The favorites that needs to be searched
	 * @param string $link The link to search for
	 * @return FavoriteSearchResult|null The favorite search result where the link belong to
	 */
	private function findResultForLink(array $favorites, $link) {
		if($link == '') {
			return null;
		}

		foreach($favorites as $favorite) {
			/** @var FavoriteSearchResult $favorite */
			if($favorite->getUrl() == $link) {
				return $favorite;
			}
		}
		return null;
	}

}
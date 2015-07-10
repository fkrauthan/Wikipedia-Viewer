<?php
namespace AppBundle\Controller;

use AppBundle\Model\SearchResult;
use AppBundle\Service\SearchService;
use AppBundle\Service\SearchTermService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FavoriteSearchResultController extends Controller {

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
			//TODO redirect to favorites page
		}
	}

	/**
	 * @return \AppBundle\Service\FavoriteSearchResultService
	 */
	private function getFavoriteSearchResultService() {
		return $this->container->get('app.favorite_search_result');
	}

}
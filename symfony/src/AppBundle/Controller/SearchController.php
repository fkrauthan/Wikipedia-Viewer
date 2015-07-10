<?php
namespace AppBundle\Controller;

use AppBundle\Model\SearchResult;
use AppBundle\Service\SearchService;
use AppBundle\Service\SearchTermService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller {

	/**
	 * @Route("/search")
	 *
	 * @param Request $request The symfony request
	 * @return Response
	 */
	public function searchAction(Request $request) {
		$searchTerm = $request->get('q', '');
		$searchResults = array();

		if (!empty($searchTerm)) {
			$searchResults = $this->getSearchService()->findWikipediaPages($searchTerm);
		}

		if (count($searchResults) == 0) {
			$topSearchTerms = $this->getSearchTermService()->getTop5SearchTerms();

			return $this->render('AppBundle:Search:no_results.html.twig', array('q' => $searchTerm, 'topSearchTerms' => $topSearchTerms));
		}
		else {
			$this->getSearchTermService()->track($searchTerm);

			$link = $request->get('link', '');
			$link = $this->findResultForLink($searchResults, $link);
			if ($link == null) {
				$link = $searchResults[0];
			}

			return $this->render('AppBundle:Search:results.html.twig', array('q' => $searchTerm, 'results' => $searchResults, 'link' => $link));
		}
	}

	/**
	 * @param array $searchResults The search results that needs to be searched
	 * @param string $link The link to search for
	 * @return SearchResult|null The search result where the link belong to
	 */
	private function findResultForLink(array $searchResults, $link) {
		if ($link == '') {
			return null;
		}

		foreach ($searchResults as $result) {
			/** @var SearchResult $result */
			if ($result->getUrl() == $link) {
				return $result;
			}
		}
		return null;
	}

	/**
	 * @return SearchService
	 */
	private function getSearchService() {
		return $this->container->get('app.search');
	}

	/**
	 * @return SearchTermService
	 */
	private function getSearchTermService() {
		return $this->container->get('app.search_term');
	}

}
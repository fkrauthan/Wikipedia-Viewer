<?php
namespace AppBundle\Controller;

use AppBundle\Entity\SearchTerm;
use AppBundle\Service\SearchTermService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SearchTermController extends Controller {


	/**
	 * @Route("/search-suggestions")
	 * @Method("POST")
	 *
	 * @param Request $request The symfony request
	 * @return Response
	 */
	public function suggestAction(Request $request) {
		$term = $request->get('q', '');
		if (strlen($term) < 1) {
			throw new AccessDeniedHttpException('You have to provide at least 3 characters for suggestions!');
		}

		$suggestions = $this->getSearchTermService()->getTop5Suggestions($term);
		$suggestionsArray = array();
		foreach ($suggestions as $suggestion) {
			/** @var SearchTerm $suggestion */
			$suggestionsArray[] = $suggestion->getTerm();
		}

		return Response::create(json_encode($suggestionsArray), 200, array(
			'Content-Type' => 'application/json'
		));
	}

	/**
	 * @return SearchTermService
	 */
	private function getSearchTermService() {
		return $this->container->get('app.search_term');
	}

}

<?php
namespace AppBundle\Controller;

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

		return $this->render('AppBundle:Search:no_results.html.twig', array('q' => $searchTerm));
	}

}
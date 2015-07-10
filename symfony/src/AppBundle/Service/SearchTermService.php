<?php
namespace AppBundle\Service;

use AppBundle\Entity\SearchTerm;
use AppBundle\Repository\SearchTermRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

class SearchTermService extends ContainerAware {

	/**
	 * @param $term string The search term to track
	 */
	public function track($term) {
		/** @var ObjectManager $registry */
		$om = $this->container->get('doctrine')->getManager();

		/** @var SearchTermRepository $repository */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:SearchTerm');
		$qb = $repository->createQueryBuilder('s');
		$query = $qb->update('AppBundle:SearchTerm', 's')
			->set('s.count', 's.count+1')
			->where('s.term = :term')
			->setParameter('term', $term)
			->getQuery();
		$updated = $query->execute();

		if($updated == 0) {
			$searchTerm = new SearchTerm();
			$searchTerm->setTerm($term);
			$searchTerm->setCount(1);

			$om->persist($searchTerm);
			$om->flush();
		}
	}

	/**
	 * @return array Top 5 SearchTerm entries
	 */
	public function getTop5SearchTerms() {
		/** @var SearchTermRepository $om */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:SearchTerm');
		return $repository->findTopXSearchTerms(5);
	}

	/**
	 * @param $term string The term you wanna have suggestions for
	 * @return array Top 5 SearchTerm suggestions for the given term
	 */
	public function getTop5Suggestions($term) {
		/** @var SearchTermRepository $om */
		$repository = $this->container->get('doctrine')->getRepository('AppBundle:SearchTerm');
		return $repository->findTopXSearchTermSuggestions(5, $term);
	}

}

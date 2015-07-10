<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SearchTermRepository extends EntityRepository {

	/**
	 * @param $count int How many search terms should be returned
	 * @return array of top x search terms
	 */
	public function findTopXSearchTerms($count) {
		$query = $this->createQueryBuilder('s')
			->orderBy('s.count', 'DESC')
			->setMaxResults($count)
			->getQuery();
		return $query->getResult();
	}

	/**
	 * @param $count int How many search terms suggestions should be returned
	 * @param $term string The term we should return suggestions for
	 * @return array of top x search term suggestions
	 */
	public function findTopXSearchTermSuggestions($count, $term) {
		$query = $this->createQueryBuilder('s')
			->where('s.term LIKE :term')
			->orderBy('s.count', 'DESC')
			->setParameter('term', '%' . $term . '%')
			->setMaxResults($count)
			->getQuery();
		return $query->getResult();
	}

}

<?php
namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class FavoriteSearchResultRepository extends EntityRepository {

	/**
	 * @param User $user The user we wanna find the favored urls for
	 * @param array $urls Urls to look for if they are favored
	 * @return array of FavoriteSearchResult objects that are actually favored
	 */
	public function findAllFavoredUrls(User $user, array $urls) {
		$query =  $this->createQueryBuilder('f')
			->where('f.user = :user and f.url in :urls')
			->setParameter('user', $user)
			->setParameter('urls', $urls)
			->getQuery();
		return $query->getResult();
	}

}

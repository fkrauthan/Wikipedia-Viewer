<?php
namespace AppBundle\Repository;

use AppBundle\Entity\FavoriteSearchResult;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class FavoriteSearchResultRepository extends EntityRepository {

	/**
	 * @param User $user The user we wanna find the favored urls for
	 * @param array $urls Urls to look for if they are favored
	 * @return array of FavoriteSearchResult objects that are actually favored
	 */
	public function findAllFavoredUrls(User $user, array $urls) {
		$query =  $this->createQueryBuilder('f')
			->where('f.user = :user and f.url in (:urls)')
			->setParameter('user', $user)
			->setParameter('urls', $urls)
			->getQuery();
		return $query->getResult();
	}

	/**
	 * @param \AppBundle\Entity\User $user the user
	 * @param $url string the page url
	 * @param $title string the title
	 * @return FavoriteSearchResult|null the favorite search result or null of it was not found
	 */
	public function findFavoredUrl(User $user, $url, $title) {
		$query =  $this->createQueryBuilder('f')
			->where('f.user = :user and f.url = :url and f.title = :title')
			->setParameter('user', $user)
			->setParameter('url', $url)
			->setParameter('title', $title)
			->getQuery();

		try {
			return $query->getSingleResult();
		} catch(NoResultException $e) {
			return null;
		}
	}

}

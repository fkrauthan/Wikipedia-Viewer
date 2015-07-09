<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="RecentSearch", mappedBy="user", cascade={"remove"})
	 *
	 * @var ArrayCollection
	 */
	protected $recentSearches;

	/**
	 * @ORM\OneToMany(targetEntity="FavoriteSearchResult", mappedBy="user", cascade={"remove"})
	 *
	 * @var ArrayCollection
	 */
	protected $favoriteSearchResults;

	public function __construct() {
		parent::__construct();

		$this->recentSearches = new ArrayCollection();
		$this->favoriteSearchResults = new ArrayCollection();
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getRecentSearches() {
		return $this->recentSearches;
	}

	/**
	 * @param ArrayCollection $recentSearches
	 */
	public function setRecentSearches(ArrayCollection $recentSearches) {
		$this->recentSearches = $recentSearches;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getFavoriteSearchResults() {
		return $this->favoriteSearchResults;
	}

	/**
	 * @param ArrayCollection $favoriteSearchResults
	 */
	public function setFavoriteSearchResults($favoriteSearchResults) {
		$this->favoriteSearchResults = $favoriteSearchResults;
	}

}

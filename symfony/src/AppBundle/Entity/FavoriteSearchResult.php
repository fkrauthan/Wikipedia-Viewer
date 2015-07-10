<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavoriteSearchResultRepository")
 * @ORM\Table(name="favorite_search_results")
 */
class FavoriteSearchResult {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="favoriteSearchResults")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 *
	 * @var User
	 */
	protected $user;

	/**
	 * @ORM\Column(name="title", type="string", length=255)
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * @ORM\Column(name="url", type="string", length=255)
	 *
	 * @var string
	 */
	protected $url;

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
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param User $user
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

}

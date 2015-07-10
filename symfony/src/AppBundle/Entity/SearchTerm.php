<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SearchTermRepository")
 * @ORM\Table(name="search_terms")
 */
class SearchTerm {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * @ORM\Column(name="term", type="string", length=255)
	 *
	 * @var string
	 */
	protected $term;

	/**
	 * @ORM\Column(name="count", type="integer")
	 *
	 * @var int
	 */
	protected $count;

	public function __construct() {
		$this->count = 0;
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
	 * @return string
	 */
	public function getTerm() {
		return $this->term;
	}

	/**
	 * @param string $term
	 */
	public function setTerm($term) {
		$this->term = $term;
	}

	/**
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @param int $count
	 */
	public function setCount($count) {
		$this->count = $count;
	}

}

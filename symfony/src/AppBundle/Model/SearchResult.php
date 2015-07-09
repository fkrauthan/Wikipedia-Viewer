<?php
namespace AppBundle\Model;

class SearchResult {

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var boolean
	 */
	private $favorite;

	/**
	 * @param string $title
	 * @param string $description
	 * @param string $url
	 */
	public function __construct($title, $description, $url) {
		$this->title = $title;
		$this->description = $description;
		$this->url = $url;

		$this->favorite = false;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @return boolean
	 */
	public function isFavorite() {
		return $this->favorite;
	}

	/**
	 * @param boolean $favorite
	 */
	public function setFavorite($favorite) {
		$this->favorite = $favorite;
	}

}
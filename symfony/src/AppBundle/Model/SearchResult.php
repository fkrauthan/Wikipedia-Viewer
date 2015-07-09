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
	 * @param string $title
	 * @param string $description
	 * @param string $url
	 */
	public function __construct($title, $description, $url) {
		$this->title = $title;
		$this->description = $description;
		$this->url = $url;
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

}
<?php
namespace AppBundle\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RequestVoter implements VoterInterface {

	private $container;

	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	public function matchItem(ItemInterface $item) {
		$request = $this->container->get('request');
		if ($item->getUri() === $request->getRequestUri()) {
			// URL's completely match
			return true;
		} else if ($item->getUri() !== $request->getBaseUrl() . '/' && (substr($request->getRequestUri(), 0, strlen($item->getUri())) === $item->getUri())) {
			// URL isn't just the base path and the first part of the URL match
			return true;
		}
		return null;
	}

}

<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class NavbarMenu extends ContainerAware {

	public function mainMenu(FactoryInterface $factory, array $options) {
		$menu = $factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav navbar-nav');

		$menu->addChild('Home', array('route' => 'app_site_index'));
		$menu->addChild('Search', array('route' => 'app_search_search'));
		$menu->addChild('About', array('route' => 'app_site_about'));

		return $menu;
	}

}

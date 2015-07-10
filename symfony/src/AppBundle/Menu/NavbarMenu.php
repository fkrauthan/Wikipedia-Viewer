<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
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

	public function userMenu(FactoryInterface $factory, array $options) {
		$menu = $factory->createItem('root');
		$menu->setChildrenAttribute('class', 'dropdown-menu');

		$menu->addChild('My Account', array('route' => 'fos_user_profile_show'));
		$menu->addChild('My Favorites', array('route' => 'app_favoritesearchresult_list'));
		$menu->addChild('Logout', array('route' => 'fos_user_security_logout'));

		return $menu;
	}

}

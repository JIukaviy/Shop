<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 19.06.2016
 * Time: 21:20
 */

namespace AppBundle\Utils;


use AppBundle\Entity\DBCategory;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilderService
{

	private $factory;
	private $entity_manager;

	/**
	 * @param FactoryInterface $factory
	 *
	 * @param EntityManager $entity_manager
	 *
	 * Add any other dependency you need
	 */
	public function __construct(FactoryInterface $factory, EntityManager $entity_manager) {
		$this->factory = $factory;
		$this->entity_manager = $entity_manager;
	}

	/**
	 * @param ItemInterface $menu
	 * @param array $categories
	 * @param string $path
	 */
	private function addChilds($menu, $categories, $path) {
		$all_child_categories = array_filter($categories,
			function ($curr_cat) use ($path) {
				return preg_match('@^' . $path .  '\w*@', $curr_cat->getPath());
			});
		$child_categories = array_filter($all_child_categories,
			function ($curr_cat) use ($path) {
				return $path == $curr_cat->getPath();
			});
		foreach ($child_categories as $child_category) {
			$menu->addChild($child_category->getUrlName(), array(
				'route' => 'shop',
				'routeParameters' => array('path' => $child_category->getPath() . $child_category->getUrlName()),
				'label' => $child_category->getName())
			);
			$this->addChilds(
				$menu[$child_category->getUrlName()],
				$all_child_categories,
				$child_category->getPath() . $child_category->getUrlName() . '/'
			);
		}
	}

	public function buildCategoriesMenu(array $options) {
		$menu = $this->factory->createItem('root');

		$categories = $this->entity_manager->getRepository('AppBundle:DBCategory')->findAll();

		$this->addChilds($menu, $categories, '/');

		return $menu;
	}
}
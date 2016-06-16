<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 28.05.2016
 * Time: 22:47
 */

namespace AppBundle\Utils;


use AppBundle\Entity\DBCategory;

class CategoriesService {
	public function catsToMenuItems($url, $categories) {
		$res = [];
		foreach ($categories as $cat) {
			$res[] = [ 'url' => $url . $cat->getPath() . $cat->getUrlName(), 'label' => $cat->getName() ];
		}
		return $res;
	}

	private function categoryToMenuItem($base_url, $category) {
		return [ 'url' => $base_url . $category->getPath() . $category->getUrlName(), 'label' => $category->getName() ];
	}

	public function buildMenu($base_url, $categories, $category) {
		$res = [];
		$child_categories = array_filter($categories,
			function ($curr_cat) use ($category) {
				return preg_match('/^\Q' . $category->getPath() . '\E\w+\/$/', $curr_cat->getPath());
			});
		if ($child_categories) {
			foreach ($child_categories as $child_category) {
				
			}
		}
	}

	public function currentCat($url) {
		preg_match('.*\/([^\/]+)', $match);
		return $match[0];
	}
}
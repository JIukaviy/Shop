<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 15.05.2016
 * Time: 0:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DBCategoryRepository extends EntityRepository {

    public function findAllInByCatName($category) {
        return $this->createQueryBuilder('cat')
	        ->where('cat.path LIKE :path')
            ->setParameter('path', '%' . $category . '/_%')
	        ->getQuery()
            ->getResult();
    }

	public function findInByName($category) {
		return $this->createQueryBuilder('cat')
			->where(':path LIKE CONCAT(\'%\', cat.url_name)')
			->setParameter('path', $category)
			->getQuery()
			->getResult();
	}

	public function findByPath($path) {
		return $this->createQueryBuilder('cat')
			->where('CONCAT(cat.path, cat.url_name) = :path')
			->getQuery()
			->setParameter('path', $path)
			->getResult();
	}

    public function findInByPath($cat_path) {
        return $this->createQueryBuilder('cat')
	        ->where('cat.path LIKE :path')
            ->setParameter('path', $cat_path)
	        ->getQuery()
            ->getResult();
    }

    public function findPathTo($category) {
        return $this->createQueryBuilder('cat')
	        ->where('cat.path LIKE :path')
            ->setParameter('path', '%' . $category . '/')
	        ->getQuery()
            ->getResult();
    }

	public function pathToArray($path) {
		return $this->createQueryBuilder('cat')
			->where(':path LIKE CONCAT(cat.path, cat.url_name, \'%\')')
			->setParameter('path', $path . '/')
			->getQuery()
			->getResult();
	}
}
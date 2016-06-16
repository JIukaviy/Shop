<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 14.05.2016
 * Time: 23:07
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;

class DBItemRepository extends EntityRepository
{
    private function getQuery() {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM AppBundle:DBItem i 
                 JOIN i.categories cat
                 WHERE cat.url_name LIKE :category'
            );
    }

    public function findInCatByName($category) {
        return $this->getQuery()
            ->setParameter('category', $category)
            ->getResult();
    }

    public function findInCatByPath($path) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM AppBundle:DBItem i 
                 JOIN i.categories cat
                 WHERE CONCAT(cat.path, cat.url_name) = :path'
            )
            ->setParameter('path', $path)
            ->getResult();
    }

    public function getFindAllInCatByPathQuery($path) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM AppBundle:DBItem i 
                 JOIN i.categories cat
                 WHERE CONCAT(cat.path, cat.url_name) LIKE :path'
            )
            ->setParameter('path', $path . '%');
    }

    public function findAllInCatByPath($path) {
        return $this->getFindAllInCatByPathQuery($path)->getResult();
    }

    public function findAllInCatByName($category) {
        return $this->getQuery()
            ->setParameter('category', '%' . $category . '/%')
            ->getResult();
    }
}
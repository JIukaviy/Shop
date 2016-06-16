<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 09.05.2016
 * Time: 23:16
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GridPageController extends Controller
{
    /**
     * @Route("/grid")
     */
    public function showAction() {
        return $this->render('grid.html.twig',[
            'content_header' => 'Таблица товаров',
            'title' => 'Таблица товаров'
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 17:55
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{

	/**
	 * @Route("/", name="index")
	 */
	public function mainPageAction() {
		return $this->render('index.html.twig');
	}

	/**
	 * @Route("/shop{path}", requirements={"path"="\/[a-z\/_]*"}, name="shop", defaults={"path" = "/"})
	 */
	public function showCategoryAction(Request $request, $path)
	{
		/*$cat = $this->getDoctrine()->getRepository('AppBundle:DBCategory')->findOneBy(array('path' => $path . '/'));
		if (!$cat) {
			throw $this->createNotFoundException('The category does not exist');
		}*/
		$items_query = $this->getDoctrine()->getRepository('AppBundle:DBItem')->getFindAllInCatByPathQuery($path);
		$path_arr = $this->getDoctrine()->getRepository('AppBundle:DBCategory')->pathToArray($path);

		$page_number = $request->query->get('page', 1);

		$pagination = $this->get('knp_paginator')->paginate(
			$items_query,
			$page_number,
			5
		);

		return $this->render('goods.html.twig', [
			'path' => $path_arr,
			'pagination' => $pagination
		]);
	}

	/**
	 * @Route("/good_info/{id}", name="good_info", requirements={"id": "\d+"})
	 */
	public function gooInfoPageAction($id) {
		$item = $this->getDoctrine()->getRepository('AppBundle:DBItem')->find($id);
		if (!$item) {
			throw $this->createNotFoundException('The product does not exist');
		}
		return $this->render('good_info.html.twig', array(
			'item' => $item
		));
	}

	/**
	 * @Route("/cart", name="cart")
	 */
	public function cartPageAction(Request $request) {
		return $this->render('cart.html.twig');
	}

	/**
	 * @Route("/my_orders", name="my_orders")
	 */
	public function myOrdersPageAction(Request $request) {
		$orders = $this->getUser()->getOrders();

		$page_number = $request->query->get('page', 1);

		$pagination = $this->get('knp_paginator')->paginate(
			$orders,
			$page_number,
			5
		);
		
		return $this->render('my_orders.html.twig', array(
			'pagination' => $pagination
		));
	}

	/**
	 * @Route("/order_info/{id}", name="order_info", requirements={"id": "\d+"})
	 */
	public function orderInfoPageAction(Request $request, $id) {
		$user = $this->getUser();
		$order = $this->getDoctrine()->getRepository('AppBundle:DBOrder')->find($id);
		if(!$order) {
			$this->createNotFoundException('Order does not exist');
		}
		if ($order->getUser() != $this->getUser()) {
			throw $this->createAccessDeniedException('This is not your order');
		}

		return $this->render('order_info.html.twig', array(
			'order' => $order
		));
	}
}
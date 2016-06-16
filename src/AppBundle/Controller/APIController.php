<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 12.06.2016
 * Time: 19:10
 */

namespace AppBundle\Controller;


use AppBundle\Entity\DBOrder;
use AppBundle\Entity\DBOrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends Controller
{
	/**
	 * @Route("/api/add_order", name="add_order")
	 */
	public function addOrder(Request $request) {
		if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER'))	{
			return $this->createApiErrorResponse('Not authorized');
		}
		$params = [];
		if ($content = $request->getContent()) {
			$params = json_decode($content, true);
			if (!$params['data']) {
				return $this->createApiErrorResponse("Expected 'data' member");
			} elseif (count($params['data']) == 0) {
				return $this->createApiErrorResponse("Data is empty");
			}
		} else {
			return $this->createApiErrorResponse("Wrong parameters");
		}
		$itemRep = $this->getDoctrine()->getRepository('AppBundle:DBItem');
		$em = $this->getDoctrine()->getManager();

		$data = $params['data'];

		$order = new DBOrder();
		$order->setUser($this->getUser());
		
		foreach ($data as $item_id => $count) {
			if ($count <= 0) {
				return $this->createApiErrorResponse('Cookie is broken :(');
			}

			$dbItem = $itemRep->find($item_id);
			if (!$dbItem) {
				return $this->createApiErrorResponse('Product with id: ' . $item_id . ' not found');
			}

			$orderItem = new DBOrderItem();
			$orderItem->setItem($dbItem);
			$orderItem->setCount($count);
			$orderItem->setPrice($dbItem->getPrice());

			$em->persist($orderItem);

			$order->addOrderItem($orderItem);
		}

		$em->persist($order);
		$em->flush();

		return $this->createApiSuccessResponse();
	}

	/**
	 * @Route("/api/get_item_info", name="get_item_info")
	 */
	public function getItemInfo(Request $request) {
		$params = [];
		if ($content = $request->getContent()) {
			$params = json_decode($content, true);
			if (!isset($params['data'])) {
				return $this->createApiErrorResponse("Expected 'data' member");
			} elseif (count($params['data']) == 0) {
				return $this->createApiErrorResponse("Data is empty");
			}
		} else {
			return $this->createApiErrorResponse("Wrong parameters");
		}
		$itemRep = $this->getDoctrine()->getRepository('AppBundle:DBItem');
		$out = [];
		dump($params);
		foreach ($params['data'] as $param) {
			$out[$param['id']] = $itemRep->find($param['id']);
		}
		return $this->createApiSuccessResponse(array('data' => $out));
	}

	private function createApiErrorResponse($message) {
		$response = new JsonResponse();
		$response->setData(array(
				'success' => false,
				'error' => $message
		));
		return $response;
	}

	private function createApiSuccessResponse($params = array()) {
		$response = new JsonResponse();
		$response->setData(array_merge(array('success' => true), $params));
		return $response;
	}

	private function checkContent($content) {
		if ($content) {
			$params = json_decode($content, true);
			if (!$params['data']) {
				return $this->createApiErrorResponse("Expected 'data' member");
			} elseif (count($params['data']) == 0) {
				return $this->createApiErrorResponse("Data is empty");
			}
		} else {
			return $this->createApiErrorResponse("Wrong parameters");
		}
		return $params;
	}
}
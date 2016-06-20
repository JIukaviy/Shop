<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 21.06.2016
 * Time: 3:17
 */

namespace AppBundle\Entity;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class DBOrderItemAdmin extends AbstractAdmin
{
	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('item', 'entity', array(
				'label' => 'Название',
				'class' => 'AppBundle\Entity\DBItem',
				'choice_label' => 'name'
			))
			->add('count', 'number', array('label' => 'Количество'))
			->add('price', 'number', array('label' => 'Цена на момент заказа'));
	}
}
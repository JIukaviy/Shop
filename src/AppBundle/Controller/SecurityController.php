<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 10.05.2016
 * Time: 0:57
 */

namespace AppBundle\Controller;

use AppBundle\Entity\DBUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;

class SecurityController extends Controller
{
    public function loginAction() {
        $helper = $this->get('security.authentication_utils');

        $formFactory = Forms::createFormFactory();
        $form = $formFactory->createBuilder()
            ->setAction($this->generateUrl('_security_check'))
            ->setMethod('POST')
            ->add('username', TextType::class, array(
	            'label' => 'Иия пользователя',
	            'required' => true))
            ->add('password', PasswordType::class, array(
	            'label' => 'Пароль',
	            'required' => true))
            ->add('submit', SubmitType::class, array(
	            'label' => 'Войти'))
            ->getForm();

        return $this->render('login.html.twig', array(
            'login_form' => $form->createView(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }

	/**
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @Route("/register", name="register")
	 */
    public function registerAction(Request $request) {
	    $user = new DBUser();

	    $form = $this->createFormBuilder($user)
		    ->add('username', TextType::class, array(
			    'label' => 'Имя пользователя',
		        'required' => true))
		    ->add('password', RepeatedType::class, array(
			    'type' => PasswordType::class,
			    'required' => true,
			    'invalid_message' => 'Пароли не совпадают!',
			    'first_options'  => array('label' => 'Пароль'),
			    'second_options' => array('label' => 'Повторите пароль')))
		    ->add('submit', SubmitType::class, array(
			    'label' => 'Зарегистрироваться'))
		    ->getForm();

	    $form->handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) {
		    $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());

		    $user->setPassword($password);
		    $userRole = $this->getDoctrine()->getRepository('AppBundle:DBRole')->findOneBy(array('role' => 'ROLE_USER'));
		    $user->addRole($userRole);

		    $entityManager = $this->getDoctrine()->getManager();
		    $entityManager->persist($user);
		    $entityManager->flush();

		    return $this->redirectToRoute('_security_login');
	    }

	    return $this->render('register.html.twig', array(
			    'register_form' => $form->createView()
	    ));
    }
}
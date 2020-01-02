<?php

namespace PiouPiou\RibsAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
	/**
	 * @Route("/index", name="ribsadmin_index")
	 * @Route("/navigation", name="ribsadmin_navigation")
	 * @Route("/modules", name="ribsadmin_modules")
	 */
	public function indexAction()
	{
		return $this->render('@RibsAdmin/Default/index.html.twig');
	}
}

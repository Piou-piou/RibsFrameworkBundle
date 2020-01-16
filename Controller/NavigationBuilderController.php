<?php

namespace PiouPiou\RibsAdminBundle\Controller;

use PiouPiou\RibsAdminBundle\Entity\Module;
use PiouPiou\RibsAdminBundle\Service\AccessRights;
use PiouPiou\RibsAdminBundle\Service\Globals;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavigationBuilderController extends AbstractController
{
	private  $nav = [];
	
	/**
     * function that display the left navigation mapped by user rights
	 * @return Response
	 */
	public function getLeftNavigation(Globals $globals, AccessRights $access_rights): Response
	{
		$navigation = json_decode(file_get_contents($globals->getBaseBundlePath() . "/Resources/json/navigation.json"), true);
		
		foreach ($navigation["items"] as $item) {
			if ($access_rights->testRight($item["right"]) && (!isset($item["position"]) || $item["position"] === "left")) {
				$this->nav[] = $item;
			}
		}
		
		$this->getModuleNavigation();
		
		return $this->render("@RibsAdmin/navigation.html.twig", ["navigation" => $this->nav]);
	}
	
	/**
	 * to get all modules navigation and test right navigation
	 */
	private function getModuleNavigation()
	{
		$modules = $this->getDoctrine()->getRepository(Module::class)->findBy([
			"active" => true,
			"displayed" => true
		]);
		
		foreach ($modules as $module) {
			$navigation = json_decode(file_get_contents($this->get("ribs_admin.globals")->getBaseBundlePath
				($module->getPackageName(), $module->getDevMode()) . "/Resources/json/navigation.json"), true);
			
			foreach ($navigation["items"] as $item) {
				if ($this->get("ribs_admin.acess_rights")->testRight($item["right"]) && (!isset($item["position"]) || $item["position"] === "left")) {
					$this->nav[] = $item;
				}
			}
		}
	}
}

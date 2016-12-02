<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {

		return  $this->render('new_story.html.twig');
	}











	





	public function newlineAction(Request $request)
	{
		$pretexte = $request->request->get('texte');
		return $this->render('new_line.html.twig', array('pretexte' => $pretexte)); 
	}
	

}








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
<<<<<<< HEAD
		return  $this->render('new_story.html.twig');
	}

=======
		$pretexte = $request->request->get('texte');
		//$story = get_story();
		//Si une story est en cours
		//if (true) {
			echo $pretexte;
			return  $this->render('new_story.html.twig');
		//}
		//return $this->render('new_line.html.twig', array('pretexte' => $pretexte)); 
    }
	
	/**
     * @Route("/", name="register")
     */
	 
>>>>>>> 867424b0bfdadcbe064e77fcb3117627ecf86fbb
	public function newlineAction(Request $request)
	{
		$pretexte = $request->request->get('texte');
		return $this->render('new_line.html.twig', array('pretexte' => $pretexte)); 
	}
	

}

/* /
/new
/register
/newLine
/registerLine
/show?id=1 */

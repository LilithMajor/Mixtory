<<<<<<< HEAD
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$pretexte = $request->request->get('texte');
		return $this->render('new_line.html.twig', array('pretexte' => $pretexte)); 
	}

=======
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$pretexte = $request->request->get('texte');
		return $this->render('new_line.html.twig', array('pretexte' => $pretexte)); 
	}

>>>>>>> 867424b0bfdadcbe064e77fcb3117627ecf86fbb
}

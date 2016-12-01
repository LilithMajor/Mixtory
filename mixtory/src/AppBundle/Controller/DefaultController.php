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
		$story = get_story();
		
		if ($story !== null) {
			return  $this->render('new_story.html');
		}
		
		return $this->render('new_line.html', [
			'story' => $story,
		]);
    }
	

}

/
/new
/register
/newLine
/registerLine
/show?id=1
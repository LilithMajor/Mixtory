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
    public function firstlineAction(Request $request)
    {
        $pretexte = $request->request->get('texte');
        $id = $request->request->get('nbr_auteurs');
        if($id == 1){
            return $this->render('last_autor.html.twig', array('pretexte' =>$pretexte));
        }
        else{
            return $this->render('new_line.html.twig', array('pretexte' =>$pretexte,'id' => $id));
        }
    }

	public function newlineAction(Request $request, $id)
    {
        $id--;
        $pretexte = $request->request->get('texte');
        if($id == 1){
            return $this->render('last_autor.html.twig', array('pretexte' =>$pretexte));  
        }
        else{
            return $this->render('new_line.html.twig', array('pretexte' => $pretexte,'id' => $id));
        } 
    }
    public function envoiAction(Request $request){
        return new Response("Test");
    }
}








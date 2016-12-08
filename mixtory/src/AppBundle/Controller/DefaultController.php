<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use AppBundle\Entity\Auteur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $repAuteur = $this->getDoctrine()->getRepository('AppBundle:Auteur');
        $story = $repository->findOneByEnCours(true);

        if(!$story)
        {
            return  $this->render('new_story.html.twig');
        }
        else
        {
            $id = $story->getId();
            $nbrAuteurs = $story->getNbrAuteurs();
            $auteur = $repAuteur->findOneBy(
                                    array('idStory'=>$id),
                                    array('id'=>'DESC')
                                    );
            $pretexte = $auteur->getTexte();
        if($nbrAuteurs>1)
            {
                return $this->render('new_line.html.twig', array('pretexte' =>$pretexte, 'id' => $id, 'titre' => $story->getTitre()));
            }
            else
            {
                return $this->render('last_autor.html.twig', array('pretexte'=>$pretexte, 'id' => $id, 'titre' => $story->getTitre()));
            }
        }
    }

    public function firstlineAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $story = new Story();
        $story->setTitre($request->request->get('titre'));
        $story->setEnCours(true);
        $story->setNbrAuteurs($request->request->get('nbr_auteurs'));
        $em->persist($story);
        $em->flush();
        $auteur = new Auteur();
        $auteur->setIdStory($story->getId());
         $mail = $request->request->get('email');
          if(!$mail){
                $mail = 'mixtorythestory@gmail.com';
           }
        $auteur->setEmail($mail);
        $auteur->setTexte($request->request->get('texte'));
        $em->persist($auteur);
        $em->flush();

        $merci = "Merci d'avoir créé l'histoire nommée : ".$story->getTitre();
        return $this->render('merci.html.twig', array('merci' => $merci));

    }

	public function newlineAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $story = $em->getRepository('AppBundle:Story')->find($id);

        if (!$story) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }   
        $nbrAuteurs = $story->getNbrAuteurs();
        $texte = $request->request->get('texte');
        if($texte)
        {
           $nbrAuteurs = $nbrAuteurs - 1; 
        }
        else{}
        $story->setNbrAuteurs($nbrAuteurs);
        $em->flush();
        $auteur = new Auteur();
        $auteur->setIdStory($story->getId());
        $mail = $request->request->get('email');
        if(!$mail){
              $mail = 'mixtorythestory@gmail.com';     
         }
        $auteur->setEmail($mail);
        $auteur->setTexte($request->request->get('texte'));
        $em->persist($auteur);
        $em->flush();
        $merci = "Merci d'avoir participé à l'histoire nommée : ".$story->getTitre();

        return $this->render('merci.html.twig', array('merci'=> $merci)); 
    }

    public function envoiAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $story = $em->getRepository('AppBundle:Story')->find($id);
        if (!$story) {
              throw $this->createNotFoundException(
                  'No product found for id '.$id
              );
        }
        $story->setEnCours(false);
        $em->persist($story);
        $em->flush();
         $auteur = new Auteur();
        $auteur->setIdStory($id);
        $mail = $request->request->get('email');
        if(!$mail){
            $mail = 'mixtorythestory@gmail.com';
         }
         $auteur->setEmail($mail);
         $auteur->setTexte($request->request->get('texte'));
         $em->persist($auteur);
         $em->flush();
         $merci = "Merci d'avoir participé à l'histoire nommée : ".$story->getTitre();
         $repository = $this->getDoctrine()->getRepository('AppBundle:Auteur');
         $auteurs = $repository->findByIdStory($id);
         if($auteurs != null)
         {
				$message = \Swift_Message::newInstance();

				// Give the message a subject
				$message->setSubject('Votre cadavre exquis !');

				// Set the From address with an associative array
				$message->setFrom(array('mixtorythestory@gmail.com' => 'Mixtory'));

				// Set the To addresses with an associative array
                foreach($auteurs as $auteur)
                {
				    $message->addTo($auteur->getEmail());
                }
				// Give it a body
				$message->setBody($this->render('mail.html.twig', array('story' => $story, 'auteurs' => $auteurs)), 'text/html');

				// And optionally an alternative body
				//$message->addPart('<q>Here is the message itself</q>', 'text/html');
                // Optionally add any attachme
                $this->get('mailer')->send($message);
         }
         else
         {
         }
                
            return $this->render('merci.html.twig', array('merci' => $merci));
    }

    public function oldstoriesAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $stories = $repository->findByEnCours(false);
        return $this->render('oldstories.html.twig', array('stories' => $stories));
    }

    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Auteur');
        $auteurs = $repository->findByIdStory($id);
        $repositorystory = $this->getDoctrine()->getRepository('AppBundle:Story');
        $story = $repositorystory->find($id);
        return $this->render('story.html.twig', array('story' => $story, 'auteurs' => $auteurs));
    }
}








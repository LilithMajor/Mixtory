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
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $story = $repository->findOneByEnCours(true);

        if(!$story)
        {
            return  $this->render('new_story.html.twig');
        }
        else
        {
            $id = $story->getId();
            $auteur = $repository->findOneById($story->getId());
            $pretexte = $auteur->getTexte();
            return $this->render('new_line.html.twig', array('pretexte' =>$pretexte, 'id' => $id));
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
        $auteur->setEmail($request->request->get('email'));
        $auteur->setTexte($request->request->get('texte'));
        $em->persist($auteur);
        $em->flush();

        $merci = "Merci d'avoir créé l'histoire nommée :".$story->getTitre();
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
        $story->setNbrAuteurs($nbrAuteurs--);
        $em->flush();
        $auteur = new Auteur();
        $auteur->setIdStory($story->getId());
        $auteur->setEmail($request->request->get('email'));
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
         $em->flush();
         $auteur->setIdStory($story->getId());
         $auteur->setEmail($request->request->get('email'));
         $auteur->setTexte($request->request->get('texte'));
         $em->persist($auteur);
         $em->flush();
         $merci = "Merci d'avoir participé à l'histoire nommée : ".$story->getTitre();
         $repository = $this->getDoctrine()->getRepository('AppBundle:Auteurs');
         $adresses_mails = $repository->myFindEmails($story->getId()); 
         $transport = Swift_SmtpTransport::newInstance()
					->setHost('smtp.gmail.com')
					->setPort(587)
					->setEncryption('TLS')
					->setUsername('mixtorythestory@gmail.com')
					->setPassword('Poudlard1')
				;
				$mailer = Swift_Mailer::newInstance($transport);
				// Create the message
				$message = Swift_Message::newInstance();

				// Give the message a subject
				$message->setSubject('Votre cadavre exquis !');

				// Set the From address with an associative array
				$message->setFrom(array('mixtorythestory@gmail.com' => 'Mixtory'));

				// Set the To addresses with an associative array
				
				$message->setTo($adresse_mails);

				// Give it a body
				$message->setBody('Merci d\'avoir participé à Mixtory ! Coeur sur vous <3');

				// And optionally an alternative body
				//$message->addPart('<q>Here is the message itself</q>', 'text/html');
				// Optionally add any attachments
				$message->attach(Swift_Attachment::fromPath($new_title));
                $result = $mailer->send($message);
                
            return $this->render('merci.html.twig', array('merci' => $merci));
    }
}








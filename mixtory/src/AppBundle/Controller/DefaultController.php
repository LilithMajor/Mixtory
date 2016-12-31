<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $repAuthor = $this->getDoctrine()->getRepository('AppBundle:Author');
        $story = $repository->findOneByOnGoing(true);
        //$image = "url(large_potato.png)";
        if(!$story)
        {
            return  $this->render('new_story.html.twig');
        }
        else
        {   
            $image = "" ;
            $id = $story->getId();
            $theme = $story->getImage();
                if($theme=="Horror")
                    {
                        $image="url(Images/sgtn_1179_full.jpg)";
                    }
                if($theme=="Comedy")
                    {
                        $image="url(Images/Comedy1.jpg)";
                    }
                if($theme=="Romantic")
                    {
                        $image="url(Images/Romance.jpg)";
                    }
                $css = "body{background-image:".$image."};";
            $nbrAuthor = $story->getNbrAuthor();
            $author = $repAuthor->findOneBy(
                                    array('idStory'=>$id),
                                    array('id'=>'DESC')
                                    );
            $pretext = $author->getText();
            if($nbrAuthor>1)
            {
                return $this->render('new_line.html.twig', array('pretext' =>$pretext, 'id' => $id, 'title' => $story->getTitle(), 'css' => $css, 'theme' => $theme));
            }
            else
            {
                return $this->render('last_autor.html.twig', array('pretext'=>$pretext, 'id' => $id, 'title' => $story->getTitle(), 'css' => $css, 'theme' => $theme));
            }
        }
    }

    public function firstlineAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $story = new Story();
        $story->setTitle($request->request->get('title'));
        $story->setOnGoing(true);
        $story->setNbrAuthor($request->request->get('nbr_author'));
        /* Alex */
        $story->setImage($request->request->get('theme'));
        $em->persist($story);
        $em->flush();
        $author = new Author();
        $author->setIdStory($story->getId());
        $mail = $request->request->get('email');
          if(!$mail){
                $mail = 'mixtorythestory@gmail.com';
           }
        $author->setEmail($mail);
        $author->setText($request->request->get('text'));
        $em->persist($author);
        $em->flush();

        $thx = "Merci d'avoir créé l'histoire nommée : ".$story->getTitle();
        return $this->render('merci.html.twig', array('thx' => $thx));
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
        $nbrAuthor = $story->getNbrAuthor();
        $text = $request->request->get('text');
        if($text)
        {
           $nbrAuthor = $nbrAuthor - 1; 
        }
        else{}
        $story->setNbrAuthor($nbrAuthor);
        $em->flush();
        $author = new Author();
        $author->setIdStory($story->getId());
        $mail = $request->request->get('email');
        if(!$mail){
              $mail = 'mixtorythestory@gmail.com';     
         }
        $author->setEmail($mail);
        $author->setText($request->request->get('text'));
        $em->persist($author);
        $em->flush();
        $thx = "Merci d'avoir participé à l'histoire nommée : ".$story->getTitle();

        return $this->render('merci.html.twig', array('thx'=> $thx)); 
    }

    public function sendAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $story = $em->getRepository('AppBundle:Story')->find($id);
        if (!$story) {
              throw $this->createNotFoundException(
                  'No product found for id '.$id
              );
        }
        $story->setOnGoing(false);
        $em->persist($story);
        $em->flush();
         $author = new Author();
        $author->setIdStory($id);
        $mail = $request->request->get('email');
        if(!$mail){
            $mail = 'mixtorythestory@gmail.com';
         }
         $author->setEmail($mail);
         $author->setText($request->request->get('text'));
         $em->persist($author);
         $em->flush();
         $thx = "Merci d'avoir participé à l'histoire nommée : ".$story->getTitle();
         $repository = $this->getDoctrine()->getRepository('AppBundle:Author');
         $authors = $repository->findByIdStory($id);
         if($authors != null)
         {
				$message = \Swift_Message::newInstance();

				// Give the message a subject
				$message->setSubject('Votre cadavre exquis !');

				// Set the From address with an associative array
				$message->setFrom(array('mixtorythestory@gmail.com' => 'Mixtory'));

				// Set the To addresses with an associative array
                foreach($authors as $author)
                {
				    $message->addTo($author->getEmail());
                }
				// Give it a body
				$message->setBody($this->render('mail.html.twig', array('story' => $story, 'authors' => $authors)), 'text/html');

				// And optionally an alternative body
				//$message->addPart('<q>Here is the message itself</q>', 'text/html');
                // Optionally add any attachme
                $this->get('mailer')->send($message);
         }
         else
         {
         }
                
            return $this->render('merci.html.twig', array('thx' => $thx));
    }

    public function oldstoriesAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $stories = $repository->findBy(array('onGoing' => false),array('id' => 'desc'), 10, 0);
        return $this->render('oldstories.html.twig', array('stories' => $stories));
    }

    public function showAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Author');
        $authors = $repository->findByIdStory($id);
        $repositorystory = $this->getDoctrine()->getRepository('AppBundle:Story');
        $story = $repositorystory->find($id);
        $theme = "Horror";
        $image="";
                 if($theme=="Horror")
                     {
                         $image="url(Images/sgtn_1179_full.jpg)";
                     }
                 if($theme=="Comedy")
                     {
                         $image="url(Images/Comedy1.jpg)";
                     }
                 if($theme=="Romantic")
                     {
                            $image="url(Images/Romance.jpg)";
                     }
                 $css = "body{background-image:".$image."};";

        return $this->render('story.html.twig', array('story' => $story, 'authors' => $authors, 'css' => $css));
    }

    public function storyViewAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Story');
        $stories = $repository->findByOnGoing(false);
        return $this->render('allstories.html.twig', array('stories' => $stories));
    }
}








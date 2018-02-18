<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;

class MainController extends Controller
{
    /**
     * @Route("search", name="cms_search")
     */
    public function searchAction(Request $request){
        $products = "";
        if ($request->isMethod('POST')) {
            $searchQuery = $request->request->get('search');
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository('StoreBundle:Product')->findBySearch($searchQuery);
        }
        return $this->render('store/products.html.twig', array(
            'products' => $products,
            'colMd' => 4
        ));
    }

    /**
     * @Route("/", name="cms_homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lastProducts = $em->getRepository('StoreBundle:Product')->findLastProducts(4);
        $famousProducts = $em->getRepository('StoreBundle:Product')->findFamousProducts(4);
        $slides = $em->getRepository('AppBundle:Slide')->findAll();

        return $this->render('app/index.html.twig', array(
            'products' => $lastProducts,
            'famousProducts' =>$famousProducts,
            'slides' => $slides,
            'colMd' => 3
        ));
    }

    /**
     * @Route("/presentation", name="cms_presentation")
     */
    public function presentationAction(Request $request)
    {
        return $this->render('app/presentation.html.twig');
    }
    
    /**
     * @Route("/contact", name="cms_contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            
            if ($form->isValid()) {
                // Actions à effectuer après validation du formulaire
                $this->get('session')->getFlashBag()->add('notice', "Merci, votre message a bien été pris en compte !");
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                

                $message = \Swift_Message::newInstance()
                    ->setSubject('Nouvelle demande de contact')
                    ->setFrom('contact@shoefony.fr')
                    ->setTo('administrateur@shoefony.fr')
                    ->setContentType("text/html")
                    ->setBody($this->renderView('app/mail/contact.html.twig', array('contact' => $contact)))
                ;

                $this->get('mailer')->send($message);

                
                // Redirection afin d'éviter le "re-posting"
                return $this->redirect($this->generateUrl('cms_contact'));
            }
        }
        
        return $this->render('app/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

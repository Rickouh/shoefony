<?php

namespace StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use StoreBundle\Entity\Opinion;
use StoreBundle\Form\OpinionType;

class StoreController extends Controller
{

    /**
     * @Route("/products/{id}", defaults={"id" = null}, name="store_products")
     */
    public function productsAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id == null){
            $product = $em->getRepository("StoreBundle:Product")->findAll();
        } else{
            $product = $em->getRepository("StoreBundle:Brand")->findOneById($id)->getProducts();
        }

        $paginator  = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $product,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3));
        return $this->render('store/products.html.twig', array(
            'colMd' => 4,
            'products' => $products,
        ));
    }
    
    /**
     * @Route("/product/{id}/details/{slug}", requirements={"id" = "\d+"}, name="store_product")
     */
    public function productAction($id, $slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('StoreBundle:Product')->find($id);
        if (!$product) { 
            throw $this->createNotFoundException('Impossible de trouver le produit auquel vous souhaitez accéder.'); 
        }

        $opinion = new Opinion();
        $form = $this->createForm(new OpinionType(), $opinion);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // Actions à effectuer après validation du formulaire
                $this->get('session')->getFlashBag()->add('notice', "Merci, votre message a bien été pris en compte !");

                $em = $this->getDoctrine()->getManager();
                $opinion->setProduct($product);
                $em->persist($opinion);
                $em->flush();
            }
        }

        $opinions = $em->getRepository("StoreBundle:Opinion")->findByProductId($id);

        return $this->render('store/product.html.twig', array(
            'product' => $product,
            'opinions' => $opinions,
            'form' => $form->createView()
        ));
    }
    
    public function brandsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $brands = $em->getRepository('StoreBundle:Brand')->findAll();
        return $this->render('store/partial/_brands.html.twig', array(
            'brands' => $brands,
        ));
    }
    
}

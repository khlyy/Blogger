<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BloggerController extends Controller
{
  /**
   * @Route("/", name="Article_list")
   */
  public function listAction()
  {
    $articles = $this->getDoctrine()
        -> getRepository('AppBundle:Article')
        ->findAll();

    return $this->render('blogger/index.html.twig', array(
      'articles' => $articles));
  }
}

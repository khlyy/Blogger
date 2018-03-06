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
    $todos = $this->getDoctrine()
        -> getRepository('AppBundle:Article')
        ->findAll();

    return $this->render('todo/index.html.twig', array(
      'todos' => $todos));
  }

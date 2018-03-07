<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
  /**
  * @Route("/seed", name="database_seed")
  */

  public function seedDatabse(Request $request){
  $author1 = new User;
  $author1
      ->setName('Mohamed Khaled')
      ->setEmail('Mohamed@gmail.com')
      ->setType(1);

  $em = $this->getDoctrine()->getManager();

  $em->persist($author1);


  $author2 = new User;

  $author2
      ->setName('Ahmed khaled')
      ->setEmail('Ahmed@gmail.com')
      ->setType(2);

  $em->persist($author2);

  $article1 = new Article;
  $now = new\DateTime('now');

  $article1
      ->setTitle('Your first blog post example')
      ->setCategory('sports')
      ->setDescription('OMG SALAAH SCOOOOORED.')
      ->setAuthor($author1->getName())
      ->setDueDate($now)
      ->setCreateDate($now);

  $em->persist($article1);

  $article2 = new Article;
  $now = new\DateTime('now');

  $article2
      ->setTitle('Your second blog post example')
      ->setCategory('politics')
      ->setDescription('Politics is on fire those days.')
      ->setAuthor($author2->getName())
      ->setDueDate($now)
      ->setCreateDate($now);

  $em->persist($article2);


  $em->flush();
  return $this->redirectToRoute('article_list');


}
}

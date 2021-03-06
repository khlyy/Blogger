<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
  /**
  * an api for seeding database (should be done using doctrine fixtures but there is a problem with composer)
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

  $category1 = new Category();
  $category1->setName("sports");

  $category2 = new Category();
  $category2->setName("politics");

  $em->persist($category1);
  $em->persist($category2);

  $article1 = new Article;
  $now = new\DateTime('now');

  $article1
      ->setTitle('Your first blog post example')
      ->setCategory($category1)
      ->setDescription('OMG SALAAH SCOOOOORED.')
      ->setAuthor($author1->getName())
      ->setDueDate($now)
      ->setCreateDate($now);

  $em->persist($article1);

  $article2 = new Article;
  $now = new\DateTime('now');

  $article2
      ->setTitle('Your second blog post example')
      ->setCategory($category2)
      ->setDescription('Politics is on fire those days.')
      ->setAuthor($author2->getName())
      ->setDueDate($now)
      ->setCreateDate($now);

  $em->persist($article2);


  $em->flush();
  return $this->redirectToRoute('article_list');


}
}

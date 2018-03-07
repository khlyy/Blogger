<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BloggerController extends Controller
{
  /**
   * @Route("/", name="article_list")
   */
  public function listAction()
  {
    $articles = $this->getDoctrine()
        -> getRepository('AppBundle:Article')
        ->findAll();

    return $this->render('blogger/index.html.twig', array(
      'articles' => $articles));
  }

    /**
      * @Route("/article/create/{id}", name="article_create")
     */
    public function createAction(Request $request, $id)
    {
      $user = $this->getDoctrine()
          -> getRepository('AppBundle:User')
          ->find($id);

          if ($user->getType() == 2) // type 2 means this user is a visitor so he cannot add article.
            return $this->redirectToRoute('article_list');


      $article = new Article;
      $form = $this->createFormBuilder($article)
          -> add('title', TextType::class, array('attr'=> array('class' => 'form-control','style'=>'margin-bottom:15px')))
          -> add('category', TextType::class, array('attr'=> array('class' => 'form-control','style'=>'margin-bottom:15px')))
          -> add('description', TextareaType::class, array('attr'=> array('class' => 'form-control','style'=>'margin-bottom:15px')))
          -> add('due_date', DateTimeType::class, array('attr'=> array('class' => 'formcontrol','style'=>'margin-bottom:15px')))
          -> add('save', SubmitType::class, array('label'=> 'create Todo','attr'=> array('class' => 'btn-btn-primary','style'=>'margin-bottom:15px')))
          -> getForm();

          $form ->handleRequest($request);
          if($form-> isSubmitted() && $form -> isValid()){
            $author = user.getName();
            $title = $form['title']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');
            $article->setAuthor($author);
            $article-> setTitle($title);
            $article-> setcategory ($category);
            $article-> setdescription($description);
            $article-> setDueDate($due_date);
            $article-> setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            $em -> persist($article);
            $em ->flush();

            $this->addFlash(
              'notice',
                'article Added'
              );
            return $this->redirectToRoute('article_list');
          }


      return $this->render('blogger/create.html.twig', array(
          'form'=>$form-> createView()
      ));
    }


}

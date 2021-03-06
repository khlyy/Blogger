<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
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
   * get list of all articles.
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
      *create new article if the user is an author (type 1)
      * @Route("/article/create/{id}", name="article_create")
     */
    public function createAction(Request $request, $id)
    {
      $user = $this->getDoctrine() // get user with the specific id to check whether he is visitor or author.
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
          -> add('save', SubmitType::class, array('label'=> 'create Article','attr'=> array('class' => 'btn-btn-primary','style'=>'margin-bottom:15px')))
          -> getForm();

          $form ->handleRequest($request);
          if($form-> isSubmitted() && $form -> isValid()){
            $author = $user->getName();
            $title = $form['title']->getData();
            $categoryName = $form['category']->getData();
            $description = $form['description']->getData();
            $due_date = $form['due_date']->getData();

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();


            $entity = $em->getRepository('AppBundle:Category')->findOneBy([
                    'name' => $categoryName]);

             $category;
            if($entity == null){ // if category does not exist make new one and insert it.

            $category = new Category();
            $category->setName($categoryName);
            $em -> persist($category);
          }else{
            $category = $entity;
          }

            $now = new\DateTime('now');
            $article->setAuthor($author);
            $article-> setTitle($title);
            $article-> setCategory ($category);
            $article-> setDescription($description);
            $article-> setDueDate($due_date);
            $article-> setCreateDate($now);


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


    /**
     * get the details of specific article.
     * @Route("/article/details/{id} ", name="article_details")
     */
    public function detailsAction($id)
    {   $article = $this->getDoctrine()
          -> getRepository('AppBundle:Article')
          ->find($id);

      return $this->render('blogger/details.html.twig', array(
        'article' => $article));
    }

    /**
     *filter the articles based on their category.
     * @Route("filter/article", name="article_filter")
     */

     public function filterAction(Request $request)
     {

       $searchCategory = $request->get('search'); // get the search input from search bar.

         $em = $this->getDoctrine()->getManager();

         $qb = $em->createQueryBuilder();

         $entity = $em->getRepository('AppBundle:Category')->findOneBy([
                 'name' => $searchCategory]);

         $category;
         $articles;
        if($entity == null){ // if category does not exist then pass an empty array to the view.
          $articles = [];
        }else{
          $category = $entity;
          $articles = $category->getArticles(); // the results of articles based on the query.
      }



       return $this->render('blogger/index.html.twig', array(
         'articles' => $articles));
     }
}

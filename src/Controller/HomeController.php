<?php

namespace MicroCMS\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use MicroCMS\Domain\Comment;
use MicroCMS\Form\Type\CommentType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }
    
	/**
     * Mention legales page controller ajout MYF.
     *
     * @param Application $app Silex application
     */
    public function mentionAction(Application $app) {
        return $app['twig']->render('mention.html.twig');
    }
	
    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app) {
        $article = $app['dao.article']->find($id);
        $commentFormView = null;
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new Comment();
            $comment->setArticle($article);
            $user = $app['user'];
            $comment->setAuthor($user);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté avec succès.');
			/* effacement fenetre saisie MYF */
				unset($comment);
  				unset($commentForm);
  				$comment = new Comment();
				$commentForm = $app['form.factory']->create(CommentType::class, $comment);
			/* fin effacement fenetre saisie MYF */	
            }
            $commentFormView = $commentForm->createView();
        }
        $comments = $app['dao.comment']->findAllByArticle($id);
        
        return $app['twig']->render('article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }
    
    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
	
	/**
    * Comment report counter (increase) controller.
	*
	* @param integer $id Comment id
	* @param Application $app Silex application
	*/
	public function signalPlusCommentAction($id, Application $app) {
       	$comment = $app['dao.comment']->find($id);
		$newComReport = $comment->getSignal() + 1;
		$commentData = array('sig_cp' => $newComReport); 
		$app['dao.comment']->signalPlus($id,$commentData);
		$app['session']->getFlashBag()->add('success', 'Ce commentaire a été signalé avec succès.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
	}	

	/**
    * Comment form erase controller.
	*
	* @param integer $id Article id
	* @param Application $app Silex application
    */  
	 public function eraseAction($id, Application $app) { 
    }

}
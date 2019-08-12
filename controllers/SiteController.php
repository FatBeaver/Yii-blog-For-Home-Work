<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use app\models\Article;
use app\models\Category;
use app\models\CommentForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $data       = Article::getAll();

        $popular    = Article::getPopular();
        $recent     = Article::getRecent();
        $categories = Category::getCategories();

        return $this->render('index', [
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }


    public function actionSingle($id) {

        $article = Article::findOne($id);
        $tags    = $article->tags;

        $popular     = Article::getPopular();
        $recent      = Article::getRecent();
        $categories  = Category::getCategories();
        $comments    = $article->getArticleComments();
        $commentForm = new CommentForm();

        $article->viewedCounter();

        return $this->render('single', [
            'article' => $article,
            'tags'    => $tags,
            'popular' => $popular,
            'recent'  => $recent,
            'categories' => $categories,
            'comments' => $comments,
            'commentForm' => $commentForm,
        ]);
    }


    public function actionCategory($id) {
        
        $data       = Category::getArticlesByCategory($id);
        $popular    = Article::getPopular();
        $recent     = Article::getRecent();
        $categories = Category::getCategories();

        return $this->render('category', [
            'pagination' => $data['pagination'],
            'articles'   => $data['articles'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }

    public function actionComment($id) 
    {
        $model = new CommentForm();

        if (Yii::$app->request->isPost)
        {   
            Yii::$app->getSession()->setFlash('comment', 'Ваш коментарий успешно добавлен');
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)) 
            {
                return $this->redirect(['site/single', 'id' => $id]);
            }
        } 
    }
  
}

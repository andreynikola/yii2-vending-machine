<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\db\ActiveRecord;
use app\models\Balance;
use app\models\Products;
use yii\web\HttpException;

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
        $balance = new Balance();
        $products = new Products();
        return $this->render('index', ['balance' => $balance->getMain(), 'products' => $products->getAll() ]);
    }

    public function actionBuy()
    {
        if (Yii::$app->request->isAjax){
            return (new Products())->buy(Yii::$app->request->post('product_id'));
        }

    }

    public function actionContribute()
    {
        if (Yii::$app->request->isAjax){
            return (new Balance())->contributeMoney(Yii::$app->request->post('amount'));
        }

    }

    public function actionReturn()
    {
        if (Yii::$app->request->isAjax){
            return (new Balance())->returnMoney();
        }
    }

}

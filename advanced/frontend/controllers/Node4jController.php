<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use Everyman\Neo4j\Client;
use Everyman\Neo4j\Index\NodeIndex;
use Everyman\Neo4j\Index;
use Everyman\Neo4j\Label;

/**
 * Site controller
 */
class Node4jController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
     */
    public function actions() {
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
     * @return mixed
     */
    public function actionIndex() {
        //$user =  \app\models\User::find();

        return $this->render('index');
    }

    public function actionAdd() {
        return $this->render('display_node');
    }

    public function actionCreate() {
        if (count($_POST) > 0) {
            //DB connection 
            $client = new Client('localhost', 7474);
            $client->getTransport()->setAuth('neo4j', '123456');
            //create a new Employee Label
            $label = $client->makeLabel('Employee');
            //set node properties
            $properties['firstname'] = $_POST['firstname'];
            $properties['lastname'] = $_POST['lastname'];
            $properties['position'] = $_POST['position'];
            //create a new node with properties from POST and defined label
            $node = new \Everyman\Neo4j\Node($client);
            $node->setProperties($properties)->save()->addLabels(array($label));
            //set a FOLLOW relationship 
            $node->relateTo($client->getNode(216), 'FOLLOW')->save();

            $nodeIndex = new NodeIndex($client, Index::TypeNode, 'Employee');
            $nodeIndex->add($node, 'lastname', $properties['lastname']);
            $nodes =   $client->makeLabel('Employee')->getNodes();
            return $this->render('all_nodes',['nodes'=>$nodes]);
        } else {

            return $this->render('node_form');
        }
    }
    public function actionNodes() {
        $client = new Client('localhost', 7474);
            $client->getTransport()->setAuth('neo4j', '123456');
         $nodes =   $client->makeLabel('Employee')->getNodes();
     
        //$nodes = $client->getNodesForLabel($client->makeLabel('Employee'));
        return $this->render('all_nodes',['nodes'=>$nodes]);
    }

}

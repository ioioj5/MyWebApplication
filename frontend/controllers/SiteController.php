<?php

namespace frontend\controllers;

use common\components\FrontController;
use common\models\SignupForm;
use frontend\models\Goods;
use Yii;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends FrontController {
	/**
	 * @inheritdoc
	 */
	public function behaviors () {
		return [
			'access' => [
				'class' => AccessControl::className (),
				'only'  => [
					'logout',
					'signup'
				],
				'rules' => [
					[
						'actions' => [
							'signup'
						],
						'allow'   => true,
						'roles'   => [
							'?'
						]
					],
					[
						'actions' => [
							'logout'
						],
						'allow'   => true,
						'roles'   => [
							'@'
						]
					]
				]
			],
			'verbs'  => [
				'class'   => VerbFilter::className (),
				'actions' => [
					'logout' => [
						'post'
					]
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions () {
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction'
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
			]
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex () {
		$page = intval ( Yii::$app->request->get ( 'page' ) );

		$limit  = 20;
		$offset = ( $page - 1 ) * $limit;
		$params = array ( 'site/index', 'page' => '{page}' ); // 生成URL参数数组


		$list      = Goods::getGoodsList ( $limit, $offset );
		$totalPage = ceil ( $list[ 'count' ] / $limit );
		$link      = Url::toRoute ( $params ); //$this->createUrl ( 'admin/index', $params ); // '/page/{page}';
		$navbar    = $this->pager ( $page, $limit, $list[ 'count' ], $link, 'active', '' );

		return $this->render ( 'index', [
			'list'      => $list,
			'navbar'    => $navbar,
			'totalPage' => $totalPage,
			'total'     => $list[ 'count' ],
			'page'      => $page,
			'limit'     => $limit,
			'params'    => $params
		] );
	}

	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact () {
		$model = new ContactForm ();
		if ( $model->load ( Yii::$app->request->post () ) && $model->validate () ) {
			if ( $model->sendEmail ( Yii::$app->params [ 'adminEmail' ] ) ) {
				Yii::$app->session->setFlash ( 'success', 'Thank you for contacting us. We will respond to you as soon as possible.' );
			} else {
				Yii::$app->session->setFlash ( 'error', 'There was an error sending email.' );
			}

			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [
				'model' => $model
			] );
		}
	}

	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout () {
		return $this->render ( 'about' );
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup () {
		$model = new SignupForm ();
		if ( $model->load ( Yii::$app->request->post () ) ) {
			if ( $user = $model->signup () ) {
				if ( Yii::$app->getUser ()->login ( $user ) ) {
					return $this->goHome ();
				}
			}
		}

		return $this->render ( 'signup', [
			'model' => $model
		] );
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset () {
		$model = new PasswordResetRequestForm ();
		if ( $model->load ( Yii::$app->request->post () ) && $model->validate () ) {
			if ( $model->sendEmail () ) {
				Yii::$app->session->setFlash ( 'success', 'Check your email for further instructions.' );

				return $this->goHome ();
			} else {
				Yii::$app->session->setFlash ( 'error', 'Sorry, we are unable to reset password for email provided.' );
			}
		}

		return $this->render ( 'requestPasswordResetToken', [
			'model' => $model
		] );
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 *
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword ( $token ) {
		try {
			$model = new ResetPasswordForm ( $token );
		} catch ( InvalidParamException $e ) {
			throw new BadRequestHttpException ( $e->getMessage () );
		}

		if ( $model->load ( Yii::$app->request->post () ) && $model->validate () && $model->resetPassword () ) {
			Yii::$app->session->setFlash ( 'success', 'New password was saved.' );

			return $this->goHome ();
		}

		return $this->render ( 'resetPassword', [
			'model' => $model,
		] );
	}
}

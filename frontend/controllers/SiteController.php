<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Departaments;
use app\models\Work;
use common\models\User;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
//    public $layout = 'login';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {


        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            if ($role !== null) {
                $role = $role->item_name ? $role->item_name : 0;
                if ($role === 'Administrator') {
                    $this->layout = 'main';
                }
                if ($role === 'admin_audit') {
                    $this->layout = 'main';
                }
                if ($role === 'auditor') {
                    $this->layout = 'auditors';
                }
                if ($role === 'departaments') {
                    $this->layout = 'departaments';
                }
                if ($role === 'monitoring') {
                    $this->layout = 'main';
                }
            } else {
                Yii::$app->session->setFlash('error', 'Роль пользователя не определена.');
                Yii::$app->user->logout();
//                return $this->redirect(['/site/login']);
            }
        }
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $user_id = Yii::$app->user->id;
        $dep_id = \common\models\User::findOne($user_id)->dep_id;
        $dep_name = Departaments::findOne($dep_id)->name;
        return $this->render('index', [
            'dep_name' => $dep_name,
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);

            if ($role !== null) {
                $role = $role->item_name;
                if ($role === 'Administrator') {
                    $this->layout = 'main';
                    return $this->goBack();
                }
                if ($role === 'admin_audit') {
                    $this->layout = 'main';
                    return $this->goBack();
                }
                if ($role === 'auditor') {
                    $this->layout = 'main';
                    return $this->goBack();
                }
                if ($role === 'departaments') {
                    $this->layout = 'departaments';
                    return $this->goBack();
                }
                if ($role === 'monitoring') {
                    $this->layout = 'main';
                    return $this->goBack();
                }
            } else {
                Yii::$app->session->setFlash('error', 'Роль пользователя не определена.');
                Yii::$app->user->logout();
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionChange_password()
    {
        $user = Yii::$app->user->identity;
        $loadedPost = $user->load(Yii::$app->request->post());
        if ($loadedPost && $user->validate()) {
            $user->password = $user->newPassword;
            $user->save(false);
            Yii::$app->session->setFlash('success', 'pasword changed ok');
            return $this->actionLogout();
        }
        return $this->render("change_password", [
            'user' => $user,
        ]);
    }

    public function actionUsers_list()
    {
        $users = User::find()->all();

        return $this->render("users_list", [
            'users' => $users,
        ]);
    }

    public function actionReset_password()
    {
        $user_id = Yii::$app->request->post('User')['id']; // предположим, что у вас есть поле 'id' в модели User
        $user = User::findOne($user_id);

        $loadedPost = $user->load(Yii::$app->request->post());
        if ($loadedPost && $user !== null) {
            $user->password = $user->newPassword;
            $user->save(false);
            Yii::$app->session->setFlash('success', 'pasword changed ok');
            return $this->redirect(['site/users_list']);
        }

        return $this->render("users_list", [
            'user' => $user,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}

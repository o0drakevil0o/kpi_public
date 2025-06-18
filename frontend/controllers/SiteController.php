<?php

namespace frontend\controllers;

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
use frontend\helpers\Url ;

/**
 * Site controller
 */
class SiteController extends Controller
{
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
 

    /**
     * Requests password reset.
     *
     * @return mixed
     */
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

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
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

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
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

    /**
     * Resend verification email
     *
     * @return mixed
     */
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

    public function actionLoginProvider() { 
            $session = Yii::$app->session ; 
            if (!empty(Yii::$app->request->get('web'))) {
                $session['web'] = $_GET['web']; 
            }

            $client_id = getenv('CLIENT_ID');
            $redirect_uri = getenv('REDIRECT_URI');
            $response_type = "code";

            $url = "https://moph.id.th/oauth/redirect?client_id=$client_id&redirect_uri=$redirect_uri&response_type=$response_type";  
            return $this->redirect($url);
    }

    public function actionCallbackProvider($code) {
        $session = Yii::$app->session ; 
        if(empty($code))
        { 
            return $this->redirect(Url::to(("login")));
        }else{ 
            if (isset($code)) {
                $code = $code;
                $client_id = getenv('CLIENT_ID');
                $client_secret = getenv('CLIENT_SECRET');
                $client_id_Provider = getenv('PROVIDER_CLIENT_ID');
                $client_secret_Provider = getenv('PROVIDER_CLIENT_SECRET');
                $redirect_uri = getenv('REDIRECT_URI'); 
                $post_fields = http_build_query([
                    "grant_type" => "authorization_code",
                    "code" => $code,
                    "redirect_uri" => $redirect_uri,
                    "client_id" => $client_id,
                    "client_secret" => $client_secret
                ]);
                $ch = curl_init("https://moph.id.th/api/v1/token");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/x-www-form-urlencoded"
                ]);
                $response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                    if ($http_code == 200) {
                    $response_data = json_decode($response, true);
                    if ($response_data === null) {
                        echo json_encode(["error" => "JSON Decode Error", "message" => json_last_error_msg()]);
                        exit;
                    }
                    if (!isset($response_data["data"]["access_token"])) {
                        echo json_encode(["error" => "'access_token' not found in response"]);
                        exit;
                    }
                    $access_token = $response_data["data"]["access_token"];
                    $provider_api_url = "https://provider.id.th/api/v1/services/token";
                    $provider_post_data = json_encode([
                        "client_id" => $client_id_Provider,
                        "secret_key" => $client_secret_Provider,
                        "token_by" => "Health ID",
                        "token" => $access_token
                    ]);
                    $ch2 = curl_init($provider_api_url);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch2, CURLOPT_POST, true);
                    curl_setopt($ch2, CURLOPT_POSTFIELDS, $provider_post_data);
                    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json"
                    ]);
                    $provider_response = curl_exec($ch2);
                    $provider_http_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                    curl_close($ch2);
                    if ($provider_http_code != 200) {
                        echo json_encode(["error" => "Provider API Request Failed", "status_code" => $provider_http_code]);
                        exit;
                    }
                    $provider_data = json_decode($provider_response, true);
                    if (!isset($provider_data["data"]["access_token"])) {
                        echo json_encode(["error" => "'provider_access_token' not found in response"]);
                        exit;
                    }
                    $provider_access_token = $provider_data["data"]["access_token"];
                    $profile_api_url = "https://provider.id.th/api/v1/services/profile?moph_center_token=1&moph_idp_permission=1&position_type=1";
                    $ch3 = curl_init($profile_api_url);
                    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch3, CURLOPT_HTTPGET, true);
                    curl_setopt($ch3, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json",
                        "Authorization: Bearer $provider_access_token",
                        "client-id: $client_id_Provider",
                        "secret-key: $client_secret_Provider"
                    ]);
                    $profile_response = curl_exec($ch3);
                    $profile_http_code = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
                    curl_close($ch3);
                    if ($profile_http_code != 200) {
                        echo json_encode(["error" => "Profile API Request Failed", "status_code" => $profile_http_code]);
                        exit;
                    }     
                    $dataJson = json_decode($profile_response , true) ; 
                    $hcode = $dataJson['data']['organization'][0]['hcode'] ; 
                    $hcodeData = \Yii::$app->db->createCommand("SELECT id FROM kp_hcode WHERE hcode = ".$hcode." LIMIT 1 ")->queryAll() ;
                    if(!empty($hcodeData)){ 
                        $hash = $dataJson['data']['hash_cid'] ; 
                        $sqlHash = "SELECT username , fname , lname FROM user WHERE hcode = ".$hcodeData[0]['id']." AND cid_hash = '".$hash."'"." LIMIT 1" ; 
                        $hashData = \Yii::$app->db->createCommand($sqlHash)->queryAll() ;

                        if(!empty($hashData)){ 
                            $model = new LoginForm();
                            $model->username = $hashData[0]["username"]; 
                            if ($model->loginByProviderId()) {
                                return $this->goBack();
                            }
                        }    
                        }
                        else { 
                            echo json_encode(["error" => "ไม่พบสถานบริการที่มีอยู่ในระบบ", "http_status" => $http_code]);
                        }
                        } else {
                            echo json_encode(["error" => "Request failed", "http_status" => $http_code]);
                        }
                    } else {
                        echo json_encode(["error" => "Missing 'code' parameter"]);
                    }
        }

    }
}

<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword ;
    public $fname ; 
    public $lname ; 
    public $status ; 
    public $role ; 
    public $cid ; 
    public $cid_hash ; 
    public $hcode; 

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required' , 'when' => "signup"],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['repassword', 'required' , 'when' => "signup"],
            ['repassword' , 'string'],

            ['cid', 'required'],
            ['cid', 'unique' , 'targetClass' => '\common\models\User', 'message' => 'This have person ID.'],
            ['cid', 'string', 'max' => 255],

            ['cid_hash' , 'required'] , 

            ['hcode', 'string', 'max' => 5],


            ['fname' , 'trim'] , 
            ['fname' , 'required'] , 
            ['fname' , 'string' , 'min' => 2  , 'max' => 255] ,
            
            ['lname' , 'trim'] , 
            ['lname' , 'required'] , 
            ['lname' , 'string' , 'min' => 2  , 'max' => 255] ,

            ['status' , 'trim'] , 
            ['status' , 'integer'],

            ['role' , 'trim'] , 
            ['role' , 'string']
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        // if (!$this->validate()) {
        //     return null;
        // }
        
        $user = new User();
        // $security = new Security() ; 

        if($this->password === $this->repassword){
            $user->setPassword($this->password);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->fname = $this->fname ; 
            $user->lname = $this->lname; 
            $user->status = $this->status ; 
            $user->role = $this->role ; 
            $user->cid = $this->cid ; 
            $user->cid_hash = hash('sha256', $this->cid) ;
            $user->hcode = $this->hcode;   
            $user->generateAuthKey();
        }
        else{ 
            Yii::$app->session->setFlash('error', 'Passwords is not same');
        }
        //$user->generateEmailVerificationToken();
        return $user->save() ; /*&& $this->sendEmail($user)*/
    }

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}

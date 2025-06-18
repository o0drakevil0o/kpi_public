<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UpdateUserForm extends Model
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
    public $cid_hash; 
    public $hcode ;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['cid', 'required'],
            ['cid', 'string', 'max' => 255],

            ['cid_hash' , 'required'] , 

            ['hcode', 'string', 'max' => 5],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['repassword' , 'string'],

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
    public static function getUser($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }
    }

    public function update($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $user = User::findOne(["id" => $id]);
        if($this->password === $this->repassword){
            if(!empty($this->password) && !empty($this->repassword))
            { 
                $user->setPassword($this->password);
            }     
            $user->username = $this->username;
            $user->email = $this->email;
            $user->fname = $this->fname ; 
            $user->lname = $this->lname; 
            $user->status = $this->status ; 
            $user->role = $this->role ;
            $user->cid = $this->cid ; 
            $user->cid_hash = $this->cid_hash ; 
            $user->hcode = $this->hcode ;  
            $user->generateAuthKey();
        }
        else{ 
            Yii::$app->session->setFlash('error', 'Passwords is not same');
        }
        //$user->generateEmailVerificationToken();
        return $user->save() ; /*&& $this->sendEmail($user)*/
    }
    public function resetPassword($id){
        if (!$this->validate()) {
            return null;
        }
        $user = User::findOne(["id" => $id]);
        $user->username = $user->cid ; 
        $user->setPassword("12345678");
        $user->generateAuthKey();
        return $user->save() ;
    }

}

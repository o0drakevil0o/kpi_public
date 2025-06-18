<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property string|null $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $password_set ; 
    public $password_set_recheck ; 

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at' , 'cid' , 'cid_hash'], 'required'],
            [['role'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['fname', 'lname', 'username', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 60],
            [['password_set'], 'string', 'max' => 60],
            [['password_set_recheck'], 'string', 'max' => 60],
            [['cid'], 'string', 'max' => 13],
            [['hcode'], 'int', 'max' => 2],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ลำดับ',
            'fname' => 'ชื่อ',
            'lname' => 'นามสกุล',
            'username' => 'ชื่อผู้ใช้',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'อีเมลล์',
            'role' => 'สิทธิ์',
            'status' => 'สถานะ',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'password_set' => "ตั้งค่ารหัสผ่านใหม่" ,
            'password_set_recheck' => "ตั้งค่ารหัสผ่านใหม่ (ยืนยัน)" ,
            'cid' => 'เลขบัตรประจำตัวประชาชนเจ้าหน้าที่', 
            'cid_hash' => 'cid-hash'
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password2;
    public $check;
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }
    /**
     * {@inheritdoc}
     */
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
            [['full_name', 'username', 'email', 'phone', 'password','password2','check'], 'required'],
            [['password2'],'compare','compareAttribute'=>'password'],
            [['check'],'compare','compareValue'=>1,'message'=>'Обязательно!'],
            [['email'],'email'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i','message'=>'Только латиница!'],
            ['full_name','match', 'pattern' => '/^[А-яЁе]*$/u','message'=>'Только кириллица!'],
            [['role'], 'integer'],
            [['phone'],'string','max'=> 30],
            [['password','password2'],'string','min'=>6],
            [['full_name', 'username', 'email', 'phone', 'password'], 'string', 'max' => 255],
        ];
    }
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function isAdmin(){
        return $this->role == 1;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'username' => 'Логин',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'password2' => 'Подтверждение пароля',
            'check' => 'Согласие на обработку персональных данных',
            'role' => 'Role',
        ];
    }
}

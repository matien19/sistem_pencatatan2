<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $nama
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CalonSiswa[] $calonSiswas
 * @property Siswa[] $siswas
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Finds an identity by the given ID.
     * @param string|int $id
     * @return static|null
     */
       public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['username' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * ENUM field values
     */
    const ROLE_SISWA = 'siswa';
    const ROLE_STAF = 'staf';
    const ROLE_CALON_SISWA = 'calon_siswa';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email_verified_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 'staf'],
            [['username', 'nama', 'email', 'password'], 'required'],
            [['email_verified_at', 'created_at', 'updated_at'], 'safe'],
            [['role'], 'string'],
            [['username', 'nama', 'email', 'password'], 'string', 'max' => 255],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nama' => 'Nama',
            'email' => 'Email',
            'email_verified_at' => 'Email Verified At',
            'password' => 'Password',
            'role' => 'Role',
            'remember_token' => 'Remember Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CalonSiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalonSiswas()
    {
        return $this->hasMany(CalonSiswaModel::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Siswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiswas()
    {
        return $this->hasMany(SiswaModel::class, ['user_id' => 'id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_SISWA => 'siswa',
            self::ROLE_STAF => 'staf',
            self::ROLE_CALON_SISWA => 'calon_siswa',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleSiswa()
    {
        return $this->role === self::ROLE_SISWA;
    }

    public function setRoleToSiswa()
    {
        $this->role = self::ROLE_SISWA;
    }

    /**
     * @return bool
     */
    public function isRoleStaf()
    {
        return $this->role === self::ROLE_STAF;
    }

    public function setRoleToStaf()
    {
        $this->role = self::ROLE_STAF;
    }

    /**
     * @return bool
     */
    public function isRoleCalonsiswa()
    {
        return $this->role === self::ROLE_CALON_SISWA;
    }

    public function setRoleToCalonsiswa()
    {
        $this->role = self::ROLE_CALON_SISWA;
    }
}

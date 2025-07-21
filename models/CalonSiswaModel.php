<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calon_siswa".
 *
 * @property int $id
 * @property string $nama
 * @property string $no_pendaftaran
 * @property string $no_hp
 * @property int $user_id
 * @property int $jurusan_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Jurusan $jurusan
 * @property Tagihan[] $tagihans
 * @property Users $user
 */
class CalonSiswaModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calon_siswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['nama', 'no_pendaftaran', 'no_hp', 'user_id', 'jurusan_id'], 'required'],
            [['user_id', 'jurusan_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 50],
            [['no_pendaftaran'], 'string', 'max' => 20],
            [['no_hp'], 'string', 'max' => 13],
            [['jurusan_id'], 'exist', 'skipOnError' => true, 'targetClass' => JurusanModel::class, 'targetAttribute' => ['jurusan_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'no_pendaftaran' => 'No Pendaftaran',
            'no_hp' => 'No Hp',
            'user_id' => 'User ID',
            'jurusan_id' => 'Jurusan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Jurusan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJurusan()
    {
        return $this->hasOne(JurusanModel::class, ['id' => 'jurusan_id']);
    }

    /**
     * Gets query for [[Tagihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getTagihans()
    // {
    //     return $this->hasMany(Tagihan::class, ['calon_siswa_id' => 'id']);
    // }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "siswa".
 *
 * @property int $id
 * @property string $nama
 * @property string $nisn
 * @property string $no_hp
 * @property int $user_id
 * @property int $kelas_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kelas $kelas
 * @property Tagihan[] $tagihans
 * @property Users $user
 */
class SiswaModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'siswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['nama', 'nisn', 'no_hp', 'user_id', 'kelas_id'], 'required'],
            [['user_id', 'kelas_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 50],
            [['nisn'], 'string', 'max' => 20],
            [['no_hp'], 'string', 'max' => 13],
            [['kelas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kelas::class, 'targetAttribute' => ['kelas_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'nisn' => 'Nisn',
            'no_hp' => 'No Hp',
            'user_id' => 'User ID',
            'kelas_id' => 'Kelas ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Kelas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKelas()
    {
        return $this->hasOne(Kelas::class, ['id' => 'kelas_id']);
    }

    /**
     * Gets query for [[Tagihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihans()
    {
        return $this->hasMany(Tagihan::class, ['siswa_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}

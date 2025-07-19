<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kelas".
 *
 * @property int $id
 * @property string $kelas 1,2,3
 * @property string $nama A,B,C
 * @property string $tahun_masuk
 * @property int $jurusan_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Jurusan $jurusan
 * @property Siswa[] $siswas
 */
class KelasModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['kelas', 'nama', 'tahun_masuk', 'jurusan_id'], 'required'],
            [['jurusan_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['kelas', 'nama', 'tahun_masuk'], 'string', 'max' => 255],
            [['jurusan_id'], 'exist', 'skipOnError' => true, 'targetClass' => JurusanModel::class, 'targetAttribute' => ['jurusan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kelas' => 'Kelas',
            'nama' => 'Nama',
            'tahun_masuk' => 'Tahun Masuk',
            'jurusan_id' => 'Jurusan ID',
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
     * Gets query for [[Siswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getSiswas()
    // {
    //     return $this->hasMany(Siswa::class, ['kelas_id' => 'id']);
    // }

}

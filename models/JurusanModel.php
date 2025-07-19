<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jurusan".
 *
 * @property int $id
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CalonSiswa[] $calonSiswas
 * @property JenisJurusan[] $jenisJurusans
 * @property JenisPembayaran[] $jenisPembayarans
 * @property Kelas[] $kelas
 */
class JurusanModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jurusan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['nama'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CalonSiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getCalonSiswas()
    // {
    //     return $this->hasMany(CalonSiswa::class, ['jurusan_id' => 'id']);
    // }

    // /**
    //  * Gets query for [[JenisJurusans]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getJenisJurusans()
    // {
    //     return $this->hasMany(JenisJurusan::class, ['jurusan_id' => 'id']);
    // }

    // /**
    //  * Gets query for [[JenisPembayarans]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getJenisPembayarans()
    // {
    //     return $this->hasMany(JenisPembayaran::class, ['jurusan_id' => 'id']);
    // }

    // /**
    //  * Gets query for [[Kelas]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getKelas()
    // {
    //     return $this->hasMany(Kelas::class, ['jurusan_id' => 'id']);
    // }

}

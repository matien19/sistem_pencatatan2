<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tagihan".
 *
 * @property int $id
 * @property int|null $siswa_id
 * @property int|null $calon_siswa_id
 * @property int $jenis_pembayaran_id
 * @property int $status
 * @property string|null $tanggal_jatuh_tempo
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property CalonSiswa $calonSiswa
 * @property JenisPembayaran $jenisPembayaran
 * @property Pembayaran[] $pembayarans
 * @property Siswa $siswa
 */
class TagihanModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tagihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['siswa_id', 'calon_siswa_id', 'tanggal_jatuh_tempo', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['siswa_id', 'calon_siswa_id', 'jenis_pembayaran_id', 'status'], 'integer'],
            [['jenis_pembayaran_id'], 'required'],
            [['tanggal_jatuh_tempo', 'created_at', 'updated_at'], 'safe'],
            [['calon_siswa_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalonSiswa::class, 'targetAttribute' => ['calon_siswa_id' => 'id']],
            [['jenis_pembayaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisPembayaran::class, 'targetAttribute' => ['jenis_pembayaran_id' => 'id']],
            [['siswa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Siswa::class, 'targetAttribute' => ['siswa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'siswa_id' => 'Siswa ID',
            'calon_siswa_id' => 'Calon Siswa ID',
            'jenis_pembayaran_id' => 'Jenis Pembayaran ID',
            'status' => 'Status',
            'tanggal_jatuh_tempo' => 'Tanggal Jatuh Tempo',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CalonSiswa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalonSiswa()
    {
        return $this->hasOne(CalonSiswa::class, ['id' => 'calon_siswa_id']);
    }

    /**
     * Gets query for [[JenisPembayaran]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisPembayaran()
    {
        return $this->hasOne(JenisPembayaran::class, ['id' => 'jenis_pembayaran_id']);
    }

    /**
     * Gets query for [[Pembayarans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayarans()
    {
        return $this->hasMany(Pembayaran::class, ['tagihan_id' => 'id']);
    }

    /**
     * Gets query for [[Siswa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiswa()
    {
        return $this->hasOne(Siswa::class, ['id' => 'siswa_id']);
    }

}

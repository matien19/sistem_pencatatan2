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
            [['siswa_id', 'calon_siswa_id', 'tanggal_jatuh_tempo'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'default', 'value' => function () {
                return date('Y-m-d H:i:s');
            }],
            [['jenis_pembayaran_id'], 'integer'],
            [['tanggal_jatuh_tempo'], 'date', 'format' => 'php:Y-m-d'],
            [['status'], 'default', 'value' => 0],
            [['siswa_id', 'calon_siswa_id', 'jenis_pembayaran_id', 'status'], 'integer'],
            [['jenis_pembayaran_id', 'tanggal_jatuh_tempo'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['calon_siswa_id'], 'exist', 'skipOnError' => true, 'targetClass' => CalonSiswaModel::class, 'targetAttribute' => ['calon_siswa_id' => 'id']],
            [['jenis_pembayaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisPembayaranModel::class, 'targetAttribute' => ['jenis_pembayaran_id' => 'id']],
            [['siswa_id'], 'exist', 'skipOnError' => true, 'targetClass' => SiswaModel::class, 'targetAttribute' => ['siswa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'siswa_id' => 'Siswa',
            'calon_siswa_id' => 'Calon Siswa',
            'jenis_pembayaran_id' => 'Jenis Pembayaran',
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
        return $this->hasOne(CalonSiswaModel::class, ['id' => 'calon_siswa_id']);
    }

    /**
     * Gets query for [[JenisPembayaran]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisPembayaran()
    {
        return $this->hasOne(JenisPembayaranModel::class, ['id' => 'jenis_pembayaran_id']);
    }

    /**
     * Gets query for [[Pembayarans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayaran()
    {
        return $this->hasMany(PembayaranModel::class, ['tagihan_id' => 'id']);
    }

    /**
     * Gets query for [[Siswa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiswa()
    {
        return $this->hasOne(SiswaModel::class, ['id' => 'siswa_id']);
    }

}

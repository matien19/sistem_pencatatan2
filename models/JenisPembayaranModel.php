<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis_pembayaran".
 *
 * @property int $id
 * @property int|null $jurusan_id
 * @property string|null $kelas 1,2,3
 * @property string $nama_pembayaran contoh: spp, ujian
 * @property float $nominal
 * @property int $tahun_akademik
 * @property string $semester
 * @property string $keterangan
 * @property string $kepada
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property JenisJurusan[] $jenisJurusans
 * @property Jurusan $jurusan
 * @property Tagihan[] $tagihans
 */
class JenisPembayaranModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jurusan_id', 'kelas', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['tahun_akademik'], 'integer'],
            [['nama_pembayaran', 'nominal', 'tahun_akademik', 'semester', 'keterangan', 'kepada'], 'required'],
            [['nominal'], 'number'],
            [['created_at', 'updated_at','jurusan_id'], 'safe'],
            [['nama_pembayaran', 'semester', 'keterangan', 'kepada'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jurusan_id' => 'Jurusan ID',
            'kelas' => 'Kelas',
            'nama_pembayaran' => 'Nama Pembayaran',
            'nominal' => 'Nominal',
            'tahun_akademik' => 'Tahun Akademik',
            'semester' => 'Semester',
            'keterangan' => 'Keterangan',
            'kepada' => 'Kepada',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
   
}

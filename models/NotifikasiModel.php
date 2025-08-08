<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifikasi".
 *
 * @property int $id_notifikasi
 * @property int $id_user
 * @property int $id_tagihan
 * @property string $pesan
 * @property string $tgl_kirim
 * @property string $status_baca
 * @property string $created_at
 * @property string $updated_at
 */
class NotifikasiModel extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_BACA_0 = '0';
    const STATUS_BACA_1 = '1';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_tagihan', 'pesan', 'tgl_kirim', 'status_baca'], 'required'],
            [['id_user', 'id_tagihan'], 'integer'],
            [['tgl_kirim', 'created_at', 'updated_at'], 'safe'],
            [['status_baca'], 'string'],
            [['pesan'], 'string', 'max' => 255],
            ['status_baca', 'in', 'range' => array_keys(self::optsStatusBaca())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_notifikasi' => 'Id Notifikasi',
            'id_user' => 'Id User',
            'id_tagihan' => 'Id Tagihan',
            'pesan' => 'Pesan',
            'tgl_kirim' => 'Tgl Kirim',
            'status_baca' => 'Status Baca',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * column status_baca ENUM value labels
     * @return string[]
     */
    public static function optsStatusBaca()
    {
        return [
            self::STATUS_BACA_0 => '0',
            self::STATUS_BACA_1 => '1',
        ];
    }

    /**
     * @return string
     */
    public function displayStatusBaca()
    {
        return self::optsStatusBaca()[$this->status_baca];
    }

    /**
     * @return bool
     */
    public function isStatusBaca0()
    {
        return $this->status_baca === self::STATUS_BACA_0;
    }

    public function setStatusBacaTo0()
    {
        $this->status_baca = self::STATUS_BACA_0;
    }

    /**
     * @return bool
     */
    public function isStatusBaca1()
    {
        return $this->status_baca === self::STATUS_BACA_1;
    }

    public function setStatusBacaTo1()
    {
        $this->status_baca = self::STATUS_BACA_1;
    }
}

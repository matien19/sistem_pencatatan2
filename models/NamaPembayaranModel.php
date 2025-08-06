<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nama_pembayaran".
 *
 * @property int $id
 * @property string $nama_pembayaran
 * @property string $created_at
 * @property string $updated_at
 */
class NamaPembayaranModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nama_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pembayaran'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama_pembayaran'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_pembayaran' => 'Nama Pembayaran',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pembayaran".
 *
 * @property int $id
 * @property int $tagihan_id
 * @property int $nominal_bayar
 * @property string $bukti_bayar
 * @property string $tanggal_bayar
 * @property string $metode_bayar qris,bank,tunai
 * @property string $dibayar_oleh siswa, staf
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Tagihan $tagihan
 */
class PembayaranModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['tagihan_id', 'nominal_bayar', 'bukti_bayar', 'tanggal_bayar', 'metode_bayar', 'dibayar_oleh'], 'required'],
            [['tagihan_id', 'nominal_bayar'], 'integer'],
            [['tanggal_bayar', 'created_at', 'updated_at'], 'safe'],
            [['bukti_bayar', 'metode_bayar', 'dibayar_oleh'], 'string', 'max' => 255],
            [['tagihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagihanModel::class, 'targetAttribute' => ['tagihan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagihan_id' => 'Tagihan ID',
            'nominal_bayar' => 'Nominal Bayar',
            'bukti_bayar' => 'Bukti Bayar',
            'tanggal_bayar' => 'Tanggal Bayar',
            'metode_bayar' => 'Metode Bayar',
            'dibayar_oleh' => 'Dibayar Oleh',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Tagihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihan()
    {
        return $this->hasOne(TagihanModel::class, ['id' => 'tagihan_id']);
    }

}

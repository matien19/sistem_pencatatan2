<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nama_kelas".
 *
 * @property int $id
 * @property string $nama_kelas
 * @property string $created_at
 * @property string $updated_at
 */
class NamaKelasModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nama_kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kelas'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama_kelas'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kelas' => 'Nama Kelas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}

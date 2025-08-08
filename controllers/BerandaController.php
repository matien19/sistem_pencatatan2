<?php

namespace app\controllers;

use app\models\CalonSiswaModel;
use app\models\NotifikasiModel;
use app\models\SiswaModel;
use app\models\TagihanModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class BerandaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index', 'dashboard', 'siswa'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'dashboard', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'staf' || Yii::$app->user->identity->role === 'admin';
                        },
                    ],
                    [
                        'actions' => ['siswa'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return in_array(Yii::$app->user->identity->role, ['siswa', 'calon_siswa']);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $jumlahSiswa = SiswaModel::find()->count();
        $jumlahCalon = CalonSiswaModel::find()->count();
        $totalTagihan = TagihanModel::find()->count();
        $jumlahLunas = TagihanModel::find()->where(['status' => 1])->count();
        $jumlahBelum = $totalTagihan - $jumlahLunas;

        return $this->render('/beranda/index', [
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahCalon' => $jumlahCalon,
            'totalTagihan' => $totalTagihan,
            'jumlahLunas' => $jumlahLunas,
            'jumlahBelum' => $jumlahBelum,
        ]);
    }
    
    public function actionSiswa()
    {
        $userId = Yii::$app->user->id;
        $siswa = SiswaModel::findOne(['user_id' => $userId]);
        $notifikasiBelum = NotifikasiModel::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status_baca' => '0'])
            ->orderBy(['tgl_kirim' => SORT_DESC])
            ->all();
            
        // Cek apakah siswa atau calon siswa
        if ($siswa) {
            $query = TagihanModel::find()->where(['siswa_id' => $siswa->id]);
        } else {
            $siswa = CalonSiswaModel::findOne(['user_id' => $userId]);
            if ($siswa) {
                $query = TagihanModel::find()->where(['calon_siswa_id' => $siswa->id]);
            } else {
                $query = TagihanModel::find()->where(['0=1']); // kosong
            }
        }

        // Hitung total tagihan dan lunas
        $jumlahTagihan = $query->count();
        $jumlahLunas = clone $query;
        $jumlahLunas = $jumlahLunas->andWhere(['status' => 1])->count();

        return $this->render('/beranda/siswa', [
            'siswa' => $siswa,
            'jumlahTagihan' => $jumlahTagihan,
            'jumlahLunas' => $jumlahLunas,
            'notifikasiBelum' => $notifikasiBelum,
        ]);
    }

    public function actionTandaiNotifikasiRead()
    {
        $userId = Yii::$app->user->id;
        $notifikasiBelum = NotifikasiModel::find()
            ->where(['user_id' => $userId, 'status_baca' => '0'])
            ->all();

        // return json_encode(['status' => 'success', 'message' => $notifikasiBelum]);

        foreach ($notifikasiBelum as $notif) {
            $notif->status_baca = '1';
            $notif->save(false);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->redirect(['beranda/siswa']);
    }
}

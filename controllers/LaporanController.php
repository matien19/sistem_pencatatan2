<?php

namespace app\controllers;

use app\models\TagihanModel;
use Mpdf\Mpdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class LaporanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === 'admin';
                            },
                        ],
                    ],
                ],
            ]
        );
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
        
        $bulan = Yii::$app->request->get('bulan');
        $tahun = Yii::$app->request->get('tahun');

        $querySiswa = TagihanModel::find()->where(['not', ['siswa_id' => null]]);
        $queryCalon = TagihanModel::find()->where(['not', ['calon_siswa_id' => null]]);

        // Jika filter bulan & tahun dipilih
        if ($bulan && $tahun) {
            $tanggalAwal = "$tahun-$bulan-01";
            $tanggalAkhir = date('Y-m-t', strtotime($tanggalAwal));

            $querySiswa->andWhere(['between', 'tanggal_jatuh_tempo', $tanggalAwal, $tanggalAkhir]);
            $queryCalon->andWhere(['between', 'tanggal_jatuh_tempo', $tanggalAwal, $tanggalAkhir]);
        }

        $dataProviderSiswa = new ActiveDataProvider([
            'query' => $querySiswa,
            'pagination' => ['pageSize' => 20],
        ]);

        $dataProviderCalonSiswa = new ActiveDataProvider([
            'query' => $queryCalon,
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProviderSiswa' => $dataProviderSiswa,
            'dataProviderCalonSiswa' => $dataProviderCalonSiswa,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }
    public function actionCetakPdf($tipe = 'siswa', $bulan = null, $tahun = null)
    {
        $query = TagihanModel::find();

        // Filter berdasarkan tipe
        if ($tipe === 'siswa') {
            $query->andWhere(['not', ['siswa_id' => null]]);
        } elseif ($tipe === 'calon') {
            $query->andWhere(['not', ['calon_siswa_id' => null]]);
        } else {
            throw new BadRequestHttpException("Tipe tidak valid.");
        }

        // Filter tanggal jika ada
        if ($bulan && $tahun) {
            $tanggalAwal = "$tahun-$bulan-01";
            $tanggalAkhir = date('Y-m-t', strtotime($tanggalAwal));
            $query->andWhere(['between', 'tanggal_jatuh_tempo', $tanggalAwal, $tanggalAkhir]);
        }

        $models = $query->all();

        // Render partial view sebagai isi PDF
        $content = $this->renderPartial('_laporan-pdf', [
            'models' => $models,
            'tipe' => $tipe,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        // Buat PDF dengan Mpdf
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);
        $mpdf->SetTitle("Laporan Tagihan");
        $mpdf->Output("Laporan_Tagihan_{$tipe}_{$bulan}_{$tahun}.pdf", \Mpdf\Output\Destination::INLINE);
        return;
    }
}

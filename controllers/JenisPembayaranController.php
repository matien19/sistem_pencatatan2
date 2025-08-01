<?php

namespace app\controllers;

use app\models\JenisPembayaranModel;
use app\models\KelasModel;
use app\models\SearchJenisPembayaranModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JenisPembayaranController implements the CRUD actions for JenisPembayaranModel model.
 */
class JenisPembayaranController extends Controller
{
    /**
     * @inheritDoc
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
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === 'staf' || \Yii::$app->user->identity->role === 'admin';
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all JenisPembayaranModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchJenisPembayaranModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataKelas = KelasModel::find()->orderBy(['created_at' => SORT_DESC])->all(); // ambil max 100, bisa disesuaikan
        $currentYear = date('Y');

        foreach ($dataKelas as $item) {
            $academicYear = (int) $item->tahun_masuk;
            $classNumber = $currentYear - $academicYear + 1;

            // Batas logika kelas 1 sampai 3
            if ($classNumber < 1) {
                $classNumber = 1;
            } elseif ($classNumber > 3) {
                $classNumber = 3;
            }

            $item->kelas = $classNumber;
            $item->save(false); // false = skip validasi, bisa diganti true jika validasi diperlukan
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JenisPembayaranModel model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JenisPembayaranModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new JenisPembayaranModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validasi data sebelum menyimpan
                if (!$model->validate()) {
                    Yii::$app->session->setFlash('error', 'Data tidak valid. Silakan periksa kembali.');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                $kelas = $model->kelas ?? [];
                $jurusan = $model->jurusan_id ?? [];

                // Buat instance baru dari model pembayaran
                $jenis = new JenisPembayaranModel();
                $jenis->nama_pembayaran = $model->nama_pembayaran;
                $jenis->nominal = $model->nominal;
                $jenis->tahun_akademik = $model->tahun_akademik;
                $jenis->semester = $model->semester;
                $jenis->keterangan = $model->keterangan;
                $jenis->kepada = $model->kepada;
                $jenis->created_at = date('Y-m-d H:i:s');
                $jenis->updated_at = date('Y-m-d H:i:s');

                if (!empty($kelas)) {
                    $jenis->kelas = json_encode($kelas); // atau implode(',', $kelas);
                } else {
                    $jenis->kelas = '["-"]'; // atau implode(',', $kelas);
                }
                if (!empty($jurusan)) {
                    $jenis->jurusan_id = json_encode($jurusan); // atau implode(',', $jurusan);
                } else {
                    $jenis->jurusan_id = '["-"]'; // atau implode(',', $jurusan);
                }

                if ($jenis->save()) { // false = skip validasi, bisa diganti true jika validasi diperlukan
                    Yii::$app->session->setFlash('success', 'Jenis pembayaran berhasil dibuat.');
                    return $this->redirect(['view', 'id' => $jenis->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan jenis pembayaran. Silakan coba lagi.');
                }

                $model->addErrors($model->getErrors());
            }
           
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing JenisPembayaranModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
         $model = JenisPembayaranModel::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if (!$model->validate()) {
                    Yii::$app->session->setFlash('error', 'Data tidak valid. Silakan periksa kembali.');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }

                $kelas = $model->kelas ?? [];
                $jurusan = $model->jurusan_id ?? [];

                $model->updated_at = date('Y-m-d H:i:s');

                $model->kelas = !empty($kelas) ? json_encode($kelas) : '["-"]';
                $model->jurusan_id = !empty($jurusan) ? json_encode($jurusan) : '["-"]';

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Jenis pembayaran berhasil diperbarui.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan perubahan.');
                }
            }
        } else {
            // decode JSON agar saat update form bisa diisi ulang sebagai array
            $model->kelas = is_string($model->kelas) && $model->kelas !== '["-"]' ? json_decode($model->kelas, true) : [];
            $model->jurusan_id = is_string($model->jurusan_id) && $model->jurusan_id !== '["-"]' ? json_decode($model->jurusan_id, true) : [];
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing JenisPembayaranModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the JenisPembayaranModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return JenisPembayaranModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JenisPembayaranModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

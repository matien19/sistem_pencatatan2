<?php

namespace app\controllers;

use app\models\CalonSiswaModel;
use app\models\JenisPembayaranModel;
use app\models\TagihanModel;
use app\models\SearchTagihanModel;
use app\models\SiswaModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TagihanController implements the CRUD actions for TagihanModel model.
 */
class TagihanController extends Controller
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
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === 'staf';
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TagihanModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchTagihanModel();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        $querySiswa = TagihanModel::find()->where(['not', ['siswa_id' => null]]);
        $queryCalon = TagihanModel::find()->where(['not', ['calon_siswa_id' => null]]);

        $dataProviderSiswa = new ActiveDataProvider([
            'query' => $querySiswa,
        ]);

        $dataProviderCalonSiswa = new ActiveDataProvider([
            'query' => $queryCalon,
        ]);

        return $this->render('index', [
            'dataProviderSiswa' => $dataProviderSiswa,
            'dataProviderCalonSiswa' => $dataProviderCalonSiswa,
        ]);
    }

    /**
     * Displays a single TagihanModel model.
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
     * Creates a new TagihanModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TagihanModel();
        $jenisPembayaranList = ArrayHelper::map(JenisPembayaranModel::find()->all(),
            'id',
            function ($item) {
                return "{$item->nama_pembayaran} | {$item->kepada} | Rp " . number_format($item->nominal, 0, ',', '.') .
                    " | {$item->tahun_akademik} | {$item->semester}";
            }
        );

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $jenis = JenisPembayaranModel::findOne($model->jenis_pembayaran_id);
                if (!$jenis) {
                    // Yii::$app->session->setFlash('error', 'Jenis pembayaran tidak ditemukan.');
                    return $this->redirect(['create']);
                }

                if ($jenis->kepada === 'calon_siswa') {

                    $jurusanList = is_array($jenis->jurusan_id) ? $jenis->jurusan_id : json_decode($jenis->jurusan_id, true);

                    if (in_array('-', $jurusanList)) {
                        $calonList = CalonSiswaModel::find()->all();
                        foreach ($calonList as $calon) {
                            $model = new TagihanModel([
                                'calon_siswa_id' => $calon->id,
                                'jenis_pembayaran_id' => $jenis->id,
                                'total_tagihan' => $jenis->nominal,
                                'status' => 0,
                                'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                            ]);
                            $model->save();
                        }
                    } else {
                        foreach ($jurusanList as $jurusan) {
                            $calonList = CalonSiswaModel::find()->where(['jurusan_id' => $jurusan])->all();
                            foreach ($calonList as $calon) {
                                $model = new TagihanModel([
                                    'calon_siswa_id' => $calon->id,
                                    'jenis_pembayaran_id' => $jenis->id,
                                    'total_tagihan' => $jenis->nominal,
                                    'status' => 0,
                                    'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                                ]);
                                $model->save();
                            }
                        }   
                    }

                } elseif ($jenis->kepada === 'siswa') {

                    $jurusanList = is_array($jenis->jurusan_id) ? $jenis->jurusan_id : json_decode($jenis->jurusan_id, true);
                    $kelasArray = is_array($jenis->kelas) ? $jenis->kelas : json_decode($jenis->kelas, true);

                    $query = SiswaModel::find()->joinWith(['kelas.jurusan']);

                    // Jika jurusan dan kelas == '-'
                    if (in_array('-', $jurusanList) && in_array('-', $kelasArray)) {
                        $siswaList = $query->all();
                        foreach ($siswaList as $siswa) {
                            $model = new TagihanModel([
                                'siswa_id' => $siswa->id,
                                'jenis_pembayaran_id' => $jenis->id,
                                'total_tagihan' => $jenis->nominal,
                                'status' => 0,
                                'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                            ]);
                            $model->save();
                        }
                    }

                    // Jika jurusan == '-' → ambil berdasarkan kelas ID saja
                    elseif (in_array('-', $jurusanList)) {
                        foreach ($kelasArray as $kelas) {
                            $siswaList = $query->where(['kelas.kelas' => $kelas])->all();
                            foreach ($siswaList as $siswa) {
                                $model = new TagihanModel([
                                    'siswa_id' => $siswa->id,
                                    'jenis_pembayaran_id' => $jenis->id,
                                    'total_tagihan' => $jenis->nominal,
                                    'status' => 0,
                                    'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                                ]);
                                $model->save();
                            }
                        }
                    }

                    // Jika kelas == '-' → ambil berdasarkan jurusan ID
                    elseif (in_array('-', $kelasArray)) {
                        foreach ($jurusanList as $jurusan) {
                            $siswaList = $query->where(['kelas.jurusan_id' => $jurusan])->all();
                            foreach ($siswaList as $siswa) {
                                $model = new TagihanModel([
                                    'siswa_id' => $siswa->id,
                                    'jenis_pembayaran_id' => $jenis->id,
                                    'total_tagihan' => $jenis->nominal,
                                    'status' => 0,
                                    'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                                ]);
                                $model->save();
                            }
                        }
                    }

                    // Jika jurusan dan kelas keduanya spesifik
                    else {
                        foreach ($jurusanList as $jurusan) {
                            foreach ($kelasArray as $kelas) {
                                $siswaList = $query->where(['kelas.jurusan_id' => $jurusan, 'kelas.kelas' => $kelas])->all();
                                foreach ($siswaList as $siswa) {
                                    $model = new TagihanModel([
                                        'siswa_id' => $siswa->id,
                                        'jenis_pembayaran_id' => $jenis->id,
                                        'total_tagihan' => $jenis->nominal,
                                        'status' => 0,
                                        'tanggal_jatuh_tempo' => $model->tanggal_jatuh_tempo,
                                    ]);
                                    $model->save();
                                }
                            }
                        }
                    }
                }

                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'jenisPembayaranList' => $jenisPembayaranList,
        ]);
    }

    /**
     * Updates an existing TagihanModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     $jenisPembayaranList = ArrayHelper::map(JenisPembayaranModel::find()->all(),
    //         'id',
    //         function ($item) {
    //             return "{$item->nama_pembayaran} | {$item->kepada} | Rp " . number_format($item->nominal, 0, ',', '.') .
    //                 " | {$item->tahun_akademik} | {$item->semester}";
    //         }
    //     );

    //     if ($this->request->isPost) {
    //         $model->load($this->request->post());

    //         $jenis = JenisPembayaranModel::findOne($model->jenis_pembayaran_id);
    //             if (!$jenis) {
    //                 // Yii::$app->session->setFlash('error', 'Jenis pembayaran tidak ditemukan.');
    //                 return $this->redirect(['create']);
    //             }
    //         if ($jenis->kepada === 'calon_siswa') {
    //             $calon = CalonSiswaModel::findOne($model->calon_siswa_id);
    //             if (!$calon) {
    //                 Yii::$app->session->setFlash('error', 'Calon siswa tidak ditemukan.');
    //                 return $this->redirect(['index']);
    //             }
    //             $model->siswa_id = null; // Set siswa_id to null for calon siswa
    //         } elseif ($jenis->kepada === 'siswa') {
    //             $siswa = SiswaModel::findOne($model->siswa_id);
    //             if (!$siswa) {
    //                 Yii::$app->session->setFlash('error', 'Siswa tidak ditemukan.');
    //                 return $this->redirect(['index']);
    //             }
    //             $model->calon_siswa_id = null; // Set calon_siswa_id to null for siswa
    //         }

    //         if ($model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //         'jenisPembayaranList' => $jenisPembayaranList,
    //     ]);
    // }

    /**
     * Deletes an existing TagihanModel model.
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
     * Finds the TagihanModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return TagihanModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TagihanModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionVerifikasi($id)
    {
        $model = $this->findModel($id);
        $model->status = 1; // asumsi status true artinya sudah diverifikasi
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Pembayaran berhasil diverifikasi.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal memverifikasi pembayaran.');
        }
        return $this->redirect(['index']); // sesuaikan redirect
    }
}

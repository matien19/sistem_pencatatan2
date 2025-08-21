<?php

namespace app\controllers;

use app\helpers\FonnteHelper;
use app\models\CalonSiswaModel;
use app\models\JenisPembayaranModel;
use app\models\NotifikasiModel;
use app\models\PembayaranModel;
use app\models\TagihanModel;
use app\models\SearchTagihanModel;
use app\models\SiswaModel;
use Mpdf\Mpdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === 'staf' || \Yii::$app->user->identity->role === 'admin';
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
        $pembayaranBaru = new PembayaranModel();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'pembayaranBaru' => $pembayaranBaru,
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
        $pembayaran = PembayaranModel::find()->where(['tagihan_id' => $id])->all();
        foreach ($pembayaran as $pembayaranItem) {
            $pembayaranItem->delete();
        }

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
            $siswa = SiswaModel::findOne($model->siswa_id);
            if (!$siswa) {
                $siswa = CalonSiswaModel::findOne($model->calon_siswa_id);
            }
            $notifikasi = new NotifikasiModel();
            $notifikasi->id_tagihan = $model->id;
            $notifikasi->user_id = $siswa->user_id;
            $notifikasi->pesan = "Tagihan {$model->jenisPembayaran->nama_pembayaran} Rp {$model->total_tagihan} telah diverifikasi dan Lunas.";
            $notifikasi->tgl_kirim = date('Y-m-d H:i:s');
            $notifikasi->save(false);

            FonnteHelper::kirimWa($siswa->no_hp, $notifikasi->pesan);

            Yii::$app->session->setFlash('success', 'Pembayaran berhasil diverifikasi.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal memverifikasi pembayaran.');
        }
        return $this->redirect(['index']); // sesuaikan redirect
    }
    public function actionPembayaran()
    {
        $model = new PembayaranModel();
        
        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';
            // print_r($model->attributes);
            // Tangkap file upload
            $model->bukti_bayar = UploadedFile::getInstance($model, 'bukti_bayar');

            // Proses simpan file jika ada bukti
            if ($model->bukti_bayar) {
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $maxSize = 5 * 1024 * 1024; 

                if (!in_array(strtolower($model->bukti_bayar->extension), $allowedExtensions)) {
                    Yii::$app->session->setFlash('error', 'Format file harus JPG atau PNG.');
                    return $this->redirect(Yii::$app->request->referrer);
                }

                if ($model->bukti_bayar->size > $maxSize) {
                    Yii::$app->session->setFlash('error', 'Ukuran file maksimal adalah 5MB.');
                    return $this->redirect(Yii::$app->request->referrer);
                }

                $uploadPath = Yii::getAlias('@webroot/bukti/');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $filename = 'bukti_' . time() . '.' . $model->bukti_bayar->extension;
                $path = $uploadPath . $filename;

                $model->bukti_bayar->saveAs($path);
                $model->bukti_bayar = $filename;
            }

            $model->dibayar_oleh = 'staf';
            $model->status = 1;
            if ($model->save(false)) { 
                $tagihan = TagihanModel::findOne($model->tagihan_id);
                $siswa = SiswaModel::findOne($tagihan->siswa_id);
                if (!$siswa) {
                    $siswa = CalonSiswaModel::findOne($tagihan->calon_siswa_id);
                }
                $totalBayar = PembayaranModel::find()
                    ->where(['tagihan_id' => $model->tagihan_id])
                    ->sum('nominal_bayar'); 
                $sisa_bayar = $tagihan->total_tagihan - $totalBayar;
                if ($sisa_bayar < 0) {
                    $sisa_bayar = 0; // Pastikan sisa bayar tidak negatif
                }
                $notifikasi = new NotifikasiModel();
                $notifikasi->id_tagihan = $model->tagihan_id;
                $notifikasi->user_id = $siswa->user_id;
                $notifikasi->pesan = "Pembayaran Rp {$model->nominal_bayar} diterima. Sisa: Rp {$sisa_bayar}";
                $notifikasi->tgl_kirim = date('Y-m-d H:i:s');
                $notifikasi->save(false);

                FonnteHelper::kirimWa($siswa->no_hp, $notifikasi->pesan);


                Yii::$app->session->setFlash('success', 'Pembayaran berhasil disimpan.');
                return $this->redirect(['tagihan/view', 'id' => $model->tagihan_id]);
            }
            $model->addErrors($model->getErrors());
                return $this->redirect(['tagihan/view', 'id' => $model->tagihan_id]);

        }
    }
    public function actionVerifikasipem($id)
    {
        
        $model = PembayaranModel::findOne($id);
        $model->status = 1; // asumsi status true artinya sudah diverifikasi
        if ($model->save()) {
            $tagihan = TagihanModel::findOne($model->tagihan_id);
            $siswa = SiswaModel::findOne($tagihan->siswa_id);
            if (!$siswa) {
                $siswa = CalonSiswaModel::findOne($tagihan->calon_siswa_id);
            }

            $totalBayar = PembayaranModel::find()
                ->where(['tagihan_id' => $model->tagihan_id])
                ->sum('nominal_bayar'); 
            $sisa_bayar = $tagihan->total_tagihan - $totalBayar;
            if ($sisa_bayar < 0) {
                $sisa_bayar = 0; // Pastikan sisa bayar tidak negatif
            }
            $notifikasi = new NotifikasiModel();
            $notifikasi->id_tagihan = $model->tagihan_id;
            $notifikasi->user_id = $siswa->user_id;
            $notifikasi->pesan = "Pembayaran Rp {$model->nominal_bayar} diterima. Sisa: Rp {$sisa_bayar}";
            $notifikasi->tgl_kirim = date('Y-m-d H:i:s');
            $notifikasi->save(false);

            FonnteHelper::kirimWa($siswa->no_hp, $notifikasi->pesan);

            Yii::$app->session->setFlash('success', 'Pembayaran berhasil diverifikasi.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal memverifikasi pembayaran.');
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['tagihan/index']);
    }
    public function actionTolakpem($id)
    {
        $model = PembayaranModel::findOne($id);
        $model->status = 2;
        $model->nominal_bayar = 0; // Reset jumlah bayar jika ditolak
        if ($model->save()) {
            $tagihan = TagihanModel::findOne($model->tagihan_id);
            $siswa = SiswaModel::findOne($tagihan->siswa_id);
            if (!$siswa) {
                $siswa = CalonSiswaModel::findOne($tagihan->calon_siswa_id);
            }

            $notifikasi = new NotifikasiModel();
            $notifikasi->id_tagihan = $model->tagihan_id;
            $notifikasi->user_id = $siswa->user_id;
            $notifikasi->pesan = "Pembayaran {$tagihan->jenisPembayaran->nama_pembayaran} ditolak.";
            $notifikasi->tgl_kirim = date('Y-m-d H:i:s');
            $notifikasi->save(false);

            FonnteHelper::kirimWa($siswa->no_hp, $notifikasi->pesan);
            
            Yii::$app->session->setFlash('success', 'Pembayaran berhasil ditolak.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menolak pembayaran.');
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['tagihan/index']);
    }

    public function actionCetakKuitansi($id)
    {
        $pembayaran = PembayaranModel::findOne($id);

        if (!$pembayaran || $pembayaran->status != 1) {
            throw new \yii\web\NotFoundHttpException('Pembayaran tidak ditemukan atau belum diterima.');
        }

        $mpdf = new Mpdf([
            'format' => 'A5-L', // Kuitansi biasanya landscape kecil
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_left' => 5,
            'margin_right' => 5
        ]);

        $html = $this->renderPartial('_kuitansi', [
            'pembayaran' => $pembayaran,
            'tagihan' => $pembayaran->tagihan
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Kuitansi_' . $pembayaran->id . '.pdf', 'I');
    }


}

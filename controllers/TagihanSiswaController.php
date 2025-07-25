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
class TagihanSiswaController extends Controller
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
                            return !\Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, ['siswa', 'calon_siswa']);
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
        $userId = Yii::$app->user->id;
        $siswa = SiswaModel::findOne(['user_id' => $userId]);
        if (!$siswa) {
            throw new NotFoundHttpException('Siswa not found.');
        }
        $searchModel = new SearchTagihanModel();
        $query = TagihanModel::find()->where(['siswa_id' => $siswa->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

                // return $this->redirect(['index']);
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

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
}

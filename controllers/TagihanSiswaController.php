<?php

namespace app\controllers;

use app\models\CalonSiswaModel;
use app\models\JenisPembayaranModel;
use app\models\PembayaranModel;
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
use yii\web\UploadedFile;

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
                            return !\Yii::$app->user->isGuest && \Yii::$app->user->identity->role === 'siswa' || \Yii::$app->user->identity->role === 'calon_siswa';
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
        // Coba cari dari tabel siswa dulu
        $siswa = SiswaModel::findOne(['user_id' => $userId]);

        if ($siswa) {
            $query = TagihanModel::find()->where(['siswa_id' => $siswa->id])->orderBy(['created_at' => SORT_DESC]);
        } else {
            // Jika tidak ditemukan, coba cari dari calon siswa
            $calonSiswa = CalonSiswaModel::findOne(['user_id' => $userId]);

            if ($calonSiswa) {
                $query = TagihanModel::find()->where(['calon_siswa_id' => $calonSiswa->id])->orderBy(['created_at' => SORT_DESC]);
            } else {
                throw new NotFoundHttpException('Siswa atau Calon Siswa tidak ditemukan.');
            }
        }
        $searchModel = new SearchTagihanModel();
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
        $model = $this->findModel($id);

        $pembayaranBaru = new PembayaranModel();
        return $this->render('view', [
            'model' => $model,
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

            $model->dibayar_oleh = 'siswa'; // Atur sesuai dengan role yang sesuai
            if ($model->save(false)) { // skip validate karena sudah dilakukan
                Yii::$app->session->setFlash('success', 'Pembayaran berhasil disimpan.');
                return $this->redirect(['tagihan-siswa/view', 'id' => $model->tagihan_id]);
            }
            $model->addErrors($model->getErrors());
                return $this->redirect(['tagihan-siswa/view', 'id' => $model->tagihan_id]);

            
        }

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

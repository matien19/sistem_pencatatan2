<?php

namespace app\controllers;

use app\models\CalonSiswaModel;
use app\models\SearchCalonSiswaModel;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalonSiswaController implements the CRUD actions for CalonSiswaModel model.
 */
class CalonSiswaController extends Controller
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
     * Lists all CalonSiswaModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchCalonSiswaModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CalonSiswaModel model.
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
     * Creates a new CalonSiswaModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CalonSiswaModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Create User first
                $noPendaftaran = $this->request->post('CalonSiswaModel')['no_pendaftaran'] ?? null;

                $user = new User();
                $user->nama = $this->request->post('CalonSiswaModel')['nama'] ?? '';
                $user->email = $this->request->post('CalonSiswaModel')['email'] ?? ($user->nama . '@gmail.com');
                $user->username = $noPendaftaran ? 'REG' . $noPendaftaran : $user->nama;
                $user->role = 'siswa';
                $user->created_at = date('Y-m-d H:i:s');
                $user->updated_at = date('Y-m-d H:i:s');
                $user->password = Yii::$app->security->generatePasswordHash($user->username);
                if ($user->save()) {
                    // Assign user_id to siswa
                    $model->no_pendaftaran = $user->username;
                    $model->user_id = $user->id;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->updated_at = date('Y-m-d H:i:s');
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
                // Jika gagal simpan user atau siswa, tampilkan error ke view
                $model->addErrors($user->getErrors());
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
     * Updates an existing CalonSiswaModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->no_pendaftaran = preg_replace('/^REG/', '', $model->no_pendaftaran);

        $user = User::findOne($model->user_id); // Ambil user yang terkait

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postData = $this->request->post('CalonSiswaModel');

            // Update data user juga
            if ($user) {
                $user->nama = $postData['nama'] ?? $user->nama;
                $user->email = $postData['email'] ?? $user->email;
                $user->username = 'REG' . ($postData['no_pendaftaran'] ?? $model->no_pendaftaran);
                $user->password = Yii::$app->security->generatePasswordHash($user->username);
                $user->updated_at = date('Y-m-d H:i:s');
            }

            $model->updated_at = date('Y-m-d H:i:s');
            $model->no_pendaftaran = $user->username; // Sinkronkan no_pendaftaran dengan username

            // Simpan user & model
            $isUserSaved = $user ? $user->save() : true;
            $isModelSaved = $model->save();

            if ($isUserSaved && $isModelSaved) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            // Jika gagal simpan, tampilkan error di view
            $model->addErrors($user ? $user->getErrors() : []);
            $model->addErrors($model->getErrors());
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CalonSiswaModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id) {
            $user = User::findOne(['id' => $model->user_id]);
            if ($user) {
                $user->delete();
            }
        }
        // Hapus siswa
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CalonSiswaModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return CalonSiswaModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CalonSiswaModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

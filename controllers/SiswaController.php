<?php

namespace app\controllers;

use app\models\SiswaModel;
use app\models\SearchSiswaModel;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SiswaController implements the CRUD actions for SiswaModel model.
 */
class SiswaController extends Controller
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
            ]
        );
    }

    /**
     * Lists all SiswaModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchSiswaModel();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SiswaModel model.
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
     * Creates a new SiswaModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SiswaModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Create User first
                $user = new User();
                $user->nama = $this->request->post('SiswaModel')['nama'] ?? '';
                $user->email = $this->request->post('SiswaModel')['email'] ?? ($user->nama . '@gmail.com');
                $user->username = $this->request->post('SiswaModel')['nisn'] ?? $user->nama;
                $user->role = 'siswa';
                $user->created_at = date('Y-m-d H:i:s');
                $user->updated_at = date('Y-m-d H:i:s');
                $user->password = Yii::$app->security->generatePasswordHash($this->request->post('SiswaModel')['nisn'] ?? 'password');
                if ($user->save()) {
                    // Assign user_id to siswa
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
     * Updates an existing SiswaModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Update related User data
            $user = User::findOne(['id' => $model->user_id]);
            if ($user) {
                $user->nama = $this->request->post('SiswaModel')['nama'] ?? $user->nama;
                $user->email = $this->request->post('SiswaModel')['email'] ?? $user->email;
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
            }
            $model->updated_at = date('Y-m-d H:i:s');
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            // Jika gagal simpan user atau siswa, tampilkan error ke view
            $model->addErrors($user->getErrors());
            $model->addErrors($model->getErrors());
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SiswaModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // Hapus user terkait berdasarkan user_id
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
     * Finds the SiswaModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SiswaModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SiswaModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

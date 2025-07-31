<?php

namespace app\controllers;

use app\models\KelasModel;
use app\models\SearchKelasModel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KelasController implements the CRUD actions for KelasModel model.
 */
class KelasController extends Controller
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
     * Lists all KelasModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchKelasModel();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        $currentYear = date('Y');

        $dataKelas = KelasModel::find()->orderBy(['created_at' => SORT_DESC])->all(); // ambil max 100, bisa disesuaikan

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
     * Displays a single KelasModel model.
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
     * Creates a new KelasModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new KelasModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $currentYear = date('Y');
                $tahun_masuk = $this->request->post('KelasModel')['tahun_masuk'];

                $classNumber = $currentYear - $tahun_masuk + 1;
                
                if ($classNumber < 1) {
                    $classNumber = 1;
                } elseif ($classNumber > 3) {
                    $classNumber = 3;
                }
                
                $model->kelas = $classNumber;
                $model->tahun_masuk = $tahun_masuk;
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
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
     * Updates an existing KelasModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KelasModel model.
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
     * Finds the KelasModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return KelasModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KelasModel::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

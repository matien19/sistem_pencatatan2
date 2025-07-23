<?php

namespace app\controllers;

use app\models\TagihanModel;
use app\models\SearchTagihanModel;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
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

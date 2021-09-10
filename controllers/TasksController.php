<?php

namespace app\controllers;

use app\models\Tasks;
use app\models\TasksForm;
use app\models\TasksSearch;
use app\models\UploadFilesForm;
use Yii;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\TooManyRequestsHttpException;
use yii\web\UploadedFile;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
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
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $searchModel->user_id = \Yii::$app->user->id;

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasks();
//        $uploadModel = new UploadFilesForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->user_id = \Yii::$app->user->identity->getId();
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                $model->user_id = \Yii::$app->user->identity->getId();
//                $model->file = UploadedFile::getInstance($model, 'file');
//                $model->file->saveAs("img/{$model->file->baseName}.{$model->file->extension}");
//                $model->save(false);
//
//                $model->save();
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
//        $model = $this->findModel($id);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }

        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($file = UploadedFile::getInstance($model, 'file')) {
                $model->file = $model->uploadFile($file, $model->file);
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Все прошло удачно');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteFile($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->deleteFile();
            $model->file = '';
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Изображение удалено!');
            }
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
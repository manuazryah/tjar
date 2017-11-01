<?php

namespace backend\modules\product\controllers;

use Yii;
use common\models\Products;
use common\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use common\models\ProductSpecifications;
use yii\imagine\Image;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex() {
        unset(Yii::$app->session['tempfolder']);
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Products();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            if ($model->validate()) {
                $tag = Yii::$app->request->post()['Products']['search_tags'];
                if ($tag) {
                    $model->search_tags = implode(',', $tag);
                }
                if ($model->save()) {

                    if ($this->SaveGalleyImage($model)) {


                        $this->ChangeImageName($model);
                        $this->generateThumbImages($model);
                    }


                    $specfctns = Yii::$app->request->post()['specifications'];
                    if (!empty($specfctns)) {

                        foreach ($specfctns as $key => $value) {
//						if (!empty($value)) {
                            $product_specfctn_model = new ProductSpecifications();
                            $product_specfctn_model->product_id = $model->id;
                            $product_specfctn_model->product_feature_id = $key;
                            $product_feture = \common\models\ProductFeatures::findOne(['id' => $key]);
                            if ($product_feture->specification_type == 0) {
                                $val = explode('_', $value);
                                $product_specfctn_model->product_feature_value = $val[0];
                                $product_specfctn_model->Product_feature_text = $val[1];
                            }
                            $product_specfctn_model->save();
//						}
                        }
                    }

                    return $this->redirect(['index']);
                }
            }
        } else {
            $this->TempImageSession(Yii::$app->session['tempfolder']);
            unset(Yii::$app->session['tempfolder']);
        }
//		exit;
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    function generateThumbImages($model) {
        $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id);
        $profile_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile';
        $path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery';
        if ($this->checkdirectory($split_folder, $model, 'gallery_thumb')) {
            $thumb_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb';
            foreach (glob("{$path}/*") as $file) {
                $arry = explode('/', $file);
                $extensn = explode('.', end($arry));
                Image::thumbnail($path . '/' . end($arry), 91, 63)
                        ->save($thumb_path . '/' . $extensn[0] . '_thumb.' . $extensn[1], ['quality' => 80]);
            }
        }
        if (file_exists($profile_path . '/' . $model->canonical_name . '.' . $model->gallery_images)) {
            Image::thumbnail($profile_path . '/' . $model->canonical_name . '.' . $model->gallery_images, 91, 63)
                    ->save($profile_path . '/' . $model->canonical_name . '_thumb.' . $model->gallery_images, ['quality' => 80]);
        } else {
            
        }
    }

    function checkdirectory($split_folder, $model, $directory) {
        if (!is_dir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . $directory)) {


            mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . $directory);
            chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . $directory, 0777);
            return true;
        } else {
            return false;
        }
    }

    function SaveGalleyImage($model) {

        if (isset(Yii::$app->session['tempfolder'])) {
            $path = Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'];
            $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id);
            $new_prod_path = Yii::$app->basePath . '/../uploads/products/' . $split_folder;
            if ($this->NewFolder($model->id, $new_prod_path, $split_folder)) {
                $new_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery';
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if (file_exists($path)) {
                        if ($this->CopyImage($path, $new_path, $model, $split_folder)) {
                            $this->TempImageSession(Yii::$app->session['tempfolder']);
                            unset(Yii::$app->session['tempfolder']);
                        }
                    } else {
                        unset(Yii::$app->session['tempfolder']);
                    }
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }


                return true;
            }
        } else {
            return true;
        }
    }

    function CopyImage($path, $new_path, $model, $split_folder) {

        foreach (glob("{$path}/*") as $file) {

            $arry = explode('/', $file);
            if (is_dir($file)) {

                $profile_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile';

                $this->CopyImage($file, $profile_path, $model, $split_folder);
            } else {

                $newfile = $new_path . '/' . end($arry);
                copy($file, $newfile);
            }
        }
    }

    function NewFolder($id, $new_prod_path, $split_folder) {
        if (!is_dir($new_prod_path)) {
            mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder);
            chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder, 0777);
        }
        if (!is_dir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id)) {
            mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id);
            mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id . '/profile');
            chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id, 0777);
            chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id . '/profile', 0777);
        }
        if (!is_dir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id . '/gallery')) {
            mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id . '/gallery');
            chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $id . '/gallery', 0777);
        }

        return true;
    }

    function ChangeImageName($model) {



        $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id);

        $gallery_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . 'gallery';
        $profile_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . 'profile';
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (file_exists($gallery_path)) {
                $this->changeGalleryName($gallery_path, $split_folder, $model);
                $this->ChangeProfileImageName($profile_path, $model);
                $transaction->commit();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $this->changeGalleryName($gallery_path, $split_folder, $model);
    }

    function changeGalleryName($path, $split_folder, $model) {
        if (is_dir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/' . 'gallery')) {
            $i = 1;

            foreach (glob("{$path}/*") as $file) {
                $arry = explode('/', $file);
                $img_name = explode('.', end($arry));
                $oldDirectory = $path . '/' . $img_name[0] . '.' . $img_name[1];
                $newDirectory = $path . "/" . $model->canonical_name . '_' . $i . '.' . $img_name[1];
                rename($oldDirectory, $newDirectory);



                $i++;
            }

            return TRUE;
        }
    }

    function ChangeProfileImageName($path, $model) {
        if (is_dir($path)) {
            foreach (glob("{$path}/*") as $file) {
                $arry = explode('/', $file);
                $img_name = explode('.', end($arry));
                $oldDirectory = $path . '/' . $img_name[0] . '.' . $img_name[1];
                $newDirectory = $path . "/" . $model->canonical_name . '.' . $img_name[1];
                rename($oldDirectory, $newDirectory);
            }
            if (file_exists($path)) {
                $model->gallery_images = $img_name[1];
                $model->update();
            }
        } else {
            return FALSE;
        }
    }

    function TempImageSession() {

        if (isset(Yii::$app->session['tempfolder'])) {
            $path = Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'] . '/';
            if (file_exists($path)) {
                $this->recursiveRemoveDirectory($path);
            } else {

                unset(Yii::$app->session['tempfolder']);
                return true;
            }
            return true;
        }
    }

    function recursiveRemoveDirectory($directory) {
        foreach (glob("{$directory}/*") as $file) {
            if (is_dir($file)) {
                $this->recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        }
        FileHelper::removeDirectory($directory);
        return true;
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $image = $model->gallery_images;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {

            $model->gallery_images = $image;

            if ($model->validate() && $model->save()) {
                $new_specifictns = Yii::$app->request->post()['specifications_new'];
                $specfctns = Yii::$app->request->post()['specifications'];
                if (!empty($specfctns)) {
                    foreach ($specfctns as $key => $value) {
                        $specification_update = ProductSpecifications::find()->where(['product_id' => $id, 'id' => $key])->one();
                        $product_feture = \common\models\ProductFeatures::findOne(['id' => product_feature_id]);
//						if (empty($value)) {
//							$specification_update->delete();
//						} else {
                        if ($product_feture->specification_type == 0) {

                            $val = explode('_', $value);

                            $specification_update->product_feature_value = $val[0];
                            $specification_update->Product_feature_text = $val[1];
                        } else {
                            $specification_update->product_feature_value = $value;
                        }
                        $specification_update->update();
//						}
                    }
                }
                if (!empty($new_specifictns)) {
                    foreach ($new_specifictns as $key => $value) {
//						if (!empty($value)) {
                        $new_specfctn = new ProductSpecifications();
                        $new_specfctn->product_id = $model->id;
                        $new_specfctn->product_feature_id = $key;
                        $new_specfctn->product_feature_value = $value;
                        $new_specfctn->save();
//						}
                    }
                }
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'specifications_model' => $specifications,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProductImage() {
        if (Yii::$app->request->isAjax) {
            if (isset(Yii::$app->session['tempfolder'])) {
                $dir = \Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'] . '/';
                $result = $this->ImageUpload($_FILES, $dir);
            } else {
                $uniqueId = time() . '-' . mt_rand();
                Yii::$app->session['tempfolder'] = $uniqueId;
                if (!is_dir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId)) {
                    mkdir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId);
                    chmod(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId, 0777);
                    $dir = \Yii::$app->basePath . '/../uploads/temp/' . $uniqueId . '/';
                    $result = $this->ImageUpload($_FILES, $dir);
                }
            }
            if ($result == 1) {
                $home_path = Yii::$app->homeUrl . '../uploads/temp/' . Yii::$app->session['tempfolder'];
                $base_path = \Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'];
                $value = $this->renderPartial('image-preview', [
                    'session_id' => Yii::$app->session['tempfolder'],
                    'home_path' => $home_path,
                    'base_path' => $base_path,
                ]);

                echo $value;
            } else {
                echo 0;
            }
        }
    }

    /* for display previously added images in update form */

    public function actionProductGalleryImages() {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['modelId'])) {
                $product_model = Products::findOne($_POST['modelId']);

                if (!empty($product_model)) {

                    $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $product_model->id);
                    $home_path = Yii::$app->homeUrl . '../uploads/products/' . $split_folder . '/' . $product_model->id . '/gallery';
                    $base_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $product_model->id;
                    if (file_exists($base_path)) {
                        $value = $this->renderPartial('image-preview-update', [
                            'session_id' => Yii::$app->session['tempfolder'],
                            'home_path' => $home_path,
                            'base_path' => $base_path,
                            'model' => $product_model,
                            'split_folder' => $split_folder,
                        ]);
                        echo $value;
                    }
                }
            }
        }
    }

    public function ImageUpload($data, $dir) {
        if (isset($data['files']) && !empty($data['files'])) {
            $no_files = count($data["files"]['name']);

            for ($i = 0; $i < $no_files; $i++) {
                if ($data["files"]["error"][$i] > 0) {
                    return 0;
                } else {
                    if (move_uploaded_file($data["files"]["tmp_name"][$i], $dir . $data["files"]["name"][$i])) {
                        $reslt = 1;
                    } else {
                        $reslt = 0;
                    }
                }
            }
            return $reslt;
        } else {
            echo 'Please choose at least one file';
        }
    }

    public function actionProductFeatures() {
        if (Yii::$app->request->isAjax) {

            if (!empty($_POST['category_id'])) {

                $features = \common\models\ProductFeatures::find()->where(['category' => $_POST['category_id']])->all();
            } elseif (!empty($_POST['sub_category_id']) && !empty($_POST['category_id'])) {
                $features = \common\models\ProductFeatures::find()->where(['category' => $_POST['category_id'], 'subcategory' => $_POST['sub_category_id']])->all();
            }

            $value = $this->renderPartial('product-specifications', [
                'features' => $features,
            ]);

            echo $value;
        }
    }

    public function actionProductFeaturesUpdate() {
        if (Yii::$app->request->isAjax) {
            $specifications = ProductSpecifications::find()->where(['product_id' => $_POST['modelid']])->all();
            $saved_specifications = [];
            foreach ($specifications as $specfctn) {
                $saved_specifications [] = $specfctn->product_feature_id;
            }
            $more_features = \common\models\ProductFeatures::find()
                    ->andFilterWhere(['NOT IN', 'id', $saved_specifications])
                    ->all();

            $value = $this->renderPartial('product-specifications-update', [
                'specifications' => $specifications,
                'more_features' => $more_features,
            ]);

            echo $value;
        }
    }

    public function actionSetProfileImage() {
        if (Yii::$app->request->isAjax) {
            if (isset(Yii::$app->session['tempfolder'])) {
                $uniqueId = Yii::$app->session['tempfolder'];
                $dir = \Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'] . '/';
                if (file_exists($dir . $_POST['imagepath'])) {

                    if (!is_dir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId . '/profile')) {
                        mkdir(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId . '/profile');
                        chmod(\Yii::$app->basePath . '/../uploads/temp/' . $uniqueId . '/profile', 0777);
                    }

                    $prof_dir = \Yii::$app->basePath . '/../uploads/temp/' . $uniqueId . '/profile/';
                    if (file_exists($prof_dir)) {

                        foreach (glob("{$prof_dir}/*") as $file) {
                            unlink($file);
                        }
                    }

                    $file = $dir . $_POST['imagepath'];
                    $newfile = $prof_dir . $_POST['imagepath'];
                    if (!copy($file, $newfile)) {
                        echo "failed to copy $file...\n";
                    } else {
                        echo "copied $file into $newfile\n";
                    }
                }
            }
        }
    }

    public function actionSetNewprofileImage() {
        if (Yii::$app->request->isAjax) {

            if (isset($_POST['modelid'])) {
                $model = $this->findModel($_POST['modelid']);
                $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id);
                $dir = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb/';
                if (file_exists($dir)) {

                    if (!is_dir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile')) {

                        mkdir(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile');
                        chmod(\Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile', 0777);
                    }

                    $prof_dir = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile/';
                    $thumb_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile/';

                    if (file_exists($prof_dir)) {
                        foreach (glob("{$prof_dir}/*") as $file) {
                            unlink($file);
                        }
                    }

                    $file = $dir . $_POST['imagepath'];
                    $img_extnsn = explode('.', $_POST['imagepath']);
                    $newfile = $prof_dir . $model->canonical_name . '.' . $img_extnsn[1];

                    if (!copy($file, $newfile)) {
                        echo "failed to copy $file...\n";
                    } else {

                        $model->gallery_images = $img_extnsn[1];
                        $model->update();

                        Image::thumbnail($prof_dir . $model->canonical_name . '.' . $img_extnsn[1], 91, 63)
                                ->save($thumb_path . $model->canonical_name . '_thumb.' . $img_extnsn[1], ['quality' => 80]);
                        echo "copied $file into $newfile\n";
                    }
                }
            }
        }
    }

    public function actionDeleteGalleryImage() {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['id'])) {

                $id = explode('_', $_POST['id']);
                $image = explode('_', $_POST['image']);
                $extnsn = explode('.', end($image));
                $model = Products::findOne($id[3]);
                $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $id[3]);
                $filename = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery/' . $image[0] . '_' . $image[1] . '.' . $extnsn[1];
                $thumb = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb/' . $_POST['image'];
//				$filename_profile = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/profile/' . $_POST['image'];

                if (file_exists($thumb)) {

                    if (unlink($thumb))
                        unlink($filename);
                    echo json_encode(array('msg' => 'success', 'id' => $id[2]));
                } else {


                    echo json_encode(array('msg' => 'error', 'title' => 'Image Not Found'));
                }
            }
        }
    }

    public function actionDeleteGalleryImageFrmTemp() {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['image']) && isset(Yii::$app->session['tempfolder'])) {
                $div_id = explode('_', $_POST['id']);
                $filename = \Yii::$app->basePath . '/../uploads/temp/' . Yii::$app->session['tempfolder'] . '/' . $_POST['image'];
                if (file_exists($filename)) {

                    unlink($filename);
                    echo json_encode(array('msg' => 'success', 'div_id' => $div_id[2]));
                } else {
                    echo json_encode(array('msg' => 'error', 'title' => 'Image Not Found'));
                }
            }
        }
    }

    /* to add more images in gallery */

    public function actionMoreGalleryImage() {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['model_id'])) {
                $model = $this->findModel($_POST['model_id']);
                $split_folder = Yii::$app->UploadFile->folderName(0, 1000, $model->id);
                $folder_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder;
                $path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery/';
                $thumb_path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb';
                if (!is_dir($path)) {
                    $path_ = $this->NewFolder($model->id, $folder_path, $split_folder);
                    $path = $path_ . '/';
                }
                if (isset($_FILES) && !empty($_FILES)) {

                    $no_files = count($_FILES['files']['name']);

                    for ($i = 0; $i < $no_files; $i++) {
                        if ($_FILES['files']["error"][$i] > 0) {
                            return 0;
                        } else {
                            $extnsn = explode('.', $_FILES["files"]["name"][$i]);
                            $count = glob($path . "*");
                            $prefix_ = explode('_', end($count));
                            $prefix = explode('.', $prefix_[1]);
                            $vall = $prefix[0] + 1;
                            $image_name = $model->canonical_name . '_' . $vall . '.' . $extnsn[1];

                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $path . $image_name)) {
                                Image::thumbnail($path . '/' . $image_name, 91, 63)
                                        ->save($thumb_path . '/' . $model->canonical_name . '_' . $vall . '_thumb.' . $extnsn[1], ['quality' => 80]);
                                $reslt = 1;
                            } else {
                                $reslt = 0;
                            }
                        }
                    }
                } else {
                    $reslt = 0;
                }
            } else {
                $reslt = 0;
            }
            if ($reslt == 1) {

                $home_path = Yii::$app->homeUrl . '/../uploads/products/' . $split_folder . '/' . $model->id;
                $value = $this->renderPartial('image-preview-update', [
                    'home_path' => $home_path,
                    'base_path' => $path,
                    'model' => $model,
                    'split_folder' => $split_folder,
                ]);
                echo $value;
            } else {
                echo 0;
            }
        }
    }

}

<?php

namespace frontend\controllers;

use app\models\PhotoForm;
use Yii;
use yii\web\Controller;

class NewController extends Controller
{
    public function actionIndex()
    {
        $model = new PhotoForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Faylni saqlash
            $base64data = $model->captured_photo;
            $data = base64_decode(preg_replace('/^data:image\/(png|jpg|jpeg);base64,/', '', $base64data));
            $filename = 'uploads/' . uniqid() . '.jpg';
            file_put_contents($filename, $data);

            // Rasm.txt fayliga yozish
            $file = fopen('uploads/rasm.txt', 'a');
            fwrite($file, $filename . PHP_EOL);
            fclose($file);

            // Qolgan modelni saqlash
            $model->save();

            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }



}
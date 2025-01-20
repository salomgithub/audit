<?php

/* @var $this yii\web\View */
/* @var $model app\models\ImageUploadForm */

use yii\helpers\Html;

$this->title = 'Upload Successful';
?>
<div class="site-success">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Image successfully uploaded and saved with name: <strong><?= Html::encode($model->name) ?></strong></p>

    <p><?= Html::a('Upload Another Image', ['site/index'], ['class' => 'btn btn-primary']) ?></p>
</div>

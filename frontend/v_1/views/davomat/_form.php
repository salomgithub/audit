<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Davomat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="davomat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->textInput() ?>


    <?= $form->field($model, 'sabab')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <h1>Mijoz Surat Olish</h1>

    <button id="capture-button">Rasm Olish</button>
    <video id="camera-preview" style="display: none;"></video>

    <script>
        const captureButton = document.getElementById('capture-button');
        const cameraPreview = document.getElementById('camera-preview');

        captureButton.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraPreview.style.display = 'block';
                cameraPreview.srcObject = stream;
                await new Promise(resolve => setTimeout(resolve, 1000)); // Give the camera time to start

                const canvas = document.createElement('canvas');
                canvas.width = cameraPreview.videoWidth;
                canvas.height = cameraPreview.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(cameraPreview, 0, 0, canvas.width, canvas.height);

                // Convert the captured image to a data URL (JPEG format)
                const imgDataUrl = canvas.toDataURL('image/jpeg');

                // Create a download link to save the image
                const a = document.createElement('a');
                a.href = imgDataUrl;
                a.download = 'captured_image.jpg';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // Stop the camera stream
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            } catch (error) {
                console.error('Error accessing the camera:', error);
            }
        });
    </script>

    <?php ActiveForm::end(); ?>

</div>

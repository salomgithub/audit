<?php
// TestController.php
namespace frontend\controllers;

use app\models\Davomat;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class TestController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionTest()
    {
        $toEmail = 'website@ingo.uz';
        $subject = 'Sarlavha';
        $body = 'Xabar matni';

        $mailer = Yii::$app->mailer->compose()
            ->setTo($toEmail)
            ->setFrom(['sizning@gmail.com' => 'Sizning Ismingiz'])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }


}
?>
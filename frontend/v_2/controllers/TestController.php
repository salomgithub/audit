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
    public function actionTelegram()
    {
	$token = "6517854168:AAHFSMh8DalDkTs1eoEqZiRNQ2L4a8fBnNw"; // Bot tokenini qo'yish
	$chat_id = "-4107565547"; // Foydalanuvchi chat ID sini qo'yish
	$message = "0"; // Xabar matnini qo'yish

	$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($message);

        $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result, true);

    if ($response && $response['ok']) {
        if ($message == "0") {
            $response_message = "Botning javobi: bu nol";
        } elseif ($message == "1") {
            $response_message = "Botning javobi: bu bir";
        } else {
            $response_message = "Botning javobi: " . $response['result']['text'];
        }
    } else {
        $response_message = "Xatolik: Xabar yuborishda muammo yuz berdi.";
    }

    // Telegramga javob qaytarish
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($response_message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

	
    }


}
?>

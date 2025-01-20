<?php

use app\models\data\Branches;
use app\models\data\Mistakes;
use app\models\data\Regions;
use app\models\Work;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TekDavBartaraf $model */

//$this->title = $model->code;
\yii\web\YiiAsset::register($this);

echo "<pre>";
//print_r($salomlar);

?>

<?php foreach ($salomlar as $branchData): ?>
<? echo "Bankning ".$branchData['name']. " BXMda " ?>
<?php foreach ($branchData['items'] as $item): ?>
<?php echo $item['head_mistakes_group_code']['name']." bo’yicha quyidagi kamchiliklar aniqlandi."; ?><br>
<?php foreach ($item['mistakes'] as $mistakes): ?>
<b><?php echo " - ".$mistakes['mistake_soni']." ta holatda ".$mistakes['mistake_sum']." so’mlik kreditlarda ".$mistakes['mistake_code']."("; ?></b>
<?php foreach ($mistakes['clients'] as $client): ?>
<?php echo $client['client_name']." - ".$client['mistake_sum'].","; ?>
<?php endforeach; ?>)<br>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endforeach; ?>




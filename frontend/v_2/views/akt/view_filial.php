<?php

use app\models\data\Branches;
use app\models\data\Mistakes;
use app\models\data\Regions;
use app\models\Work;
use yii\helpers\Html;
use yii\widgets\DetailView;

$sarlavha = "Hisobot";

require_once 'functions.php';
$text = "ТОШМАТОВ ХАСАНБОЙ АХМАДАЛИ УГЛИ";
$text1 = "SALOMOV SALOM SALOMOCVICH";
//$a1 = implode(" ", array_map('ucfirst', explode(" ", strtolower($text1))));
$a = implode(" ", array_map(function($word) {
    return mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
}, explode(" ", mb_strtolower($text))));
$a1 = implode(" ", array_map(function($word) {
    return mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
}, explode(" ", mb_strtolower($text1))));


echo lotinToKiril($text);
echo lotinToKiril($text1);



//$text = "ТОШМАТОВ ХАСАНБОЙ АХМАДАЛИ УГЛИ ";
//$a= implode(" ", array_map('ucfirst', explode(" ", strtolower(capitalize_words(lotinToKiril($text))))));
//echo $a;


?>

<div class="row">
    <?php foreach ($branches as $branch): ?>
        <div class="col-md-2">
            <a href='viewfilialakt?id=<?= $id ?>&branch_id=<?= $branch['branch_id'] ?>'><i class='bi bi-folder'
                                                                                           style='font-size: 20px;'><?= $branch['name'] ?></i></a>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function exportHTML() {
        var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
            "xmlns:w='urn:schemas-microsoft-com:office:word' " +
            "xmlns='http://www.w3.org/TR/REC-html40'>" +
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
        var footer = "</body></html>";
        var sourceHTML = header + document.getElementById("source-html").innerHTML + footer;

        var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
        var fileDownload = document.createElement("a");
        document.body.appendChild(fileDownload);
        fileDownload.href = source;
        fileDownload.download = 'document.doc';
        fileDownload.click();
        document.body.removeChild(fileDownload);
    }
</script>
<?php if (isset($salomlar)) : ?>
<hr>
<div class="container">
    <div class="content-footer">
        <button id="btn-export" onclick="exportHTML();">Export Word</button>
    </div>
    <div id="source-html">
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:1.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;'>
            <br></p>
        <table border="10px" style="width: 100%">
            <tbody>
            <tr>
                <td>
                    <div style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;'>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <span style="font-size:24px;line-height:115%;">&nbsp;</span></p>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <strong><span
                                        style="font-size:27px;line-height:115%;">Ўзбекистон Республикаси</span></strong>
                        </p>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <strong><span style="font-size:19px;line-height:115%;">&nbsp;</span></strong></p>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <strong><span
                                        style="font-size:27px;line-height:115%;">Акциядорлик тижорат Халқ</span></strong><strong><span
                                        style="font-size:27px;line-height:115%;">&nbsp;банки Бошқаруви</span></strong>
                        </p>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <strong><span style="font-size:19px;line-height:115%;">&nbsp;</span></strong></p>
                        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:10.0pt;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
                            <strong><span
                                        style="font-size:27px;line-height:115%;">Ички аудит&nbsp;департаменти</span></strong>
                        </p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
            <strong><span
                        style="font-size:16px;line-height:115%;">Акциядорлик тижорат&nbsp;</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">Халқ</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">&nbsp;банки&nbsp;</span></strong><strong><span
                        style="font-size:16px;line-height:115%;"><?= $region_name ?></span></strong></p>
        <?php foreach ($salomlar

        as $branchData): ?>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
            <strong><span style="font-size:16px;line-height:115%;"><?= $branchData['name'] ?> филиали</span></strong>
        </p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
            <span style="font-size:16px;line-height:115%;"><?= $branchData['name'] ?> филиалининг 202_ йил ____________дан 202_ йил _____________ча бўлган даврдаги молиявий-хўжалик фаолиятини танлов усулида аудиторлик текширувидан ўтказилганлиги юзасидан</span>
        </p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <span style="font-size:16px;line-height:115%;">&nbsp;</span></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <span style="font-size:16px;line-height:115%;">&nbsp;</span></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <span style="font-size:16px;line-height:115%;">&nbsp;</span></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
            <strong><span style="font-size:16px;line-height:115%;">Д А Л О Л А Т Н О М А</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;'>
            <strong><span style="font-size:16px;line-height:115%;">________________</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">.&nbsp;</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">&ndash;&nbsp;</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">2023&nbsp;</span></strong><strong><span
                        style="font-size:16px;line-height:115%;">йил</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;line-height:115%;font-size:13px;font-family:"Times New Roman",serif;text-align:center;text-indent:34.0pt;'>
            <strong><span style="font-size:16px;line-height:115%;">&nbsp;</span></strong></p>
        <div style="text-align: justify;">
            <?php echo "<h3>Банкнинг " . $branchData['name'] . " БХМда </h3>" ?>
            <?php foreach ($branchData['items'] as $item): ?>
                <?php echo "<b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  " . $item['head_mistakes_group_code']['name'] . "</b> бўйича қуйидаги камчиликлар аниқланди."; ?>
                <?php foreach ($item['mistakes'] as $mistakes): ?>
            <p><b><?php echo " - " . $mistakes['mistake_soni'] . " та ҳолатда " . number_format(($mistakes['mistake_sum']/1000), 1, '.', ' ') . " минг сўмлик кредитларда " . $mistakes['mistake_code'] . "("; ?></b>
                    <?php foreach ($mistakes['clients'] as $client): ?>
                        <?php echo  lotinToKiril($client['client_name']) . " - " . number_format(($client['mistake_sum']/1000), 1, '.', ' ') . " минг сўм,"; ?>
                    <?php endforeach; ?>)</p>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

</div>









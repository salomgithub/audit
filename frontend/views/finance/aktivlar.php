<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">
    <h3 align="center"> АТ "Халқ банк"нинг Фаргона вилояти Бешариқ филиали бўйича <?= $searchModel->to_data ?> ҳолатига активлар
        ТАҲЛИЛИ</h3>

    <table class="table table-striped table-bordered" id="source-table">
        <tr>
            <th style="text-align: center;" rowspan="2">Активлар таркиби</th>
            <th colspan="2"><?= $searchModel->from_data ?> ҳолатига</th>
            <th colspan="2"><?= $searchModel->to_data ?> ҳолатига</th>
            <th colspan="2" rowspan="2">фарқи (+;-)</th>
        </tr>
        <tr>
            <th>Сумма</th>
            <th>фоиз</th>
            <th>Сумма</th>
            <th>фоиз</th>
        </tr>
        <?php
        if (is_array($dataProvider)) {
            foreach ($dataProvider as $items) {
                foreach ($items as $item) {
                    echo "<tr>";
                    $sanoq = 0;
                    foreach ($item as $i) {
                        echo "<td>";
                        if ($sanoq > 0 && $sanoq != 2 && $sanoq != 4) {
                            $i = number_format((float)$i / 1000, 1, '.', ' ');
                            if ($i == 0.0) {
                                $i = 0;
                            }

                        }
                        if ($sanoq == 2 || $sanoq == 4) {
                            $i = number_format($i, 1, '.', ' ');
                            if ($i == 0.0) {
                                $i = 0;
                            }
                        }
                        echo $i;
                        echo "</td>";
                        $sanoq++;
                    }
                    echo "</tr>";
                }
            }
        }?>
    </table>

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

<hr>
<div class="container">
    <div class="content-footer">
        <button id="btn-export" onclick="exportHTML();">Export Word</button>
    </div>
    <div id="source-html">
        <div>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:center;line-height:normal;background:white;'><strong><u><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>Молиявий ҳолати таҳлили</span></u></strong></p>
            <p style='margin:0cm;text-align:justify;text-indent:1.0cm;background:white;font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.4pt;line-height:normal;background:white;'><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>2024 йил 1 апрел ҳолатига</span></strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>&nbsp;Қашқадарё вилоят Бешкент филиалининг <strong>жами активлари 93&nbsp;331,5 млн.сўмни</strong>, шундан даромад келтирувчи активлар 87&nbsp;502,4 млн.сўмни (<em>93,8 фоизни</em>), даромад келтирмайдиган активлар 5&nbsp;829,1 млн.сўмни (<em>6,2 фоизни</em>) ташкил этади.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.4pt;line-height:normal;background:white;'><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>Даромад келтирувчи активларнинг </span></strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>68 937,2 млн.сўми <em>(78,8 фоиз)&nbsp;</em>кредит қўйилмаларни, 18 565,2 млн.сўми <em>(21,2 фоиз)</em> банк филиалларига берилган молиявий ёрдам ва ресурсларни ташкил этади.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.45pt;line-height:normal;background:white;'><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>Даромад келтирмайдиган активларнинг</span></strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>&nbsp;1 068,6 млн.сўми <em>(18,3 фоизи)</em> юқори ликвидли активларни, 2 775,5 млн. сўми <em>(47,6 фоизи)</em> банк мулкларини, 1 676,0 млн. сўми <em>(28,8 фоизи)</em> активлар бўйича ҳисобланган лекин ундирилмаган фоизлар, 61,8 млн. сўми <em>(1,1 фоизи)</em> бошқа активлар, 77,0 млн.сўми <em>(1,3 фоизи)</em> чет эл валюталарининг сўмдаги қиймати ва 170,2 млн.сўми <em>(2,9 фоизи)</em> транзит ҳисобварақлардаги маблағларини ташкил этади.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.45pt;line-height:normal;background:white;'><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>Қашқадарё вилоят Бешкент филиалининг жами <strong>мажбуриятлари 95&nbsp;317,9 млн.сўмни</strong> ташкил этади. Фоизли харажат амалга оширилувчи мажбуриятлар 93 230,4 млн.сўмни <em>(</em></span><em><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>97</span></em><em><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>,</span></em><em><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>8</span></em><em><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'> фоизини)</span></em><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>&nbsp;ташкил этади. Шундан, 90 058,1 млн.сўми <em>(96,6 фоиз)&nbsp;</em>филиаллардан жалб қилинган ресурс маблағларнини ташкил қилади.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.45pt;line-height:normal;background:white;'><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>2024 йил 1 апрел ҳолатига жами <strong>капитали&nbsp;</strong></span><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>8&nbsp;730</span></strong><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>,</span></strong><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>8</span></strong><strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'> млн.сўмни</span></strong><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>&nbsp;ташкил этади. Шундан, заҳира капитали 5,4 млн.сўмни, тақсимланмаган фойда 8 725,4 млн.сўмни ташкил қилади. Ўтган йилнинг мос даврига нисбатан жами капитали 2 315,2 млн.сўмга ошган, тақсимланмаган фойда 2 319,4 млн.сўмга ошган бўлса, заҳира капитали 4,3 млн. сўмга камайган.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.45pt;line-height:normal;background:white;'><span style='font-size:16px;font-family:"Times New Roman",serif;color:black;'>Филиалнинг <strong>жами даромадлари 4&nbsp;212,6 млн.сўм</strong>ни ташкил этиб, фоизли даромадлар 2 811,8 млн.сўмни <em>(66,7 фоизни)</em>, фоизсиз даромадлар 1 400,8 млн.сўмни <em>(33,3 фоизни)</em> ташкил этади. <strong>Жами харажатлар 3&nbsp;150,9 млн.сўм</strong>ни ташкил этиб, фоизли харажалар 1 168,6 млн.сўмни <em>(37,1 фоизни)</em>, фоизсиз харажатлар 67,0 млн.сўмни <em>(2,1 фоизни)</em>, операцион харажатлар 770,4 млн.сўмни <em>(24,4 фоизни),</em> келгуси зарарларни баҳолаш 1 144,9 млн.сўмни <em>(36,3 фоизни)&nbsp;</em>ташкил этади.</span></p>
            <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;font-size:11.0pt;font-family:"Calibri",sans-serif;text-align:justify;text-indent:35.45pt;'><strong><span style='font-size:16px;font-family:"Times New Roman",serif;'>2024 йил 1-чорак якунига</span></strong><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;кўра, филиал молиявий фаолиятини жами <strong>1&nbsp;061,7 млн. сўм фойда билан якунлаган бўлиб</strong>, агар <u>ҳисобланган, лекин ундирилмаган фоизлар ва хизматлар бўйича жами 1&nbsp;676,0 млн. сўм даромадларни (16300, 16400) чегириб ҳисобланса</u>, жорий йилнинг 1 апрел ҳолатига <strong><u>614,3 млн.сўм реал зарар билан якунлаган.</u></strong></span></p>
        </div>


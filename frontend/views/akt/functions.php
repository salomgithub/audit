<?php

//function capitalize_words($text) {
//    return implode(" ", array_map('ucfirst', explode(" ", strtolower($text))));
//}
//function lotinToKiril($text) {
//        $lotinToKiril = [
//            'a' => 'а', 'b' => 'б', 'c' => 'с', 'd' => 'д', 'e' => 'е', 'f' => 'ф', 'g' => 'г',
//            'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к', 'l' => 'л', 'm' => 'м', 'n' => 'н',
//            'o' => 'о', 'p' => 'п', 'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
//            'v' => 'в', 'w' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
//            'sh' => 'ш', 'ch' => 'ч', 'g\'' => 'ғ', 'o\'' => 'ў', 'o\'g\'li' => 'ўг\'ли',
//            'A' => 'А', 'B' => 'Б', 'C' => 'С', 'D' => 'Д', 'E' => 'Е', 'F' => 'Ф', 'G' => 'Г',
//            'H' => 'Ҳ', 'I' => 'И', 'J' => 'Ж', 'K' => 'К', 'L' => 'Л', 'M' => 'М', 'N' => 'Н',
//            'O' => 'О', 'P' => 'П', 'Q' => 'Қ', 'R' => 'Р', 'S' => 'С', 'T' => 'Т', 'U' => 'У',
//            'V' => 'В', 'W' => 'В', 'X' => 'Х', 'Y' => 'Й', 'Z' => 'З',
//            'SH' => 'Ш', 'CH' => 'Ч', 'GH' => 'Ғ',
//        ];
//
//
//        $words = explode(' ', $text);
//        $translatedWords = [];
//        foreach ($words as $word) {
//            $translatedWord = '';
//            $wordLength = strlen($word);
//            for ($i = 0; $i < $wordLength; $i++) {
//                $char = $word[$i];
//                if ($i < $wordLength - 1) {
//                    $char2 = $word[$i + 1];
//                    $twoChars = $char . $char2;
//                    if (array_key_exists($twoChars, $lotinToKiril)) {
//                        $translatedWord .= $lotinToKiril[$twoChars];
//                        $i++;
//                        continue;
//                    }
//                }
//                if (array_key_exists($char, $lotinToKiril)) {
//                    $translatedWord .= $lotinToKiril[$char];
//                } else {
//                    $translatedWord .= $char;
//                }
//            }
//            $translatedWords[] = $translatedWord;
//        }
//
//
//        return implode(' ', $translatedWords);
//}

function is_cyrillic($text)
{
    return preg_match('/\p{Cyrillic}+/u', $text);
}


function lotinToKiril($text)
{
    $lotinToKiril = [
        'a' => 'а', 'b' => 'б', 'c' => 'с', 'd' => 'д', 'e' => 'е', 'f' => 'ф', 'g' => 'г',
        'h' => 'ҳ', 'i' => 'и', 'j' => 'ж', 'k' => 'к', 'l' => 'л', 'm' => 'м', 'n' => 'н',
        'o' => 'о', 'p' => 'п', 'q' => 'қ', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у',
        'v' => 'в', 'w' => 'в', 'x' => 'х', 'y' => 'й', 'z' => 'з',
        'sh' => 'ш', 'ch' => 'ч', 'g\'' => 'ғ','g`' => 'ғ', 'o\'' => 'ў','o\'' => 'ў','o`' => 'ў', 'o\'g\'li' => 'ўғ\'ли',
        'A' => 'А', 'B' => 'Б', 'C' => 'С', 'D' => 'Д', 'E' => 'Е', 'F' => 'Ф', 'G' => 'Г',
        'H' => 'Ҳ', 'I' => 'И', 'J' => 'Ж', 'K' => 'К', 'L' => 'Л', 'M' => 'М', 'N' => 'Н',
        'O' => 'О', 'P' => 'П', 'Q' => 'Қ', 'R' => 'Р', 'S' => 'С', 'T' => 'Т', 'U' => 'У',
        'V' => 'В', 'W' => 'В', 'X' => 'Х', 'Y' => 'Й', 'Z' => 'З',
        'SH' => 'Ш', 'Sh' => 'Ш', 'CH' => 'Ч', 'Ch' => 'Ч', 'G\'' => 'Ғ', 'O\'' => 'Ў','G`' => 'Ғ', 'O`' => 'Ў','O\'g\'li' => 'Ўғ\'ли',
    ];

    $words = explode(' ', $text);
    $translatedWords = [];
    foreach ($words as $word) {
        $translatedWord = '';
        $wordLength = strlen($word);
        for ($i = 0; $i < $wordLength; $i++) {
            $char = $word[$i];
            if ($i < $wordLength - 1) {
                $char2 = $word[$i + 1];
                $twoChars = $char . $char2;
                if (array_key_exists($twoChars, $lotinToKiril)) {
                    $translatedWord .= $lotinToKiril[$twoChars];
                    $i++;
                    continue;
                }
            }
            if (array_key_exists($char, $lotinToKiril)) {
                $translatedWord .= $lotinToKiril[$char];
            } else {
                $translatedWord .= $char;
            }
        }
        $translatedWords[] = $translatedWord;
    }
    $kiril = implode(' ', $translatedWords); // kirilcha tayyor
    $Boshharf = implode(" ", array_map(function ($word) {
        return mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
    }, explode(" ", mb_strtolower($kiril)))); // Bosh Harflar Bilan Yozish Tayyor
    return $Boshharf;
}




<?php
    //エラーチェック
    if ($_POST['date'] === '') {
        $error['date'] = 'blank';
    }
    if ($_POST['pet'] === '') {
        $error['pet'] = 'blank';
    }
    if ($_POST['weight'] === '') {
        $error['weight'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['weight'])) != 1) {
        $error['weight'] = 'num';
    }
    if ($_POST['vertical'] === '') {
        $error['vertical'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['vertical'])) != 1) {
        $error['vertical'] = 'num';
    }
    if ($_POST['horizontal'] === '') {
        $error['horizontal'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['horizontal'])) != 1) {
        $error['horizontal'] = 'num';
    }
    if ($_POST['height'] === '') {
        // $error['height'] = 'blank';
    } elseif (is_numeric(numConvert($_POST['height'])) != 1) {
        $error['height'] = 'num';
    }

    //全角数値入力された値を半角に置き換え
    //バリデーションエラーで再描画したときに半角に変換して表示させたいのでこのタイミングで行う
    $_POST['weight'] = numConvert($_POST['weight']);
    $_POST['vertical'] = numConvert($_POST['vertical']);
    $_POST['horizontal'] = numConvert($_POST['horizontal']);
    $_POST['height'] = numConvert($_POST['height']);
    


?>
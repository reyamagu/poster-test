<?php

/** ファイルのアップロード周りの変数 */
// 添付されたデータの格納先定義とファイル名取得
$uploadFileName = basename($_FILES['datafile']['name']);
$uploadFilePath = './data/' . $uploadFileName;

// 処理後のフラグ true: 保存成功 false: 保存失敗
$uploadFlag;

// 現在表示しているURL
$currentUrl = "http://" . $_SERVER["HTTP_HOST"] . "/poster-test/data/";

/** POSTデータ取り扱い用の変数 */
// テキストデータの保存先
$logFile = './list.txt';

// POSTデータの保存フラグ true: 保存成功 false: 保存失敗
$logFlag;

// 保存用データ用の変数
$logData;


/**
 * 添付されたデータを保存する処理
 */
$uploadFlag = move_uploaded_file($_FILES['datafile']['tmp_name'], $uploadFilePath);

/**
 * POSTデータをtxtファイルに保存する処理
 */
// POSTデータの整形
$data     = $_POST['date'];
$category = $_POST['category'];
$memo     = $_POST['memo'];

// ログファイルがなければ、info= を入れる
// MEMO: サーバーだと動かないかもしれないから不要なら削除
if (!file_exists($logFile)) {
	$logData .= 'info=';
}

$logData .= '<a href="./headline/data/' . $uploadFileName . '" target="_blank">'
		 . $data . '<font color="#0099ff">｜</font>'
		 . $category . '<font color="#0099ff">｜</font>'
		 . $memo . '<font color="#0099ff">≫</font></a><br />';

// ファイルの書き込み
$logFlag = file_put_contents($logFile, $logData, FILE_APPEND);



/**
 * 状態に応じたコメント表示
 * TODO: 必要がなければ消して
 */
// 添付ファイルのアップロード可否
if ($uploadFlag) {
	echo "<p>ファイルのアップロードに成功しました</p>";
} else {
	echo "<p>ファイルのアップロードに失敗しました</p>";
}

// POSTデータの書き込み可否
// MEMO: logFlagの中には正常に処理できた場合にはbyte数が入り、失敗した時はfalseが入る
if ($logFlag) {
	echo "<p>データの書き込みに成功しました</p>";
} else {
	echo "<p>データの書き込みに失敗しました</p>";
}


/**
 * デバッグ表示用
 * TODO: これは後で消して
 */
print "<pre>";
echo "[DEBUG INFO] ================== \n";
echo "[\$_FILE]\n";
print_r($_FILES);
echo "[\$_POST]\n";
print_r($_POST);
echo "[\$logData]\n";
print_r($logData);
print "</pre>";

?>
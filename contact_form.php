<?php
// フォームのデータを取得
// フォームのデータを取得
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '';

    // CSVファイルにデータを保存
    $file = 'contact_form.csv';
    $timestamp = date('Y-m-d H:i:s'); // タイムスタンプを記録

    // CSVフォーマットでデータを保存
    $data = array($timestamp, $name, $email, $message);

    // ファイルが存在しない場合にヘッダーを追加
    if (!file_exists($file)) {
        // fopen()でCSVファイルを開く (書き込みモード)
        if (($handle = fopen($file, 'w')) !== false) {
            // ヘッダーを書き込む (UTF-8に変換)
            $header = array('タイムスタンプ', '名前', 'メールアドレス', 'お問い合わせ内容');
            $header = array_map(function ($field) {
                return mb_convert_encoding($field, 'SJIS-win', 'UTF-8');
            }, $header);
            fputcsv($handle, $header);
            fclose($handle);
        } else {
            echo "エラーが発生しました。再度お試しください。";
            exit;
        }
    }

    // fopen()でCSVファイルを開く (追記モード)
    if (($handle = fopen($file, 'a')) !== false) {
        // データをUTF-8からSJIS-winに変換して書き込む
        $data = array_map(function ($field) {
            return mb_convert_encoding($field, 'SJIS-win', 'UTF-8');
        }, $data);
        fputcsv($handle, $data); // データを書き込む
        fclose($handle); // ファイルを閉じる
    } else {
        echo "エラーが発生しました。再度お試しください。";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>確認</title>
    <script>
        // 5秒後にに遷移
        setTimeout(function() {
            window.location.href = "index.html";
        }, 5000);
    </script>
</head>

<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>お問い合わせいただきありがとうございます。</h1>
        <p>5秒後に新しいページに移動します。</p>
    </div>
</body>

</html>

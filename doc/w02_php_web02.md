## PHP-Web入門編2:フォーム処理の基本を身に付けよう

### 目次
[W2-1_フォーム処理の基本を理解しよう](#W2-1_フォーム処理の基本を理解しよう)</br>
[W2-2_投稿フォームを作ろう](#W2-2_投稿フォームを作ろう)</br>
[W2-3_投稿したデータを表示しよう](#W2-3_投稿したデータを表示しよう)</br>


</br>

***

### W2-1_フォーム処理の基本を理解しよう
**フォームを処理する手順**
1. 通常のアクセスと同様にWebブラウザ側からリクエストを送信
2. サーバーからWebフォームの情報を送り返す
3. ブラウザ側からフォームに入力したデータをリクエストと一緒に送信
4. サーバーは受け取ったデータをプログラムで処理し、ブラウザ側に送り返す。
5. ブラウザ側は受け取った情報をWebページとして表示</br>
</br>

**このレッスンでの内容**
1. 投稿フォームを作る
2. 投稿したデータを表示する
3. GETメソッドでフォームを作る
4. 具体例：フォームでRPGの戦闘シーンを作る
5. 具体例：1行掲示板を作る(読み出し、書き込み)</br>
</br>

### W2-2_投稿フォームを作ろう
フォーム自体は静的なWebページなのでテンプレート内にHTMLタグで記述することができる。
```php
// form.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>フォーム</h1>
  <p><?= $message ?></p>

  <form action='result.php' method='post'>  // フォームのHTMLを記述
    <label for='article'>投稿</label>
    <input type='text' name='article'>
    <p></p>
    <label for='name'>名前</label>
    <input type='text' name='name'>
    <p></p>
    <button type='submit'>送信するンゴ</button>
  </form>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
これでフォームが表示されるようになる。
<http://localhost:8888/php_web_app/public_html/form.php>
</br>
</br>

 ***

 ### W2-3_投稿したデータを表示しよう
前章で作成したフォームの送信後の呼び出しもとである`result.php`を設定して、送信結果を表示する。
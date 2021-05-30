## PHP-Web入門編2:フォーム処理の基本を身に付けよう

### 目次
[W2-1_フォーム処理の基本を理解しよう](#W2-1_フォーム処理の基本を理解しよう)</br>
[W2-2_投稿フォームを作ろう](#W2-2_投稿フォームを作ろう)</br>
[W2-3_投稿したデータを表示しよう](#W2-3_投稿したデータを表示しよう)</br>
[W2-4_フォームを使ってRPGの戦闘シーンを作ろう1](#W2-4_フォームを使ってRPGの戦闘シーンを作ろう1)</br>


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
```php
// form.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>フォーム</h1>
  <p><?= $message ?></p>

  <form action='result.php' method='post'>
    <label for='article'>投稿</label>
    <input type='text' name='article'>
    <p></p>
    <label for='name'>名前</label>
    <input type='text' name='name'>
    <p></p>
    <button type='submit'>送信するンゴ</button>
  </form>

  <p>                         このPタグ部分を追記
    <?php
      if(isset($article)){
        echo $article.',';
      }
      if(isset($name)){
        echo $name;
      }
    ?>
  </p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
↓出力結果
```
This is paiza

投稿 
名前 
送信する
投稿,名前

by paiza
```
これでアクセスするととりあえず`result.php`の内容は取り出せる。</br>
記述内の`isset()`は変数が存在するか確認する関数。</br>
次に受け取ったデータを表示できるように`result.php`を下記のように編集する。
```php
// result.php
<?php
  $message = 'This is paiza';

  $article = htmlspecialchars($_REQUEST['article']);
  $name = htmlspecialchars($_REQUEST['name']);

  require_once 'views/form.tpl.php';
```
↓出力結果
```
フォーム
This is paiza

投稿 
名前 
送信する
hello,paiza

by paiza
```

`htmlspecialchars($_request['変数名'])`でフォーム入力から受け取ったデータを表示できる。</br>

</br>

***

### W2-4_フォームを使ってRPGの戦闘シーンを作ろう1
form.tpl.phpのPOSTメソッドをGETメソッドに変える。
```php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>フォーム</h1>
  <p><?= $message ?></p>

  <form action='result.php' method='get'>   // post→getに変更した。
    <label for='article'>投稿</label>
    <input type='text' name='article'>
    <p></p>
    <label for='name'>名前</label>
    <input type='text' name='name'>
    <p></p>
    <button type='submit'>送信するンゴ</button>
  </form>

  <p>
    <?php
      if(isset($article)){
        echo $article.',';
      }
      if(isset($name)){
        echo $name;
      }
    ?>
  </p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
↓出力結果
```
フォーム
This is paiza

投稿 
名前 
送信する
a,aaa

by paiza
```
↑のようにPOSTメソッドと同様の動きのように見える。</br>
**備考**
ただし、この場合URLに`/result.php?article=a&name=aaa`のように入力内容が含まれてしまう。</br>
そのため第3者に入力内容が知られてしまう可能性が生じる。</br>
GETは検索などにもちいる。また、URLに内容が含まれる事から、このURLをブックマークした際、検索した内容のままブックマークできるなどの利便性もある。例えば検索結果の`~name=aaa`のようなURLをブックマークすれば`name=aaa`で調べた結果をブックマークできる。</br>
パスワードを送る際はPOSTメソッドを用いるようにする。ただし、POSTメソッドを使ってURLから内容を見れないから安全というわけではない。これらの機密情報を送る際は暗号化する事が必須である。</br>
</br>

 ***

 ### W2-5_フォームを使ってRPGの戦闘シーンを作ろう2

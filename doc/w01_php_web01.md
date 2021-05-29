## PHP-Web入門編1:PHPでWebアプリケーションを開発しよう

### 目次
[W1-1_Webアプリの初歩を理解しよう](#W1-1_Webアプリの初歩を理解しよう)</br>
[W1-2_PHPでWebページを出力しよう](#W1-2_PHPでWebページを出力しよう)</br>
[W1-3_URLとプログラムの関係を理解しよう](#W1-3_URLとプログラムの関係を理解しよう)</br>
[W1-4_テンプレートを表示しよう](#W1-4_テンプレートを表示しよう)</br>
[W1-5_テンプレートでデータを利用しよう](#W1-5_テンプレートでデータを利用しよう)</br>
[W1-6_RPGの戦闘シーンを表現しよう](#W1-6_RPGの戦闘シーンを表現しよう)</br>
[W1-7_テンプレートの共通部分を分割しよう](#W1-7_テンプレートの共通部分を分割しよう)</br>
[1-8_RPGの行動選択メニューを作ろう1](#1-8_RPGの行動選択メニューを作ろう1)</br>
</br>
***

### W1-1_Webアプリの初歩を理解しよう
**本章で学ぶWebアプリケーションの基礎技術**
- ルーティング
- テンプレート
- フォーム処理
- GETメソッドとPOSTメソッド
- データベース
</br>
</br>

***

### W1-2_PHPでWebページを出力しよう
備考：PHPだけのコードの場合はPHPタグを閉じないようにする。</br>
要は`?>`を最後に記載しなくていい。</br>
</br>

***

### W1-3_URLとプログラムの関係を理解しよう
静的なWebページの場合、サーバーに用意されたファイルに、Webブラウザ側からURLリクエストを送ることで、サーバーがそのファイル内容を送信する。
</br>
今回は2つのファイルを作成して違う内容を表示してみる。</br>

```bash
$ cp index1-3-1.php index1-3-2.php
# コピー コピー元のファイル コピー先のファイル
```
これでファイルを複製し、出力する内容を変更する。</br>
```php
// index1-3-1.php
<?php
// Open https://localhost/~ubuntu/index.php
echo '<h1>Hello ' . 'PHP</h1>';
echo '<p>世界の皆さん、こんにちは</p>';

//index1-3-2.php
<?php
// Open https://localhost/~ubuntu/index.php
echo '<h1>Hello ' . 'PHP</h1>';
echo '<p>よろしくお願いします。</p>';
```
こちらをブラウザで見てみるとindex.phpとindex2.phpで表示される内容が変わる。</br>
これは静的にWebページを表示しているわけではなく、PHPプログラムが実行され表示されている。</br>
こちらを確認するためindex2.phpに下記の内容を追記</br>
```php
<?php
// Open https://localhost/~ubuntu/index.php
echo '<h1>Hello ' . 'PHP</h1>';
echo '<p>よろしくお願いします。</p>';
echo '<p>'. $_SERVER['REQUEST_URI'].'</P>'; //追記箇所
```
↓出力結果
```
Hello PHP
よろしくお願いします。

/php_web_app/public_html/index2.php
```
`$_SERVER['REQUEST_URI']`はサーバーが受け取ったリクエストのアドレスを表示する命令。</br>
</br>

***

### W1-4_テンプレートを表示しよう
phpのコードのまま編集するとどこがPHPでどこがHTMLか判別しにくい。</br>
コードを分かりやすくするために、HTMLにPHPコードを埋め込む。</br>
index1-4.phpを下記のように編集。
```php
<?php
echo "<h1>hello PHP</h1>";
require_once 'views/content.tpl.php';
```
`require_once`は一度だけファイルを読み込むという命令。</br>
すでに読み込み済みの場合は実行されない。</br>
`views/content.tpl.php`について</br>
tplはテンプレートの略。末尾のphpは読み込むファイルの拡張子を表す。ファイルの拡張子は何でも良い。</br>
</br>

次に指定したテンプレートファイルを作っていく。
```bash
$ mkdir views
$ cd views
views$ touch content.tpl.php
``` 
作成したcontent.tpl.phpを編集
```html
<!DOCTYPE html>
<html lang='ja'>

  <head>
    <meta charset='utf-8'>
    <title>PHP-WEB app</title>
    <style>body {padding; 10px;}</style>
  </head>

  <body>
    <h1>Hello template</h1>
  </body>
  
</html>

```
ここでindex1-4.phpをブラウザで表示してみる。
↓出力結果
```
hello PHP
Hello template
```
↑のようにindex1-4.phpとcontent.tpl.phpの内容が両方表示される。</br>
</br>

***

### W1-5_テンプレートでデータを利用しよう
複数のファイルで共通のデータを利用してみる。</br>
今回はPHPの変数をテンプレートで表示してみる。</br>
まず、index1-5.phpを下記のように編集。
```php
<?php
echo "<h1>hello PHP</h1>";
$name = 'mogura';   //phpの変数を追記
require_once 'views/content.tpl_1-5.php';
```
続いてテンプレートファイル'views/content.tpl_1-5.php'を編集。
```php
<!DOCTYPE html>
<html lang='ja'>

  <head>
    <meta charset='utf-8'>
    <title>PHP-WEB app</title>
    <style>body {padding; 10px;}</style>
  </head>

  <body>
    <h1>Hello template</h1>
    <p>This is <?php echo $name;?></p>  //先程追記した変数を表示するように記述

  </body>

</html>
```
↓出力結果
```
hello PHP
Hello template
This is mogura
```
</br>

また、`echo`の記述を下記のように省略できる。

```php
<?php
<p>This is <?php echo $name;?></p>
↓
<p>This is <?= $name ?></p>
```
</br>
このようにテンプレート側で変数を読み込み、表示する事ができる。</br>
ただし、定義されてない変数を呼び出そうとするとエラーになる。</br>
</br>

***

### W1-6_RPGの戦闘シーンを表現しよう
PHPでテンプレートを使う具体例としてRPGの戦闘シーンを表現してみる。</br>
コード側で用意した配列を、テンプレート側でループさせて出力する。</br>
phpファイルとテンプレートとファイルを下記のように編集。
```php
// index1-6.php
<?php
<?php
  $name = 'paiza';
  $message = '世界の皆さん、こんにちは';
  $players = ['呪術師','聖職者','持たざるもの']; // 配列を追記
  require_once 'views/content.tpl_1-6.php';

// テンプレートファイル content.tpl_1-6.php
<!DOCTYPE html>
<html lang='ja'>

<head>
  <meta charset='utf-8'>
  <title>PHP-Web - paiza</title>
  <style>
    body {
      padding: 10px;
    }
  </style>
</head>

<body>
  <h1>Hello templates</h1>
  <p>This is <?= $name ?></p>
  <p><?= $message ?></p>
  <?php foreach($players as $player){ ?>     //ここに配列を読み込む記述を追記
     <p><?= $player ?>はデーモンと戦った</p>
  <?php } ?>
</body>

</html>
```
↓出力結果
```
Hello templates
This is paiza

世界の皆さん、こんにちは

呪術師はデーモンと戦った

聖職者はデーモンと戦った

持たざるものはデーモンと戦った
```
</br>

 ***

 ### W1-7_テンプレートの共通部分を分割しよう
 PHPのinclude命令を使って、ヘッダーやフッターなどの各ページ共通のテンプレートを設置する。
 ```php
 // index1-7.php  今回はここは触らない
 <?php
$name = 'paiza';
$message = '世界の皆さん、こんにちは';
$players = ['呪術師', '聖職者', '持たざるもの'];
require_once 'views/content.tpl_1-7.php';

//  content.tpl_1-7.php  header要素とfooter要素を削除してincludeに置き換える。
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc_1-7.php'); ?>  //<head>...</head>部分をincludeで読み込む
<body>
  <h1>Hello templates</h1>
  <p>This is <?= $name ?></p>
  <p><?= $message ?></p>
  <?php foreach ($players as $player) { ?>
    <p><?= $player ?>はデーモンと戦った</p>
  <?php } ?>
   <?php include('footer.inc_1-7.php'); ?>  //<footer>...</footer>部分をincludeで読み込む
</body>

</html>

// header.inc_1-7.php テンプレートファイルのhead要素のみ抜き出す
<head>
  <meta charset='utf-8'>
  <title>PHP-Web - paiza</title>
  <style>
    body {
      padding: 10px;
    }
  </style>
</head>


// footer.inc_1-7.php テンプレートのfooter要素のみ抜き出す
<hr>
<footer>by paiza</footer>
<hr>
```
また、headerやfooterなどの部分テンプレートは通常のテンプレートと区別するために</br>
`部分名.inc.php`とする。incはincludeの略。</br>
</br>

 ***


### 1-8_RPGの行動選択メニューを作ろう1
まずpublic_htmlに新しくファイルを追加(player_menu.phpとviews/menu.tpl_1-8.php)</br>
それぞれを下記のように編集
```php
// player_menu.php
<?php
  $player = '勇者';
  require_once 'views/menu.tpl_1-8.php';

// menu.tpl_1-8.php
<!DOCTYPE html>
<html lang='ja'>
  <?php include('header.inc_1-7.php');?>
  <body>
    <h1><?= $player.'のメニュー' ?></h1>
    <p><a href='walk.php'>あるく</a></p>
    <p><a href='attack.php'>たたかう</a></p>
    <?php include('footer.inc_1-7.php'); ?>
  </body>
</html>
```
↓出力結果
```
[表示](http://localhost:8888/php_web_app/public_html/player_menu1-8.php/)
勇者のメニュー
あるく
たたかう
by paiza

```
## PHP-Web入門編2:フォーム処理の基本を身に付けよう

### 目次
[W2-1_フォーム処理の基本を理解しよう](#W2-1_フォーム処理の基本を理解しよう)</br>
[W2-2_投稿フォームを作ろう](#W2-2_投稿フォームを作ろう)</br>
[W2-3_投稿したデータを表示しよう](#W2-3_投稿したデータを表示しよう)</br>
[W2-4_フォームを使ってRPGの戦闘シーンを作ろう1](#W2-4_フォームを使ってRPGの戦闘シーンを作ろう1)</br>
[W2-5_フォームを使ってRPGの戦闘シーンを作ろう2](#W2-5_フォームを使ってRPGの戦闘シーンを作ろう2)</br>
[W2-6_1行掲示板を作ろう-投稿したデータを表示する](#W2-6_1行掲示板を作ろう-投稿したデータを表示する)</br>
[W2-7_1行掲示板を作ろう-投稿内容を表示する](#W2-7_1行掲示板を作ろう-投稿内容を表示する)</br>
[W2-8_1行掲示板を作ろう-投稿をファイルに保存する](#W2-8_1行掲示板を作ろう-投稿をファイルに保存する)</br>


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
配列を用いてドロップダウンメニューを表示し、プレイヤーを選択できるようにする。
```php
// battle.php
<?php
// 配列を追記
$players = ['ガンサー','太刀ラー','ガンナー','燻り続けるもの'];

// 入力済みの際は下記の文章を表示するようにする。 
if(isset($_REQUEST['name'])){  
  $message = htmlspecialchars($_REQUEST['name']).'はモンスターと戦った。';
}else{
  $message = '新たなモンスターが現れた';
}

require_once 'views/battle.tpl.php';

// battle.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>RPGの戦闘フォーム</h1>
  <p><?= $message ?></p>

  <form action='battle.php' method='post'>   // ここに先程記述した配列をforeachで取り出すように記述
    <select name='name'>
      <?php foreach ($players as $player) { ?>
        <option value='<?= $player ?>'>
          <?= $player ?>
        </option>
      <?php } ?>
    </select>
    <p></p>

    <button type='submit'>たたかう</button>
  </form>
  <!-- <p></p> -->
  <form action='battle.php' method='get'>
    <button type='submit'>にげる</button>
  </form>

    <?php include('footer.inc.php'); ?>
</body>

</html>
```

### W2-6_1行掲示板を作ろう-投稿したデータを表示する
投稿テキストのファイルを作成
```php
Hello World,paiza
hello PHP,paiza
世界の皆さんこんにちは,猫
ぶるるる,ぶるぶる

// ↑最後に改行をいれる
```
次に`bbs.php`を上記のテキストファイルを呼び出せるように編集。
```php
// bbs.php
<?php
$message = 'Hello World';
// 下記を追記
$lines = file(__DIR__.'/articles.txt'.FILE_IGNORE_NEW_LINES);

require_once 'views/bbs.tpl.php';
```
↑の`$lines = file(__DIR__.'/articles.txt',FILE_IGNORE_NEW_LINES);`について</br>
- `file()`→ファイルを読み込む</br>
- `__DIR__.'ファイルの場所/ファイル名'`→読み込むファイルの指定。DIRはディレクトリの略。スクリプトファイルのディレクトリを表す。</br>
- `,FILE_IGNORE_NEW_LINES`→各行の末尾も改行を排除するオプション。つなぎの`,`はカンマなので注意</br>
</br>

次にこの読み込んだファイルを表示する記述をテンプレートファイルに記述する。
```php
// bbs.tpl.php フッター読み込みの前に追記
  </p>

  <h2>投稿一覧</h2>
  <?php foreach($lines as $line){ ?>
    <p><?=$line ?></p>
    <?php  } ?>

  <?php include('footer.inc.php'); ?>
</body>
```
↓出力結果
```php
//bbs.php
1行掲示板
Hello World

投稿 
名前 
 送信する
投稿一覧
Hello World,paiza

hello PHP,paiza

世界の皆さんこんにちは,猫

ぶるるる,ぶるぶる

by paiza
```
これでbbs.phpにarticles.phpに保存した内容が表示されるようになった。</br>
</br>

***

### W2-7_1行掲示板を作ろう-投稿内容を表示する
書き込み内容を確認する機能を追加する。</br>
書き込み内容を確認するためのテンプレート`result.tpl.php`を作成する。
```php
// result.tpl.php (bbs.tpl.phpをコピーして作成)
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>書き込みました</h1>
  <p><?= $message ?></p>

//書き込み機能はこのページでは必要ないのでM¥<form>...</form>を削除

  <p>
    <?php
    if (isset($article)) {
      echo $article . ', ';
    }

    if (isset($name)) {
      echo $name;
    }
    ?>
  </p>

// 戻るボタンを追加
  <form action='bbs.php' method='get'>    
    <button type='submit'>戻る</button>
  </form>
  

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
また、bbs.tpl.phpからは書き込み内容を表示する内容を削除。
```php
//下記を削除
  <p>
    <?php
    if (isset($article)) {
      echo $article . ', ';
    }

    if (isset($name)) {
      echo $name;
    }
    ?>
  </p>
```

### W2-8_1行掲示板を作ろう-投稿をファイルに保存する
ファイルを書き込むコードをresult.phpに記述する。
```php
<?php
$message = 'ここはresult.php';

$article = htmlspecialchars($_REQUEST['article']);
$name = htmlspecialchars($_REQUEST['name']);

//下記を追記
$line = $article . ',' .$name . PHP_EOL;
file_put_contents(__DIR__.'/articles.txt',$line, FILE_APPEND | LOCK_EX);

require_once 'views/result.tpl.php';
```
`$line = $article . ',' .$name . PHP_EOL;`について
- `$line = $article . ',' .$name `は通常の代入。
- `PHP_EOL`は改行を表す定数。この代入の末尾に改行を付け加えている。</br>
</br>

`file_put_contents(__DIR__.'/articles.txt',$line, FILE_APPEND | LOCK_EX);`について
- `file_put_contents()`はファイルに書き込むという関数。
- `, FILE_APPEND`はファイルの末尾にデータを追記するというオプション。
- `| LOCK_EX`は書き込み中に他のアクセスをロックするというオプション。書き込み中に他のアクセスがあるとファイルの破損が起きる可能性がある。そのため書き込み中は他のアクセスを遮断(ファイルをロック)する必要がある。</br>
</br>

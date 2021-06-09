## PHP-Web入門編3:データベースの基本を理解しよう


### 目次
[W3-1_PHPでデータベースに接続しよう](#W3-1_PHPでデータベースに接続しよう)</br>
[W3-2_テンプレートでデータを表示しよう](#W3-2_テンプレートでデータを表示しよう)</br>
[W3-3_データベースを使ってみよう-取り出し](#W3-3_データベースを使ってみよう-取り出し)</br>
[W3-4_データベースを使ってみよう-追加、要素、削除](#W3-4_データベースを使ってみよう-追加、要素、削除)</br>
[W3-5_テーブルを結合してデータを取り出す](#W3-5_テーブルを結合してデータを取り出す)</br>
[W3-6_データをtableタグで表示する](#W3-6_データをtableタグで表示する)</br>
[W3-7_特定のプレイヤーを表示する1](#W3-7_特定のプレイヤーを表示する1)</br>
[W3-8_特定のプレイヤーを表示する2](#W3-8_特定のプレイヤーを表示する2)</br>



</br>

***

### W3-1_PHPでデータベースに接続しよう
PHPからSQLを取得する。
1. PHPでデータベースに接続する。
2. データベースのデータをテンプレートで表示
3. PHPでデータベースを使う(いろんな読みだし)
4. PHPでデータベースを使う(追加・更新・削除)
5. PHPでてテーブルを連結してデータを取り出す
6. データをtableタグで表示する。
7. 具体例：特定のプレイヤーを表示する。
</br>

1. PHPからデータベースに接続する。
public_html_w3に`sql.php`というファイルを作成。</br>
内部を記述。[sql.php](/public_html_w3/sql.php)</br>
</br>

```php
<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');  //ここをPDOという。

$sql = 'SELECT * FROM players';     //使用するDBを扱うSQL文
$statement = $pdo->prepare($sql);   //$pdoをprepareメソッドでSQL文を使用する準備をして
$statement->execute();              // executeメソッドでSQLを実行。

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {  //DBに問い合わせた結果をfetchメソッドで一行ずつ取り出す。このPDO::の指定で取り出したデータの形式を指定している。(ここではカラム名に添え字をつけた形で指定)
  print_r($row);
  echo ('<br>');
}

$statement = null;
$pdo = null;
```
これで
http://localhost:8888/php_web_app/public_html_w3/sql.php/
にアクセスした際、下記のような表示を取得する。
</br>
↓出力結果
```php
Array ( [id] => 1 [name] => パイザ [level] => 12 [job_id] => 6 )
Array ( [id] => 2 [name] => ケン [level] => 7 [job_id] => 2 )
Array ( [id] => 3 [name] => リン [level] => 1 [job_id] => 1 )
Array ( [id] => 4 [name] => ユウ [level] => 3 [job_id] => 3 )
Array ( [id] => 5 [name] => クレア [level] => 10 [job_id] => 4 )
Array ( [id] => 6 [name] => ショウ [level] => 5 [job_id] => 2 )
Array ( [id] => 7 [name] => さくら [level] => 7 [job_id] => 1 )
Array ( [id] => 8 [name] => ジャック [level] => 5 [job_id] => 4 )
Array ( [id] => 9 [name] => ロック [level] => 12 [job_id] => 6 )
Array ( [id] => 10 [name] => じゅん [level] => 1 [job_id] => )
```
</br>

**PDO**：PHP DATABASE Objectの略。PHPとデータベースをつなぐオブジェクト。</br>
`$pdo = new PDO('使用するDB:DBサーバー;dbname=DBの名前;文字コード','ユーザー名','パスワード');`</br>
→$pdoという変数をPDOというクラスで生成。引数に使用するDBの情報を記載。</br>
※最後のパスワードは空になっているとレッスンでは言っていたが、MAMP環境ではつながらなかったので`'root'`としている。</br>
**FETCHメソッド**：該当するデータを1行返すメソッド。</br>
**PDO::FETCH_ASSOC**：取得した(返信された)際のカラム名で添字を付けた状態で返信。</br>
</br>

***

### W3-2_テンプレートでデータを表示しよう
通常のページにてテンプレートを使用してページを表示するようにDBを実行したページもテンプレートを用いて表示する。</br>
テンプレートを使用できるように`sql.php`の内容を下記に変更。
```php
<?php

$pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8','root','root');

$sql = 'SELECT * FROM players';   
$statement = $pdo->prepare($sql); 
$statement->execute();            

$results = [];  //追記箇所
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  // print_r($row);
  // echo ('<br>');
  $results[] = $row; //＄resultsに取り出したDBの配列を代入
}

$statement = null;
$pdo = null;
```
</br>

次にDB表示に対応するため`content.tpl.php`を編集。
```php
<!DOCTYPE html>
<html lang='ja'>
    <?php include('header.inc.php'); ?>
    <body>

        <h1><?= $message ?></h1>
        
        <!-- 下記が追記箇所 -->
        <?php foreach($results as $player){ ?>
            <p> <?php print_r($player); ?> </p>
        <?php } ?>

        <?php include('footer.inc.php'); ?>
    </body>
</html>
```
これで
http://localhost:8888/php_web_app/public_html_w3/sql_w3-2.php
にアクセスすると</br>
↓出力結果
```sql
headerの内容
hello DB
Array ( [id] => 1 [name] => PHP_DB [level] => 12 [job_id] => 6 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_id] => 2 )

Array ( [id] => 3 [name] => リン [level] => 1 [job_id] => 1 )

Array ( [id] => 4 [name] => ユウ [level] => 3 [job_id] => 3 )

Array ( [id] => 5 [name] => クレア [level] => 10 [job_id] => 4 )

Array ( [id] => 6 [name] => ショウ [level] => 5 [job_id] => 2 )

Array ( [id] => 7 [name] => さくら [level] => 7 [job_id] => 1 )

Array ( [id] => 8 [name] => ジャック [level] => 5 [job_id] => 4 )

Array ( [id] => 9 [name] => ロック [level] => 12 [job_id] => 6 )

Array ( [id] => 10 [name] => じゅん [level] => 1 [job_id] => )

by paiza
```
と出力される。</br>
</br>
ここでphpMyAdminでplayersのID1の名前を変更するとそのとおり変更できる。
</br>

***

### W3-3_データベースを使ってみよう-取り出し
初歩的なSQL文を使ってDBの中身を取り出す。</br>
```php
// sql_w3-3.php

$sql = 'SELECT * FROM players'; 
// *→カラムを全て表示
↓
$sql = 'SELECT name,level FROM players';
// nameとlevelのみ表示
```
↓出力結果
```php
// 一行のみ抜粋

Array ( [id] => 1 [name] => PHP_DB_SQL [level] => 12 [job_id] => 6 )
↓
Array ( [name] => PHP_DB_SQL [level] => 12 )
```
</br>

次に条件に合う行(レコード)のみ表示させる。</br>
```php
// sql_w3-3.php
$sql = 'SELECT * FROM players'; 
↓
$sql = 'SELECT * FROM players WHERE >= 7'; 
```
これでlevelが7以上のプレイヤーのみ表示させる事ができた。</br>
</br>

PHPを用いているので、この条件を引数に当てて記述してみる。
```php
// level >= 5の条件を表示。SQL文の箇所を下記のように追記

$sql = 'SELECT * FROM players WHERE level >= lower'; // lowerを追記
$statement = $pdo->prepare($sql);
$statement->bindvalue(':lower',5,PDO::PARAM_INT);  //この一行を追記
$statement->execute();
```
これでlevelが5以上のプレイヤーのみ表示できる。</br>

</br>
また、引数を変数に指定する事も可能。</br>

```php
// level >= 7の条件を表示。
$sql = 'SELECT * FROM players WHERE level >= :lower'; 
$statement = $pdo->prepare($sql);
$low_value = 7;                                                //  変数を追記
$statement->bindValue(':lower',$low_value,PDO::PARAM_INT);    // 変数を引数に指定
$statement->execute();
```
</br>

- `bindValue`： PHPのbindvalue()とは、プリペアドステートメントで使用するSQL文の中で、変数の値をバインドするための関数。</br>
  SQL文に対して一部分の変更可能な箇所を定義し、さらに定義したものを自由に変更できるようにするためのDB機能。</br>
  </br>
- `PDO::PARAM_INT`：SQL INTEGER データ型を表す。(”整数を指定する”という意味らしいが、動かない(整数にしてくれない)との噂がある。)</br>
  [関連時期](https://qiita.com/te2ji/items/a8e7211a69f313126f7c)</br>
  [参考：定義済み定数](https://www.php.net/manual/ja/pdo.constants.php)</br>
</br>

***

### W3-4_データベースを使ってみよう-追加、要素、削除
PHPからDBにデータを追加する。</br>
phpファイルのSQL文を書き換えて追加するコードを記述する。</br>
SQL文の追加の仕方とは違い、変数に値を割り当ててレコードを追加していく。
```php
// sql_w3-4.phpにて 下記を追記
$name = '霧島1号';
$level = 1;
$job_id = 1;
$sql = 'INSERT INTO players (name, level, job_id) VALUES (:name, :level, :job_id)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':level', $level, PDO::PARAM_INT);
$statement->bindValue(':job_id', $job_id, PDO::PARAM_INT);
$statement->execute();

$sql = 'SELECT * FROM players';
$statement = $pdo->prepare($sql);
$statement->execute();
```
今回はMAMP上では追加を確認できず。(エディタ上では追加された)</br>
</br>
↓
**対策方法がわかった**</br>
paizaのエディタからphpMyAdminを確認したところ、playersテーブルのその他に**AUTO_INCREMENT**という項目が表示されていた。</br>
この項目を自身のMAMP環境のphpMyAdminの構造から確認したところ、`A_I`なるチェックボックスがある。</br>
これをONにして再度試行してみると、自動でIDが＋1されてレコードが生成できた。</br>
</br>

次に更新を実行してみる。</br>
```php
$sql = 'UPDATE players SET level = 50 WHERE id = 1';
$statement = $pdo->prepare($sql);
$statement->execute();
```
今度はMAMP上でも実行された。</br>
</br>

次にレコードを削除してみる。
```php
$sql = 'DELETE FROM players WHERE id = 12';
$statement = $pdo->prepare($sql);
$statement->execute();
```
これもMAMP上で実行できた。</br>
</br>

***

### W3-5_テーブルを結合してデータを取り出す
まず、SQLでやった時と同様にPHPでテーブル同士をつなげて表示する。</br>
今回は**左結合(`LEFT JOIN`)**で結合する。
```php
<?php

$pdo = new PDO('mysql:host=localhost; dbname=LNG_db-sql; charset=utf8', 'root', 'root');
// ↓LEFT JOIN以降を追記 
$sql = 'SELECT * FROM players LEFT JOIN jobs ON jobs.id = players.job_id';
$statement = $pdo->prepare($sql);
$statement->execute();

$results = [];
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
  $results[] = $row;
}

$statement = null;
$pdo = null;

$message = 'hello world';
require_once 'views/content.tpl.php';
```
↓出力結果
```php
// LEFT JOIN jobs ON jobs.id = players.job_id 追記前
Array ( [id] => 1 [name] => PHP_DB_SQL [level] => 30 [job_id] => 6 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_id] => 2 )

↓

// LEFT JOIN jobs ON jobs.id = players.job_id 追記後
Array ( [id] => 6 [name] => PHP_DB_SQL [level] => 30 [job_id] => 6 [job_name] => 勇者 [vitality] => 10 [strength] => 10 [agility] => 10 [intelligence] => 10 [luck] => 10 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_id] => 2 [job_name] => 盗賊 [vitality] => 3 [strength] => 3 [agility] => 8 [intelligence] => 5 [luck] => 7 )
```
</br>

次にカラムの表示をプレイヤーのid、名前、レベル、職業名だけにする。</br>
```php
$sql = 'SELECT * FROM players LEFT JOIN jobs ON jobs.id = players.job_id';
↓
$sql = 'SELECT players.id,name,level,job_name FROM players LEFT JOIN jobs ON jobs.id = players.job_id';
```
↓出力結果
```php
Array ( [id] => 6 [name] => PHP_DB_SQL [level] => 30 [job_id] => 6 [job_name] => 勇者 [vitality] => 10 [strength] => 10 [agility] => 10 [intelligence] => 10 [luck] => 10 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_id] => 2 [job_name] => 盗賊 [vitality] => 3 [strength] => 3 [agility] => 8 [intelligence] => 5 [luck] => 7 )

↓

Array ( [id] => 1 [name] => PHP_DB_SQL [level] => 30 [job_name] => 勇者 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_name] => 盗賊 )
```
</br>

***

### W3-6_データをtableタグで表示する
テーブル表示の見た目を変える。見た目を変えるにはテンプレートファイルを編集する。</br>
```php
// content_w3-6.tpl.php
<?php foreach($results as $player){ ?>
  <p> <?php print_r($player); ?> </p>
<?php } ?>

↓

<?php foreach($results as $player){ ?>
  <p>
    <?= $player['id'] ?>
    <?= $player['name'] ?>
    <?= $player['level'] ?>
    <?= $player['job_name'] ?>               
  </p>
<?php } ?>
```
↓出力結果
```php
Array ( [id] => 1 [name] => PHP_DB_SQL [level] => 30 [job_name] => 勇者 )

Array ( [id] => 2 [name] => ケン [level] => 7 [job_name] => 盗賊 )

↓

1 PHP_DB_SQL 30 勇者

2 ケン 7 盗賊
```
</br>

さらにHTMLのtableで表示する。
```php
// content_w3-6.tpl.php
<table>
  <?php foreach ($results as $player) { ?>
    <tr>
      <td><?= $player['id'] ?></td>
      <td><?= $player['name'] ?></td>
      <td><?= $player['job_name'] ?></td>
      <td><?= $player['level'] ?></td>
    </tr>
  <?php } ?>
</table>
```
↓出力結果
```php
1	PHP_DB_SQL	勇者	30
2	ケン	盗賊	7
3	リン	戦士	1
4	ユウ	狩人	3
```
</br>

***

### W3-7_特定のプレイヤーを表示する1
PHPを使って簡単なWebアプリケーションを作成する。プレイヤー一覧からそのプレイヤーの詳細情報を表示する。</br>
sql.phpと同様にtable上でplayersテーブルを表示するファイルを作成。(index_w3-7.php)</br>
これをもとにプレイヤー情報の詳細を表示するファイルを作成。(show_player_w3-7.php)</br>
show_player_w3-7.phpがidを受け取った際、そのidのレコード1行のみを表示するように編集。</br>
```php
// show_player_w3-7.php
<?php

$pdo = new PDO('mysql:host=localhost; dbname=LNG_db-sql; charset=utf8', 'root', 'root');

// idを受け取ったら詳細を表示するという記述を追記
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
}

$sql = 'SELECT players.id, name, level, job_name 
FROM players LEFT JOIN jobs ON jobs.id = players.job_id
WHERE players.id =:id';  //ここを追記

$statement = $pdo->prepare($sql);
$statement->bindValue(':id',$id,PDO::PARAM_INT);
$statement->execute();

// 下記を削除
// $results = [];
// while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
//   $results[] = $row;
// }

// 下記を追記
$player = $statement->fetch(PDO::FETCH_ASSOC);

$statement = null;
$pdo = null;

$message = 'This is Detail of the Player.';
// require_once 'views/index_w3-7.tpl.php';
// 正しく動くか確認するためとりあえずprint_rで出力してみる。下記を追記
print_r($player);
```
</br>

***

### W3-8_特定のプレイヤーを表示する2
前章で記述した確認用のprint_rを削除し、表示用のテンプレートのリンクを作成。そのテンプレートファイルも作成。(profile.tpl.php)</br>
```php
// show_player_w3-7.php

$message = 'This is Detail of the Player.';
// require_once 'views/index_w3-7.tpl.php';
// 正しく動くか確認するためとりあえずprint_rで出力してみる。下記を追記
print_r($player);

↓

$message = 'This is profile of the Player.';
require_once 'views/profile.tpl.php';
```
</br>

テンプレートファイルを作成。
```php
// profile.tpl.php(index_w3-7.tpl.phpをコピーして作成)
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player profile</h1>
  <p><?= $message ?></p>

  // 下記を追記
  <ul>
    <li>ID：<?= $player['id'] ?></li>
    <li>名前：<?= $player['name'] ?></li>
    <li>職業：<?= $player['job_name'] ?></li>
    <li>レベル：<?= $player['level'] ?></li>
  </ul>

  <p><a href='index_w3-7.php'>プレイヤーリストに戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
</br>

次にプレイヤー一覧ページ(index_w3-7.php)から詳細ページ(show_player_w3-7.php)に飛べるようにリンクを設定。</br>
```php
// index_w3-7.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <table>
    <tr style="background:#ccccff">
      <th>ID</ht>
      <th>名前</ht>
      <th>職業</ht>
      <th>レベル</ht>
      <th>詳細</ht>
    </tr>
    <?php foreach ($results as $player) { ?>

      <tr>
        <td><?= $player['id'] ?></td>
        <td><?= $player['name'] ?></td>
        <td><?= $player['job_name'] ?></td>
        <td><?= $player['level'] ?></td>
        // 下記を追記
        <td><a href='show_player_w3-7.php?id=<?= $player['id'] ?>'>表示</a></td>
      </tr>
    <?php } ?>
  </table>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
これで詳細に飛べるリンクを各レコードに設定できた。
## PHP-Web入門編3:データベースの基本を理解しよう


### 目次
[W3-1_PHPでデータベースに接続しよう](#W3-1_PHPでデータベースに接続しよう)</br>
[W3-2_テンプレートでデータを表示しよう](#W3-2_テンプレートでデータを表示しよう)</br>
[W3-3_データベースを使ってみよう-取り出し](#W3-3_データベースを使ってみよう-取り出し)</br>
[W3-4_データベースを使ってみよう-追加、要素、削除](#W3-4_データベースを使ってみよう-追加、要素、削除)</br>
[W3-5_テーブルを結合してデータを取り出す](#W3-5_テーブルを結合してデータを取り出す)</br>



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



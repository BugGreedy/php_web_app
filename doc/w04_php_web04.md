## PHP-Web入門編4:Eloquentでデータベースを操作しよう


### 目次
[W4-1_Eloquentの役割と効果](#W4-1_Eloquentの役割と効果)</br>
[W4-2_Eloquentでデータを表示しよう](#W4-2_Eloquentでデータを表示しよう)</br>
[W4-3_Eloquentでデータベースを使ってみよう(いろんな読み出し)](#W4-3_Eloquentでデータベースを使ってみよう(いろんな読み出し))</br>
[W4-4_Eloquentでデータベースを使ってみよう(追加・更新・削除)](#W4-4_Eloquentでデータベースを使ってみよう(追加・更新・削除))</br>
[W4-5_Eloquentでテーブルを連結してデータを取り出す](#W4-5_Eloquentでテーブルを連結してデータを取り出す)</br>
[W4-6_特定のプレイヤーを表示する-その1](#W4-6_特定のプレイヤーを表示する-その1)</br>
[W4-7_特定のプレイヤーを表示する-その2](#W4-7_特定のプレイヤーを表示する-その2)</br>




</br>

***

### W4-1_Eloquentの役割と効果
**Eloquent**：エレクエントと読む。
- PHPでデータベースを操作できるライブラリ。
  - DBのレコードをオブジェクトに割り当てる。
    → SQL文を書かなくてもPHPのコードでDBの操作が可能。
    オブジェクトでDBを操作するツールを**ORマッパー(オブジェクトリレーショナルマッパー)**という。(EloquentもORマッパーの一つ)
    </br>

- PHPの文法でDBを操作できる。
  </br>
  
- Laravelで採用されている。
</br>

このカリキュラムでは下記の内容を学習する。
- PHPとEloquentでデータを表示しよう
- Eloquentでデータベースを使ってみよう
  (いろんな読み出し)
- Eloquentでデータベースを使ってみよう
  (追加、更新、削除)
- Eloquentでテーブルを連結してデータを取り出す
- 具体例：特定のプレイヤー情報を表示する
- 具体例：職業一覧を表示する
- 具体例：ある職業のプレイヤー一覧を表示する
</br>

***

### W4-2_Eloquentでデータを表示しよう
当カリキュラムを行う前に、開発環境(mamp ON mac)にcomposerを導入し、eloquentをインストールする。

- composerの導入。[参考:【mac】MAMPでLaravelを導入する方法] (https://qiita.com/kuroudoart/items/366e42d606764b46da7f)</br>
- eloquentのインストール手順
  ```bash
  # 使用するappのディレクトリにインストール
  $ cd public_html  
  $ composer require illuminate/database
  ```
で完了.</br>
</br>

ではこれまでSQLで記述していたページを、eloquentによってデータを取得できるように、接続情報を書き換える。
```php
<?php

// $pdo = new PDO('mysql:host=localhost;dbname=LNG_db-sql;charset=utf8', 'root', 'root');

// 下記を追記
require_once './vendor/autoload.php';  // composerで用意しておいたライブラリを読み込む
$db = new Illuminate\Database\Capsule\Manager;  // 生成したオブジェクトを$DB変数に代入して
$db->addConnection([                             // 下記で接続情報を指定
  'driver' => 'mysql',
  'host' => 'localhost',
  'database' => 'LNG_db-sql',
  'username' => 'root',
  'password' => 'root'
]);
$db->setAsGlobal();   // setAsGlobal()はこの$db変数をどこからでも利用できるようにするメソッド。 
$db->bootEloquent();  // bootEloquent()はORマッパーを起動する。
// ここまでが接続情報を指定して実行している箇所

// 下記はデータを取り出す記述箇所
class Player extends Illuminate\Database\Eloquent\Model { 
} 
// 取り出したデータを格納するクラスを定義
// このときeloquentではクラス名を複数名にしたものが自動的にテーブル名になる。また、カラムなどを自動的に取得してくれる。

// $sql = 'SELECT * FROM players';
// $statement = $pdo->prepare($sql);
// $statement->execute();

// $players = [];
// while ($player = $statement->fetch(PDO::FETCH_ASSOC)) {
//   $players[] = $player;
// }

// $statement = null;
// $pdo = null;


$players = Player::all();  // $SQL以降を削除し、ここを追記
$message = 'hello world';
require_once 'views/content.tpl.php';
```
テンプレートファイルである`content.tpl.php`は特に変更しない。</br>
また、SQLで取得していたデータは配列だったが、**eloquentで取得した際はオブジェクト**となる。</br>
</br>

***

### W4-3_Eloquentでデータベースを使ってみよう(いろんな読み出し)
eloquentのいろいろなデータの取り出し方。
```php
// sql_w4-3.php
$players = Player::all();
↓
$players = Player::select('*')->get();
```
これでも同様にテーブルの全てのデータを取り出す事ができる。</br>
また、**EloquentはSQL文を組み立てるクエリビルダーとしても活用できる**。</br>
</br>

次にレベルが5以上のデータを取り出してみる。
```php
$players = Player::where('level','>=',5)->get();
```
</br>

次は1件だけレコードを取り出す記述を行う。また、今回は1件だけ表示するためのテンプレートで表示する。
```php
$player = Player::find(1);
$message = 'hello world';
// require_once 'views/content.tpl.php';
require_once 'views/profile.tpl.php';
```
**注意**：1件だけ取り出すので変数名を`$player`と単数形にすること。</br>
</br>

***

### W4-4_Eloquentでデータベースを使ってみよう(追加・更新・削除)
まずテーブルにデータを追加してみる。
```php
// sql_w4-4.php
<?php

require_once './vendor/autoload.php';
$db = new Illuminate\Database\Capsule\Manager;
$db->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'LNG_db-sql',
    'username'  => 'root',
    'password'  => 'root'
]);
$db->setAsGlobal();
$db->bootEloquent();

class Player extends Illuminate\Database\Eloquent\Model {
  // 下記を追記
  public $timestamps = false; // ←備考1
}

// クラスでオブジェクトを生成するような感じの記述でレコードを追加する
$player = new Player;
$player->name = 'もぐらeloquent号';
$player->level = '1';
$player->job_id = '1';
$player->save();  // これで配列にオブジェクトを格納している

$players = Player::all();
$message = 'hello world';
require_once 'views/content_w4-4.tpl.php';
```
**備考1**</br>
データを追加するテーブルに`created_at`と`updated_at`というカラムがある場合は、データ作成時に日時を更新してくれる。</br>
今回のテーブルではそのカラムがないので、playerクラスのtimestampsをfalesにしておく必要がある。(`public $timestamps = false;`)</br>
</br>

次に追加したデータを更新してみる。</br>
```php
class Player extends Illuminate\Database\Eloquent\Model {
  // 下記を追記
  public $timestamps = false; 
}
// 上記(既存)の下記を追記
$player = Player::find(19);
$player-> level += 1;
$player-> save();
```
</br>

次にこのデータを削除してみる。
```php
$player = Player::find(19);
$player-> delete();
```
備考：複数同時に削除する場合は次のような記載方法も可能。</br>
```php
$players = Player::where('id','>=',11)->delete();
```
</br>

***

### W4-5_Eloquentでテーブルを連結してデータを取り出す
**多対1の関係**：例えばプレイヤーとジョブの関係ついて、ジョブ一つのIDに対してプレイヤーは複数のIDが関連付けられている(例：戦士というジョブのプレイヤーは複数いる)。このような一方のテーブルにおいて一つのレコードに対して、関連付けられたもう一方のテーブルにおいては複数のIDに関連付けられている状態を**多対1の関係**という。</br>
</br>

それではまず、playersテーブルとjobsテーブルを連結する。</br>
```php
// sql_w4-5.php
<?php

require_once './vendor/autoload.php';
$db = new Illuminate\Database\Capsule\Manager;
$db->addConnection([
  'driver'    => 'mysql',
  'host'      => 'localhost',
  'database'  => 'LNG_db-sql',
  'username'  => 'root',
  'password'  => 'root'
]);
$db->setAsGlobal();
$db->bootEloquent();

// 下記を追記
use Illuminate\Database\Eloquent\Model;  // これはclassを定義する時に、親クラスのパスを省略できる宣言。

// class Player extends Illuminate\Database\Eloquent\Model
// {
//   public $timestamps = false;
// }

// classの箇所を下記のように編集
class Player extends Model{
  public $timestamps = false;
  public function job(){
    return $this->belongsTO('Job');  // belongsTo('テーブル名')で"テーブル名に所属する"となる。
    // 今回はplayersテーブルはjobテーブルに所属するとなる。→ 多対1の関係を表している。
  }
}

// 次にjobsテーブルのモデルを定義する。
class Job extends model{
}

$players = Player::all();
$message = 'hello world';
require_once 'views/content_w4-5.tpl.php';
```
次に連結したテーブルの情報を表示できるようにテンプレートを編集する。
```php
// content_w4-5.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <?php foreach ($players as $player) { ?>
    <p>
      <?= $player->id ?>,
      <?= $player->name ?>,
      <?= $player->level ?>,
      <?= $player->job_id ?>
      <!-- 下記を追記 -->
      <?= $player->job->job_name ?>
    </p>
  <?php } ?>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
これでプレイヤー情報にjobsテーブルから職業名を表示できた。</br>
</br>

***

### W4-6_特定のプレイヤーを表示する-その1
特定のプレイヤーのレコードをクリックするとその詳細を表示するプログラムを作成する。</br>
まず、指定のレコードを取り出す記述をし、print_rで正しく取得できているか確認する
```php
// index_w4-6.php
<?php

require_once './vendor/autoload.php';
$db = new Illuminate\Database\Capsule\Manager;
$db->addConnection([
  'driver'    => 'mysql',
  'host'      => 'localhost',
  'database'  => 'LNG_db-sql',
  'username'  => 'root',
  'password'  => 'root'
]);
$db->setAsGlobal();
$db->bootEloquent();

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
  public $timestamps = false;
  public function job()
  {
    return $this->belongsTo('Job');
  }
}

class Job extends Model{
}

// 下記を追記。GETメソッドで指定されたidを取得したら〜という条件記述
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
}

// 取得したidを代入
$player = Player::find($id); // 注意：レコードをひとつだけ表示するので単数形にすること。
$message = 'hello world';
// require_once 'views/index_w4-6.tpl.php';
print_r($player);
```
これでid=1を与えてブラウザにアクセスしてみる。
(http://localhost:8888/php_web_app/curriculum_W4/public_html_w4/show_w4-6.php?id=1)</br>
↓出力結果</br>
```php
Player Object ( [timestamps] => [connection:protected] => default [table:protected] => players [primaryKey:protected] => id [keyType:protected] => int [incrementing] => 1 [with:protected] => Array ( ) [withCount:protected] => Array ( ) [preventsLazyLoading] => [perPage:protected] => 15 [exists] => 1 [wasRecentlyCreated] => [attributes:protected] => Array ( [id] => 1 [name] => Eloquent [level] => 30 [job_id] => 6 ) [original:protected] => Array ( [id] => 1 [name] => Eloquent [level] => 30 [job_id] => 6 ) [changes:protected] => Array ( ) [casts:protected] => Array ( ) [classCastCache:protected] => Array ( ) [dates:protected] => Array ( ) [dateFormat:protected] => [appends:protected] => Array ( ) [dispatchesEvents:protected] => Array ( ) [observables:protected] => Array ( ) [relations:protected] => Array ( ) [touches:protected] => Array ( ) [hidden:protected] => Array ( ) [visible:protected] => Array ( ) [fillable:protected] => Array ( ) [guarded:protected] => Array ( [0] => * ) )
```
</br>

***

### W4-7_特定のプレイヤーを表示する-その2
前回の続き。では、次に詳細表示ページを編集する。
```php
// index_w4-6.phpにてテンプレートを読み込めるように修正。
$player = Player::find($id);
$message = 'This is Profile.';
require_once 'views/profile_w4-6.tpl.php';
// print_r($player);
```
</br>

```php
// profile.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player profile</h1>
  <p><?= $message ?></p>

  <ul>
    <li>ID：<?= $player->id ?></li>
    <li>名前:<?= $player->name ?></li>
    <li>レベル：<?= $player->level ?></li>
    <li>職業id：<?= $player->job_id ?></li>
    <!-- 下記を追記 -->
    <li>職業名：<?= $player->job->job_name ?></li>
  </ul>

  <p><a href='index_w4-6.php'>リストに戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
これで詳細ページを表示できるようになった。</br>
</br>

最後にプレイヤー一覧ページ(index)からこの詳細ページにとべるようにリンクを設定。
```php
// index_w4-6.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1>Player List</h1>
  <p><?= $message ?></p>


  <table>
    <tr style='background: #AD9DED'>
      <th>ID</th>
      <th>名前</th>
      <th>職業</th>
      <th>レベル</th>
      <th>詳細</th>
    </tr>

    <?php foreach ($players as $player) { ?>
    <tr>
      <td><?= $player->id ?></td>
      <td><?= $player->name ?></td>
      <td><?= $player->level ?></td>
      <td><?= $player->job->job_name ?></td>
      <!-- 下記を追記 -->
      <td><a href='http://localhost:8888/php_web_app/curriculum_W4/public_html_w4/show_w4-6.php?id=<?= $player->id ?>'>表示</a></td>
    </tr>
    <?php } ?>
  </table>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
</br>

***

### W4-8_



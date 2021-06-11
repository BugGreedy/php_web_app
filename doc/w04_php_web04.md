## PHP-Web入門編4:Eloquentでデータベースを操作しよう


### 目次
[W4-1_Eloquentの役割と効果](#W4-1_Eloquentの役割と効果)</br>
[W4-2_Eloquentでデータを表示しよう](#W4-2_Eloquentでデータを表示しよう)</br>
[W4-3_Eloquentでデータベースを使ってみよう(いろんな読み出し)](#W4-3_Eloquentでデータベースを使ってみよう(いろんな読み出し))</br>
[W4-4_Eloquentでデータベースを使ってみよう(追加・更新・削除)](#W4-4_Eloquentでデータベースを使ってみよう(追加・更新・削除))</br>




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






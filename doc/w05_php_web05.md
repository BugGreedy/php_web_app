## PHP-Web入門編5:Eloquentでメモ帳アプリを作ろう


### 目次
[W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ](#W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ)</br>
[W5-2_データベースを用意する](#W5-2_データベースを用意する)</br>
[W5-3_メモ一覧を表示しよう](#W5-3_メモ一覧を表示しよう)</br>
[W5-4_メモを表示しよう(詳細ページ)](#W5-4_メモを表示しよう(詳細ページ))</br>
[W5-5_Markdownで表示しよう](#W5-5_Markdownで表示しよう)</br>
[W5-6_新規メモを作ろう](#W5-6_新規メモを作ろう)</br>
[W5-7_新規メモを保存しよう](#W5-7_新規メモを保存しよう)</br>
[W5-8_メモを編集しよう](#W5-8_メモを編集しよう)</br>
[W5-9_編集したメモを保存しよう](#W5-9_編集したメモを保存しよう)</br>

</br>

***

### W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ
PHPとEloquentを用いてメモ帳アプリを作成する。</br>
- メモ帳アプリの概要</br>
  - 構成：メモ一覧・新規作成・詳細・編集</br>
  - php-markdownというライブラリを用いてマークダウン記述に対応できるようにする。
  - 機能：新規作成・保存・更新・削除
</br>

- 各画面について
  - 一覧画面(index.tpl.php)
  - 新規画面(new.tpl.php)
  - 詳細画面(show.tpl.php)
  - 編集画面(edit.tpl.php)
</br>

- ページ遷移図</br>
  ![](/img/memoappli.png)</br>
</br>

- アプリのDB概要
  - データベース：memo
  - テーブル：note
  - カラム：
    - id(INT) ※数値
    - title(VARCHAR 255) ※CHARACTER VARYING(文字の可変性)の略。可変長の最大255文字の文字列のデータ型の事。
    - content(TEXT)
    - created_at(TIMESTAMP)
    - updated_at(TIMESTAMP)
</br>

- メモ帳アプリの作成手順
  - データベースを用意する
  - データベースに接続して、メモ一覧を表示する
  - メモを表示する
  - markdownで表示する
  - 新規メモを作成する
  - メモを保存・削除する
  - メモを編集・保存する
</br>

***

### W5-2_データベースを用意する
使用するDBを作成する。</br>
まず、sqlファイルを作成する。この時、拡張子はsqlであることに注意。</br>
```sql
// memo.sql
CREATE TABLE notes (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  title VARCHAR(255),
  content TEXT
);

INSERT INTO notes(title,content)
  VALUES
  ('hello world','hello world'),
  ('hello PHP','hello PHP'),
  ('hello Eloquent','hello Eloquent'),
  ('markdownメモ','# 世界の皆さん、こんにちは。\n\nよろしくお願いします。\n\n## 本日のお買い得\n\n- apple\n- orange\n- jucie');
```
</br>
次にphpMyAdminを開き、DBの新規作成を選択。</br>
DB名を"memo"とし,照合順序を"utf8_general_ci"(値に日本語を扱うから)とし、作成をクリック。</br>
作成されたmemoDBからSQLタブを選択し、先程作成したmemo.sqlの内容を貼り付け実行。</br>
これでmemoDBにカラムとサンプルデータの登録ができた。</br>
最後にこのDBへの接続情報を記載したphpファイルを編集する。</br>

```php
// db_connect.php
<?php

require_once './vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as Model;

$db = new Capsule;
$db->addConnection([
  'driver'    => 'mysql',
  'host'      => 'localhost', //もとは'127.0.0.1'だったが、ローカルのMAMP環境ではつながらなかったので変更
  'database'  => 'memo',
  'username'  => 'root',
  'password'  => 'root'
]);

$db->setAsGlobal();
$db->bootEloquent();

class Note extends Model{
}
```
**このファイルは`require_once`で読み込んで使用する。**</br>
</br>

***

### W5-3_メモ一覧を表示しよう
composerを用いてeloquentライブラリを導入する。
```bash
# プログラムのディレクトリで実行
$ composer require illuminate/database
```
</br>

それでは一覧表示ページ`index.php`を作成していこう。
```php
<?php

require_once 'db_connect.php';

$message = 'Hello World!';
$notes = Note::all();

require_once 'views/index.tpl.php';
```
続いてテンプレートを編集
```php
// index_w5-3.tpl.php
<!DOCTYPE html>
<html lang='ja'>
  <?php include('header.inc.php'); ?>
  <body>

    <h1><?= $message ?></h1>

    <?php foreach($notes as $note){ ?>
      <p>
        <?= $note->id ?>
        <?= $note->title ?>
      </p>
    <?php } ?>
  
  <?php include('footer.inc.php'); ?>

  </body>

</html>
```
</br>
では、最後にこの一覧ページをtableタグで表示するように編集しておく。
```php
// index.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <table>
    <tr>
      <th>id</th>
      <th>タイトル</th>
    </tr>
  
    <?php foreach ($notes as $note) { ?>
      <tr>
        <td><?= $note->id ?></td>
        <td><?= $note->title ?></td>
      </tr>
    <?php } ?>
  </table>
  <p>新規メモ</p> 

  <?php include('footer.inc.php'); ?>

</body>

</html>
```

`<p>新規メモ</P>`は今はテキストが表示されるだけでいい。次でリンクを作成する。</br>
</br>

***

### W5-4_メモを表示しよう(詳細ページ)
指定したメモを個別に表示する。</br>
ではメモの詳細ページを作っていく。
```php
// show.php
<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];

  $message = 'Show note #'. $id;
  $note = Note::find($id);  // 一行だけ取り出すので変数名は単数形
}

require_once 'views/show.tpl.php';
```
次に詳細ページ用のテンプレートを編集する。
```php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <p>タイトル：<?= $note->title ?></p>
  <P><?= $note->content ?></p>

 
  <p><a href='index.php'>一覧に戻る</a> | 編集 | 削除</p>

  <?php include('footer.inc.php'); ?>

</body>

</html>
```
次に一覧から詳細に行けるようにリンクを作成する。
```php
// index.tpl.php
<?php foreach ($notes as $note) { ?>
      <tr>
        <td><?= $note->id ?></td>
        <td><a href='show.php?id=<?= $note->id ?>'><?= $note->title ?></a></td>
      </tr>
<?php } ?>
```
一覧表示している部分を書き換える。これでメモのタイトルが詳細ページへのリンクとなった。</br>
</br>

***

### W5-5_Markdownで表示しよう
ここではMarkdownで記述した内容をHTMLで表示できるようにする。</br>
**php-markdown**という変換ライブラリを使ってみる。</br>

- php-markdownのインストール
  ```bash
  # プログラムのディレクトリで実行
  $ composer require michelf/php-markdown
  ```
  `composer.json`を確認してみると
  ```json
  {
    "require": {
        "illuminate/database": "^8.46",
        "michelf/php-markdown": "^1.9"
    }
  }
  ```
  上記のようにphp-Markdownが追加されている。</br>
  </br>
  `db_connect.php`において下記のように自動で読み込むように設定されているからすでにこのライブラリを使用できる環境にある。
  ```php
  // db_connect.php
  <?php

  require_once './vendor/autoload.php';
  // 以下略
  ```
</br>

それではMarkdownライブラリを使用して、テキストをMarkdownに変換してみる。
```php
// show.php
<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];

  $message = 'Show note #'. $id;
  $note = Note::find($id);
}

// 下記を追記
$my_html = Michelf\Markdown::defaultTransform($note->content);

require_once 'views/show.tpl.php';
```
同時にテンプレートも編集を加える。
```php
// show.tpl.php

```
↓出力結果
```php
// PHP-Markdown変換前
タイトル：markdownメモ

# 世界の皆さん、こんにちは。 よろしくお願いします。 ## 本日のお買い得 - apple - orange - jucie

↓

// PHP-Markdown変換後
タイトル：markdownメモ

世界の皆さん、こんにちは。
よろしくお願いします。

本日のお買い得
apple
orange
jucie
```
</br>

***

### W5-6_新規メモを作ろう
メモを新規作成できるページを入力フォームを用いて作成する。</br>
新規作成ページのファイルとなる`new.php`を作成する。</br>
```php
<?php

$message = 'New note';
require_once 'views/new.tpl.php'
```
続いてこのページに用いるテンプレートを作成する。
```php
// new.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <form action='create.php' method='post'>
    <label for='title'>タイトル</label><br>
    <input type='text' name='title' value=''>
    <p></p>
    <label for='content'>本文</label><br>
    <textarea name='content' cols='40' rows='10'></textarea>
    <p></p>
    <button type='submit'>作成する</button>
  </form>
  
  <p><a href='index.php'>一覧に戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
</br>

次にこのページのリンクをindexに設置する。
```php
// index.tpl.php 下記を追記
  <p><a href='new.php'>新規メモ</a></p>
```
これでメモの新規作成ページが作成できた。</br>
ただし、また作成したメモを保存するプログラムがないためこの状態で送信してもエラーになる。</br>
</br>

***

### W5-7_新規メモを保存しよう
ここではメモを新規保存する機能に加え、削除機能も追加する。</br>
新規保存するファイル`create.php`を作成。
```php
<?php

require_once 'db_connect.php';

$note = new Note;                      // 新規のNoteオブジェクトをセットして
$note->title = $_REQUEST['title'];     // フォームから受け取った情報を入力
$note->content = $_REQUEST['content'];
$note->save();                         // それから保存している。

header('Location: show.php?id='.$note->id);  // show.phpを呼び出して、別のページに処理を切り替えている。
exit;   // 呼び出し元の処理を中断         つまり、入力した内容を一度show.php?id=にて詳細画面を表示する。
```
</br>

次にメモの削除機能を追加する。</br>
create.phpをコピーして`destroy.php`を作成する。
```php
// destroy.php
<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $note = Note::find($id);
  $note->delete();
}


header('Location: index.php?id='.$note->id);  //index.phpを呼び出して、一覧ページに処理を切り替えている。
exit; 
```
詳細ページの削除にこの削除ファイルのリンクを設置</br>
```php
// show.tpl.php 下記に変更
  <p><a href='index.php'>一覧に戻る</a> | 編集 | <a href='destroy.php?id=<?= $note->id ?>'>削除</a></p>
```
</br>

***

### W5-8_メモを編集しよう
ここではメモの編集機能を作成する。</br>
編集用ページのファイル`edit.php`を作成する。
```php
// edit.php
<?php

require_once 'db_connect.php';

if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $message = 'Edit note #'. $id;  // messageを変更
  $note = Note::find($id);
}

// 下記を編集用のテンプレートに変更
require_once 'views/edit.tpl.php';
```
</br>

次にテンプレートを編集する。
```php
// edit.tpl.php
<!DOCTYPE html>
<html lang='ja'>
<?php include('header.inc.php'); ?>

<body>

  <h1><?= $message ?></h1>

  <form action='update.php' method='post'> 
    <input type='hidden' name='id' value='<?= $note['id'] ?>'> // hedden(隠し要素)でidを送信する
    <label for='title'>タイトル</label><br>
    <input type='text' name='title' value='<?= $note['title'] ?>'> // フォームに既存の内容を入れる
    <p></p>
    <label for='content'>本文</label><br>
    <textarea name='content' cols='40' rows='10'><?= $note['content'] ?></textarea> // フォームに既存の内容を入れる
    <p></p>
    <button type='submit'>保存する</button>
  </form>
  
  <p><a href='index.php'>一覧に戻る</a></p>

  <?php include('footer.inc.php'); ?>
</body>

</html>
```
</br>

次に詳細ページからこの編集ページに飛べるようにリンクを設置する。
```php
// show.tpl.php メニューのリンクの箇所を下記のように編集
  <p><a href='index.php'>一覧に戻る</a> | <a href='edit.php?id=<?= $note->id ?>'>編集</a> | <a href='destroy.php?id=<?= $note->id ?>'>削除</a></p>
```
</br>
次にチャプターで編集を保存するプログラムを作成する。</br>
</br>

***

### W5-9_編集したメモを保存しよう
編集したメモを保存する`update.php`を作成する。
```php
// update.php
<?php

require_once 'db_connect.php';

// 下記を追記 (これまで同様に指定のidを受け取ったらという条件を記述)
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $note = Note::find($id);
  $note->title = $_REQUEST['title'];
  $note->content = $_REQUEST['content'];
  $note->save();
}

header('Location: show.php?id='.$note->id); 
exit;
```
これでメモ帳アプリの開発デモは終了。
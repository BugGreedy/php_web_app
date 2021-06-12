## PHP-Web入門編5:Eloquentでメモ帳アプリを作ろう


### 目次
[W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ](#W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ)</br>

</br>

***

### W5-1_PHPとEloquentで作るmarkdownメモ帳アプリ
PHPとEloquentを用いてメモ帳アプリを作成する。</br>
- メモ帳アプリの概要</br>
  - 構成：メモ一覧・新規作成・詳細・編集</br>
  - PHPマークダウンというライブラリを用いてマークダウン記述に対応できるようにする。
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
    - title(VARCHAR 255) ※CHARACTER VARYING(文字の可変性)の略。可変長の255文字の文字列のデータ型の事。
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

###
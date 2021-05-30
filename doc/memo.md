## 目次
[変数が宣言されているか、またその変数がnullではないかを調べる(isset)](#変数が宣言されているか、またその変数がnullではないかを調べる(isset))
[GETメソッドとPOSTメソッドについて](#GETメソッドとPOSTメソッドについて)

</br>

### 変数が宣言されているか、またその変数がnullではないかを調べる(isset)
`isset(調べたい変数名)`
例：
```php
<?php
$num = 1;
if(isset($num)){
  echo isset($num);
}else{
  echo "nothing";
}
?>
```
出力結果 → 1
</br>

```php
<?php
$num = NULL;
if(isset($num)){
  echo isset($num);
}else{
  echo "nothing";
}
```
出力結果 → nothing</br>
</br>

### GETメソッドとPOSTメソッドについて
GETメソッドで入力内容を送信した場合、URLに`/result.php?article=a&name=aaa`のように入力内容が含まれてしまう。</br>
そのため第3者に入力内容が知られてしまう可能性が生じる。</br>
GETは検索などにもちいる。また、URLに内容が含まれる事から、このURLをブックマークした際、検索した内容のままブックマークできるなどの利便性もある。例えば検索結果の`~name=aaa`のようなURLをブックマークすれば`name=aaa`で調べた結果をブックマークできる。</br>
パスワードを送る際はPOSTメソッドを用いるようにする。ただし、POSTメソッドを使ってURLから内容を見れないから安全というわけではない。これらの機密情報を送る際は暗号化する事が必須である。</br>
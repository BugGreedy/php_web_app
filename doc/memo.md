## 目次
[変数が宣言されているか、またその変数がnullではないかを調べる(isset)](#変数が宣言されているか、またその変数がnullではないかを調べる(isset))

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

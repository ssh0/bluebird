# bluebird

[チームラボ](http://www.team-lab.com/)の[オンラインスキルアップ課題(STEP2 Twitterもどきをつくろう)](http://team-lab.github.io/skillup/2/10.html)成果物

**仕様**

* [画面仕様書](http://team-lab.github.io/skillup/docs/ui.xls)に従う


**製作環境**

```
$ uname -rvpio
3.13.0-65-lowlatency #106-Ubuntu SMP PREEMPT Fri Oct 2 23:06:14 UTC 2015 x86_64 x86_64 GNU/Linux
```

```
$ php --version
PHP 5.5.9-1ubuntu4.19 (cli) (built: Jul 28 2016 19:31:33)
Copyright (c) 1997-2014 The PHP Group
Zend Engine v2.5.0, Copyright (c) 1998-2014 Zend Technologies
    with Zend OPcache v7.0.3, Copyright (c) 1999-2014, by Zend Technologies
```

```
$ mysql --version
mysql  Ver 14.14 Distrib 5.5.50, for debian-linux-gnu (x86_64) using readline 6.3
```

```
$ bin/cake --version
3.3.2
```

# 本番環境でのセットアップ

`.gitignore`には`config/app.php`を含めているので，本番環境のデータベースの設定にあわせて設定する必要がある。
また，`config/app.php`内の`Security.salt`の項目も変更する必要があるが，ランダムな文字列を生成するのに以下のコマンドが使える。

```
$ cat /dev/urandom | tr -dc 'a-z0-9' | fold -w 64 | head -n 1
qrpy8ar4esa4w3fkxk8013zctp7iiimcpcdiwlrkjxl7eeby8swv6igvp0cwjon0
```

# Credit

**icons** '[Essential Set](http://www.flaticon.com/packs/essential-set-2)': Designed by [Madebyoliver](http://www.flaticon.com/authors/madebyoliver) from [Flaticon](http://www.flaticon.com/).



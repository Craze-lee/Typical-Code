<?php
/**
 * 计算函数执行时间
 * /

//创建无意义长字符串
$long_str = uniqid(php_uname('a'),true);

$start = microtime(true);

$md5 = md5($long_str);

$elapsed = microtime(true)-$start;

echo "That took $elapsed seconds.\n";

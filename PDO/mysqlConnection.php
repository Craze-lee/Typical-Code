<?php

//Data source name
$dsn = 'mysql:host=localhost;dbname=mycontacts';
$user = 'root';
$password = 'liyong';

try{
    $dbh = new pdo($dsn,$user,$password);
}catch(PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
}

//Query获取数据，最快，但不一定最好
$uid = 1;
try{
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from contacts where uid=' . $dbh->quote($uid);    //quote()对数据进行转移
    foreach($dbh->query($sql) as $row){
        print $row['name'] . "\r\n";
    }
}catch(PDOException $e){
    echo 'SQL Query: ' . $sql;
    echo 'Error: '. $e->getMessage();
}

//Prepare和Execute方法，一般情况下是较好的查询方法
try{
    $sql = 'select * from contacts where uid =:uid';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        print $row['email'] . "\r\n";
    }
}catch(PDOException $e){}


/**
 * 如果只进行一次查询，那么query是较好的选择，多次使用SQL语句，那么最好用prepare和execute，（预编译）
 *
 * $stmt->rowCount();受影响的行数
 * $dbh->lastInsertId(); 最新插入的ID
 */
?>

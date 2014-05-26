<?php

$dsn = 'mysql:host=localhost;dbname=mycontacts';
$user = 'root';
$password = 'liyong';
try{
    $dbh = new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $uid = 2; $email = 'lyverygood@126.com'; $password = sha1('hello');
    //事务开始
    $dbh->beginTransaction();
    $sql = 'insert into users(uid,email,password) values(:uid, :email, :password)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':uid'=>$uid,':email'=>$email,':password'=>$password));

    $sql = 'insert into contacts values(:uid,:name,:email,:phone,:address)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':uid'=>$uid,':email'=>$email,':name'=>'Craze lee',':phone'=>'110',':address'=>'Meizhou'));

    //提交事务
    $dbh->commit();

    echo "Success";

}catch(PDOException $e){
    //异常回滚
    $dbh->rollback();
    echo "Error";
}



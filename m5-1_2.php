<!DOCTYPE html>
<html lang="ja">
<FONT face="しねきゃぷしょん">
    <head>
        <meta charset="UTF-8">
        <title>mission5</title>
    </head>
    <body>
    <!--ここから入力フォームの設定-->
    <p>テキスト記入欄</p>
    <form action="" method="post">
        <input type=text name="name" placeholder="名前">
        <input type=text name="comment" placeholder="コメント">
        <button submit="submit" name="submit">
            送信
        </button>
        <p>削除したい番号を入力してください</p>
        <input type=number name="del" value="">
        <button submit="submit" name="delsubmit">
            削除
        </button>
        <p>編集用記入欄</p>
        <input type=number name="cn" placeholder="編集番号">
        <input type=text name="ct" placeholder="編集テキスト">
        <input type=text name="cname" placeholder="編集者名">
        <button submit="submit" name="change">
            編集
        </button>
    </form>
    <!--入力フォームここまで-->
        <?php
        $dsn='mysql:dbname=tb******db;host=localhost';
        $user='tb-******';
        $pass='password';
        $pdo = new PDO($dsn, $user, $pass , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        $sql = "CREATE TABLE IF NOT EXISTS mission5_1"." (". "id INT AUTO_INCREMENT PRIMARY KEY,". "name char(32),". "comment TEXT".");";
        $stmt = $pdo->query($sql);
        $sql = "CREATE TABLE IF NOT EXISTS mission5_1"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT"
        .");";
        //入力フォームが両方とも空でないときだけ、書き込む
        if(!empty($_POST["comment"])){
            if(!empty($_POST["name"])){
                $sql=$pdo -> prepare("INSERT INTO mission5_1 (name,comment) VALUES (:name, :comment)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $sql -> execute();
            }}
        //削除用
        if(!empty($_POST["del"])){
            $id = $_POST["del"]; //削除する投稿番号
            $sql='delete from mission5_1 where id=:id';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->execute();
            $sql='SELECT * FROM mission5_1';
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            }
        //編集用
        if(!empty($_POST["cn"])){
            if(!empty($_POST["ct"])){
                $id = $_POST["cn"]; //変更する投稿番号
                $name = $_POST["cname"];
                $comment = "【編集済み】".$_POST["ct"]; 
                $sql = 'UPDATE mission5_1 SET name=:name,comment=:comment WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        ?>
        <p>掲示板</p><br>
        <?php
        $sql='SELECT * FROM mission5_1';
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row){
        echo $row['id']." ";
        echo $row['name']." ";
        echo $row['comment']."<br>";
        echo "<hr>";
        }
        ?>
    </body>
</FONT>
</html>
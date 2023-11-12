<?php

include_once "../Classes/DbConnector.php";

class ChatCls {

    public function createchat() {
        
    }

    public function changeStatustoA($user) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "UPDATE chatusers SET status = 'Active now' WHERE username=?";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->execute();
    }

    public function changeStatustoOff($user) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "UPDATE chatusers SET status = 'Offline' WHERE username=?";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->execute();
    }

    public function getChat($user) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "SELECT * FROM chatusers WHERE username = ?;";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }

    public function myChat($user) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "SELECT * FROM chatusers WHERE username = ? ORDER BY chatId DESC";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    
    public function myChatX($user,$patner) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "SELECT * FROM chatusers WHERE username = ? AND Did = ? ORDER BY chatId DESC";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->bindValue(2, $patner);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }

    public function lastMsj($user, $patner) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "SELECT * FROM messages WHERE (sender = ? AND receiver = ?) OR (receiver = ? AND sender = ?) ORDER BY Msjid DESC LIMIT 1";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->bindValue(2, $patner);
        $pstmt->bindValue(3, $user);
        $pstmt->bindValue(4, $patner);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    
    public function allMsj($user, $patner) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "SELECT * FROM messages LEFT JOIN chatusers ON chatusers.username = messages.sender AND chatusers.Did = messages.receiver WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?) ORDER BY Msjid";
        echo $query;
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $user);
        $pstmt->bindValue(2, $patner);
        $pstmt->bindValue(3, $patner);
        $pstmt->bindValue(4, $user);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
    
    public function sendMsj($sender,$reciver,$msj) {
        $con = new Classes\DbConnector();
        $dbcon = $con->getConnection();
        $query = "INSERT INTO messages(sender, receiver, msj, dateTime) VALUES (?,?,?,?)";
        $pstmt = $dbcon->prepare($query);
        $pstmt->bindValue(1, $sender);
        $pstmt->bindValue(2, $reciver);
        $pstmt->bindValue(3, $msj);
        $pstmt->bindValue(4, date("Y-m-d h:i:s"));
        echo $query;
        echo date("Y-m-d h:i:s");
        $pstmt->execute();
        return ($pstmt->rowCount() > 0);
    }

}

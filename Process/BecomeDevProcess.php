<?php

require '../Classes/Select.php';

use Classes\DbConnector;
use Classes\Select;

$dbcon = new DbConnector();
$select = new Select();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["BecomeaDeveloper"])) {
        if (!empty($_POST['lang']) || !empty($_POST['prolang']) || !empty($_POST['shortDescription']) || !empty($_POST['education']) || !empty($_POST['experience']) || !empty($_POST['Description'])) {//||  !empty($_POST['password']) )
            $user = $_POST['user'];
            $urid = $_POST['uid'];
            $did = $_POST['did'];
            $languages = $_POST['lang'];
            $prolanguages = $_POST['prolang'];
            $shortDescription = $_POST['shortDescription'];
            $education = $_POST['education'];
            $experience = $_POST['experience'];
            $description = $_POST['Description'];

            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
            $query = "SELECT Did FROM developer ORDER BY Did DESC LIMIT 1;";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $uid = $pstmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($uid as $value) {
                $lastid = $value->Did;
            }
            if ($lastid == NULL) {
                $output = "Dev0001";
            } else {
                $prefix = substr($lastid, 0, 3); //dev
                $number = (int) substr($lastid, 3);
                $newNumber = $number + 1;
                $output = $prefix . sprintf("%04d", $newNumber); // Combine 
            }
            $did = $output;
            
            $date = date("Y-m-d");

            $con = $dbcon->getConnection();

            
            
            if ($select->CheckDeveloper($user) === null) {
                echo "a";

                $sql = "INSERT INTO developer(Did,user,shortdes,education,languages,prolang,experience,description,datesince) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $pstmt = $con->prepare($sql);
                $pstmt->bindValue(1, $did);
                $pstmt->bindValue(2, $urid);
                $pstmt->bindValue(3, $shortDescription);
                $pstmt->bindValue(4, $education);
                $pstmt->bindValue(5, $languages);
                $pstmt->bindValue(6, $prolanguages);
                $pstmt->bindValue(7, $experience);
                $pstmt->bindValue(8, $description);
                $pstmt->bindValue(9, $date);
                $pstmt->execute();
            } else {
                echo 'aaa';
                $sql = "UPDATE developer SET shortdes=? , education=?, language=?, prolang=?, experience=?, description=? WHERE Did=? ";
                $pstmt = $con->prepare($sql);
                $pstmt->bindValue(1, $shortDescription);
                $pstmt->bindValue(2, $education);
                $pstmt->bindValue(3, $languages);
                $pstmt->bindValue(4, $prolanguages);
                $pstmt->bindValue(5, $experience);
                $pstmt->bindValue(6, $description);
                $pstmt->bindValue(7, $did);
                $pstmt->execute();
            }

            if ($pstmt->rowCount() > 0) {
                return 1;

                echo 'Successfully added data';
            } else {
                return 0;
            }
        }
    }
}



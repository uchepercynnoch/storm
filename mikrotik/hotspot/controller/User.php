<?php
/**
 * Created by PhpStorm.
 * User: uchepercynnoch
 * Date: 8/19/2017
 * Time: 9:26 PM
 */

namespace hotspot\controller;
use hotspot\model\Database;


class User
{

    private $conn;
    private $error = false;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function register($uname,$umail,$uphone,$upass)
    {
        try
        {
            $new_password = password_hash($upass, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_phone,user_pass) VALUES(:uname, :umail, :uphone, :upass)");

            $stmt->bindparam(":uname", $uname);
            $stmt->bindparam(":umail", $umail);
            $stmt->bindParam(":uphone", $uphone);
            $stmt->bindparam(":upass", $new_password);

            $stmt->execute();

            return $stmt;
        }
        catch(\PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function registerUser($id,$user_name,$user_pass,$user_owner,$user_shared,$profile)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO hotspot(user_id,user_name,user_pass,user_owner,user_shared,user_profile) 
                                                    VALUES (:uid, :username, :userpass, :userowner, :usershared, :userprofile)");
            $stmt->bindParam(":uid", $id);
            $stmt->bindParam(":username", $user_name);
            $stmt->bindParam(":userpass", $user_pass);
            $stmt->bindParam(":userowner", $user_owner);
            $stmt->bindParam(":usershared", $user_shared);
            $stmt->bindParam(":userprofile", $profile);

            $stmt->execute();

            return $stmt;

        }catch (\PDOException $e)
        {
            echo $e->getMessage();
        }


    }


    public function doLogin($uname,$umail,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:uname OR user_email=:umail ");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $userRow=$stmt->fetch(\PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1)
            {
                if(password_verify($upass, $userRow['user_pass']))
                {
                    $_SESSION['user_session'] = $userRow['user_id'];
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        catch(\PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function is_loggedin()
    {
        if(isset($_SESSION['user_session']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function doLogout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    public function error()
    {
        return $this->error;
    }
}
<?php 

    session_start();
    include_once('db.php');

    if (isset($_POST['insert'])) {
        echo$username = $_POST['username'];
        echo$password = $_POST['password'];
        echo$m_user = $_POST['m_user'];
        echo$tel_num = $_POST['tel_num'];
        
        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
            header("location: insert.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: insert.php");
        } else if (empty($m_user)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ-นามสกุล';
            header("location: insert.php");
        } else if (empty($tel_num)) {
            $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
            header("location: insert.php");
        } else {

        try {
            $check_user = $conn->prepare("SELECT * FROM tb_member WHERE m_user = :m_user");
            $check_user->bindParam(":m_user", $username);
            $check_user->execute();
            $row = $check_user->fetch(PDO::FETCH_ASSOC);
    
            if ($row['m_user'] == $username) {
                echo $_SESSION['warning'] = "ไม่สามารถเพิ่มข้อมูลได้ เนื่องจากมีผู้ใช้นี้แล้ว";
                header("location: insert.php");
            } else {
                $register = $conn->prepare("INSERT INTO tb_member (m_user, m_pass, m_name, m_phone) 
                                                VALUES(:username, :password, :m_user, :tel_num)");
                    $register->bindParam(":username", $username);
                    $register->bindParam(":password", $password);
                    $register->bindParam(":m_user", $m_user);
                    $register->bindParam(":tel_num", $tel_num);
                    $register->execute();


                $_SESSION['success'] = "เพิ่มรายการผู้ใช้สำเร็จ";
                header("location: insert.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
    
    

?>
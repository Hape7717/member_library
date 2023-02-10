<?php
    session_start();
    include_once('db.php');

    if (isset($_POST['edit'])) {
        
        echo $id = $_POST['id'];
        echo $username = $_POST['username'];
        echo $password = $_POST['password'];
        echo $m_user = $_POST['m_user'];
        echo $tel_num = $_POST['tel_num'];

        if (empty($username)) {
            echo $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
            // header("location: edit-user.php");
        } else if (empty($password)) {
            echo $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            // header("location: edit-user.php");
        } else if (empty($m_user)) {
            echo $_SESSION['error'] = 'กรุณากรอกชื่อ-นามสกุล';
            // header("location: edit-user.php");
        } else if (empty($tel_num)) {
            echo $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
            // header("location: edit-user.php");
        } else {
        
        try {
            $stmt = $conn->prepare("UPDATE tb_member SET m_user = :m_user, m_pass = :m_pass, m_name = :m_name, m_phone = :m_phone WHERE m_id = :id");
                $stmt->bindParam(':m_user', $username);
                $stmt->bindParam(':m_pass', $password);
                $stmt->bindParam(':m_name', $m_user);
                $stmt->bindParam(':m_phone', $tel_num);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                echo $_SESSION['success'] = 'แก้ไขรายการผู้ใช้สำเร็จ';
                echo $_SESSION['id'] = $id;
                header("location: index.php");

            } catch(PDOException $e) {
                echo $e->getMessage();
        }
    }
}
?>
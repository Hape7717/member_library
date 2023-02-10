<?php
    session_start();
    include_once 'db.php';
    

    if($_GET['id']){
        $stmt = $conn->prepare("SELECT * FROM tb_member WHERE m_id = :id");
        $stmt->bindParam(':id', ($_GET['id']));
        $stmt->execute();
        $users = $stmt->fetch();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | User</title>
</head>
<body>
<div>
    <div>
        <h3>เพิ่มข้อมูลสมาชิก</h3>
    </div>
    <div>
        <form action="edit-user-db.php" method="post">
            <div>
                <label for="username">ชื่อผู้ใช้</label>
                <input type="hidden" name="id" value="<?php echo $users['m_id']; ?>">
                <input type="text" name="username" value="<?php echo $users['m_user']; ?>">
            </div>
            <div>
                <label for="password">รหัสผ่าน</label>
                <input type="password" name="password" value="<?php echo $users['m_pass']; ?>">
            </div>
            <div>
                <label for="m_user">ชื่อ-นามสกุล</label>
                <input type="text" name="m_user" value="<?php echo $users['m_name']; ?>">
            </div>
            <div>
                <label for="tel_num">เบอร์โทรศัพท์</label>
                <input type="text" name="tel_num" value="<?php echo $users['m_phone']; ?>">
            </div>
            <button type="submit" name="edit">แก้ไขข้อมูล</button>
            <a href="index.php">ยกเลิก</a>
        </form>
    </div>
</div>
</body>
</html>
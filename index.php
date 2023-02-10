<?php
    include_once 'db.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM tb_member WHERE m_id = $delete_id");
        $deletestmt->execute();
        
        if ($deletestmt) {
            echo "<script>alert('Data has been deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted succesfully";
            header("refresh:1; url=index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="view-blog.css">
    <link rel="stylesheet" href="table-manage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="sweetalert2.min.css">
    <!-- end sweetalert2 -->


</head>
<body>
    <h3>การจัดการข้อมูลสมาชิก</h3>
    <!-- <input type="search"> -->
    <a href="insert.php">เพิ่มข้อมูลสมาชิกใหม่</a>
    <table id="myTable" class="table">
        <thead>
            <th>ลำดับ</th>
            <th>ชื่อผู้ใช้</th>
            <th>รหัสผ่าน</th>
            <th>ชื่อ-สกุล</th>
            <th>เบอร์โทรศัพท์</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </thead>
        <tbody>
<?php
    $user_stmt = $conn->prepare("SELECT * FROM tb_member");
    $user_stmt->execute();
    // set the resulting array to associative
    $result = $user_stmt->setFetchMode(PDO::FETCH_ASSOC);
                    
    foreach($user_stmt->fetchAll() as $users) {
                ?>
                <tr>
                    <td data-label="Name Blog"><?php echo $users['m_id']; ?></td>
                    <td data-label="Name Blog"><?php echo $users['m_user']; ?></td>
                    <td data-label="type"><?php echo $users['m_pass']; ?></td>
                    <td data-label="type"><?php echo $users['m_name']; ?></td>
                    <td data-label="type"><?php echo $users['m_phone']; ?></td>
                    <td>
                        <a class="btn-diy" href="edit-user.php?id=<?php echo $users['m_id']; ?>">แก้ไข</a>
                        <!-- <a class='btn-diy-2' href="?delete=">Delete</a> -->
                    </td>
                    <td>
                    <a data-id="<?php echo $users['m_id']; ?>" href="?delete=<?php echo $users['m_id']; ?>" class="btn-diy-2 delete-btn">ลบ</a>

                    </td>
                </tr>
                <?php } ?>
            </tbody>        
        </table>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>   
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>

<script>
            $(".delete-btn").click(function(e) {
                        var userId = $(this).data('id');
                        e.preventDefault();
                        deleteConfirm(userId);
                    })

                    function deleteConfirm(userId) {
                        Swal.fire({
                            title: 'ยืนยันการลบข้อมูล?',
                            showCancelButton: true,
                            confirmButtonText: 'ยืนยัน',
                            showLoaderOnConfirm: true,
                            preConfirm: function() {
                                return new Promise(function(resolve) {
                                    $.ajax({
                                            url: 'index.php',
                                            type: 'GET',
                                            data: 'delete=' + userId,
                                        })
                                        .done(function() {
                                            Swal.fire({
                                                title: 'ลบข้อมูลสำเร็จ',
                                                icon: 'success',
                                            }).then(() => {
                                                document.location.href = 'index.php';
                                            })
                                        })
                                        .fail(function() {
                                            Swal.fire('มีบางอย่างผิดพลาด')
                                            window.location.reload();
                                        });
                                });
                            },
                        });
                    }
    </script>

            <!-- action to edit_data.php end -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweetalert2.all.min.js"></script>


</body>
</html>
<?php 
    $conn = null;
?>
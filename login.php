<?php
include("db.connect.php");
include("structure/header.php");
include("structure/navbar.php");

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // ใช้ prepared statement สำหรับการตรวจสอบอีเมล
    $sql = 'SELECT * FROM user WHERE email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" สำหรับ string
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data && $email == $data['email'] && md5($pass) == $data['pass']) {
        // เก็บข้อมูล session ของผู้ใช้
        session_start();
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['role'] = $data['role'];
        print_r($_SESSION);
        header('location:index.php');
    } else {
        echo "<script>
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'ไม่สามารถทำรายการได้',
            showConfirmButton: false,
            timer: 2000 })
            </script>";
        // รอ 2 วินาทีแล้วกลับไปที่หน้า login
        header("Refresh:2; url=login.php");
    }
}
?>
<body>
    
    <div class="contrainer mt-5">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col"></div>
            <div class="col-3">
                <div class="card border-dark">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>เข้าสู่ระบบ</h2>
                        </div>
                        <form method="post">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">อีเมล</label>
                                <input type="email" class="form-control " id="email" name="email" aria-describedby="emailHelp" placeholder="กรอก อีเมล" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="กรอก รหัสผ่าน" required>
                            </div>
                            <button type="submit" class="btn btn-success" style="width: 100%;">ยืนยัน</button>
                           
                        </form>
                        <a href="register.php" class="btn btn-primary w-100 mt-2" role="button" data-bs-toggle="button">สมัคสมาชิก</a>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>

<?php include('structure/footer.php') ?>
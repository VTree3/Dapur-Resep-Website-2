<?php 

//koneksi ke database
$conn = mysqli_connect("localhost","root","","dapurresep");

function query($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function regis ($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn,$data["password2"]);

    // cek username udah ada atau belum
    $result = mysqli_query($conn,"SELECT username FROM user WHERE username ='$username'");

    if (mysqli_fetch_assoc($result)){
        echo "<script type='text/javascript'>
                alert('username sudah terdaftar');
            </script>";
        return false;
    }

    // cek konfirmasi password
    if( $password !== $password2){
        echo "<script type='text/javascript'>
                alert('konfirmasi password tidak sesuai!');
            </script>";
        header("Location: register.php");
        exit;
        return false;
    }

    // enkripsi password
    $password = password_hash($password,PASSWORD_DEFAULT);
    // var_dump ($password); die;

    // tambahkan user baru ke database
    mysqli_query($conn,"INSERT INTO user VALUES('','$username','$password')");
    return mysqli_affected_rows($conn);
}

?>



<?php
require __DIR__ . '/../../config/conn.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($action == 'add'){
        $id_u = random_int(1000, 9999);
        $user = $_POST['username'];
        $name = $_POST['name'];
        $pw = $_POST['password'];
        $pass = password_hash($pw, PASSWORD_BCRYPT);
        $jabatan = $_POST['jabatan-input'];
        $jabatanArray = explode(', ',$jabatan);
        $tags = $_POST['tags_value'];
        $tagsArray = explode(', ', $tags);

        $conn->begin_transaction();
        try {
        
            $cek = $conn->query("SELECT username FROM user WHERE username = '$user'");
            if ($cek->num_rows > 0) {
                throw new Exception("Username sudah ada");
            }
        
            $in = $conn->query("INSERT INTO user (id, username, name, password) VALUES ('$id_u', '$user', '$name', '$pass')");
            if (!$in) {
                throw new Exception("Gagal menyisipkan data ke tabel user");
            }
            if(!empty($tags)){
                foreach ($tagsArray as $tag_i) {
                    $t = $conn->prepare("INSERT INTO app (id_u, id_md) VALUES (?, ?)");
                    $t->bind_param("ii", $id_u, $tag_i);
                    if (!$t->execute()) {
                        throw new Exception("Gagal menyisipkan data ke tabel app");
                    }
                }
            }
            if(!empty($jabatan)){
                foreach ($jabatanArray as $jb) {
                    $t = $conn->prepare("INSERT INTO role_u (id_u, id_r) VALUES (?, ?)");
                    $t->bind_param("ii", $id_u, $jb);
                    if (!$t->execute()) {
                        throw new Exception("Gagal menyisipkan data ke tabel role_u");
                    }
                }
            }
        
            $conn->commit();
        
            header('Location: ../../admin/user-all?status=insert');
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            header('Location: ../../admin/user-all?status=noinsert&error=' . urlencode($e->getMessage()));
            exit;
        }finally {
            if (isset($conn) && $conn instanceof mysqli) {
                $conn->close();
            }
        }
        
        
    }elseif($action == 'edit'){
        $e_id_u = $_POST['id_u'];
        $u_user = $_POST['username'];
        $u_name = $_POST['name'];
        $pass = $_POST['pass-baru'];
        $jabatan2 = $_POST['jabatan-input2'];
        $jabatanArray2 = explode(', ', $jabatan2);
        $tags2 = $_POST['tags_value2'];
        $tagsArray2 = explode(', ', $tags2);

        // Validate
        $tag_v = trim($tag2);
        $jabatan_v = trim($jabatan2);

        $conn->begin_transaction();
        try {
            if (!empty($pass)) {
                $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
                $u_p = $conn->prepare("UPDATE user SET username = ?, name = ?, password = ? WHERE id = ?");
                $u_p->bind_param("sssi", $u_user, $u_name, $hashedPassword, $e_id_u);
                if (!$u_p->execute()) {
                    throw new Exception("Gagal menjalankan perintah SQL: " . $u_p->error);
                }
            } else {
                $u = $conn->prepare("UPDATE user SET username = ?, name = ? WHERE id = ?");
                $u->bind_param("ssi", $u_user, $u_name, $e_id_u);
                if (!$u->execute()) {
                    throw new Exception("Gagal menjalankan perintah SQL: " . $u->error);
                }
            }
            if(!empty($tags2)){
                foreach ($tagsArray2 as $tagtag) {
                    $t = $conn->prepare("INSERT into app (id_u, id_md) values (?,?) ");
                    $t->bind_param("ii", $e_id_u, $tagtag);
                    if (!$t->execute()) {
                        throw new Exception("Gagal menjalankan perintah SQL: " . $t->error);
                    }   
                }
            }
            if(!empty($jabatan_v)){
                foreach ($jabatanArray2 as $jb2) {
                    $t = $conn->prepare("INSERT INTO role_u (id_u, id_r) VALUES (?, ?)");
                    $t->bind_param("ii", $e_id_u, $jb2);
                    if (!$t->execute()) {
                        throw new Exception("Gagal menyisipkan data ke tabel role_u" . $conn->error);
                    }
                }
            }
            $conn->commit();
        
            header('Location: ../../admin/user-all?status=editok');
            exit;
        } catch (Exception $e) {
            if (isset($conn) && $conn instanceof mysqli) {
                $conn->rollback();
            }
        
            header('Location: ../../admin/user-all?status=noedit&error=' . urlencode($e->getMessage()));
            exit;
        } finally {
            if (isset($conn) && $conn instanceof mysqli) {
                $conn->close();
            }
        }
    } else {

    }
}

?>
<?php
    if (isset($_GET['edit_user'])) {
        $the_user_id = $_GET['edit_user'];

        $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
        $select_users_query = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users_query)) {
            $user_id = $row["user_id"];
            $username = $row["username"];
            $user_password = $row["user_password"];
            $user_firstname = $row["user_firstname"];
            $user_lastname = $row["user_lastname"];
            $user_email = $row["user_email"];
            $user_image = $row["user_image"];
            $user_role = $row["user_role"];
        }
    }

        if (isset($_POST['edit_user'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
 /*
        $post_image = $_FILES['post_image'] ['name'];
        $post_image_temp = $_FILES['post_image'] ['tmp_name']; 
 */
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_password = hash("gost", $user_password);
        //$post_date = date('d-m-y');

        //move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
        $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}') ";
        $add_user_query = mysqli_query($connection, $query);

        confirmQuery($add_user_query); 
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?= $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" value="<?= $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" class="form-control" id="user_role">
            <option value=""><?= $user_role; ?></option>
            <?php
                if($user_role == 'Admin') {
                    echo "<option value='Subscriber'>Subscriber</option>";
                } else {
                    echo "<option value='Admin'>Admin</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?= $username; ?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" value="<?= $user_email; ?>" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="<?= $user_password; ?>" class="form-control" name="user_password">
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User"> 
    </div>
</form>
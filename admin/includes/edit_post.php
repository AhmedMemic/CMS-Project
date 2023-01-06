<?php
    if (isset($_GET["p_id"])) {
        $the_post_id = escape($_GET["p_id"]);
    }

    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
    $select_posts_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row["post_id"];
        $post_author = $row["post_author"];
        $post_title = $row["post_title"];
        $post_category_id = $row["post_category_id"];
        $post_status = $row["post_status"];
        $post_image = $row["post_image"];
        $post_content = $row["post_content"];
        $post_tags = $row["post_tags"];
        $post_comment_count = $row["post_comment_count"];
        $post_date = $row["post_date"];
    }

    if(isset($_POST["update_post"])) {
        $post_author = escape($_POST["post_author"]);
        $post_title = escape($_POST["post_title"]);
        $post_category_id = escape($_POST["post_category_id"]);
        $post_status = escape($_POST["post_status"]);
        $post_image = escape($_FILES["post_image"]["name"]);
        $post_image_temp = escape($_FILES["post_image"]["tmp_name"]);
        $post_content = escape($_POST["post_content"]);
        $post_tags = escape($_POST["post_tags"]);

        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_image)) {
                $post_image = $row['post_image'];
            }
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$the_post_id} ";

        $update_post = mysqli_query($connection, $query);

        confirmQuery($update_post);

        echo "<h4 class='bg-success'>Post Updated. 
              <a href='../post.php?p_id={$the_post_id}'>View Post</a> or
              <a href='posts.php'>Edit More Posts</a></h4>"; 
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?= $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
    <label for="post_category_id">Category</label>
        <select name="post_category_id" id="post_category">
            
            <?php
                $query = "SELECT * FROM categories ";
                $select_categories = mysqli_query($connection, $query);

                confirmQuery($select_categories); 

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <br>
        <select name="post_author" id="post_author">
            
            <?php
                $query = "SELECT * FROM users ";
                $select_users = mysqli_query($connection, $query);

                confirmQuery($select_users); 
                echo "<option value='{$post_author}'>{$post_author}</option>";
                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];

                    echo "<option value='{$user_firstname} {$user_lastname}'>{$user_firstname}" . " " ."{$user_lastname}</option>";
                }
                
            ?>

        </select>
    </div>

    <div class="form-group">
    <select name="post_status" id="post_status">
        <option value='<?= $post_status; ?>'><?= $post_status; ?></option>
        <?php
        if($post_status == 'Published') {
            echo "<option value='Draft'>Draft</option>";
        } else {
            echo "<option value='Published'>Published</option>";
        }
        ?>
    </select>          
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label> 
        <br>
        <img width="100" src="../images/<?= $post_image; ?>" alt="post_image">
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?= $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?= $post_content; ?></textarea>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post"> 
    </div>
</form>
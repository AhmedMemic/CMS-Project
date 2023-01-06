<?php
    if (isset($_POST['create_post'])) {
        $post_title = escape($_POST['post_title']);
        $post_author = escape($_POST['post_author']);
        $post_category_id = escape($_POST['post_category_id']);
        $post_status = escape($_POST['post_status']);
 
        $post_image = escape($_FILES['post_image'] ['name']);
        $post_image_temp = escape($_FILES['post_image'] ['tmp_name']); 

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
        $post_date = escape(date('d-m-y'));
        //$post_comment_count = 4;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
        $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
        $create_post_query = mysqli_query($connection, $query);

        confirmQuery($create_post_query);

        $the_post_id = mysqli_insert_id($connection);
        echo "<h4 class='bg-success'>Post  Created. 
        <a href='../post.php?p_id={$the_post_id}'>View Post</a> or
        <a href='posts.php'>View All Posts</a></h4>"; 
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <br>
        <select name="post_category_id" id="post_category_id">
            
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
            <option value="Draft">Post Status</option>
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div>
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post"> 
    </div>
</form>
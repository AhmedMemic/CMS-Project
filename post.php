<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php // include "admin/functions.php"; ?>;

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container"> 

        <div class="row">
 
            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 
                if(isset($_GET['p_id'])) {
                    $the_post_id = escape($_GET['p_id']);

                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$the_post_id} ";
                    $send_query = mysqli_query($connection, $view_query);
                    
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                    $select_all_posts_query = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row["post_title"];
                        $post_author = $row["post_author"];
                        $post_date = $row["post_date"];
                        $post_image = $row["post_image"];
                        $post_content = $row["post_content"];
                    ?>
                    
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- Blog Post -->
                    <h2><?= $post_title ?></a></h2> 
                    <p class="lead">
                        by <a href="author_post.php?author=<?= $post_author ?>&p_id=<?= $post_id ?>"><?= $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?= $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?= $post_image; ?>" alt="">
                    <hr>
                    <p><?= $post_content ?></p>

                    <hr>

                    <?php }
                } else {
                    header("Location: index.php");
                } 
                ?> 

                <!-- Blog Comments -->
                <?php
                    if(isset($_POST['create_comment'])) { 
                        $the_post_id = escape($_GET['p_id']);
                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                            $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now()) ";
                            $create_comment_query = mysqli_query($connection, $query);
                            if (!$create_comment_query) {
                                die("Query Failed" . mysqli_error($connection));
                            }

                            

/*                          Old was how comment count was written
                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id ";
                            $update_comment_count = mysqli_query($connection, $query);
                        */
                        } else {
                            echo "<script>alert('Fields can not be empty!')</script>";
                        }
                        // TO DO - redirect("/cms/post.php?p_id=$the_post_id");
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Your Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <h3>Comments</h3>

                <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                    $query .= "AND comment_status = 'Approved' ";
                    $query .= "ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if (!$select_comment_query) {
                        die('Query failed' . mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_array($select_comment_query)) {
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
 
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="Image">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $comment_author ?>
                            <small><?= $comment_date ?></small>
                        </h4>
                        <?= $comment_content ?>
                    </div>
                </div>

                <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php"; ?>
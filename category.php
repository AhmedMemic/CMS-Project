<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container"> 

        <div class="row">
 
            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php  
                
                if(isset($_GET['category'])) {
                    $post_category_id = $_GET['category'];
                }
                ?>

                <?php 
                $query= "SELECT cat_title FROM categories WHERE cat_id = $post_category_id ";
                $select_cat_title_query = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($select_cat_title_query);
                $cat_title = $row['cat_title'];
                ?>

                <h1 class="page-header">All posts of the Category <small><?= $cat_title ?></small></h1>

                <?php
                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ";
                $select_all_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row["post_id"];
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_image = $row["post_image"];
                    $post_content = substr($row["post_content"], 0, 100);
                ?>
                
                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?= $post_id; ?>"><?= $post_title ?></a>
                </h2> 
                <p class="lead">
                    by <a href="author_post.php?author=<?= $post_author ?>&p_id=<?= $post_id ?>"><?= $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?= $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?= $post_id; ?>"><img class="img-responsive" src="images/<?= $post_image; ?>" alt=""></a>
                <hr>
                <p><?= $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?= $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php } ?> 

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php"; ?>
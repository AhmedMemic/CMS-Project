<?php include "includes/admin_header.php" ?>

    <div id="wrapper">

        <?php include "includes/admin_navigation.php" ?>    <!-- Navigation --> 

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments for the post:
                            <br> 
                            <small><?php
                            $query = "SELECT * FROM posts WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['id']) . " ";
                            $post_title_query = mysqli_query($connection, $query);
                            while ($row = mysqli_fetch_array($post_title_query)) {
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                            }
                            echo "<a href='../post.php?p_id=$post_id'>{$post_title}</a>";
                            ?></small>
                        </h1>
                        <table class="table table-bordered table-hover">
                            <thead> 
                                <tr> 
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unaprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                                $query = "SELECT * FROM comments WHERE comment_post_id=" . mysqli_real_escape_string($connection, $_GET['id']) . " ";
                                $select_comments = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($select_comments)) {
                                    $comment_id = $row["comment_id"];
                                    $comment_author = $row["comment_author"];
                                    $comment_email = $row["comment_email"];
                                    $comment_post_id = $row["comment_post_id"];
                                    $comment_status = $row["comment_status"];
                                    $comment_content = $row["comment_content"];
                                    $comment_date = $row["comment_date"];
                                    
                                    echo "<tr>";
                                    echo "<td>{$comment_id}</td>";
                                    echo "<td>{$comment_author}</td>";
                                    echo "<td>{$comment_content}</td>";
                                    echo "<td>{$comment_email}</td>";
                                    echo "<td>{$comment_status}</td>";
                                    echo "<td>{$comment_date}</td>";
                                    echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . "''>Approve</a></td>";
                                    echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] . "''>Unapprove</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            ?>

                            </tbody>
                        </table>

                        <?php 

                            if (isset($_GET["approve"])) {
                                $the_comment_id = $_GET["approve"];

                                $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id ";
                                $approve_query = mysqli_query($connection, $query);
                                header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                            }

                            if (isset($_GET["unapprove"])) {
                                $the_comment_id = $_GET["unapprove"];

                                $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $the_comment_id ";
                                $unapprove_query = mysqli_query($connection, $query);
                                header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                            }

                            if (isset($_GET["delete"])) {
                                $the_comment_id = $_GET["delete"];

                                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: post_comments.php?id=" . $_GET['id'] . " ");
                            }
                        ?>
                        </div>
                </div>  <!-- /.row -->
            </div>  <!-- /.container-fluid -->
        </div>  <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
<table class="table table-bordered table-hover">
    <thead> 
        <tr> 
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unaprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php 
        $query = "SELECT * FROM comments ";
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

            /*$query = "SELECT * FROM categories WHERE cat_id = $comment_post_id ";
            $select_categories_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<td>{$cat_title}</td>";
            }*/ 

            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";

            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";                
            }

            echo "<td>{$comment_date}</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id='>Approve</a></td>";
            echo "<td><a href='posts.php?delete='>Unapprove</a></td>";
            echo "<td><a href='posts.php?delete='>Delete</a></td>";
            echo "</tr>";
        }
    ?>

    </tbody>
</table>

<?php 
    if (isset($_GET["delete"])) {
        $the_post_id = $_GET["delete"];

        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
        $delete_query = mysqli_query($connection, $query);
    }
    /*
    if (isset($_GET["edit"])) {
        $the_post_id = $_GET["edit"];

        $query = "UPDATE FROM posts WHERE post_id = {$the_post_id} ";
        $edit_query = mysqli_query($connection, $query);
    } */
?>
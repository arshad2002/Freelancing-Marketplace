<?php
require_once("../model/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $results = searchFreelancer($searchQuery);
} else {
    header("Location: ../view/clientDashboard.php");
    exit();
}
?>
<html>
<body>
    <section>
        <h2>Search Results</h2>
        <?php if (empty($results)) : ?>
            <p>No freelancers found.</p>
        <?php else : ?>
            <ul>
                <?php foreach ($results as $result) : ?>
                    <li>
                        <strong>Username:</strong> <?php echo $result['username']; ?><br>
                        <strong>User ID:</strong> <?php echo $result['user_id']; ?><br>
                        <hr>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?> 
    </section>
    <a href="../view/clientDashboard.php">Back to Dashboard</a>
</body>

</html>

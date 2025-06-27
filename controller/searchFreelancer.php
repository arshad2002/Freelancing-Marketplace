<?php
require_once("../model/userModel.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
    $results = searchFreelancer($searchQuery);
    
    // Check if this is an AJAX request
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
              strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
    if ($isAjax) {
        // Return JSON response for AJAX requests
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'query' => $searchQuery,
            'results' => $results,
            'count' => count($results)
        ]);
        exit();
    }
} else {
    header("Location: ../view/clientDashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Freelancer Marketplace</title>
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/client.css">
    <link rel="stylesheet" href="../asset/css/searchFreelancer.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="../view/clientDashboard.php" class="logo">← Back to Dashboard</a>
        </div>
    </nav>

    <main class="main-section">
        <section class="search-results-page">
            <h2 class="section-title">Search Results</h2>
            
            <?php if (empty($searchQuery)): ?>
                <div class="warning-card">
                    <h3>No Search Query</h3>
                    <p>Please enter a search term to find freelancers.</p>
                    <a href="../view/clientDashboard.php" class="btn btn-primary">Go Back</a>
                </div>
            <?php elseif (empty($results)): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>No Results Found</h3>
                        <p class="card-subtitle">Search query: "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                    </div>
                    <div class="card-body">
                        <p>No freelancers found matching your search criteria. Try:</p>
                        <ul>
                            <li>Checking your spelling</li>
                            <li>Using different keywords</li>
                            <li>Searching by user ID</li>
                            <li>Using broader search terms</li>
                        </ul>
                        <div style="margin-top: 2rem;">
                            <a href="../view/clientDashboard.php" class="btn btn-primary">Try Another Search</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="results-summary">
                    <p>Found <strong><?php echo count($results); ?></strong> freelancer<?php echo count($results) !== 1 ? 's' : ''; ?> 
                    for "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                </div>
                
                <div class="freelancer-results">
                    <?php foreach ($results as $result): ?>
                        <div class="card freelancer-card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo htmlspecialchars($result['username']); ?></h3>
                                <span class="user-id-badge">ID: <?php echo htmlspecialchars($result['user_id']); ?></span>
                            </div>
                            <div class="card-body">
                                <div class="freelancer-info">
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($result['email'] ?? 'Not provided'); ?></p>
                                    <p><strong>Join Date:</strong> <?php echo isset($result['created_at']) ? date('M j, Y', strtotime($result['created_at'])) : 'N/A'; ?></p>
                                </div>
                                <div class="freelancer-actions">
                                    <a href="viewUser.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-primary">
                                        View Profile
                                    </a>
                                    <a href="message.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-secondary">
                                        Send Message
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <div class="back-actions">
                <a href="../view/clientDashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
            </div>
        </section>
    </main>
</body>
</html>

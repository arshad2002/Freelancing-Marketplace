<?php
// Navbar component - consistent navigation across all pages
// Usage: include_once("../view/components/navbar.php");

function renderNavbar($currentPage = '', $showSearch = false, $searchAction = '', $searchPlaceholder = 'Search...') {
    $userType = $_SESSION['user_type'] ?? '';
    $username = $_SESSION['username'] ?? 'User';
    
    // Determine dashboard URL based on user type
    $dashboardUrl = 'login.php'; // default fallback
    $dashboardText = 'Home';
    
    switch ($userType) {
        case 'client':
            $dashboardUrl = 'clientDashboard.php';
            $dashboardText = 'Client Dashboard';
            break;
        case 'freelancer':
            $dashboardUrl = 'freelancerDashboard.php';
            $dashboardText = 'Freelancer Dashboard';
            break;
        case 'admin':
            $dashboardUrl = 'AdminDashboard.php';
            $dashboardText = 'Admin Dashboard';
            break;
    }
    
    echo '<header>';
    echo '<nav class="navbar">';
    echo '<div class="nav-container">';
    
    // Logo/Brand
    echo '<div class="logo">';
    echo '<h1>FreeMarket - ' . ucfirst($userType) . '</h1>';
    echo '</div>';
    
    // Mobile menu toggle
    echo '<button class="mobile-menu-toggle" onclick="toggleMobileMenu()">';
    echo '<span>☰</span>';
    echo '</button>';
    
    // Navigation links
    echo '<ul class="nav-links" id="navLinks">';
    
    // Home/Dashboard
    $homeClass = ($currentPage === 'dashboard' || $currentPage === 'home') ? 'active' : '';
    echo '<li><a href="' . $dashboardUrl . '" class="' . $homeClass . '">Home</a></li>';
    
    // Profile
    $profileClass = ($currentPage === 'profile') ? 'active' : '';
    echo '<li><a href="profile.php" class="' . $profileClass . '">Profile</a></li>';
    
    // Messages/Inbox (if user type supports it)
    if ($userType === 'client' || $userType === 'freelancer') {
        $inboxClass = ($currentPage === 'inbox' || $currentPage === 'messages') ? 'active' : '';
        echo '<li><a href="inbox.php" class="' . $inboxClass . '">Messages</a></li>';
    }
    
    // User type specific links
    if ($userType === 'freelancer') {
        $jobsClass = ($currentPage === 'jobs' || $currentPage === 'myjobs') ? 'active' : '';
        echo '<li><a href="myAcceptedJobs.php" class="' . $jobsClass . '">My Jobs</a></li>';
    }
    
    // Settings
    $settingsClass = ($currentPage === 'settings') ? 'active' : '';
    echo '<li><a href="settings.php" class="' . $settingsClass . '">Settings</a></li>';
    
    // Logout
    echo '<li><a href="../controller/logoutCheck.php">Logout</a></li>';
    
    echo '</ul>';
    
    echo '</div>'; // nav-container
    
    // Search form (if enabled)
    if ($showSearch && !empty($searchAction)) {
        echo '<div class="nav-search">';
        echo '<form action="' . $searchAction . '" method="GET" class="search-form">';
        echo '<label for="search"><strong>Search:</strong></label>';
        echo '<input type="text" id="search" name="search" placeholder="' . $searchPlaceholder . '" class="search-input">';
        echo '<input type="submit" value="Search" class="search-btn">';
        echo '</form>';
        echo '</div>';
    }
    
    echo '</nav>';
    echo '</header>';
}

// JavaScript for mobile menu toggle
function renderNavbarScript() {
    echo '<script>';
    echo 'function toggleMobileMenu() {';
    echo '    const navLinks = document.getElementById("navLinks");';
    echo '    navLinks.classList.toggle("active");';
    echo '}';
    echo '';
    echo '// Close mobile menu when clicking outside';
    echo 'document.addEventListener("click", function(event) {';
    echo '    const navLinks = document.getElementById("navLinks");';
    echo '    const toggleBtn = document.querySelector(".mobile-menu-toggle");';
    echo '    ';
    echo '    if (!navLinks.contains(event.target) && !toggleBtn.contains(event.target)) {';
    echo '        navLinks.classList.remove("active");';
    echo '    }';
    echo '});';
    echo '';
    echo '// Handle window resize';
    echo 'window.addEventListener("resize", function() {';
    echo '    if (window.innerWidth > 768) {';
    echo '        document.getElementById("navLinks").classList.remove("active");';
    echo '    }';
    echo '});';
    echo '</script>';
}
?>

# FreeMarket - Freelancing Marketplace Platform

**A modern, responsive freelancing marketplace built with PHP, MySQL, and vanilla JavaScript.**

![FreeMarket Logo](asset/images/logo-placeholder.png)

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [User Guide](#user-guide)
- [Developer Guide](#developer-guide)
- [API Documentation](#api-documentation)
- [Design System](#design-system)
- [Security](#security)
- [Performance](#performance)
- [Maintenance](#maintenance)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

FreeMarket is a comprehensive freelancing marketplace platform that connects clients with skilled freelancers. The platform features a modern dark theme, responsive design, and intuitive user experience across all devices.

### Key Highlights
- **Modern UI/UX**: Dark theme with glass-morphism effects
- **Responsive Design**: Optimized for desktop, tablet, and mobile
- **Real-time Search**: AJAX-powered freelancer discovery
- **Secure Authentication**: Role-based access control
- **File Management**: Profile images and work submissions
- **Admin Panel**: Complete user and platform management

## ✨ Features

### For Clients
- **Post Jobs**: Create detailed job listings with requirements and budgets
- **Search Freelancers**: Find skilled professionals using real-time search
- **Manage Applications**: Review and approve freelancer applications
- **Track Progress**: Monitor job completion and submitted work
- **Secure Messaging**: Communicate with freelancers through the platform

### For Freelancers
- **Browse Jobs**: Discover opportunities matching your skills
- **Apply for Jobs**: Submit proposals with custom messages
- **Portfolio Management**: Upload profile images and showcase work
- **Work Submission**: Deliver completed work with file attachments
- **Application Tracking**: Monitor application status and feedback

### For Administrators
- **User Management**: Create, edit, and manage user accounts
- **Platform Overview**: Monitor platform activity and statistics
- **Content Moderation**: Review and moderate job postings and applications
- **System Configuration**: Manage platform settings and preferences

## 🛠 Technology Stack

### Backend
- **PHP 8.0+**: Server-side scripting
- **MySQL 8.0+**: Database management
- **Session Management**: User authentication and state

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with variables and grid/flexbox
- **Vanilla JavaScript**: Interactive functionality and AJAX
- **Google Fonts**: Inter font family for typography

### Development Tools
- **XAMPP**: Local development environment
- **Git**: Version control
- **VS Code**: Recommended IDE with extensions

## 🚀 Installation

### Prerequisites
- **XAMPP** (Apache + MySQL + PHP 8.0+)
- **Git** (for version control)
- **Modern Web Browser** (Chrome, Firefox, Safari, Edge)

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/freelancing-marketplace.git
cd freelancing-marketplace
```

### Step 2: Setup XAMPP
1. Install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Place project in `C:\xampp\htdocs\Freelancing-Marketplace`

### Step 3: Database Setup
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create a new database named `freelancingmarketplace`
3. Import the SQL file: `freelancingmarketplace.sql`

### Step 4: Configuration
1. Update database credentials in `model/db.php`
2. Ensure proper file permissions for upload directories
3. Configure PHP settings if needed

### Step 5: Access the Application
- Navigate to: `http://localhost/Freelancing-Marketplace`
- Default admin credentials will be in the SQL file

## ⚙️ Configuration

### Database Configuration
Edit `model/db.php`:
```php
<?php
function getConnection() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "freelancingmarketplace";
    
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>
```

### File Upload Settings
Ensure these directories exist and are writable:
- `asset/images/` - Profile images
- `asset/cv/` - Resume uploads
- `asset/work_submissions/` - Work deliverables

### PHP Configuration
Recommended `php.ini` settings:
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 30
memory_limit = 128M
```

## 📁 Project Structure

```
Freelancing-Marketplace/
├── asset/
│   ├── css/
│   │   ├── main-theme.css      # Core theme variables
│   │   ├── navbar.css          # Navigation styles
│   │   ├── profile.css         # Profile page styles
│   │   ├── settings.css        # Settings page styles
│   │   ├── jobView.css         # Job view styles
│   │   ├── client.css          # Client dashboard styles
│   │   ├── login.css           # Authentication styles
│   │   ├── signup.css          # Registration styles
│   │   └── searchFreelancer.css # Search component styles
│   ├── js/
│   │   ├── searchFreelancer.js # Real-time search
│   │   ├── profile.js          # Profile interactions
│   │   ├── clientJobView.js    # Job view functionality
│   │   ├── appliedFreelancer.js # Application management
│   │   └── *.js               # Other JavaScript files
│   └── images/
│       └── default-profile.svg # Default user avatar
├── controller/
│   ├── authCheck.php          # Authentication middleware
│   ├── searchFreelancer.php   # Search API endpoint
│   ├── uploadProfileImage.php # Image upload handler
│   └── *.php                  # Other controllers
├── model/
│   ├── db.php                 # Database connection
│   ├── userModel.php          # User data operations
│   ├── jobModel.php           # Job data operations
│   ├── applicationModel.php   # Application data operations
│   └── messageModel.php       # Message data operations
├── view/
│   ├── components/
│   │   └── navbar.php         # Reusable navigation
│   ├── login.php              # Authentication page
│   ├── signup.php             # Registration page
│   ├── clientDashboard.php    # Client interface
│   ├── freelancerDashboard.php # Freelancer interface
│   ├── profile.php            # Profile management
│   ├── settings.php           # Account settings
│   ├── jobView.php            # Job details view
│   └── *.php                  # Other view files
├── docs/                      # Documentation files
├── freelancingmarketplace.sql # Database schema
├── index.php                  # Entry point
└── README.md                  # This file
```

## 👥 User Guide

### Getting Started

#### For Clients
1. **Register**: Create an account as a "Client"
2. **Complete Profile**: Add your company information and profile image
3. **Post a Job**: Create detailed job listings with requirements and budget
4. **Review Applications**: Evaluate freelancer proposals and portfolios
5. **Hire Freelancers**: Accept applications and start projects
6. **Manage Projects**: Track progress and review submitted work

#### For Freelancers
1. **Register**: Create an account as a "Freelancer"
2. **Build Profile**: Upload profile image and add your skills/experience
3. **Browse Jobs**: Use search to find relevant opportunities
4. **Apply for Jobs**: Submit compelling proposals
5. **Deliver Work**: Upload completed work and descriptions
6. **Get Paid**: Receive payment upon work approval

### Key Features

#### Real-time Search
- Type in the search box to find freelancers instantly
- Results update automatically as you type
- Filter by skills, experience, and availability

#### Job Management
- Create detailed job postings with rich descriptions
- Set budgets and project timelines
- Manage multiple active projects

#### Profile Management
- Upload professional profile images
- Update skills and experience
- Manage account settings and preferences

#### Work Submission
- Upload files up to 10MB
- Supported formats: PDF, DOC, DOCX, ZIP, RAR, TXT, JPG, PNG
- Add detailed work descriptions

## 🛠 Developer Guide

### Getting Started with Development

#### Environment Setup
1. Install XAMPP with PHP 8.0+
2. Clone the repository
3. Set up the database
4. Configure your IDE (VS Code recommended)

#### Recommended VS Code Extensions
- PHP Intelephense
- HTML CSS Support
- JavaScript (ES6) code snippets
- Live Server
- GitLens

### Code Style Guidelines

#### PHP
- Use PSR-12 coding standards
- Implement proper error handling
- Use prepared statements for database queries
- Follow MVC architecture patterns

```php
// Good
public function getUserById($userId) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}
```

#### CSS
- Use CSS custom properties (variables)
- Follow BEM naming convention
- Mobile-first responsive design
- Semantic class names

```css
/* Good */
.job-card {
    background: var(--gradient-card);
    border-radius: var(--border-radius-lg);
    padding: var(--spacing-lg);
}

.job-card__title {
    color: var(--text-primary);
    font-size: var(--font-size-lg);
}

.job-card--featured {
    border: 2px solid var(--accent-primary);
}
```

#### JavaScript
- Use modern ES6+ features
- Implement proper error handling
- Use meaningful variable names
- Add JSDoc comments for functions

```javascript
/**
 * Debounces a function call to improve performance
 * @param {Function} func - Function to debounce
 * @param {number} delay - Delay in milliseconds
 * @returns {Function} Debounced function
 */
const debounce = (func, delay) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(null, args), delay);
    };
};
```

### Database Schema

#### Users Table
```sql
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('client', 'freelancer', 'admin') NOT NULL,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### Jobs Table
```sql
CREATE TABLE jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    payment DECIMAL(10,2) NOT NULL,
    job_type ENUM('fixed', 'hourly') NOT NULL,
    status ENUM('open', 'in_progress', 'completed', 'cancelled') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES users(user_id) ON DELETE CASCADE
);
```

#### Applications Table
```sql
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    freelancer_id INT NOT NULL,
    message TEXT,
    status ENUM('pending', 'accepted', 'rejected', 'work_submitted') DEFAULT 'pending',
    work_description TEXT,
    work_file VARCHAR(255),
    work_submitted_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE,
    FOREIGN KEY (freelancer_id) REFERENCES users(user_id) ON DELETE CASCADE
);
```

### API Endpoints

#### Search API
**Endpoint**: `controller/searchFreelancer.php`
**Method**: GET
**Parameters**:
- `query` (string): Search term
- `format` (string): Response format ('json' or 'html')

**Response** (JSON):
```json
{
    "success": true,
    "data": [
        {
            "user_id": "1",
            "username": "john_doe",
            "email": "john@example.com",
            "profile_image": "profile_1.jpg"
        }
    ],
    "total": 1
}
```

#### Authentication API
**Endpoint**: `controller/checkLogin.php`
**Method**: POST
**Parameters**:
- `username` (string): User's username
- `password` (string): User's password

### Adding New Features

#### Step 1: Plan the Feature
1. Define requirements and user stories
2. Design database schema changes
3. Plan the user interface
4. Identify security considerations

#### Step 2: Implement Backend
1. Update database schema if needed
2. Create model functions for data operations
3. Implement controller logic
4. Add proper error handling and validation

#### Step 3: Implement Frontend
1. Create HTML structure
2. Add CSS styling following the design system
3. Implement JavaScript functionality
4. Test across different devices and browsers

#### Step 4: Testing and Documentation
1. Test all functionality thoroughly
2. Update documentation
3. Add code comments
4. Create user guide updates

## 🎨 Design System

### Color Palette
The FreeMarket design system uses a professional dark theme with blue/purple accents:

```css
:root {
    /* Background Colors */
    --bg-primary: #0f172a;      /* Main background */
    --bg-secondary: #1e293b;    /* Card backgrounds */
    --bg-tertiary: #334155;     /* Input backgrounds */
    
    /* Text Colors */
    --text-primary: #ffffff;    /* Main text */
    --text-secondary: #e2e8f0;  /* Secondary text */
    --text-muted: #94a3b8;      /* Muted text */
    
    /* Accent Colors */
    --accent-primary: #3b82f6;  /* Primary blue */
    --accent-secondary: #8b5cf6; /* Secondary purple */
    
    /* Status Colors */
    --success: #10b981;         /* Success green */
    --warning: #f59e0b;         /* Warning orange */
    --error: #ef4444;           /* Error red */
    
    /* Gradients */
    --gradient-primary: linear-gradient(135deg, #3b82f6, #1d4ed8);
    --gradient-secondary: linear-gradient(135deg, #8b5cf6, #7c3aed);
    --gradient-card: linear-gradient(135deg, #1e293b, #334155);
}
```

### Typography
- **Primary Font**: Inter (Google Fonts)
- **Font Sizes**: Responsive scale from 0.875rem to 3rem
- **Font Weights**: 400 (regular), 500 (medium), 600 (semibold), 700 (bold)

### Spacing System
- **Base Unit**: 0.25rem (4px)
- **Scale**: 0.5rem, 1rem, 1.5rem, 2rem, 3rem, 4rem

### Components

#### Buttons
```css
.btn-primary {
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}
```

#### Cards
```css
.card {
    background: var(--gradient-card);
    border: 2px solid var(--border-primary);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(20px);
}
```

#### Forms
```css
.form-input {
    background: var(--bg-tertiary);
    border: 2px solid var(--border-primary);
    color: var(--text-primary);
    border-radius: 12px;
    padding: 0.875rem;
}
```

## 🔒 Security

### Authentication
- **Session Management**: Secure PHP sessions with proper configuration
- **Password Hashing**: Uses PHP's `password_hash()` function
- **Role-based Access**: Client, Freelancer, and Admin roles
- **Session Timeout**: Automatic logout after inactivity

### Data Protection
- **SQL Injection Prevention**: Prepared statements for all database queries
- **XSS Protection**: Input sanitization and output encoding
- **File Upload Security**: Type validation and secure file handling
- **CSRF Protection**: Token-based form protection

### Best Practices Implemented
```php
// Input validation and sanitization
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

// File upload validation
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
$fileExtension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedTypes)) {
    throw new Exception("Invalid file type");
}
```

## ⚡ Performance

### Optimization Strategies

#### Frontend Performance
- **CSS Optimization**: Minified CSS with efficient selectors
- **JavaScript Optimization**: Debounced search and lazy loading
- **Image Optimization**: SVG icons and compressed images
- **Caching**: Browser caching for static assets

#### Backend Performance
- **Database Optimization**: Indexed columns and efficient queries
- **Session Optimization**: Minimal session data storage
- **File Handling**: Efficient file upload and storage
- **Error Logging**: Proper error logging without exposing sensitive data

#### Responsive Design
- **Mobile-first**: Optimized for mobile devices
- **Flexible Layouts**: CSS Grid and Flexbox
- **Touch-friendly**: Appropriate touch targets
- **Performance**: Optimized for various network conditions

### Performance Monitoring
```javascript
// Performance timing example
const startTime = performance.now();
// ... your code ...
const endTime = performance.now();
console.log(`Operation took ${endTime - startTime} milliseconds`);
```

## 🔧 Maintenance

### Regular Maintenance Tasks

#### Daily
- Monitor error logs
- Check system performance
- Review user-reported issues

#### Weekly
- Database backup
- Security updates check
- Performance analysis
- User feedback review

#### Monthly
- Full system backup
- Security audit
- Performance optimization
- Documentation updates

### Backup Strategy
```bash
# Database backup
mysqldump -u username -p freelancingmarketplace > backup_$(date +%Y%m%d).sql

# File backup
tar -czf files_backup_$(date +%Y%m%d).tar.gz asset/images/ asset/cv/ asset/work_submissions/
```

### Monitoring and Logging
```php
// Error logging
function logError($message, $context = []) {
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if (!empty($context)) {
        $logMessage .= " - Context: " . json_encode($context);
    }
    error_log($logMessage, 3, "../logs/application.log");
}
```

## 🐛 Troubleshooting

### Common Issues

#### Database Connection Issues
```
Error: Connection failed: Access denied for user 'root'@'localhost'
```
**Solution**: Check database credentials in `model/db.php`

#### File Upload Issues
```
Error: Failed to upload file
```
**Solutions**:
- Check file permissions on upload directories
- Verify PHP upload settings in `php.ini`
- Ensure file size is within limits

#### Session Issues
```
Error: Session not working properly
```
**Solutions**:
- Check PHP session configuration
- Verify session directory permissions
- Clear browser cookies and cache

#### CSS/JS Not Loading
```
Error: 404 - File not found
```
**Solutions**:
- Check file paths in HTML
- Verify file exists in correct directory
- Check web server configuration

### Debug Mode
Enable debug mode by adding to `model/db.php`:
```php
// Enable error reporting for development
if (defined('DEBUG_MODE') && DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
```

### Performance Issues
- Check database query performance
- Optimize large file uploads
- Review JavaScript performance
- Monitor server resources

## 🤝 Contributing

### How to Contribute

1. **Fork the Repository**
2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/new-feature
   ```
3. **Make Your Changes**
4. **Write Tests** (if applicable)
5. **Update Documentation**
6. **Submit a Pull Request**

### Contribution Guidelines

#### Code Standards
- Follow PSR-12 for PHP
- Use consistent CSS methodology (BEM)
- Write clear, self-documenting code
- Add comments for complex logic

#### Pull Request Process
1. Ensure all tests pass
2. Update documentation
3. Add description of changes
4. Request review from maintainers

#### Bug Reports
When reporting bugs, include:
- Detailed description
- Steps to reproduce
- Expected vs actual behavior
- Browser/environment information
- Screenshots if applicable

### Development Workflow
```bash
# Setup development environment
git clone https://github.com/yourusername/freelancing-marketplace.git
cd freelancing-marketplace

# Install dependencies (if any)
# Set up database
# Configure environment

# Make changes
git add .
git commit -m "feat: add new feature"
git push origin feature/new-feature

# Create pull request
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

### MIT License Summary
- ✅ Commercial use
- ✅ Modification
- ✅ Distribution
- ✅ Private use
- ❌ Liability
- ❌ Warranty

## 📞 Support

### Getting Help

#### Documentation
- Check this README first
- Review the documentation in the `docs/` folder
- Look at code comments for specific implementations

#### Community Support
- Create an issue on GitHub
- Join our Discord community (if available)
- Check existing issues for similar problems

#### Commercial Support
For commercial support and custom development:
- Email: support@freemarket.com
- Website: https://freemarket.com
- Phone: +1 (555) 123-4567

### Reporting Security Issues
For security-related issues, please email security@freemarket.com instead of creating a public issue.

---

## 📈 Roadmap

### Version 2.0 (Planned Features)
- Real-time messaging system
- Advanced search filters
- Payment integration
- Mobile app development
- API for third-party integrations

### Version 2.1 (Future Enhancements)
- Machine learning recommendations
- Video calling integration
- Advanced analytics dashboard
- Multi-language support
- Enterprise features

---

**FreeMarket** - Your Gateway to Freelance Success

*Last Updated: June 28, 2025*
*Version: 1.0.0*

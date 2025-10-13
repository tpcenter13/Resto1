<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['fullname'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard - Kultura Cuisine</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet" />
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #FEA116;
            --light: #F1F8FF;
            --dark: #0F172B;
            --secondary: #1e293b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: rgba(15, 23, 43, 0.95);
            backdrop-filter: blur(10px);
            padding: 2rem 0;
            transition: all 0.3s ease;
            z-index: 1000;
            border-right: 1px solid rgba(254, 161, 22, 0.1);
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .logo-section {
            padding: 0 1.5rem 2rem;
            border-bottom: 1px solid rgba(254, 161, 22, 0.1);
            margin-bottom: 2rem;
        }
        
        .logo-section h3 {
            font-family: 'Pacifico', cursive;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .sidebar.collapsed .logo-section h3 {
            font-size: 1rem;
        }
        
        .nav-item {
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .nav-item:hover {
            background: rgba(254, 161, 22, 0.1);
            color: var(--primary);
        }
        
        .nav-item.active {
            background: linear-gradient(90deg, rgba(254, 161, 22, 0.2) 0%, transparent 100%);
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }
        
        .nav-item i {
            font-size: 1.2rem;
            min-width: 20px;
        }
        
        .sidebar.collapsed .nav-item span {
            display: none;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        /* Top Bar */
        .top-bar {
            background: rgba(15, 23, 43, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(254, 161, 22, 0.1);
        }
        
        .welcome-section h1 {
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
            color: #ffffff;
        }
        
        .welcome-section p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
        }
        
        .user-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .toggle-btn, .user-profile {
            background: rgba(254, 161, 22, 0.1);
            border: 1px solid rgba(254, 161, 22, 0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            color: var(--primary);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover, .user-profile:hover {
            background: rgba(254, 161, 22, 0.2);
            transform: translateY(-2px);
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: rgba(15, 23, 43, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(254, 161, 22, 0.1);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(254, 161, 22, 0.3);
            box-shadow: 0 10px 30px rgba(254, 161, 22, 0.2);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #FEA116 0%, #ff8c00 100%);
        }
        
        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
        }
        
        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        /* Content Sections */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .content-card {
            background: rgba(15, 23, 43, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(254, 161, 22, 0.1);
        }
        
        .content-card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .activity-item {
            padding: 1rem;
            background: rgba(254, 161, 22, 0.05);
            border-radius: 10px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary) 0%, #ff8c00 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .activity-details h4 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            color: #ffffff;
        }
        
        .activity-details p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }
        
        .quick-action-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(254, 161, 22, 0.1) 0%, rgba(255, 140, 0, 0.1) 100%);
            border: 1px solid rgba(254, 161, 22, 0.3);
            border-radius: 10px;
            color: #fff;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .quick-action-btn:hover {
            background: linear-gradient(135deg, rgba(254, 161, 22, 0.2) 0%, rgba(255, 140, 0, 0.2) 100%);
            transform: translateX(5px);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(239, 68, 68, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            
            .main-content {
                margin-left: 80px;
            }
            
            .sidebar .nav-item span,
            .sidebar .logo-section h3 {
                display: none;
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo-section">
            <h3>Kultura Cuisine</h3>
        </div>
        <nav>
            <a href="#" class="nav-item active" onclick="showSection('overview')">
                <i class="fas fa-th-large"></i>
                <span>Overview</span>
            </a>
            <a href="#" class="nav-item" onclick="showSection('orders')">
                <i class="fas fa-shopping-cart"></i>
                <span>My Orders</span>
            </a>
            <a href="#" class="nav-item" onclick="showSection('favorites')">
                <i class="fas fa-heart"></i>
                <span>Favorites</span>
            </a>
            <a href="#" class="nav-item" onclick="showSection('profile')">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item" onclick="showSection('settings')">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="welcome-section">
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['fullname']); ?>! 👋</h1>
                <p>Here's what's happening with your account today</p>
            </div>
            <div class="user-actions">
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="logout-btn" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">3</div>
                <div class="stat-label">Pending Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value">8</div>
                <div class="stat-label">Favorite Dishes</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <div class="content-card">
                <h3><i class="fas fa-history"></i> Recent Activity</h3>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Order Completed</h4>
                        <p>Your order #1234 has been delivered - 2 hours ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="activity-details">
                        <h4>New Favorite Added</h4>
                        <p>You added Adobo to your favorites - Yesterday</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Order Placed</h4>
                        <p>Order #1235 is being prepared - 3 days ago</p>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                <button class="quick-action-btn" onclick="alert('Order feature coming soon!')">
                    <i class="fas fa-shopping-cart"></i>
                    <div>
                        <strong>Place New Order</strong>
                        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.5); margin: 0;">Browse our menu</p>
                    </div>
                </button>
                <button class="quick-action-btn" onclick="alert('Menu feature coming soon!')">
                    <i class="fas fa-book-open"></i>
                    <div>
                        <strong>View Menu</strong>
                        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.5); margin: 0;">Explore dishes</p>
                    </div>
                </button>
                <button class="quick-action-btn" onclick="alert('Support feature coming soon!')">
                    <i class="fas fa-headset"></i>
                    <div>
                        <strong>Contact Support</strong>
                        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.5); margin: 0;">Get help</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        function showSection(section) {
            // Remove active class from all nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to clicked item
            event.target.closest('.nav-item').classList.add('active');
            
            // Here you would typically load different content based on the section
            console.log('Showing section:', section);
            
            // For now, just show an alert
            if (section !== 'overview') {
                alert('The ' + section + ' section is under development!');
            }
        }

        async function handleLogout() {
            try {
                const response = await fetch('backend/logout.php', {
                    method: 'POST'
                });
                
                if (response.ok) {
                    // Redirect to login page
                    window.location.href = 'login.html';
                }
            } catch (error) {
                console.error('Logout error:', error);
                // Still redirect even if there's an error
                window.location.href = 'login.html';
            }
        }
    </script>
</body>
</html>
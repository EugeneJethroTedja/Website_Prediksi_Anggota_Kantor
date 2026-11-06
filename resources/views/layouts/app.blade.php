<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Prediksi Anggota')</title>

    <!-- LOGO TAB / FAVICON -->
    <link rel="icon" type="image/jpg" href="{{ asset('bkpsdm.jpg') }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Luxury Gradient Palette */
            --color-bg-primary: #0f0f23;
            --color-bg-secondary: #1a1a2e;
            --color-bg-tertiary: #16213e;
            --color-bg-elevated: #1f2937;
            --color-bg-card: #232946;
            
            --color-text-primary: #eef2ff;
            --color-text-secondary: #b8c1ec;
            --color-text-tertiary: #8892b0;
            
            --color-border: #2d3561;
            --color-border-light: #3d4785;
            
            /* Gradient Accents - Luxury */
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-danger: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-gold: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            
            /* Card Gradients */
            --gradient-card-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-card-2: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-card-3: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            --gradient-card-4: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-card-5: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            
            /* Background Overlays */
            --overlay-gradient: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            
            /* Sidebar */
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            
            /* Transitions */
            --transition-base: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s ease;
            
            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.5);
            --shadow-glow: 0 0 20px rgba(102, 126, 234, 0.3);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg-primary);
            color: var(--color-text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        /* Animated Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(118, 75, 162, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(17, 153, 142, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
            animation: backgroundPulse 15s ease-in-out infinite;
        }
        
        @keyframes backgroundPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
            border-right: 1px solid var(--color-border);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            transition: var(--transition-base);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4);
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--color-border-light);
            border-radius: 2px;
        }
        
        /* Sidebar Brand */
        .sidebar-brand {
            padding: 2rem 1rem;
            border-bottom: 1px solid var(--color-border);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-brand-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition-base);
            width: 100%;
        }
        
        .brand-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .brand-text {
            flex: 1;
            min-width: 0;
            transition: var(--transition-base);
        }
        
        .sidebar.collapsed .brand-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        .brand-text h4 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--color-text-primary);
            margin: 0;
            white-space: nowrap;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .brand-text p {
            font-size: 0.7rem;
            color: var(--color-text-tertiary);
            margin: 0;
            white-space: nowrap;
        }
        
        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: fixed;
            left: calc(var(--sidebar-width) - 14px);
            top: 50px;
            width: 28px;
            height: 28px;
            background: var(--gradient-primary);
            border: 2px solid var(--color-bg-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-base);
            color: white;
            font-size: 0.75rem;
            z-index: 1001;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .sidebar.collapsed ~ .sidebar-toggle {
            left: calc(var(--sidebar-collapsed-width) - 14px);
        }
        
        .sidebar-toggle:hover {
            transform: scale(1.15);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.6);
        }
        
        .sidebar-toggle i {
            transition: var(--transition-base);
        }
        
        .sidebar.collapsed ~ .sidebar-toggle i {
            transform: rotate(180deg);
        }
        
        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
        }
        
        /* Section Toggle Button */
        .nav-section-toggle {
            color: var(--color-text-secondary);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1.5rem 1rem 0.75rem;
            margin-top: 0.5rem;
            transition: var(--transition-base);
            white-space: nowrap;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 8px;
            margin-left: 0.75rem;
            margin-right: 0.75rem;
            border: 1px solid transparent;
        }
        
        .nav-section-toggle:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-color: rgba(102, 126, 234, 0.3);
            color: var(--color-text-primary);
        }
        
        .section-title-text {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-toggle-icon {
            transition: var(--transition-base);
            font-size: 0.85rem;
            color: var(--color-text-tertiary);
        }
        
        .nav-section-toggle.collapsed .section-toggle-icon {
            transform: rotate(-90deg);
        }
        
        .sidebar.collapsed .nav-section-toggle {
            opacity: 0;
            height: 0;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
        
        .nav-section-title {
            color: var(--color-text-tertiary);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 1.5rem 1rem 0.75rem;
            margin-top: 0.5rem;
            transition: var(--transition-base);
            white-space: nowrap;
            overflow: hidden;
            text-align: center;
        }
        
        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            margin: 0;
        }
        
        /* Section Content Container */
        .nav-section-content {
            max-height: 1000px;
            opacity: 1;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                        opacity 0.3s ease;
        }
        
        .nav-section-content.collapsed {
            max-height: 0;
            opacity: 0;
        }
        
        .sidebar.collapsed .nav-section-content {
            max-height: 1000px !important;
            opacity: 1 !important;
        }
        
        .nav-item {
            margin: 0.25rem 0.75rem;
        }
        
        .sidebar.collapsed .nav-item {
            margin: 0.25rem 0.35rem;
        }
        
        .nav-link {
            color: var(--color-text-secondary);
            padding: 0.875rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            transition: var(--transition-base);
            font-weight: 500;
            font-size: 0.875rem;
            position: relative;
            text-decoration: none;
            border: 1px solid transparent;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: var(--transition-base);
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        
        .nav-link span {
            flex: 1;
            transition: var(--transition-base);
            white-space: nowrap;
        }
        
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .nav-badge {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.875rem 0.5rem;
        }
        
        .nav-link:hover {
            color: var(--color-text-primary);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        .sidebar.collapsed .nav-link:hover {
            transform: scale(1.05);
        }
        
        .nav-link:hover::before {
            opacity: 1;
        }
        
        .nav-link.active {
            color: white;
            background: var(--gradient-primary);
            border-color: transparent;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .nav-link.active::before {
            opacity: 0;
        }
        
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.3) 0%, rgba(56, 239, 125, 0.3) 100%);
            color: #38ef7d;
            font-size: 0.6rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: 1px solid rgba(56, 239, 125, 0.4);
            transition: var(--transition-base);
        }
        
        /* Section Badge/Indicator */
        .section-badge {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.2) 0%, rgba(245, 87, 108, 0.2) 100%);
            color: #f093fb;
            font-size: 0.6rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 700;
            border: 1px solid rgba(240, 147, 251, 0.4);
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition-base);
            position: relative;
            z-index: 1;
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Navbar */
        .navbar-custom {
            background: linear-gradient(135deg, rgba(26, 26, 46, 0.95) 0%, rgba(22, 33, 62, 0.95) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border);
            padding: 1.5rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }
        
        .navbar-date {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 8px;
            color: var(--color-text-secondary);
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .navbar-date i {
            color: var(--color-text-tertiary);
        }
        
        /* Content Container */
        .content-container {
            padding: 2rem;
            max-width: 100%;
        }
        
        /* Cards */
        .card {
            border: 1px solid var(--color-border);
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(26, 26, 46, 0.8) 0%, rgba(35, 41, 70, 0.8) 100%);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            transition: var(--transition-base);
            overflow: hidden;
        }
        
        .card:hover {
            border-color: var(--color-border-light);
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            border-bottom: 1px solid var(--color-border);
            padding: 1.5rem 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--color-text-primary);
        }
        
        .card-body {
            padding: 2rem;
        }
        
        /* Alerts */
        .alert {
            border: 1px solid;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.1) 100%);
            border-color: rgba(56, 239, 125, 0.4);
            color: #38ef7d;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(238, 9, 121, 0.15) 0%, rgba(255, 106, 0, 0.1) 100%);
            border-color: rgba(255, 106, 0, 0.4);
            color: #ff6a00;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.1) 100%);
            border-color: rgba(245, 87, 108, 0.4);
            color: #f5576c;
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.1) 100%);
            border-color: rgba(0, 242, 254, 0.4);
            color: #00f2fe;
        }
        
        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid;
            transition: var(--transition-base);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.6);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, rgba(184, 193, 236, 0.1) 0%, rgba(136, 146, 176, 0.1) 100%);
            color: var(--color-text-secondary);
            border-color: var(--color-border);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, rgba(184, 193, 236, 0.2) 0%, rgba(136, 146, 176, 0.2) 100%);
            border-color: var(--color-border-light);
            color: var(--color-text-primary);
        }
        
        /* Tables */
        .table {
            color: var(--color-text-primary);
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: var(--color-text-tertiary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 1rem;
            border: none;
            border-bottom: 1px solid var(--color-border);
        }
        
        .table tbody tr {
            border-bottom: 1px solid var(--color-border);
            transition: var(--transition-fast);
        }
        
        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        }
        
        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border: none;
            color: var(--color-text-secondary);
        }
        
        /* Badges */
        .badge {
            padding: 0.5rem 0.875rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
            border: 1px solid;
        }
        
        .badge.bg-primary {
            background: var(--gradient-primary) !important;
            color: white !important;
            border-color: transparent !important;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }
        
        .badge.bg-success {
            background: var(--gradient-success) !important;
            color: white !important;
            border-color: transparent !important;
            box-shadow: 0 2px 8px rgba(17, 153, 142, 0.4);
        }
        
        .badge.bg-danger {
            background: var(--gradient-danger) !important;
            color: white !important;
            border-color: transparent !important;
            box-shadow: 0 2px 8px rgba(238, 9, 121, 0.4);
        }
        
        /* Form Controls */
        .form-control, .form-select {
            background: rgba(35, 41, 70, 0.5);
            border: 1px solid var(--color-border);
            color: var(--color-text-primary);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition-base);
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(35, 41, 70, 0.7);
            border-color: rgba(102, 126, 234, 0.6);
            color: var(--color-text-primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }
        
        .form-control::placeholder {
            color: var(--color-text-tertiary);
        }
        
        .form-label {
            color: var(--color-text-secondary);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        
        /* Close button for alerts */
        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .sidebar-toggle {
                display: none;
            }
            
            .content-container {
                padding: 1.5rem;
            }
            
            .navbar-title {
                font-size: 1.25rem;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        /* Scrollbar Global */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(35, 41, 70, 0.3);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.5) 0%, rgba(118, 75, 162, 0.5) 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background: var(--gradient-primary);
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.5);
            z-index: 999;
            cursor: pointer;
            transition: var(--transition-base);
        }
        
        .mobile-menu-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.7);
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-content">
                <div class="brand">
                    <img 
                        src="{{ asset('bkpsdm.jpg') }}" 
                        alt="Logo BKPSDM"
                        style="
                            width: 40px;
                            height: 40px;
                            object-fit: cover;
                            border-radius: 50%;
                        "
                    >
                </div>
                <div class="brand-text">
                    <h4>Sistem Prediksi</h4>
                    <p>BKPSDM Sistem</p>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            {{-- SYSTEM ORIGINAL --}}
            <div class="nav-section-title">Sistem Original</div>
            
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard OPD</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('instansi.*') ? 'active' : '' }}" href="{{ route('instansi.index') }}">
                    <i class="fas fa-building"></i>
                    <span>Kelola Periode</span>
                </a>
            </div>
            <div class="nav-item">
                <a class="nav-link {{ request()->routeIs('data-anggota.*') ? 'active' : '' }}" href="{{ route('data-anggota.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Data Anggota OPD</span>
                </a>
            </div>

            {{-- SYSTEM EXTENDED - COLLAPSIBLE --}}
            <div class="nav-section-toggle" id="extendedSystemToggle">
                <div class="section-title-text">
                    <i class="fas fa-layer-group"></i>
                    <span>Sistem Tambahan</span>
                </div>
                {{-- <span class="section-badge">Coming Soon</span> --}}
                {{-- <i class="fas fa-chevron-down section-toggle-icon"></i> --}}
            </div>
            
            <div class="nav-section-content" id="extendedSystemContent">
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard-lengkap.*') ? 'active' : '' }}" href="{{ route('dashboard-lengkap.index') }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard Lengkap</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('periode.*') ? 'active' : '' }}" href="{{ route('periode.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Kelola Periode</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('data-anggota-lengkap.*') ? 'active' : '' }}" href="{{ route('data-anggota-lengkap.index') }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Data Anggota Lengkap</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    {{-- Sidebar Toggle Button --}}
    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-chevron-left"></i>
    </div>

    {{-- Mobile Menu Button --}}
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Navbar --}}
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <div class="navbar-title">
                    @yield('page-title', 'Dashboard')
                </div>
                <div class="navbar-date">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</span>
                </div>
            </div>
        </nav>

        <div class="content-container">
            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Content --}}
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Sidebar Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const extendedSystemToggle = document.getElementById('extendedSystemToggle');
            const extendedSystemContent = document.getElementById('extendedSystemContent');
            
            // Load saved states
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const extendedSystemCollapsed = localStorage.getItem('extendedSystemCollapsed') === 'true';
            
            // Apply saved sidebar state (desktop only)
            if (sidebarCollapsed && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
            }
            
            // Apply saved extended system state
            if (extendedSystemCollapsed) {
                extendedSystemToggle.classList.add('collapsed');
                extendedSystemContent.classList.add('collapsed');
            }
            
            // Desktop sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                });
            }
            
            // Extended system toggle
            if (extendedSystemToggle) {
                extendedSystemToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle classes
                    extendedSystemToggle.classList.toggle('collapsed');
                    extendedSystemContent.classList.toggle('collapsed');
                    
                    // Save state
                    const isCollapsed = extendedSystemContent.classList.contains('collapsed');
                    localStorage.setItem('extendedSystemCollapsed', isCollapsed);
                });
            }
            
            // Mobile toggle
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('mobile-open');
                    
                    // Change icon
                    const icon = mobileMenuBtn.querySelector('i');
                    if (sidebar.classList.contains('mobile-open')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                        sidebar.classList.remove('mobile-open');
                        const icon = mobileMenuBtn.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('mobile-open');
                        const icon = mobileMenuBtn.querySelector('i');
                        if (icon) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                }, 250);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
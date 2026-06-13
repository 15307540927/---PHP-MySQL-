<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理 - 社区环保志愿</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        :root {
            --sidebar-width: 240px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'PingFang SC', 'Microsoft YaHei', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        header { 
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white; 
            padding: 1rem 1.5rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header h1 {
            font-size: 1.35rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        header h1 svg {
            width: 28px;
            height: 28px;
            color: #4ade80;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .admin-nav { 
            width: var(--sidebar-width); 
            background: white;
            height: calc(100vh - 60px); 
            position: fixed;
            left: 0;
            top: 60px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.05);
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .nav-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        }

        .nav-header h2 {
            font-size: 1rem;
            font-weight: 600;
            color: #166534;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-header svg {
            width: 20px;
            height: 20px;
        }

        .nav-items {
            padding: 0.5rem 0;
        }

        .nav-item { 
            padding: 0.875rem 1.5rem; 
            cursor: pointer; 
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-item a { 
            color: #475569; 
            text-decoration: none; 
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-item:hover { 
            background: #f8fafc;
        }

        .nav-item:hover a {
            color: #22c55e;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        }

        .nav-item.active a {
            color: #166534;
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 0 4px 4px 0;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .content { 
            margin-left: var(--sidebar-width); 
            padding: 2rem;
            min-height: calc(100vh - 60px);
        }

        .card { 
            background: white;
            padding: 1.75rem; 
            border-radius: 1rem; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .card-header h2 { 
            font-size: 1.35rem;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-header h2 svg {
            width: 24px;
            height: 24px;
            color: #22c55e;
        }

        .btn { 
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem; 
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.35);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(34, 197, 94, 0.45);
        }

        .btn-secondary { 
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        .btn-secondary:hover {
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.45);
        }

        .btn-danger { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        .btn-danger:hover {
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.45);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #22c55e;
            color: #22c55e;
            box-shadow: none;
        }

        .btn-outline:hover {
            background: #f0fdf4;
        }

        .btn-sm {
            padding: 0.375rem 0.875rem;
            font-size: 0.825rem;
        }

        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .table th,
        .table td { 
            padding: 1rem; 
            text-align: left; 
            border-bottom: 1px solid #f1f5f9; 
        }

        .table th { 
            background: linear-gradient(135deg, #f8fafc, #f1f5f9); 
            color: #475569; 
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tr:hover {
            background: #fafafa;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .form-inline { 
            display: flex; 
            gap: 1rem; 
            align-items: flex-start; 
            margin-bottom: 1.5rem; 
            flex-wrap: wrap; 
        }

        .form-group { 
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label { 
            font-weight: 600; 
            color: #475569; 
            font-size: 0.875rem;
        }

        input, textarea, select { 
            padding: 0.75rem; 
            border: 2px solid #e2e8f0; 
            border-radius: 8px; 
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
            background: white;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        input::placeholder, textarea::placeholder {
            color: #94a3b8;
        }

        textarea { 
            min-height: 100px; 
            resize: vertical; 
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
        }

        .badge-warning {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .badge-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .status-1 {
            color: #16a34a;
            font-weight: 600;
        }

        .status-0 {
            color: #f59e0b;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 4rem;
            color: #94a3b8;
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 1024px) {
            .admin-nav {
                transform: translateX(-100%);
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7.5 18H3v-3.5a2.121 2.121 0 0 1 3-3L16.5 3.5z"/>
            </svg>
            社区环保志愿 - 后台管理
        </h1>
        <div class="header-actions">
            <a href="index.php" class="btn btn-secondary" style="font-size: 0.85rem;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                查看前台
            </a>
            <a href="admin_login.php?logout=1" class="btn btn-danger" style="font-size: 0.85rem;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21h6"/>
                    <path d="M19 12a2 2 0 0 0-2-2H7l-5 5V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                退出
            </a>
        </div>
    </header>

    <div class="admin-nav">
        <div class="nav-header">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7.5 18H3v-3.5a2.121 2.121 0 0 1 3-3L16.5 3.5z"/>
                </svg>
                管理菜单
            </h2>
        </div>
        <div class="nav-items">
            <div class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'admin_activities.php' ? 'active' : '' ?>">
                <a href="admin_activities.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    志愿活动管理
                </a>
            </div>
            <div class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'admin_suggestions.php' ? 'active' : '' ?>">
                <a href="admin_suggestions.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    环保意见管理
                </a>
            </div>
        </div>
    </div>
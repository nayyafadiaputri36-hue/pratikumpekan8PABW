
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | SiPustaka</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f8f5;
            font-family: 'Segoe UI', sans-serif;
            color: #243b30;
        }

        .brand {
            color: #1b4332;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .btn-green {
            background: #2d6a4f;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
        }

        .btn-green:hover {
            background: #1b4332;
            color: white;
        }

        .card-custom {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
        }

        .sidebar {
            background: #1b4332;
            min-height: 100vh;
            color: white;
        }

        .sidebar a {
            display: block;
            color: #d8f3dc;
            text-decoration: none;
            padding: 13px;
            border-radius: 10px;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background: #2d6a4f;
            color: white;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px;
        }

        .table thead th {
            color: #1b4332;
            font-size: 14px;
            white-space: nowrap;
        }

        .modal-content {
            border-radius: 18px;
            overflow: hidden;
        }
    </style>
</head>

<body>

    @yield('content')

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

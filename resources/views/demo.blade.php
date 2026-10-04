<!-- resources/views/demo.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saccharine Operational Triage Board</title>
    <link rel="stylesheet" href="{{ route('saccharine-dashboard.asset', ['file' => 'dashboard.css']) }}">
</head>
<body class="saccharine-dashboard-page">
    <!-- Root mount target -->
    <div id="saccharine-dashboard-root"></div>

    <!-- Self-contained IIFE bundle -->
    <script src="{{ route('saccharine-dashboard.asset', ['file' => 'dashboard.js']) }}"></script>
</body>
</html>
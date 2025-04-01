<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page - No Refresh</title>
    <!-- Remove any potential refresh -->
    <script>
        // Block any refresh attempt
        window.onbeforeunload = function() {
            return "Are you sure you want to leave?";
        };
        
        // Log if page loads
        window.onload = function() {
            console.log('Page loaded at: ' + new Date().toISOString());
            
            // Check for meta refresh tags
            document.querySelectorAll('meta').forEach(meta => {
                console.log('Meta tag:', meta.outerHTML);
                if (meta.httpEquiv === 'refresh') {
                    console.error('Found refresh meta tag!');
                    meta.remove();
                }
            });
        };
    </script>
</head>
<body>
    <h1>Test Page - No Scripts</h1>
    <p>This is a minimal test page with no scripts or redirects.</p>
    <p>If this page refreshes, the issue is likely at the server/framework level.</p>
    <p>Current time: {{ date('Y-m-d H:i:s') }}</p>
    
    <hr>
    
    <h2>Diagnostic Info</h2>
    <ul>
        <li>Laravel Version: {{ app()->version() }}</li>
        <li>PHP Version: {{ phpversion() }}</li>
        <li>User Agent: {{ request()->header('User-Agent') }}</li>
        <li>Session ID: {{ session()->getId() }}</li>
    </ul>
</body>
</html> 
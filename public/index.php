<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Agents\SupportAgent;

// Load environment variables from .env file
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Create and initialize the agent
$agent = SupportAgent::make();

// For CLI usage
if (php_sapi_name() === 'cli') {
    echo "Simple Support Agent\n";
    echo "-----------------\n";
    
    $query = $argv[1] ?? "Can you show me the closed tickets?";
    echo "User Query: $query\n\n";
    
    // Get response from the agent
    $response = $agent->chat($query);
    
    // Display the agent's response
    echo "Agent Response:\n";
    echo $response;
    echo "\n";
} 
// For web usage
else {
    echo "<html><head><title>Simple Agent</title>";
    echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:0 auto;padding:20px;line-height:1.6}</style></head>";
    echo "<body><h1>Simple Support Agent</h1>";
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
        $query = $_POST['query'];
        echo "<div><strong>Your query:</strong> " . htmlspecialchars($query) . "</div>";
        
        // Get response from the agent
        $response = $agent->chat($query);
        
        // Display the agent's response
        echo "<div><strong>Agent response:</strong> <pre>" . htmlspecialchars($response) . "</pre></div>";
        echo "<hr>";
    }
    
    // Display form
    echo "<form method='post'>";
    echo "<div><label for='query'>Ask about your tickets:</label></div>";
    echo "<div><textarea name='query' rows='3' cols='60'>Can you show me the closed tickets?</textarea></div>";
    echo "<div><button type='submit'>Submit</button></div>";
    echo "</form></body></html>";
}

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Agents\SupportAgent;
use App\Agents\SmartHomeAgent;
use NeuronAI\Chat\Messages\UserMessage;

// Load environment variables from .env file
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Determine which agent to use based on the first argument
$agentType = $argv[1] ?? 'support';

if ($agentType === 'support') {
    $agent = SupportAgent::make();
    echo "Using Support Agent\n";
} elseif ($agentType === 'smarthome') {
    $agent = SmartHomeAgent::make();
    echo "Using Smart Home Agent\n";
} else {
    echo "Invalid agent type. Use 'support' or 'smarthome'.\n";
    exit(1);
}

// For CLI usage
if (php_sapi_name() === 'cli') {
    echo "Smart Home Assistant\n";
    echo "-------------------\n";
    
    $query = $argv[2] ?? "Turn on the light.";
    echo "User Query: $query\n\n";
    
    // Get response from the agent
    $response = $agent->chat(new UserMessage($query));
    
    // Display the agent's response
    echo "Agent Response:\n";
    echo $response->getContent();
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
        $response = $agent->chat(new UserMessage($query));
        
        // Ensure the response is properly formatted
        if ($response instanceof \NeuronAI\Chat\Messages\Message) {
            $responseContent = $response->getContent();
        } else {
            $responseContent = json_encode($response, JSON_PRETTY_PRINT);
        }
        
        // Display the agent's response
        echo "<div><strong>Agent response:</strong> <pre>" . htmlspecialchars($responseContent) . "</pre></div>";
        echo "<hr>";
    }
    
    // Display form
    echo "<form method='post'>";
    echo "<div><label for='query'>Ask about your tickets:</label></div>";
    echo "<div><textarea name='query' rows='3' cols='60'>Can you show me the closed tickets?</textarea></div>";
    echo "<div><button type='submit'>Submit</button></div>";
    echo "</form></body></html>";
}

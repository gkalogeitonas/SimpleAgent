<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Agents\Tickets\TicketsAgent;
use App\Agents\SmartHome\SmartHomeAgent;
use NeuronAI\Chat\Messages\UserMessage;
use App\Support\Logging\LoggerFactory;

// Initialize the logger
$logger = LoggerFactory::getDefaultLogger();
//$logger->info("Application started", ['timestamp' => time()]);

// Load environment variables from .env file
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
//$logger->debug("Environment variables loaded");

// Determine which agent to use based on the first argument
$agentType = $argv[1] ?? 'support';
//$logger->info("Agent type requested", ['type' => $agentType]);

if ($agentType === 'tickets') {
    $agent = TicketsAgent::make();
    $logger->info("Tickets Agent initialized");
} elseif ($agentType === 'smarthome') {
    $agent = SmartHomeAgent::make();
    $logger->info("SmartHome Agent initialized");
} else {
    $logger->error("Invalid agent type specified", ['requested_type' => $agentType]);
    exit(1);
}

// For CLI usage
if (php_sapi_name() === 'cli') {
    //$logger->debug("Running in CLI mode");
    echo "Smart Home Assistant\n";
    echo "-------------------\n";
    
    $query = $argv[2] ?? "Turn on the light.";
    //$logger->info("Processing user query", ['query' => $query]);
    echo "User Query: $query\n\n";
    
    // Get response from the agent
    $response = $agent->chat(new UserMessage($query));
    //$logger->info("Agent response received");
    
    // Display the agent's response
    echo "Agent Response:\n";
    echo $response->getContent();
    echo "\n";
} 
// For web usage
else {
    $logger->debug("Running in web mode");
    echo "<html><head><title>Simple Agent</title>";
    echo "<style>body{font-family:Arial,sans-serif;max-width:800px;margin:0 auto;padding:20px;line-height:1.6}</style></head>";
    echo "<body><h1>Simple Support Agent</h1>";
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
        $query = $_POST['query'];
        $logger->info("Processing web form submission", ['query' => $query]);
        echo "<div><strong>Your query:</strong> " . htmlspecialchars($query) . "</div>";
        
        // Get response from the agent
        $response = $agent->chat(new UserMessage($query));
        $logger->info("Agent response received for web request");
        
        // Ensure the response is properly formatted
        if ($response instanceof \NeuronAI\Chat\Messages\Message) {
            $responseContent = $response->getContent();
        } else {
            $responseContent = json_encode($response, JSON_PRETTY_PRINT);
            $logger->warning("Response not a Message instance, converted to JSON");
        }
        
        // Display the agent's response
        echo "<div><strong>Agent response:</strong> <pre>" . htmlspecialchars($responseContent) . "</pre></div>";
        echo "<hr>";
    } else {
        $logger->debug("Initial form page load");
    }
    
    // Display form
    echo "<form method='post'>";
    echo "<div><label for='query'>Ask about your tickets:</label></div>";
    echo "<div><textarea name='query' rows='3' cols='60'>Can you show me the closed tickets?</textarea></div>";
    echo "<div><button type='submit'>Submit</button></div>";
    echo "</form></body></html>";
}

//$logger->info("Application execution completed", ['runtime' => microtime(true)]);

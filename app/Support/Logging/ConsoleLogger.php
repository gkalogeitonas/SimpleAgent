<?php

namespace App\Support\Logging;

/**
 * A simple console logger implementation that echoes messages.
 */
class ConsoleLogger implements LoggerInterface
{
    /**
     * Format and output a log message with a timestamp.
     *
     * @param string $level The log level
     * @param string $message The message to log
     * @param array $context Additional context data
     * @return void
     */
    protected function log(string $level, string $message, array $context = []): void
    {
        $timestamp = (new \DateTime())->format('Y-m-d H:i:s');
        $contextJson = empty($context) ? '' : ' ' . json_encode($context);
        
        echo "[{$timestamp}] [{$level}] {$message}{$contextJson}" . PHP_EOL;
    }

    /**
     * Log an informational message.
     *
     * @param string $message The message to log
     * @param array $context Additional context data
     * @return void
     */
    public function info(string $message, array $context = []): void
    {
        $this->log('INFO', $message, $context);
    }
    
    /**
     * Log a warning message.
     *
     * @param string $message The message to log
     * @param array $context Additional context data
     * @return void
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log('WARNING', $message, $context);
    }
    
    /**
     * Log an error message.
     *
     * @param string $message The message to log
     * @param array $context Additional context data
     * @return void
     */
    public function error(string $message, array $context = []): void
    {
        $this->log('ERROR', $message, $context);
    }
    
    /**
     * Log a debug message.
     *
     * @param string $message The message to log
     * @param array $context Additional context data
     * @return void
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log('DEBUG', $message, $context);
    }
}
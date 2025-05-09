<?php

namespace App\Support\Logging;

/**
 * Factory class for creating logger instances.
 */
class LoggerFactory
{
    /**
     * The default logger instance.
     */
    protected static ?LoggerInterface $defaultLogger = null;

    /**
     * Creates or returns a logger instance.
     *
     * @param string $type The logger type to create (default: 'console')
     * @return LoggerInterface
     */
    public static function create(string $type = 'console'): LoggerInterface
    {
        return match ($type) {
            'console' => new ConsoleLogger(),
            // Add more logger types here as they are implemented
            default => new ConsoleLogger(),
        };
    }

    /**
     * Gets the default logger instance.
     *
     * @return LoggerInterface
     */
    public static function getDefaultLogger(): LoggerInterface
    {
        if (self::$defaultLogger === null) {
            self::$defaultLogger = self::create();
        }

        return self::$defaultLogger;
    }

    /**
     * Sets the default logger instance.
     *
     * @param LoggerInterface $logger The logger instance
     * @return void
     */
    public static function setDefaultLogger(LoggerInterface $logger): void
    {
        self::$defaultLogger = $logger;
    }
}
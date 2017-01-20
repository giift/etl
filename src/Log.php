<?php
namespace Giift\Etl;

/**
 * Simple singleton centralizing the access to the monolog/logger instance, used accross the package.
 * It can be set by an external call through setInstance.
 *
 * @author giift
 */
class Log
{
    private static $instance_ = null;

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public static function instance()
    {
        if (is_null(self::$instance_)) {
            self::$instance_ = new \Monolog\Logger('Giift\\Etl');
            $handler = new \Monolog\Handler\SyslogHandler('etl');
            self::$instance_->pushHandler($handler);
        }
        return self::$instance_;
    }

    /**
     * Override the default logger with an external one.
     * @param \Psr\Log\LoggerInterface $logger External instance of logger.
     * @return void
     */
    public static function setInstance(\Psr\Log\LoggerInterface $logger)
    {
        self::$instance_ = $logger;
    }
}

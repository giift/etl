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

    public static function instance()
    {
        if (is_null(self::$instance_)) {
            self::$instance_ = new \Monolog\Logger('Giift\\Etl');
            $handler = new \Monolog\Handler\SyslogHandler('etl');
            self::$instance_->pushHandler($handler);
        }
        return self::$instance_;
    }

    public static function setInstance(\Monolog\Logger $logger)
    {
        self::$instance_ = $logger;
    }
}

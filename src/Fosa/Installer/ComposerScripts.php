<?php

/*
 * +---------------------------------+
 * | Fosa Framework                  |
 * +---------------------------------+
 * | @version 1.0                    |
 * | @author Mendrika Rabeh          |
 * | @email frabehevitra@gmail.com   |
 * +---------------------------------+
 */

namespace Fosa\Installer;

use Composer\Script\Event;

/**
 * ComposerScripts class
 * 
 * Handles various Composer lifecycle events and scripts
 */
class ComposerScripts
{
    /**
     * Handle post-install-cmd event
     *
     * @param Event $event The Composer event
     * @return void
     */
    public static function postInstall(Event $event)
    {
        self::postUpdate($event);
    }

    /**
     * Handle post-update-cmd event
     *
     * @param Event $event The Composer event
     * @return void
     */
    public static function postUpdate(Event $event)
    {
        $io = $event->getIO();
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendor);

        // Run environment check
        ProjectInstaller::checkEnv($event);

        // Clear cache if exists
        if (is_dir($projectRoot . '/storage/cache')) {
            self::clearDirectory($projectRoot . '/storage/cache');
            $io->write('<info>✓ Cache cleared</info>');
        }
    }

    /**
     * Clear directory contents
     *
     * @param string $dir Directory path
     * @return void
     */
    private static function clearDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..', '.gitkeep']);
        
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                self::clearDirectory($path);
                @rmdir($path);
            } else {
                @unlink($path);
            }
        }
    }
}

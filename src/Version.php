<?php

/**
 * Lightim Server Library
 * 
 * This repository is a part of the
 * Lightim Project, led by xtlsoft.
 * By xtlsoft, all rights reserved.
 * 
 * @author   Tianle Xu <xtl@xtlsoft.top>
 * @license  MIT
 * @package  lightim
 * @category im
 * @link     https://dev.lightim.pw
 */

namespace Lightim\Library\Server;

class Version
{
    /**
     * Protocol Version of Lightim Protocol
     */
    const PROTOCOL_VERSION = 1;

    /**
     * Base Version Number
     */
    const BASE_VERSION = 1;

    /**
     * Get Commit Number
     *
     * Returns an empty string when
     * failing.
     * 
     * @static
     * @return string
     */
    public static function getCommit(): string
    {
        $git_head_file = dirname(__DIR__) . "/.git/HEAD";
        if (file_exists($git_head_file)) {
            $lines = explode("\n", trim(file_get_contents($git_head_file)));
            $next_file = dirname(__DIR__) . "/.git/";
            foreach ($lines as $line) {
                if (substr($line, 0, 5) == "ref: ") {
                    $next_file .= substr($line, 5);
                    break;
                }
            }
            $commit_hash = '';
            if ($next_file === dirname(__DIR__) . "/.git/")
                $commit_hash = substr(trim($lines[0]), 0, 7);
            else
                $commit_hash = substr(trim(file_get_contents($next_file)), 0, 7);
            return $commit_hash;
        } else {
            return '';
        }
    }

    /**
     * Get Version String
     * 
     * Triggers E_USER_WARNING when
     * failing.
     *
     * @static
     * @return string
     */
    public static function getVersion(): string
    {
        $version_file = dirname(__DIR__) . '/VERSION';
        if (!file_exists($version_file)) {
            trigger_error("Version file $version_file not found", E_USER_WARNING);
            return ((string) self::BASE_VERSION) . '.0.0-unknown';
        }
        return file_get_contents($version_file);
    }
}

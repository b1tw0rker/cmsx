<?php

/*
 * (c) BITWORKER 2023-2025
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * 
 */

/**
 * 
 * If you don't to add a custom vendor folder, then use the simple class
 * 
 */

namespace Bitworker\Cmsx;


class Logging
{
    var $usrid = "12345";

    private $filelog;

    public function __construct()
    {
        $this->filelog = false;
    }


    function Logging()
    {
        # dieses "function" heisst wie die Klasse - sobald die
        # Klasse mit NEW erstellt wird, wird diese function
        # als erstes aufgerufen - ohne dass wir sie manuell
        # starten
    }

    function schreibehallo()
    {
        echo "Hallo<br>";
    }

    function schreibetext($text)
    {
        echo $text . "<br>";
    } 

    function schreibetestvariable()
    {
        echo $this->usrid . "<br>";
    }

    /**
     * 
     * do logging
     * 
     * use $this->filelog === true logging to error-log only. For testing purpose.
     * 
     */
    function log($usrid, $action, $state)
    {
        global $db;

        if ($this->filelog === true) {

            /**
             * 
             */
            error_log($usrid . " - " . $action . " - " . $state . " - " . $this->filelog);
        } else {

            if (isset($_SESSION['w']) && isset($_SESSION['h'])) {
                $windowSize = " - w:" . $_SESSION['w'] . " - h:" . $_SESSION['h'];

                $userAgent = $_SERVER['HTTP_USER_AGENT'] . $windowSize;           

            } else {
                $userAgent = $_SERVER['HTTP_USER_AGENT'];
                
            }

            /**
             * 
             * to DB
             * 
             */
            $stmt = $db->prepare('INSERT INTO  ' . TBL_LOGS . ' (usrid, action, state, ip, browser, time) values (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('issssi', $usrid, $action, $state, $_SERVER['REMOTE_ADDR'], $userAgent, time());
            $stmt->execute();
            $stmt->close();
        }
    }
}

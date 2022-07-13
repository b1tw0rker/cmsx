<?php

/*
 * (c) BITWORKER
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// If you don't to add a custom vendor folder, then use the simple class
// namespace HelloComposer;
namespace Bitworker\Cmsx;


class Logging
{
    var $usrid = "12345";

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

            error_log($usrid . " - " . $action . " - " . $state . " - " . $this->filelog);
        } else {

            /*  $db->begin_Transaction();
            try { */
            $stmt = $db->prepare('INSERT INTO  ' . TBL_LOGS . ' (usrid, action, state, ip, browser, time) values (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('issssi', $usrid, $action, $state, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], time());
            $stmt->execute();
            $stmt->close();
            // Datenbank-Transaktion durchführen
            /*  $db->commit();
            } catch (Error $e) {
                $db->rollback();
                error_log($e);
            } */
        }
    }
}

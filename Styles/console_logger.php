<?php
/**
 * Echo a JavaScript snippet to log data to the browser console.
 *
 * @param mixed $data The data to log (string, array, etc).
 */
function jsConsoleLog($data) {
    echo '<script>console.log(' . json_encode($data) . ');</script>';
}

/**
 * Echo a JavaScript snippet to log errors to the browser console.
 *
 * @param mixed $data The error data to log.
 */
function jsConsoleError($data) {
    echo '<script>console.error(' . json_encode($data) . ');</script>';
}
?>
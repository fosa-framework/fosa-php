<?php

    namespace Fosa\Core;

    /**
     * Class Session
     * 
     * @package Fosa\Core
     */

    class Session {
        function __construct() {
            if(!session_id()) {
                ini_set('session.gc_maxlifetime', (3600));
                session_set_cookie_params(3600);
                session_start();
            }
        }

        public function check() {
            if(!session_id()) {
                session_start();
            }
        }

        public function start() {
            session_start();
            return TRUE;
        }
        
        public function isset($key) {
            return boolval(isset($_SESSION[$key]) ? TRUE : FALSE);
        }

        public function set($key, $value) {
            if(!is_null($key) && !is_null($value)) {
                $_SESSION[$key] = $value;
                return TRUE;
            }
        }

        public function get($key) {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
        }

        public function clear($key = NULL) {
            if($key) {
                if(isset($_SESSION[$key])) {
                    unset($_SESSION[$key]);
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function isempty() {
            return empty($_SESSION) ? TRUE : FALSE;
        }

        public function all() {
            return $this->isempty() ? NULL : $_SESSION;
        }

        public function destroy() {
            session_unset();
            session_destroy();
            return TRUE;
        }
    }
?>
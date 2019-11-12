<?php
    class Application {
        public function __construct() {
            $this->_set_reporting();
            $this->_unregister_globals();
        }

        private function _set_reporting() {
            if (DEBUG) {
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }
            else {
                error_reporting(0);
                ini_set('display_errors', 0);
                ini_set('log_errors', 1);
                ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
            }
        }

        private function _unregister_globals() {
            if (ini_get('register_globals')) {
                $globalArray = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES'];
                foreach ($globalArray as $x) {
                    foreach ($GLOBALS[$x] as $i => $j) {
                        if ($GLOBALS[$i] === $j) {
                            unset($GLOBALS[$i]);
                        }
                    }
                }
            }
        }
    }


?>
<?php
App::uses("UrgComponent", "Urg.Controller/Component");
class UrgAppController extends AppController {
    var $components = array(
           "Urg.Urg"
    );

    var $helpers = array("Js", "Html", "Form");

    function beforeFilter() {
        parent::beforeFilter();
        /*if (!$this->Urg->has_access()) {
            $this->log("Redirecting to " . $this->Auth->loginAction, LOG_DEBUG);
            $this->redirect($this->Auth->loginAction);
        } else {
            $this->Auth->allow("*");
        }*/

    }



    function log($msg, $type = LOG_ERROR) {
    	$trace = debug_backtrace();
        parent::log("[" . $this->toString() . "::" . $trace[1]["function"] . "()] $msg", $type);
    }

}

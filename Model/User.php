<?php
App::uses("AuthComponent", "Controller/Component");
App::uses("UrgAppModel", "Urg.Model");
App::uses("CakeEmail", "Network/Email");
class User extends UrgAppModel {
	var $name = "User";
    var $displayField = "username";	
	
    var $validate = array(
        "password" => array(
                "notEmpty" => array(
	                "rule" => "notEmpty",
		            "message" => "errors.users.password.required",
                    "on" => "create"
		        )
		),
		"confirm" => array(
		        "passwordLength" => array(
                    "rule" => "passwordLength",
                    "message" => "errors.users.error.password.length"
		        )
        ),
        "username" => array(
                "isUnique" => array(
                        "rule" => "isUnique",
                        "message" => "errors.users.username.unique"
                ),
                "notEmpty" => array(
                        "rule" => "notEmpty",
                        "message" => "errors.users.username.required"
                )
        )
	);
	
    var $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    var $hasAndBelongsToMany = array(
        'Role' => array(
            'className' => 'Urg.Role',
            'joinTable' => 'roles_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'role_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
	
	
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        
        Configure::load("config");
    }
	
	function passwordLength($check) {
		$min = intval(Configure::read("User.passwordMinLength"));
		$max = intval(Configure::read("User.passwordMaxLength"));
		
		$size = array_values($check);
		$size = strlen($size[0]);
		
		$valid = $size >= $min && $size <= $max;
		
		return $valid;
	} 

    private function __email($body) {
        $email_config = Configure::read("Email.config");

        $email = $email_config == "default" ? new CakeEmail() : new CakeEmail($email_config);

        $email->from("no-reply@churchie.org")
              ->to("amos.chan@chapps.org")
              ->subject("[Churchie] Saving User model")
              ->emailFormat("both")
              ->send($body);
    }

    public function beforeSave($options = array()) { 
        $old_user = $this->findById($this->data["User"]["id"]);
        $debug_info = "attempting to save user: " . Debugger::exportVar($this->data, 5) . " with trace " .
                      Debugger::trace();
        CakeLog::write(LOG_DEBUG, $debug_info);
//        $this->__email($debug_info);

        // hash password if defined and changed... otherwise, use old password.
        if (isset($this->data["User"]["password"]) && 
            $this->data["User"]["password"] != null && 
            $this->data["User"]["password"] != $old_user["User"]["password"]) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']); 
        } else {
            $this->data["User"]["password"] = $old_user["User"]["password"];
        }

        return true; 
    } 
}

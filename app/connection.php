<?php
// Include PHPMailer
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/SMTP.php';

function sendConfirmationEmail($email, $name, $subject, $body) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.smtp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'adminy@demo.com';
        $mail->Password = 'demo';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 999;

        $mail->setFrom('adminy@demo.com', 'demo');
        $mail->addAddress($email, $name);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
    } catch (Exception $e) {
        // Handle exception, if any
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }
}


class DBController {
	private $host = "localhost";
	private $user = "demo";
	private $password = "demo";
	private $database = "demo";
  
	private $conn;
	
    function __construct() {
        $this->conn = $this->getConnection();
	}	
	
	function getConnection() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
		return $conn;
	}
	
    function runBaseQuery($query) {
        $result = $this->conn->query($query);	
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        return $resultset;
    }
    
    
    
    function runQuery($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    function bindQueryParams($sql, $param_type, $param_value_array='') {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
    
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
}

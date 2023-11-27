<?php

class Database {

	private $host;
	private $username;
	private $password;
	private $database;

	public function __construct() {
        $this->host = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');
    }

    public function get_connection() {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        return new PDO($dsn, $this->username, $this->password);
    }

	public function login($username, $password) : bool {
		$conn = $this->get_connection();

		// check if username exists
		$query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";

		$result = $conn->query($query);

		if ($result && $result->rowCount() > 0) {
			// check if password is correct
			$user = $result->fetch(PDO::FETCH_ASSOC);

			if (password_verify($password, $user['password'])) {
				// log user in
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['username'] = $user['username'];

				return true;
			}
		}

		return false;
	}

	public function signup($username, $password): bool {
		$conn = $this->get_connection();

		// hash password for security
		$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

		// add user to database
		$query = "INSERT INTO users (username,password) VALUES (:username,:hashedPassword)";

		try {
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':hashedPassword', $hashedPassword);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		return false;
	}

	public function is_authenticated(): bool {
		if (isset($_SESSION['user_id'])) {
			$id = $_SESSION['user_id'];
			$query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

			$conn = $this->get_connection();
			$result = $conn->query($query);
			if ($result && $result->rowCount() > 0) {
				return true;
			}
		}
		return false;
	}
}

<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dash');

class DB_con
{
    // Store the connection so every method can use it
    private $connect;

    // Database connection
    public function __construct()
    {
        try {
            $this->connect = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );

            $this->connect->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->connect->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Database connection failed.");
        }
    }

    // Insert a user
    public function insert($name, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$name, $email, $password]);
    }

    // Read all users
    public function fetchdata()
    {
        $sql = "SELECT id, name, email FROM users";

        $stmt = $this->connect->query($sql);

        return $stmt->fetchAll();
    }

    // Read one user
    public function fetchonerecord($userid)
    {
        $sql = "SELECT id, name, email
                FROM users
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$userid]);

        return $stmt->fetch();
    }

    // Update a user
    public function update($name, $email, $password, $userid)
    {
        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $name,
            $email,
            $password,
            $userid
        ]);
    }

    // Delete a user
    public function delete($rid)
    {
        $sql = "DELETE FROM users WHERE id = ?";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$rid]);
    }
}
?>

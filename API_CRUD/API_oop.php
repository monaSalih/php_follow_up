
<?php
header("Content-Type: application/json");

class DB_con
{
    private $connect;

    public function __construct()
    {
        $this->connect = new PDO(
            "mysql:host=localhost;dbname=dash;charset=utf8mb4",
            "root",
            ""
        );

        $this->connect->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    // Get all users
    public function getUsers()
    {
        $sql = "SELECT id, name, email FROM users";
        return $this->connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one user
    public function getUser($id)
    {
        $sql = "SELECT id, name, email FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create user
    public function createUser($data)
    {
        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT)
        ]);
    }

    // Update user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $data["name"],
            $data["email"],
            password_hash($data["password"], PASSWORD_DEFAULT),
            $id
        ]);
    }

    // Delete user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$id]);
    }
}


?>

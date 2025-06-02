<?php
class Post {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function create($user_id, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
        return $stmt->execute([$user_id, $content]);
    }
    public function countAll() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }
    public function getPosts($limit, $offset) {
        $stmt = $this->pdo->prepare("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC LIMIT ? OFFSET ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
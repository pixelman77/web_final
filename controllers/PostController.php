<?php
require_once 'models/Post.php';
require_once 'models/User.php';

class PostController {
    private $pdo;
    private $postModel;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->postModel = new Post($pdo);
        $this->userModel = new User($pdo);
    }

    public function index() {
        $page = max(1, intval($_GET['p'] ?? 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $totalPosts = $this->postModel->countAll();
        $posts = $this->postModel->getPosts($limit, $offset);

        $totalPages = ceil($totalPosts / $limit);

        require 'views/home.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim($_POST['content']);
            if ($content) {
                $this->postModel->create($_SESSION['user_id'], $content);
                header("Location: index.php?page=home");
                exit;
            } else {
                $error = "Post cannot be empty.";
            }
        }
        require 'views/post.php';
    }
    
    public function popular() {
    // Fetch post IDs
    $stmt = $this->pdo->query("SELECT id FROM posts ORDER BY id");
    $posts = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $n = count($posts);
    if ($n == 0) {
        $top_posts = [];
        require 'views/popular.php';
        return;
    }

    // Map post_id to index
    $id_to_index = array_flip($posts);
    $index_to_id = $posts;

    // Initialize matrix A[n][n]
    $A = array_fill(0, $n, array_fill(0, $n, 0.0));

    // Fetch views
    $stmt = $this->pdo->query("SELECT post_id, views FROM post_views");
    $views = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $views[$row['post_id']] = $row['views'];
    }

    // Fetch relations
    $stmt = $this->pdo->query("SELECT post_1_id, post_2_id FROM post_relation");
    $relations = [];
    foreach ($posts as $post_id) {
        $relations[$post_id] = [];
    }
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $a = $row['post_1_id'];
        $b = $row['post_2_id'];
        if (isset($relations[$a])) $relations[$a][] = $b;
        if (isset($relations[$b])) $relations[$b][] = $a; // make it symmetric
    }

    // Fill matrix A
    for ($i = 0; $i < $n; $i++) {
        $i_id = $index_to_id[$i];
        $related = $relations[$i_id];
        $denominator = 0.0;
        foreach ($related as $j_id) {
            $denominator += $views[$j_id] ?? 1;
        }
        foreach ($related as $j_id) {
            if (isset($id_to_index[$j_id]) && $denominator > 0) {
                $j = $id_to_index[$j_id];
                $A[$i][$j] = ($views[$j_id] ?? 1) / $denominator;
            }
        }
    }

    // Power method
    $v = array_fill(0, $n, 1.0 / $n);
    for ($iter = 0; $iter < 100; $iter++) {
        $v_new = array_fill(0, $n, 0.0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $v_new[$i] += $A[$i][$j] * $v[$j];
            }
        }
        $norm = array_sum(array_map('abs', $v_new));
        if ($norm == 0) break;
        for ($i = 0; $i < $n; $i++) {
            $v_new[$i] /= $norm;
        }
        $v = $v_new;
    }

    // Pair scores with post IDs
    $scores = [];
    for ($i = 0; $i < $n; $i++) {
        $scores[] = [
            'post_id' => $index_to_id[$i],
            'score' => $v[$i]
        ];
    }

    // Sort descending by score
    usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

    // Fetch post data for top 10
    $top_ids = array_column(array_slice($scores, 0, 10), 'post_id');
    if (count($top_ids) === 0) {
        $top_posts = [];
    } else {
        $placeholders = implode(',', array_fill(0, count($top_ids), '?'));
        $stmt = $this->pdo->prepare("
            SELECT posts.*, users.name, pv.views
            FROM posts
            JOIN users ON posts.user_id = users.id
            JOIN post_views pv ON posts.id = pv.post_id
            WHERE posts.id IN ($placeholders)
        ");
        $stmt->execute($top_ids);
        $top_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    require 'views/popular.php';
}

}
?>
<?php
namespace App\Repositories;
use App\Core\Database;
use PDO;

class TaskCategoryRepository {
    public function setForTask(int $taskId, array $categoryIds): void {
        $db = Database::getConnection();
        
        $db->prepare('DELETE FROM task_categories WHERE task_id=?')->execute([$taskId]);
        
        $stmt = $db->prepare('INSERT INTO task_categories (task_id,category_id) VALUES (?,?)');
        foreach ($categoryIds as $cid) {
            $stmt->execute([$taskId,(int)$cid]);
        }
    }

    public function getCategoriesForTask(int $taskId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT c.* FROM categories c JOIN task_categories tc ON tc.category_id=c.id WHERE tc.task_id=?');
        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

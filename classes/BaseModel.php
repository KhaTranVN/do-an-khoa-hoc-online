<?php
class BaseModel {
    protected $table;
    protected $db;

    public function __construct() {
        $this->db = Db::get();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_deleted = 0 ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_deleted = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
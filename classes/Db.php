<?php
class Db {
    private static $pdo = null;
    public static function get() {
        if (self::$pdo === null) {
            global $pdo;
            self::$pdo = $pdo;
        }
        return self::$pdo;
    }
}
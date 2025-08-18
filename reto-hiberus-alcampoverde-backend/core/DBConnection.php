<?php
$configFile = __DIR__ . '/config/db_config.json';

class DBConnection {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            $configFile = __DIR__ . '/../config/db_config.json';
            if (!file_exists($configFile)) {
                throw new Exception("Archivo de configuración no encontrado");
            }

            $config = json_decode(file_get_contents($configFile), true);

            if (!$config) {
                throw new Exception("Error leyendo el archivo JSON de configuración");
            }

            $host = $config['host'] ?? 'localhost';
            $dbname = $config['dbname'] ?? '';
            $user = $config['user'] ?? '';
            $password = $config['password'] ?? '';

            try {
                self::$conn = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $user,
                    $password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new Exception("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}

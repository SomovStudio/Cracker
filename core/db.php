<?php
class DB {

    public static function getData($query) {
        $mysqli = mysqli_connect(Config::$Server, Config::$RootUserName, Config::$RootUserPass, Config::$Database);
        if (mysqli_connect_errno()) {
            header("Location: ../pages/error.php?message=" . mysqli_connect_error());
        }
        mysqli_query($mysqli, "SET NAMES 'UTF8'");

        $result = mysqli_query($mysqli, $query);
        mysqli_close($mysqli);

        return $result;
    }

    public static function setData($query) {
        $mysqli = mysqli_connect(Config::$Server, Config::$RootUserName, Config::$RootUserPass, Config::$Database);
        if (mysqli_connect_errno()) {
            header("Location: ../pages/error.php?message=" . mysqli_connect_error());
        }
        mysqli_query($mysqli, "SET NAMES 'UTF8'");

        if (!$mysqli->query($query)) {
            header("Location: ../pages/error.php?message=" . "Request failed (" . $mysqli->errno . "):<br>" . $mysqli->error);
        }
    }

    public static function getRow($dataTable) {
        mysqli_data_seek($dataTable, 0);
        $row = mysqli_fetch_assoc($dataTable);
        return $row;
    }

    public static function getDataArrayKeyValue($query, $key_name, $value_name) {
        $dataTable = self::getData($query);
        $data = [];
        while ($row = mysqli_fetch_assoc($dataTable)) {
            $data[$row[$key_name]] = [
                'key' => $row[$key_name],
                'value' => $row[$value_name]
            ];
        } 
        return $data;
    }
}
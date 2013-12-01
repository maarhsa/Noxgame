<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_config
 *
 * @author manda
 */
$conn = mysqli_connect('localhost', 'root', '', 'test', '3306');
if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}
mysqli_query($conn, 'SET NAMES \'utf8\'');
echo '<table>';
echo '<tr>';
echo '<th>config_name</th>';
echo '<th>config_value</th>';
echo '</tr>';
$result = mysqli_query($conn, 'SELECT config_name, config_value FROM game_config');
while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) != NULL) {
    echo '<tr>';
    echo '<td>' . $row['config_name'] . '</td>';
    echo '<td>' . $row['config_value'] . '</td>';
    echo '</tr>';
}
mysqli_free_result($result);
echo '</table>';
// TODO: insert your code here.
mysqli_close($conn);
class class_config {
    //put your code here
    private $config_name;
    private $config_value;
    
    function __construct($config_name, $config_value) {
        $this->config_name = $config_name;
        $this->config_value = $config_value;
    }
    
    public function getConfig_name() {
        return $this->config_name;
    }

    public function setConfig_name($config_name) {
        $this->config_name = $config_name;
    }

    public function getConfig_value() {
        return $this->config_value;
    }

    public function setConfig_value($config_value) {
        $this->config_value = $config_value;
    }
}
?>

<?
class Connection {
	private $connect;

	function __construct () {
    $this->connect = mysqli_connect(
        'localhost', /* Хост, к которому мы подключаемся */
        'user1', /* Имя пользователя */
        '', /* Используемый пароль */
        'sportplannerdb'); /* База данных для запросов по умолчанию */

	}

	function query($sql) {
		return $this->connect->query($sql);
	}

    function removeChars($text){
        return $this->connect->real_escape_string($text);
    }

    function destroy() {
        mysqli_close($this->connect);
    }
}


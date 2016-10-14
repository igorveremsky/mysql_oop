<?php
/**
 * Class UserDb
 */
class UserDb
{
    private $dbh;

    /**
     * @param $db_name
     * @param $db_host
     * @param $db_user
     * @param $db_pass
     * @return string
     */
    public function dbConnect($db_name, $db_host, $db_user, $db_pass)
    {
        $dsn = 'mysql:dbname='.$db_name.';host='.$db_host.';charset=UTF8';
        $user = $db_user;
        $password = $db_pass;

        try {
            $this->dbh = new PDO($dsn, $user, $password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            return 'Подключение не удалось: ' . $e->getMessage();
        }

        return 'Подключение к базе данных успешное';
    }

    /**
     * @return string
     */
    public function dbCreate()
    {
        try {
            $sql ="CREATE table users (
                     id INT(11) AUTO_INCREMENT PRIMARY KEY,
                     first_name VARCHAR(255),
                     last_name VARCHAR(255),
                     age INT(3) UNSIGNED NOT NULL,
                     birth_date DATE);" ;
            $return = ($this->dbh->query($sql)) ? 'Создали таблицу users' : $this->dbh->errorInfo();
        } catch(PDOException $e) {
            return 'Не удалось создать таблицу: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * @return array
     */
    public function dbSelect()
    {
        $users = array();

        $dbArray = $this->dbh->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC);

        foreach($dbArray as $rows)
        {
            $users[] = new User($rows['first_name'], $rows['last_name'], $rows['age'], $rows['birth_date']);
        }
        return $users;
    }

    /**
     * @param User $user
     * @return string
     */
    public function dbInsert(User $user)
    {
        $user_first_name = $user->getFirstName();
        $user_last_name = $user->getLastName();
        $user_age = $user->getAge();
        $user_birth_date = $user->getBirthDate();

        $stmt = $this->dbh->prepare("INSERT INTO users (first_name, last_name, age, birth_date) VALUES (:user_first_name, :user_last_name, :user_age, :user_birth_date)");
        $stmt->bindParam(':user_first_name', $user_first_name);
        $stmt->bindParam(':user_last_name', $user_last_name);
        $stmt->bindParam(':user_age', $user_age);
        $stmt->bindParam(':user_birth_date', $user_birth_date);

        $return = ($stmt->execute()) ? 'Вы успешно зарегистрированы' : $this->dbh->errorInfo();

        return $return;
    }
}
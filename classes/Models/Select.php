<?php

namespace Models;

class Select
{
    /**
     * @var - ссылка на ресурс БД
     */
    public $dbh;

    /**
     * Функция возвращает true или false.
     * При проблемах подключения возвращает json с описанием
     * @param $logPas
     * @return bool|string
     */
    public function Connect($logPas)
    {
        $logPas = json_decode($logPas, true);
        $login = key($logPas);
        $hash = $logPas[$login];

        try {
            $this->dbh = new \PDO('mysql:host=127.0.0.1;dbname=db70', 'root', '12345678');

            $sth = $this->dbh->prepare(
                'SELECT * FROM passwords WHERE user=:user and hash=:hash '
            );
            $sth->execute([':hash' => $hash ,':user' => $login]);
            $data = $sth->fetchObject();

            if (is_object($data)){
                return true;
            }else{
                return false;
            }

        } catch (\PDOException $e) {
            switch ($e->getCode()){
                case  1049:
                    return json_encode('ресурс временно не доступен'); // обработка отсутствия нужной базы данных
                default:
                    return json_encode('что-то пошло не так'); // обработка остальнх кодов
            }
        }
    }
}

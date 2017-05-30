<?php
namespace Application\Models\User;

use Application\Models\Core\DB\Connection;
use Application\Models\User\Factory;

class Repository 
{
    private $connection;

    private $userFactory;

    private $table = 'user';

    public function __construct(Connection $connection, Factory $userFactory)
    {
            $this->connection = $connection;
            $this->userFactory = $userFactory;
    }

    public function fetchUserByUsername($username)
    {
        $select = $this->connection->getQueryFactory()->newSelect();
        $select->cols(array('*'))
                ->from($this->table)
                ->where('email = :email');

        $rows = $this->connection->getPDO()->fetchAll($select, array('email' => $username));

        if (count($rows) != 1) {
            return null;
        }
        //Create new user object using the user factory
        return $this->userFactory->create($rows[0]);
    }

    public function insertUser($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->connection->insert($this->table, $data);
    }

    public function fetchAll()
    {
        $select = $this->connection->getQueryFactory()->newSelect();
        $select->cols(array('*'))->from($this->table);

        $rows = $this->connection->getPDO()->fetchAll($select);

        return $rows;

    }

    public function fetchUserById($id)
    {
        $oSelect = $this->connection->getQueryFactory()->newSelect();
        $oSelect->cols(array('*'))->from($this->table)->where('id = :id');

        $rows = $this->connection->getPDO()->fetchAll($oSelect, array('id' => $id));

        if (count($rows) != 1) {
            return null;
        }

        return $this->userFactory->create($rows[0]);
    }

    public function getUserFactory()
    {
        return $this->userFactory;
    }
}
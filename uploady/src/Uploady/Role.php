<?php

namespace Uploady;

class Role
{
    /**
     * Database
     *
     * @var Database
     */
    private $db;

    /**
     * User
     *
     * @var User
     */
    private $user;

    /**
     * Role class constructor
     **/
    public function __construct($db, $user)
    {
        $this->db = $db;
        $this->user = $user;
    }

    /**
     * Get all roles
     *
     * @return array|bool
     */
    public function getAll()
    {
        $this->db->prepare("SELECT * FROM roles");

        $this->db->execute();

        return $this->db->resultset();
    }

    /**
     * Get a role
     *
     * @param string $role
     *  The role name
     * @return object|bool
     */

    public function get($role)
    {
        $this->db->prepare("SELECT * FROM roles WHERE id = :id");

        $this->db->bind(":id", $role, \PDO::PARAM_INT);

        $this->db->execute();

        return $this->db->single();
    }

    /**
     * Get the role of a user
     *
     * @param string $username
     *  The username
     * @return array|bool
     */
    public function getUserRole($username)
    {
        $user = $this->user->get($username);

        if ($user) {
            return $user->role;
        }

        return false;
    }

    /**
     * Create a new role
     *
     * @param mixed $role
     *  The role name
     * @return bool
     *  No return value
     */
    public function createRole($role, $size_limit)
    {
        $this->db->prepare("INSERT INTO roles (role, size_limit) VALUES (:role, :limit)");

        $this->db->bind(":role", $role, \PDO::PARAM_STR);
        $this->db->bind(":limit", $size_limit, \PDO::PARAM_STR);

        return $this->db->execute();
    }

    /**
     * Update a role
     *
     * @param mixed $role
     *  The role name
     * @param mixed $id
     *  The role id
     * @return void
     *  No return value
     */
    public function updateRole($role, $size_limit, $id)
    {
        $this->db->prepare("UPDATE roles SET role = :role, size_limit = :limit WHERE id = :id");

        $this->db->bind(":role", $role, \PDO::PARAM_STR);
        $this->db->bind(":limit", $size_limit, \PDO::PARAM_STR);
        $this->db->bind(":id", $id, \PDO::PARAM_INT);

        return $this->db->execute();
    }

    /**
     * Delete a role
     *
     * @param mixed $id
     *  The role id
     * @return void
     *  No return value
     */
    public function deleteRole($id)
    {
        $this->db->prepare("DELETE FROM roles WHERE id = :id");

        $this->db->bind(":id", $id, \PDO::PARAM_INT);

        $this->db->execute();
    }
}

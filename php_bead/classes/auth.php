<?php
require_once "user.php";
class Auth
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register($user)
    {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT); // hash password
        return $this->userRepository->insert((object) $user);
    }

    public function user_exists($username)
    {
        $users = $this->userRepository->filter(function ($user) use ($username) {
            return ((array) $user)['username'] === $username;
        });
        return count($users) >= 1;
    }

    public function login($user)
    {
        $_SESSION["user"] = $user["username"];
    }

    public function check_credentials($username, $password)
    {
        $users = $this->userRepository->filter(function ($user) use ($username) {
            return ((array) $user)['username'] === $username;
        });
        if (count($users) === 1) {
            $user = (array) array_values($users)[0];
            return password_verify($password, $user['password'])
            ? $user
            : false;
        }
        return false;
    }

    public function get_email_of($username)
    {
        $users = $this->userRepository->filter(function ($user) use ($username) {
            return ((array) $user)['username'] === $username;
        });
        if (count($users) === 1) {
            $user = (array) array_values($users)[0];
            if (isset($user['email'])) return $user['email'];
        }
        return null;
    }

    public function is_admin($username)
    {
        $users = $this->userRepository->filter(function ($user) use ($username) {
            return ((array) $user)['username'] === $username;
        });
        if (count($users) === 1) {
            $user = (array) array_values($users)[0];
            if (isset($user['is_admin'])) return $user['is_admin'] === 'true';
        }
        return false;
    }

    public function is_authenticated()
    {
        return isset($_SESSION["user"]);
    }

    public function logout()
    {
        unset($_SESSION["user"]);
    }
}
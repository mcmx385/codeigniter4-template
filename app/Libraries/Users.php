<?php

namespace App\Libraries;

class Users
{
    public function __construct()
    {
        $this->userM = new \App\Models\User();
    }
    public function autoLogin()
    {
        if (isset($_SESSION['username']) && isset($_SESSION['loggedin'])) {
            $user_rank = $this->getUserRank();
            $this->redirectRank($user_rank);
        }
        return $_SESSION['userid'];
    }
    public function autoLogout()
    {
        if (!isset($_SESSION['username']) && !isset($_SESSION['loggedin'])) {
            header('location: /user/login');
            exit;
        }
        return $_SESSION['userid'];
    }
    public function logout($session)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['userid'] = null;
            $_SESSION['username'] = null;
            $_SESSION['loggedin'] = false;
            $session->destroy();
        }
        header('location: /user/login?status=' . urlencode('logged out'));
        exit;
    }
    public function redirectRank($user_rank)
    {
        if ($user_rank == 'student') {
            header('location: /student/courses?status=' . urlencode('logged in'));
            exit;
        } elseif ($user_rank == 'teacher') {
            header('location: /teacher/courses?status=' . urlencode('logged in'));
            exit;
        } elseif ($user_rank == 'admin') {
            header('location: /admin?status=' . urlencode('logged in'));
            exit;
        }
    }
    public function getUserRank()
    {
        return $this->userM->getUserRank($_SESSION['userid']);
    }
    public function autoRedirectRank($target_rank)
    {
        $user_rank = $this->getUserRank();
        if ($user_rank !== $target_rank) {
            header('location: /user/login');
            exit;
        }
    }
}

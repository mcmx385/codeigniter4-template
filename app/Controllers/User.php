<?php

namespace App\Controllers;

class User extends BaseController
{
    public function __construct()
    {
        $this->userL = new \App\Libraries\Users();
    }
    public function login()
    {
        $this->userL->autoLogin();
        $this->template->user('user/login');
    }
    public function signup()
    {
        $this->template->user('user/signup');
    }
    public function forgot_password()
    {
        $this->template->user('user/forgot_password');
    }
    public function update_password()
    {
        $this->template->user('user/update_password');
    }
    public function reset_password()
    {
        $this->template->user('user/reset_password');
    }
    public function index()
    {
        $this->userL->autoLogout();
        $this->template->user('user/index');
    }
    public function auth()
    {
        $this->userL->autoLogin();
        $user = $this->userM->ifUserValid($_POST['username'], $_POST['password']);
        if ($user) {
            echo "User valid";
            $_SESSION['userid'] = $user->id;
            $_SESSION['username'] = $user->name;
            $_SESSION['loggedin'] = true;
            $user_rank = $this->userM->getUserRank($user->id);
            $this->userL->redirectRank($user_rank);
        } else {
            echo "User invalid";
            header('location: /user/login?status=' . urlencode('username or password invalid'));
            exit;
        }
    }
    public function logout()
    {
        $this->userL->logout($this->session);
    }
}

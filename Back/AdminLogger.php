<?php
// generation et gestion du formulaire de login admin
class AdminLogger
{
    public function generateLoginForm(string $action): void
    {
        echo '
        <form class="d-flex p-2" method="post"  id="LogIn"
            action="' . htmlspecialchars($action) . '"
            >
            <input class="form-control" type="text" name="username" id="username" placeholder="Username">
            <input class="form-control mx-2" type="password" name="password" id="password" placeholder="Password">
            <button type="submit" class="btn btn-secondary">Login</button>
        </form>
        <div id="errorForm"</div>
        ';
    }

    public function log(string $username, string $password): array
    {
        $response = [
            'granted' => false,
            'username' => null,
            'error' => null
        ];
        if ($username != "username" || $password != "password") { // a définir : username admin et password definitifs
            if (empty($username)) {
                $response['error'] = "Username is empty";
            } elseif (empty($password)) {
                $response['error'] = "Password is empty";
            } else {
                $response['error'] = "Authentication failed";
            }
        }
        if ($response['error'] === null) {
            $response['granted'] = true;
            $response['username'] = $username;
        }
        return $response;
    }
}
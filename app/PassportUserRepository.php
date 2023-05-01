<?php

namespace App;

use Illuminate\Auth\EloquentUserProvider;
use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
class PassportUserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
          Log::error('message*********');
        $guard = config('usersapi'); // obtain current guard name from config
        $provider = config('auth.guards.'.$guard.'.provider');
        $userProvider = app('auth')->createUserProvider($provider);
        
        if ($userProvider instanceof EloquentUserProvider &&
            method_exists($model = $userProvider->getModel(), 'findForPassport')) {
            $user = (new $model)->findForPassport($username);
        } else {
            $user = $userProvider->retrieveById($username);
        }

        if (!$user) {
            return;
        }

        if (method_exists($user, 'validateForPassportPasswordGrant')) {
            if (!$user->validateForPassportPasswordGrant($password)) {
                return;
            }
        } else {
            if (!$userProvider->validateCredentials($user, ['password' => $password])) {
                return;
            }
        }

        if ($user instanceof UserEntityInterface) {
            return $user;
        }

        return new User($user->getAuthIdentifier());
    }
}
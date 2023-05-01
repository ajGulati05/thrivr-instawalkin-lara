<?php

namespace App\Resolvers;
use Exception;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use  App\Services\SocialAccountsService; 
class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        // Return the user that corresponds to provided credentials.
        // If the credentials are invalid, then return NULL.
     
        $providerUser = null;
        
        try {

            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);

        } catch (Exception $exception) {

               Log::critical('Issue with provider' .$provider);
        }
     

        if ($providerUser) {

            return (new SocialAccountsService())->findOrCreate($providerUser, $provider);
        }

        return null;
    }
    
}
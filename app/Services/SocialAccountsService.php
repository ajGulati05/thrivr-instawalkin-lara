<?php
namespace App\Services;
use App\User;
use App\Userprofile;
use Laravel\Socialite\Two\User as ProviderUser;
use App\Helpers\UploadImageClass;
use Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
class SocialAccountsService
{
 
    /**
     * Find or create user instance by provider user instance and provider name.
     * 
     * @param ProviderUser $providerUser
     * @param string $provider
     * 
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $user = User::where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($user) {
           if(is_null($user->email))
           {
            $user->email=$providerUser->getEmail();
            $user->save();
           }
            return $user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (! $user) {
                
               $user= $this->createNewUser($providerUser,$provider);
            }
            else{
                $user->provider_id=$providerUser->getId();
                $user->provider=$provider;
                $user->save();
            }
        
      
               $this->downloadAvatar($user->profiles,$providerUser->getAvatar());
                return $user;
        }
    }


    public function splitNames($name){

        $returnName=explode(" ",$name);
        return $returnName;

    }

    public function createNewUser($providerUser,$provider){
           $user = User::create([
                    
                    'email' => $providerUser->getEmail(),
                    'provider_id'=>$providerUser->getId(),
                    'provider' => $provider,
                    'instauuid'=>(string) Str::orderedUuid(),
                   'email_verified_at'=>Carbon::now()
                ]);

                $name=$this->splitNames($providerUser->getName());
               $userprofile= Userprofile::create([
                    'user_id'=>$user->id,
                    'firstname' => $name[0],
                    'lastname' => end($name),
                    
                   
                ]);
              
            return $user;

    }

    public static function downloadAvatar($userprofile,$url){
      
    
    
   
             
          
            $name=time().$userprofile->firstname."_".$userprofile->lastname.".jpg";
            $filePath = 'avatar/' . $name;
           Storage::disk('s3')->put($filePath, file_get_contents($url), 'public');
           Storage::disk('s3')->delete($userprofile->avatar);
        $avatar_attributes = 
    array('width'=>Userprofile::SMALL_AVATAR_WIDTH, 'height'=>Userprofile::SMALL_AVATAR_HEIGHT);
         
        $userprofile->Update(['avatar'=>$filePath,'avatar_attributes'=>$avatar_attributes]);
       
    }
}
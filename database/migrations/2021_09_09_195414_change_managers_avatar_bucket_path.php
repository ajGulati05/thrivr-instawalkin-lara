<?php

use App\Manager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeManagersAvatarBucketPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        $managers = Manager::get();

        foreach ($managers as $manager) {
            # code...
            if($manager->mini_avatar && $manager->profile_photo){
                $path = explode("/",$manager->mini_avatar,2);
                
                $manager->mini_avatar = $path[0]."/"."opt-images/".$path[1];
                $manager->profile_photo = $path[0]."/"."opt-images/".$path[1];
                $manager->save();
            }
            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        $managers = Manager::get();

        foreach ($managers as $manager) {
            # code...
            if($manager->profile_photo && $manager->mini_avatar){
                $path = explode("/",$manager->mini_avatar,3);
                $manager->mini_avatar = $path[0]."/".$path[2];
                $manager->profile_photo = $path[0]."/".$path[2];
                $manager->save();
            }
            
        }
    }
}

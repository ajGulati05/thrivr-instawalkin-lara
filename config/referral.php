<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * Model class name of users.
     */
    'user_model' => 'App\User',

    /*
     * The length of referral code.
     */
    'referral_length' => 5,


     /*
     * referral code mask.
     * Only asterisk will be replaced, so you can add
     * or remove as many asterisk as you with
     *
     * Ex: ***-**-***
     */
    'mask' => '*****',
];
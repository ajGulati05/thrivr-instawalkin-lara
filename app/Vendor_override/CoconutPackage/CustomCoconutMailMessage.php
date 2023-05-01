<?php

namespace App\Vendor_override\CoconutPackage;

use Illuminate\Notifications\Messages\MailMessage as Message;
use Illuminate\Support\Facades\Log;
class CustomCoconutMailMessage extends Message
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    public $view = 'postmark::template';

    /**
     * Set the template alias.
     *
     * @param  string  $alias
     * @return $this
     */
    public function alias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the data array for the mail message.
     *
     * @return array
     */
    public function data(): array
    {
        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'model' => $this->data,
        ];
    }

    /**
     * Set the template identifier.
     *
     * @param  int  $id
     * @return $this
     */
    public function identifier(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the data to be available within the template.
     *
     * @param  array  $data
     * @return $this
     */
    public function include(array $data): self
    {
        $this->data = $data;

        $staticVariables=array(

    "product_url"=>config('postmark.static_variables.product_url'),
"product_logo"=>config("postmark.static_variables.product_logo"),
"product_name"=>config('postmark.static_variables.product_name'),
"thrivr_facebook"=>config('postmark.static_variables.thrivr_facebook'),
"thrivr_instagram"=>config('postmark.static_variables.thrivr_instagram'),
"thrivr_twitter"=>config('postmark.static_variables.thrivr_twitter'),
"thrivr_linkedin"=>config('postmark.static_variables.thrivr_linkedin'),
"company_name"=>config('postmark.static_variables.company_name'),


        );
        $this->data=array_merge($data,$staticVariables);


        return $this;
    }
}
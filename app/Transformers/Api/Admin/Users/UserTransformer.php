<?php

namespace App\Transformers\Api\Admin\Users;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $array = [
            'id' => $user->id,
            'f_name' => $user->f_name,
            'l_name' => $user->l_name,
            'mobile' => $user->mobile,
            'avatar' => $user->avatar ?? "",
            'email' => $user->email,
            'created_at' => $user->created_at,

        ];

        return $array;
    }
}

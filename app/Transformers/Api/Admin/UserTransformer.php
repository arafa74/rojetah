<?php

namespace App\Transformers\Api\Admin;

use App\Models\Admin;
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
    public function transform(Admin $admin)
    {
        $array = [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,

        ];

        return $array;
    }
}

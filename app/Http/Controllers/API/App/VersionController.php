<?php

namespace App\Http\Controllers\API\App;

use App\Http\Controllers\Controller;
use App\Models\Version;

class VersionController extends Controller
{
    public function versions()
    {
        $versions = Version::all();
        $app_version_data = [];
        foreach ($versions as $version){
            $app_version_data []= [
                'key' => $version->key ?? "",
                'value' =>$version->value ?? "",
            ];
        }
        return $this->ResponseApi("data added successfully", $app_version_data, 200);
    }
}

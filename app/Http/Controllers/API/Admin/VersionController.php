<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function showVersion()
    {
        $data = [];
        $data['min_android_version'] = Version::where('key' , 'min_android_version')->value('value') ?? "";
        $data['max_android_version'] = Version::where('key' , 'max_android_version')->value('value') ?? "";
        $data['min_ios_version'] = Version::where('key' , 'min_ios_version')->value('value') ?? "";
        $data['max_ios_version'] = Version::where('key' , 'max_ios_version')->value('value') ?? "";

        return $this->ResponseApi(trans('lang.api.retrieved'), ['versions' => $data]);
    }

    public function updateVersion(Request $request)
    {
        $inputs = $request->all();
        foreach ($inputs as $key => $input) {
            $data = [
                'value' => $input ?? '',
            ];
            Version::where('key', $key)->update($data);
        }

        $data = [];
        $data['min_android_version'] = Version::where('key' , 'min_android_version')->value('value') ?? "";
        $data['max_android_version'] = Version::where('key' , 'max_android_version')->value('value') ?? "";
        $data['min_ios_version'] = Version::where('key' , 'min_ios_version')->value('value') ?? "";
        $data['max_ios_version'] = Version::where('key' , 'max_ios_version')->value('value') ?? "";
        return $this->ResponseApi('App Versions updated', ['versions' => $data]);

    }
}

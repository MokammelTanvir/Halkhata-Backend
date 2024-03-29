<?php

namespace App\Repositories\SystemSetting;

use App\Models\SystemSetting;

class SystemSettingRepository implements SystemSettingInterface
{
    /*
    * @param $data
    * @return mixed|void
    */

    public function store($request_data)
    {
        $data =  SystemSetting::create([
            'site_name' => $request_data->site_name,
            'site_logo' => $request_data->site_logo,
            'site_favicon' => $request_data->site_favicon,
            'site_email' => $request_data->site_email,
            'site_phone' => $request_data->site_phone,
            'site_address' => $request_data->site_address,
            'site_description' => $request_data->site_description,
            'site_facebook_link' => $request_data->site_facebook_link,
            'site_twitter_link' => $request_data->site_twitter_link,
            'site_instagram_link' => $request_data->site_instagram_link,
            'meta_title' => $request_data->meta_title,
            'meta_description' => $request_data->meta_description,
            'meta_keywords' => $request_data->meta_keywords,


        ]);

        return $this->show($data->id);
    }

    /*
    * @return mixed|void
    */

    public function all()
    {
        $data = SystemSetting::firstOrFail();
        return $data;
    }

    /*
    * @return mixed|void
    */

    public function show($id)
    {
        $data = SystemSetting::findOrFail($id);
        return $data;
    }

    /*
    * @param $data
    * @return mixed|void
    */

    public function update($request_data, $id)
    {
        $data = SystemSetting::findOrFail($id);
        $data->update([

            'site_name' => $request_data->site_name,
            'site_logo' => $request_data->site_logo,
            'site_favicon' => $request_data->site_favicon,
            'site_email' => $request_data->site_email,
            'site_phone' => $request_data->site_phone,
            'site_address' => $request_data->site_address,
            'site_description' => $request_data->site_description,
            'site_facebook_link' => $request_data->site_facebook_link,
            'site_twitter_link' => $request_data->site_twitter_link,
            'site_instagram_link' => $request_data->site_instagram_link,
            'meta_title' => $request_data->meta_title,
            'meta_description' => $request_data->meta_description,
            'meta_keywords' => $request_data->meta_keywords,

        ]);

        return $data;
    }

    /*
    * @return mixed|void
    */

    public function delete($id)
    {
        $data = $this->show($id);
        $data->delete();
        return true;
    }

}

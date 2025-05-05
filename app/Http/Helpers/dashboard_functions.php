<?php

use App\Enums\EmployeeRole;
use App\Models\Admin;
use App\Http\Classes\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Notifications\NewNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

if ( !function_exists('isArabic') ) {

    function isArabic() : bool
    {
        return getLocale() === "ar";
    }

}

if(!function_exists('getLocale')){

    function getLocale() : string
    {
        return app()->getLocale();
    }
}

if ( !function_exists('isDarkMode') ) {

    function isDarkMode() : bool
    {
        return session('theme_mode') === "dark";
    }

}

if(!function_exists('uploadImage')){

    function uploadImage($request, $model = '' ){
        // $model        = Str::plural($model);
        // $model        = Str::ucfirst($model);
        $path         = "/Images/".$model;
        $originalName =  $request->getClientOriginalName(); // Get file Original Name
        $imageName    = str_replace(' ','','erp_' . time() . $originalName);  // Set Image name
        $request->storeAs($path, $imageName,'public');
        return $imageName;
    }
}


if(!function_exists('deleteImage')){

    function deleteImage($imageName, $model){
        // $model = Str::plural($model);
        // $model = Str::ucfirst($model);

        if ($imageName != 'default.png'){
            $path = "/Images/" . $model . '/' .$imageName;
            Storage::disk('public')->delete($path);
        }
    }
}


if(!function_exists('getImagePath')){

    function getImagePath( $imageName = null , $directory = null , $defaultImage = 'default.svg'  ): string
    {
        $imagePath = public_path('/storage/Images/'.'/' . $directory . '/' . $imageName);

        if ( $imageName && $directory && file_exists( $imagePath ) ) // check if the directory is null or the image doesn't exist
            return asset('/storage/Images') .'/' . $directory . '/' . $imageName;
        else
            return asset('placeholder_images/' . $defaultImage);

    }

}


if(!function_exists('isTabActive')){

    function isTabActive($path, $queryParam = ''){
        if ( request()->segment(2) == $path && $queryParam == request('type'))
            return 'active';
    }
}


if(!function_exists('isTabOpen')){

    function isTabOpen($path){

        if ( request()->segment(2)  === $path )
            return 'menu-item-open';

    }

}

if(!function_exists('settings')){

    function settings(): AppSetting
    {
        return new AppSetting();
    }

}

if(!function_exists('getRelationWithColumns')){

    function getRelationWithColumns($relations) : array
    {
        $relationsWithColumns = [];

        foreach ( $relations as $relation => $columns)
        {
            array_push($relationsWithColumns , $relation . ":" . implode(",",$columns));
        }

        return $relationsWithColumns;
    }

}

if(!function_exists('getDateRangeArray')){ // takes 'Y-m-d - Y-m-d' and returns [ Y-m-d 00:00:00 , Y-m-d 23:59:59 ]

    function getDateRangeArray($dateRange) : array
    {
        $dateRange = explode( ' - ' , $dateRange );

        return [ $dateRange[0] . ' 00:00:00' , $dateRange[1] . ' 23:59:59'  ];
    }

}

if ( !function_exists('getModelData') ) {

    function getModelData(Model $model, $orsFilters = [] , $andsFilters = [] ,$relations = [],$searchingColumns = null, $withTrashed = false, $modifiedRequest = null) : array
    {

        $columns              = $searchingColumns ?? $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $relationsWithColumns = getRelationWithColumns($relations); // this fn takes [ brand => [ id , name ] ] then returns : brand:id,name to use it in with clause


        /** Get the request parameters **/
        $params = $modifiedRequest ?? request()->all();

        /** Set the current page **/
        $page = $params['page'] ?? 1;

        /** Set the number of items per page **/
        $perPage = $params['per_page'] ?? 10;

        // set passed filters from controller if exist
        if(!$withTrashed)
            $model   = $model->query()->with( $relationsWithColumns );
        else
            $model   = $model->query()->onlyTrashed()->with( $relationsWithColumns );


        /** Get the count before search **/
        $itemsBeforeSearch = $model->count();

        // general search
        if(isset($params['search']['value']))
        {

            if (str_starts_with($params['search']['value'], '0'))
                $params['search']['value'] = substr($params['search']['value'], 1);

            $checkModel = clone $model;
            if (method_exists($checkModel->getModel(), 'translations') && !is_numeric($params['search']['value'])) {
                if (property_exists($checkModel->getModel(), 'translationColumns') && is_array($checkModel->getModel()->translationColumns)) {
                    $checkModel = $checkModel->orWhereHas('translations', function ($query) use ($params, $checkModel) {
                        $query->where(function ($q) use ($params, $checkModel) {
                            foreach ($checkModel->getModel()->translationColumns as $column) {
                                $word = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$params['search']['value'])));
                                $q = $q->orWhere($column, "LIKE", "%" . $word . "%");
                            }
                        });
                    });
                }
            }

            if($checkModel->count() != 0){
                $model = $checkModel;
            }

            /** search in the original table **/
            foreach ( $columns as $column)
                array_push($orsFilters, [ $column, 'LIKE', "%" . $params['search']['value'] . "%" ]);
        }



        // filter search
        if ($itemsBeforeSearch == $model->count()) {

            $searchingKeys = collect( $params['columns'] )->transform(function($entry) {

                return $entry['search']['value'] != null && $entry['search']['value'] != 'all' ? Arr::only( $entry , ['data', 'name' ,'search']) : null; // return just columns which have search values

            })->whereNotNull()->values();


            /** if request has filters like status **/
            if ( $searchingKeys->count() > 0  )
            {

                /** search in the original table **/
                foreach ($searchingKeys as $column)
                {
                    if ( ! ( $column['name'] == 'created_at' or  preg_match("/_date/i", $column['name']) ) )
                        array_push($andsFilters, [ $column['name'], '=',  $column['search']['value'] ]);
                    else
                    {
                        if( ! str_contains($column['search']['value'] , ' - ') ) // if date isn't range ( single date )
                            $model->orWhereDate( $column['name'] , $column['search']['value']);
                        else
                            $model->orWhereBetween( $column['name'] , getDateRangeArray( $column['search']['value'] ));
                    }
                }

            }

        }

        $model   = $model->where( function ($query) use ( $orsFilters ) {
            foreach ($orsFilters as  $filter)
                $query->orWhere([$filter]);
        });

        if ( $andsFilters )
            $model->where($andsFilters);

        if(isset($params['order'][0]))
        {
            $model->orderBy($params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
        }

        $model->orderBy('created_at', 'desc');

        $response = [
            "recordsTotal" => $model->count(),
            "recordsFiltered" => $model->count(),
            'data' => $model->skip(($page - 1) * $perPage)->take($perPage)->get()
        ];

        return $response;
    }

}

if(!function_exists('storeAndPushNotification')){
    function storeAndPushNotification($admins, $title, $description, $url){
        $date = \Carbon\Carbon::now()->diffForHumans();
        $notification = new NewNotification($title, $description, $date, $url);

        if(is_a($admins, 'Illuminate\Database\Eloquent\Collection'))
        {
            $admins->each(function($admin) use($notification){
                $admin->notify($notification);
            });
            $firstAdmin = $admins->first();
            $firebaseToken = $admins->pluck('device_token')->all();
        }
        else
        {
            $admins->notify($notification);
            $firstAdmin = $admins;
            $firebaseToken = [$firstAdmin->device_token];
        }

        if($firstAdmin && $firebaseToken[0])
        {
            /** push notifications to all admins **/
            // $firebaseToken = Admin::whereNotNull('device_token')->pluck('device_token')->all();
            $SERVER_API_KEY = "AAAA21NlxB0:APA91bF1rsQMEXodmmu5t4LIbUAJfhgNVpg1ME4xN8h-xkHnWHXC3CaajzzCAkZ4D3dtTYwNVjT7HeCE00c7HMwDNkLh2IvTjqXvVJQtofyphHCd9K9Rx5yWWieMg9QYVqk8tfYKgh4R";

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "alert_title" => $title,
                    "title" => $title,
                    "description" => $description,
                    "body" => $description,
                    "date" => $date,
                    "url" => $url,
                    "id" => $firstAdmin->notifications->last()->id,
                ],
            ];

            $response = Http::withHeaders([
                "Authorization" => "key=$SERVER_API_KEY",
            ])->post('https://fcm.googleapis.com/fcm/send', $data);

            return $response;
        }
        else
            return;
    }
}

if(!function_exists('isSocialMedia')){
    function isSocialMedia() : bool
    {
        $userRole = auth()->user()->role;
        return $userRole == EmployeeRole::social_media->value || $userRole == EmployeeRole::super_admin->value;
    }
}

if(!function_exists('isWarehouse')){
    function isWarehouse() : bool
    {
        $userRole = auth()->user()->role;
        return $userRole == EmployeeRole::warehouse->value || $userRole == EmployeeRole::super_admin->value;
    }
}

if(!function_exists('isSuperAdmin')){
    function isSuperAdmin() : bool
    {
        $userRole = auth()->user()->role;
        return $userRole == EmployeeRole::super_admin->value;
    }
}

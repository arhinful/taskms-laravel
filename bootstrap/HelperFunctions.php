<?php

use App\Models\Admin;
use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

if (!function_exists('formatFrontEndDate')){
    function formatFrontEndDate($date, $to='Y-m-d'): string
    {
        return Carbon::parse($date)->toDate()->format($to);
    }
}

if (!function_exists('uploadFileTo')){
    function uploadFileTo(UploadedFile $file, $path = 'uploaded-files'): bool|string
    {
        return $file->storePublicly($path, ['disk' => 'public_uploads']);
    }
}

if (!function_exists('generateUniqueNumber')){
    function generateUniqueNumber($model, $column = 'code'): string
    {
        do {
            $code = random_int(100000000000000, 999999999999999);
        } while ($model::where($column, "=", $code)->first());
        return $code;
    }
}

if (!function_exists('uploadToGallery')){
    function uploadToGallery(Model $model, $image, $collection): Media
    {
        if (!in_array(InteractsWithMedia::class, class_uses_recursive($model))){
            throw new Exception("this model type is not a mediable class");
        }
        return $model->addMedia($image)
            ->toMediaCollection($collection);
    }
}

if (!function_exists('getConvertedMediaUrl')){
    function getConvertedMediaUrl($model, $collection, $convert): string|null
    {
        $media = $model->getFirstMedia($collection);
        if ($media){
            return $media->getUrl($convert);
        }
        return null;
    }
}

if (!function_exists('businessActiveAndOwns')){
    function businessActiveAndOwns(Business $business, $child, $foreign_id = 'business_id'): bool{
        return $business->is_active && $business->id === $child->{$foreign_id};
    }
}

if (!function_exists('notifyAdmins')){
    function notifyAdmins($notification, ...$data): void{
        $admins = Admin::query()->get();
        NotificationFacade::send($admins, new $notification(...$data));
    }
}



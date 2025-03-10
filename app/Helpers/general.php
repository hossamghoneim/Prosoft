<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

if(!function_exists('can')){

    function can($module, $permission): bool
    {
        $userRole = auth()->user()->role;

        if ( isset($userRole->permissions[$module]))
            return in_array($permission, $userRole->permissions[$module]);
        else
            throw new Exception("Forbidden Exception", ResponseAlias::HTTP_FORBIDDEN);
    }

}

if (!function_exists('upload_file')) {
    function upload_file($file, $folder): string
    {
        $folder       = Str::plural($folder);
        $folder       = Str::ucfirst($folder);
        $imageName    = str_replace([ '(', ')', ' '],'','e_commerce' . time() . $file->getClientOriginalName());  // Set Image name
        return $file->storeAs("uploads/$folder", $imageName, 'public');
    }
}
if (!function_exists('update_file')) {
    function update_file($oldPhotoPath, $file, $folder)
    {
        // If no new image in data, return old path
        if (!isset($file) || !$file)
            return $oldPhotoPath;

        // If a file is uploaded
        if ($file instanceof UploadedFile) {
            $newFile = $file;

            // If old image exists, delete it
            if ($oldPhotoPath && Storage::disk('public')->exists($oldPhotoPath))
                Storage::disk('public')->delete($oldPhotoPath);

            $folder       = Str::plural($folder);
            $folder       = Str::ucfirst($folder);
            $fileName    = str_replace([ '(', ')', ' '],'','e_commerce' . time() . $file->getClientOriginalName());  // Set Image name

            return $newFile->storeAs("uploads/$folder", $fileName, 'public');
        }

        return $oldPhotoPath;
    }
}


if(!function_exists('delete_file')){

    function delete_file($filePath): int
    {
        if (Storage::disk('public')->exists($filePath))
            return Storage::disk('public')->delete($filePath);
        return 0;
    }
}

if(!function_exists('getFilePath')){

    function getFilePath( $FileName = null , $defaultImage = 'default.jpg'): string
    {
        $imagePath = public_path('/storage/' . $FileName);

        if ( $FileName && file_exists( $imagePath ) ) // check if the directory is null or the image doesn't exist
            return asset('/storage')  . '/' . $FileName;
        else
            return asset('placeholder_images/' . $defaultImage);

    }

}

if(!function_exists('getFileBasePath')){

    function getFileBasePath( ): string
    {
        return Storage::disk(env('FILESYSTEM_DRIVER'))->url( '/' );
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

if(!function_exists('isTabActive')){

    function isTabActive($path): string
    {
        if ( request()->segment(1)  === $path  ||  request()->segment(2) . '/'. request()->segment(3) === $path )
            return 'active';

        return '';
    }
}

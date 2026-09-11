<?php

class FileUpload
{
    private $uploadDirectory;

    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload($file)
    {
        /*
        |--------------------------------------------------------------------------
        | CHECK FILE
        |--------------------------------------------------------------------------
        */

        if (
            !isset($file) ||
            !isset($file["error"]) ||
            $file["error"] === UPLOAD_ERR_NO_FILE
        ) {
            return [
                "success" => true,
                "filename" => ""
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK UPLOAD ERROR
        |--------------------------------------------------------------------------
        */

        if ($file["error"] !== UPLOAD_ERR_OK) {
    return [
        "success" => false,
        "message" =>
            "Upload error code: " . $file["error"]
    ];
}

        /*
        |--------------------------------------------------------------------------
        | MAXIMUM FILE SIZE
        |--------------------------------------------------------------------------
        */

        $maxFileSize = 2 * 1024 * 1024;

        if ($file["size"] > $maxFileSize) {
            return [
                "success" => false,
                "message" =>
                    "Profile photo must be less than 2 MB."
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK ACTUAL FILE TYPE
        |--------------------------------------------------------------------------
        */

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $fileType = $finfo->file(
            $file["tmp_name"]
        );

        $allowedTypes = [
            "image/jpeg" => "jpg",
            "image/png"  => "png",
            "image/webp" => "webp"
        ];

        if (!isset($allowedTypes[$fileType])) {
            return [
                "success" => false,
                "message" =>
                    "Only JPG, PNG and WEBP images are allowed."
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFY IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            @getimagesize($file["tmp_name"]) === false
        ) {
            return [
                "success" => false,
                "message" => "Invalid profile photo."
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | GET SAFE EXTENSION
        |--------------------------------------------------------------------------
        */

        $extension =
            $allowedTypes[$fileType];

        /*
        |--------------------------------------------------------------------------
        | CREATE UPLOAD DIRECTORY IF NEEDED
        |--------------------------------------------------------------------------
        */

        if (!is_dir($this->uploadDirectory)) {
            mkdir(
                $this->uploadDirectory,
                0755,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE UNIQUE FILE NAME
        |--------------------------------------------------------------------------
        */

        $fileName =
            uniqid("emp_", true) .
            "." .
            $extension;

        $uploadPath =
            $this->uploadDirectory .
            $fileName;

        /*
        |--------------------------------------------------------------------------
        | MOVE FILE
        |--------------------------------------------------------------------------
        */

        if (
            !move_uploaded_file(
                $file["tmp_name"],
                $uploadPath
            )
        ) {
            return [
                "success" => false,
                "message" =>
                    "Failed to upload profile photo."
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return [
            "success" => true,
            "filename" => $fileName
        ];
    }

    public function delete($filename)
    {
        if (empty($filename)) {
            return true;
        }

        $filePath =
            $this->uploadDirectory .
            $filename;

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return true;
    }
}
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
        if (
            !isset($file) ||
            $file["error"] === UPLOAD_ERR_NO_FILE
        ) {
            return [
                "success" => true,
                "filename" => ""
            ];
        }

        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];

        $maxFileSize = 2 * 1024 * 1024;

        $extension = strtolower(
            pathinfo(
                $file["name"],
                PATHINFO_EXTENSION
            )
        );

        if (!in_array($extension, $allowedExtensions)) {
            return [
                "success" => false,
                "message" => "Invalid profile photo format."
            ];
        }

        if ($file["size"] > $maxFileSize) {
            return [
                "success" => false,
                "message" => "Profile photo must be less than 2 MB."
            ];
        }

        $fileName =
            uniqid("emp_", true) .
            "." .
            $extension;

        $uploadPath =
            $this->uploadDirectory .
            $fileName;

        if (
            !move_uploaded_file(
                $file["tmp_name"],
                $uploadPath
            )
        ) {
            return [
                "success" => false,
                "message" => "Failed to upload profile photo."
            ];
        }

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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFiles extends Model
{
    use HasFactory;
    protected $table = 'user_files';

    public function logFileToDB($user_file, $filepath)
    {
        $file = [
            'user_id' => Auth::user()->id,
            'filename' => $user_file,
            'filepath' => $filepath,
        ];
        return $this->insert($file);
    }
}

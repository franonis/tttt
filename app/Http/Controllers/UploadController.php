<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function getUploadPage()
    {
        return view('upload', ['title' => '上传数据']);
    }

    public function newtask_att_up(Request $request)
    {
        #dd("vv");
        $file = $request->file('file');

        #$allowed_extensions = ["jpg"]; //多类型
        #//判断文件是否是允许上传的文件类型
        #if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
        #    $data = [
        #        'status' => 0, //返回状态码，在js中用改状态判断是否上传成功。
        #        'msg' => '不支持此格式',
        #    ];
        #    return json_encode($data);
        #}
        #
        //保存文件，新建路径，拷贝文件
        $path = date('Y/m/d/', time());
        $destinationPath = 'uploads/';
        is_dir($destinationPath) or mkdir($destinationPath, 0777, true);
        $extension = $file->getClientOriginalExtension();
        $fileName = $extension;
        $file->move($destinationPath, $file->getClientOriginalName());
        $data = [
            'status' => 1, //返回状态码，在js中用改状态判断是否上传成功。
            'msg' => $destinationPath . $fileName, //上传成功，返回服务器上文件名字
            'originalname' => $file->getClientOriginalName(), //上传成功，返回上传原文件名字
            'file' => $file, //上传成功，返回上传原文件名字
        ];
        return json_encode($data);

    }
    public function canshu(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('canshu', ['title' => '设置参数']);
    }

    public function crosscanshu(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('crosscanshu', ['title' => '设置参数']);
    }

    public function uploadFiles(Request $request)
    {

        // 用户的文件名
        #dd("vv");
        $user_filename = $request->file->getClientOriginalName();
        $user_ext = $request->file->getClientOriginalExtension();
        $file_size = $request->file->getClientSize();
        if ($user_ext != 'zip') {
            return ['status' => 0, 'msg' => '仅支持zip文件!'];
        }

        $destinationPath = storage_path('storage/uploads/'); //public 文件夹下面建 storage/uploads 文件夹
        $extension = $file->getClientOriginalExtension();
        $fileName = md5(time() . rand(1, 1000)) . '.' . $extension;
        $file->move($destinationPath, $fileName);
        $filePath = asset($destinationPath . $fileName);

        return $filepath ? ['status' => 1, 'msg' => '保存成功！'] : ['status' => 0, 'msg' => '保存错误！'];

    }
    public function uploadFile(Request $request)
    {

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $allowed_extensions = ["png", "jpg", "gif"];
            if (!in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                dd('只能上传png,jpg和gif格式的图片.');
            } else {
                #storage_path('blast')
                #$destinationPath = 'storage/uploads/'; //public 文件夹下面建 storage/uploads 文件夹
                $destinationPath = storage_path('storage/uploads/'); //public 文件夹下面建 storage/uploads 文件夹
                $extension = $file->getClientOriginalExtension();
                $fileName = md5(time() . rand(1, 1000)) . '.' . $extension;
                $file->move($destinationPath, $fileName);
                $filePath = asset($destinationPath . $fileName);
                dd("文件路径：" . asset($destinationPath . $fileName));
            }
        } else {
            dd('图片上传失败请重试.');
        }
    }
}

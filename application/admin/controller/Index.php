<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Base
{

    public function gofirst()
    {
        return $this->fetch();
    }

    public function index()
    {
        return $this->fetch();
    }

    /**
     * [contract_files description] 通用上传类
     * @return [type] [description] 参数必须
     */
    public function contract_files()
    {
        $file = request()->file('file');
        if (!$file) {
            return resultArray(['error' => '请上传文件']);
        }
        $info = $file->validate(['ext' => 'jpg,png,gif'])->move('./uploads');
        if ($info) {
            if (request()->host() == '103.192.226.194') {
                return json(resultArray(['data' => 'http://103.192.226.194/uploads/' . str_replace("\\", "/", $info->getSaveName())]));
            } else {
                return json(resultArray(['data' => HttpServerName() . '/uploads/' . str_replace("\\", "/", $info->getSaveName())]));
            }

        }
        return json(resultArray(['error' => $info->getError()]));
    }
}

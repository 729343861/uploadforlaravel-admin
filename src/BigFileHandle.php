<?php
/**
 * Created by 2020/1/8 0008
 * Effect: BigFile.php
 * Author: 品花
 * Date: 2020/1/8 0008
 * Time: 下午 7:24
 */

namespace Encore\bigfile;

use Encore\Admin\Form\Field;
use zgldh\QiniuStorage\QiniuStorage;

class BigFileHandle extends Field
{

    protected $view = 'laravel-admin-bigfile::bigfile';

    /**
     * @var array
     */
    protected static $css = [
        'vendor/laravel-admin-ext/bigfile/css/bigfile.css',
    ];
    /**
     * @var array
     */
    protected static $js = [
        'vendor/laravel-admin-ext/bigfile/js/qiniu.min.js',
    ];


    public function getUploadToken()
    {

        $disk  = QiniuStorage::disk('qiniu');
        $token = $disk->uploadToken();
        return $token;
    }

    public function getFileName()
    {
        return 'video/' . md5(date('YmdHis' . mt_rand(10000, 99999)));
    }

    public function getChunkSize()
    {
        return isset($this->options['chunk_size']) ? $this->options['chunk_size'] : 1 * 1024 * 1024;
    }

    public function getMaxSize()
    {
        return isset($this->options['max_size']) ? $this->options['max_size'] : 1 * 1024 * 1024;
    }

    public function getFileExt()
    {
        $json = json_encode(isset($this->options['ext']) ? $this->options['ext'] : []);

        return $json;
    }


    public function render()
    {
        $this->script = <<<EOT

        $("button[type='submit']").click(function(){

               var fileName = $("input[name='{$this->column()}']").val()
               if(!fileName){
                alert('请选择视频');
                return false;
               }

        })
        $("#cancelUpload").click(function(){
                window.subscription.unsubscribe() // 上传取消
        })

        $('#bigfile').change(function(e){

            $("#cancelUpload").show();
            var fileObj = document.getElementById("bigfile").files[0]; // js 获取文件对象
            var fileName = fileObj.name;
            var patternFileExtension = /\.([0-9a-z]+)(?:[\?#]|$)/i;
            var fileExtension = (fileName).match(patternFileExtension);

            var exts = '{$this->getFileExt()}';
            exts = eval(exts);
            if(!exts.includes(fileExtension[1])   ){
                  alert('该文件类型不允许上传');
                  return false;
            }
            if(fileObj.size > {$this->getMaxSize()}){
                alert('文件超出配置大小');
                return false;
            }
            var putExtra = {
              fname: "",
              params: {},
              mimeType: null,
              chunkSize:{$this->getChunkSize()}
            };
            var config = {
              useCdnDomain: true,
              region: null,
              chunkSize:{$this->getChunkSize()}
            };
            var fileName =  '{$this->getFileName()}'
            var observable = qiniu.upload(fileObj, fileName, '{$this->getUploadToken()}', putExtra, config)
            var observer = {
              next(res){

                    var schedule = res.total.percent;
                    $('#schedule').text( Math.ceil(schedule));
                  console.log('进度信息',res);
              },
              error(err){
                console.log('错误信息',err);
              },
              complete(res){

                $('#fileName').text(res.key)
                $("input[name='{$this->column()}']").val(res.key)
              }
            }
            window.subscription = observable.subscribe(observer) // 上传开始
//            subscription.unsubscribe() // 上传取消

        })

EOT;

        return parent::render();
    }
}

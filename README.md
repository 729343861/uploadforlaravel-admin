### Requirements
##### laravel-admin >= 1.6


### Installation
` composer require uploadforlaravel-admin/bigfile` <br/>
` php artisan vendor:publish --tag=laravel-admin-bigfile`


### Configurations
#####  configuration file: config/admin.php
    'extensions' => [
        'bigfile' => [

            // Set to false if you want to disable this extension
            'enable' => true,

            // If you want to set an alias for the calling method
            //'alias' => 'markdown',

            // Editor configuration
            'config' => [
                //file Host
                'host'=> 'http://www.baidu.cn/'
                'prefix'=> 'file'

            ]
        ]
    ],`
### Use

`  $form->bigfile('field_name')->options(['chunk_size'=> 3 * 1024 * 1024 ,'max_size'=> 5 * 1024 * 1024,'ext'=> ['exe']]);`

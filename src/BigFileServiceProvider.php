<?php

namespace Encore\bigfile;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\Admin;
use Encore\Admin\Form;
class BigFileServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(BigFile $extension)
    {
        if (! BigFile::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-bigfile');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/bigfile')],
                'laravel-admin-bigfile'
            );
        }

        //
        Admin::booting(function () {
            Form::extend('bigfile', BigFileHandle::class);

            if ($alias = BigFile::config('alias')) {
                Form::alias('bigfile', $alias);
            }
        });


        Admin::booted(function () {
            if (BigFile::config('config.renderingConfig.codeSyntaxHighlighting')) {
                Admin::css('//cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css');
                Admin::js('//cdn.jsdelivr.net/highlight.js/latest/highlight.min.js');
            }
        });

    }
}

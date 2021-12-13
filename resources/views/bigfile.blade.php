
<div class="form-group"  >
    <label class="col-sm-2 control-label">文件上传
    </label>
    <div class="col-sm-8">
        <div class="file-preview ">
            <input type="file" class="file" id="bigfile" name="icon" data-initial-preview="{{$host}} {{$value}}" data-initial-caption="{{ old($column, $value) }}" id="1639382320956_72">
        </div>
        @include('admin::form.error')
        <input type="text" name="{{$name}}" value="{{ old($column, $value) }}" hidden>
        @include('admin::form.help-block')
        <div class="jdt">
            进度<strong id="schedule">0</strong>%
        </div>
    </div>
</div>



<div class="form-group 1"  >
    <label class="col-sm-2 control-label">视频上传
    </label>
    <div class="col-sm-2">
        <a href="javascript:;" class="file">选择文件
            <input type="file"   style="background-color: #0d6aad;width: 120px;" id="bigfile"  value="选择视频" placeholder="请选择视频">
            <input type="text" name="{{$name}}" hidden>
        </a>
    </div>
    <div class="col-sm-3" id="fileName" style="white-space:normal;padding-top: 8px;"></div>
    <div class="col-sm-1" style="padding-top: 8px;">
        进度<strong id="schedule">0</strong>%
    </div>
    <div class="col-sm-2">
        <button type="button" id="cancelUpload" class="btn btn-warning" style="display: none;">取消上传</button>
    </div>

</div>

var html_start = "<div class=\"tabs-container\"><div class=\"tabs-left\"><ul class=\"nav nav-tabs\"><li class=\"active\"><a data-toggle=\"tab\" href=\"#tab-1\"> 新建合同1</a></li></ul><div class=\"tab-content \"><div id=\"tab-1\" class=\"tab-pane active\"><div class=\"panel-body\"></div></div></div></div></div>";

function contract_html(types, i) {
    var html = '';
    switch (types) {
        case 1:
            html = '<li><a data-toggle=\"tab\" href=\"#tab-' + i + '\"> 新建合同' + i + '</a></li>';
            break;
        case 2:
            html = '<div id=\"tab-' + i + '\" class=\"tab-pane\"><div class=\"panel-body\"><div class=\"col-sm-8\"><form class=\"form-horizontal\"role=\"form\"action=\"' + uri + '\"><input name=\"id\"type=\"hidden\"/><input name=\"files_name\"type=\"hidden\"/><input type=\"hidden\"name=\"files\"/><div class=\"form-group\"><label class=\"col-sm-2 control-label\">合同名称：</label><div class=\"col-sm-6\"><input name=\"name\"type=\"text\"placeholder=\"合同名称\"class=\"form-control col-xs-6 col-sm-6\"autocomplete=\"off\"value=\"新建合同' + i + '\"/></div></div><div class=\"form-group\"><label class=\"col-sm-2 control-label\">源文件：</label><div class=\"col-sm-6\"><div class=\"picker\"><i class=\"fa fa-upload\"></i>&nbsp;&nbsp;<span class=\"bold\">上传</span></div></div></div><div class=\"form-group\"><label class=\"col-sm-2 control-label\">操作：</label><div class=\"col-sm-5\"><a class=\"btn btn-success btn-outline\"onclick=\"add_key_val(this)\"><i class=\"fa fa-plus\"> </i>添加键值对</a></div></div><div class=\"key_val\"><div class=\"form-group\"><div class=\"col-sm-2\">&nbsp;</div><div class=\"col-sm-3\"><input type=\"text\"class=\"form-control\"autocomplete=\"off\"placeholder=\"变量名\"name=\"settings[key][]\"></div><div class=\"col-sm-3\">' + select_html + '</div></div></div><p>&nbsp;</p><div class=\"form-group\"><div class=\"col-sm-2\">&nbsp;</div><div class=\"col-sm-4\"><button class=\"btn btn-w-m btn-warning\" type=\"button\" onclick=\"printfiles(this)\">预览</button>&nbsp;&nbsp;<button type=\"submit\"class=\"btn btn-w-m btn-primary\">保存</button></div></div></form></div><div class=\"col-sm-4\"></div></div></div>';
            break;
        case 3:
            html = '<div class=\"form-group\"><div class=\"col-sm-2\">&nbsp;</div><div class=\"col-sm-3\"><input type=\"text\"class=\"form-control\"autocomplete=\"off\"placeholder=\"变量名\"name=\"settings[key][]\"></div><div class=\"col-sm-3\">' + select_html + '</div><div class=\"col-sm-3\"><button class=\"btn btn-outline btn-danger\"type=\"button\"onclick=\"del_key_val(this)\"><i class=\"fa fa-trash\"></i>&nbsp; 删除</button></div></div>';
            break;

        case 4:
            html = '<div class=\"form-group\"><div class=\"col-sm-2\">&nbsp;</div><div class=\"col-sm-3\"><input type=\"text\"class=\"form-control\"autocomplete=\"off\"placeholder=\"菜单名\"name=\"settings[key][]\"></div><div class=\"col-sm-3\">' + select_html + '</div><div class=\"col-sm-3\"><button type=\"button\" class=\"btn btn-outline btn-primary\"><i class=\"fa fa-hand-o-up\"></i> 上传</button>&nbsp;<button class=\"btn btn-outline btn-danger\"type=\"button\"onclick=\"del_key_val(this)\"><i class=\"fa fa-trash\"></i> 删除</button></div></div>';
            break;
    }
    return html;
}


var html_start2 = "<div class=\"tabs-container\"><div class=\"tabs-left\"><ul class=\"nav nav-tabs\"><li class=\"active\"><a data-toggle=\"tab\" href=\"#tab-1\"> 新建菜单1</a></li></ul><div class=\"tab-content \"><div id=\"tab-1\" class=\"tab-pane active\"><div class=\"panel-body\"></div></div></div></div></div>";

function contract_html2(types, i) {
    var html = '';
    switch (types) {
        case 1:
            html = '<li><a data-toggle=\"tab\" href=\"#tab-' + i + '\"> 新建菜单' + i + '</a></li>';
            break;
        case 2:
            html = '<div id=\"tab-' + i + '\" class=\"tab-pane\"><div class=\"panel-body\"><div class=\"col-sm-8\"><form class=\"form-horizontal\"role=\"form\"action=\"' + uri + '\"><input name=\"id\"type=\"hidden\"/><input name=\"files_name\"type=\"hidden\"/><input type=\"hidden\"name=\"files\"/><div class=\"form-group\"><label class=\"col-sm-2 control-label\">菜单名称：</label><div class=\"col-sm-6\"><input name=\"name\"type=\"text\"placeholder=\"菜单名称\"class=\"form-control col-xs-6 col-sm-6\"autocomplete=\"off\"value=\"新建合同' + i + '\"/></div></div><div class=\"form-group\"><label class=\"col-sm-2 control-label\">添加操作：</label><div class=\"col-sm-5\"><a class=\"btn btn-success btn-outline\"onclick=\"add_key_val(this)\"><i class=\"fa fa-plus\"> </i> 添加图片名称-图片地址</a></div></div><div class=\"key_val\"><div class=\"well\"><div class=\"form-group\"><div class=\"col-sm-3\"><input type=\"text\"class=\"form-control\"autocomplete=\"off\"placeholder=\"菜单名\"name=\"settings[key][]\"></div><div class=\"col-sm-6\">' + select_html + '</div><div class=\"col-sm-3\"><input type=\"hidden\" name=\"settings[val][]\" /><div class=\"picker\" onclick=\"getlist(this)\"><i class=\"fa fa-upload\"></i><span class=\"bold\">上传</span></div><button class=\"btn btn-outline btn-danger\"type=\"button\"onclick=\"del_key_val(this)\"><i class=\"fa fa-trash\"></i> 删除</button></div></div></div><p>&nbsp;</p><div class=\"form-group\"><div class=\"col-sm-2\">&nbsp;</div><div class=\"col-sm-4\"><button type=\"submit\" class=\"btn btn-w-m btn-primary\">保存</button></div></div>';
            break;

        case 3:
            html = '<div class=\"well\"><div class=\"form-group\"><div class=\"col-sm-3\"><input type=\"text\" class=\"form-control\" autocomplete=\"off\" placeholder=\"图片名\" name=\"settings[key][]\"></div><div class=\"col-sm-6\"><img id=\"avatar\" class=\"feed-photo\" width=\"340\" height=\"80\" src=\"\" alt=\"image\"></div><div class=\"col-sm-3\"><input type=\"hidden\" name=\"settings[url][]\" /><div class=\"picker\" onclick=\"getlist(this)\"><i class=\"fa fa-upload\"></i><span class=\"bold\">上传</span></div><button onclick="del_key_val(this)" type="button" class="btn btn-outline btn-danger"><i class="fa fa-trash"></i> 删除</button></div><div class=\"col-sm-6\">图片跳转地址:<input type=\"text\" class=\"form-control\" autocomplete=\"off\" placeholder=\"图片跳转地址\" name=\"settings[jump_url][]\"></div><div class=\"col-sm-6\">图片简介:<textarea class=\"form-control\" autocomplete=\"off\" placeholder=\"图片简介\" name=\"settings[short_intro][]\"></textarea></div></div></div>';
            break;
    }
    return html;
}
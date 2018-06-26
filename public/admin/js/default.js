var random_chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];


//提示小部件
$(".tooltip_default").tooltip({
    selector: "[data-toggle=tooltip]",
    container: "body"
});

function jija(obj) {
    console.log(obj);
}

function htmlDecode(value) {
    return $('<div/>').html(value).text();
}

function card_format(str) {
    str = str.replace(/\s/g, '');
    str = str.replace(/(\d{4})/g, '$1 ').replace(/\s*$/, '');
    return str
}
//关闭layer
function close_layer(type) {
    if (!type) { //关闭自身否则关闭指定层
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }
}

// 随机字符串
function generateMixed(n) {
    var res = "";
    for (var i = 0; i < n; i++) {
        var id = Math.ceil(Math.random() * 35);
        res += random_chars[id];
    }
    return res;
}
//纯数字
function genenumMixed(len) {
    var pwd = "";
    for (var idx = 0; idx < len; idx++) {
        var seed = parseInt(Math.random() * 9);
        pwd = pwd + seed;
    }
    return pwd;
}

// 随机字符串
function GetRandomNum(Min, Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return (Min + Math.round(Rand * Range));
}


// 格式化money
function money_format(obj) {
    var str = $(obj).val();
    if (str.indexOf(".") < 0 && str != "" && str.length != 0)
        $(obj).val(str + ".00");

    if (str.indexOf(".") == 1 && str.length < 4) {
        $(obj).val(str + "0");
    }
}

// 时间戳转日期
function getYmdTime(time) {
    if (time > 0) {
        var dateStr = new Date(time * 1000);
        Y = dateStr.getFullYear() + '-';
        M = (dateStr.getMonth() + 1 < 10 ? '0' + (dateStr.getMonth() + 1) : dateStr.getMonth() + 1) + '-';
        D = dateStr.getDate();
        D = D > 9 ? D + ' ' : "0" + D + ' ';

        h = dateStr.getHours();
        h = h > 9 ? h + ":" : "0" + h + ":";

        m = dateStr.getMinutes();
        m = m > 9 ? m + ":" : "0" + m + ":";

        s = dateStr.getSeconds();
        s = s > 9 ? s : "0" + s;
        return Y + M + D + h + m + s;
    } else {
        return '末知时间';
    }
}

// 日期转时间戳
function getUnixTime(time) {
    time = time.replace(/-/g, "/");
    return new Date(time).getTime();

}

function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}

function refreshShow() {
    $(".show").scrollTop($(".show").height());
}

var area = document.getElementById('text');
area.onkeydown = function(e){
    e = e?e:window.event;
    // 按回车提交
    if(event.ctrlKey != true && 13==e.keyCode){
        var value = trim(this.value);
        if (value == ""){
            return;
        }
        var post = {text:value};
        $.post("/index/submit",post,function(data){
            var str = showItem(data);
            $(".show").html($(".show").html() + str);
            refreshShow();
            document.getElementById('text').value = "";
        },'json');
        return false;
    }
}

function showItem(data) {
    var str = "";
    if (data['special']){
        str += "<div class=sentarea_sp>";
    }else{
        str += "<div class=sentarea>";
    }
    str += "<div class=sentence>&nbsp;&nbsp;";
    str += data['text'];
    str += "</div><div class=date>";
    str += getLocalTime(data['_t']);
    str += "</div></div>";
    return str;
}
function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}     

refreshShow();

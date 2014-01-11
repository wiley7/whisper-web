var area = document.getElementById('text');
var sending = false;
area.onkeydown = function(e){
    e = e?e:window.event;
    // 按回车提交
    if(sending == false && event.ctrlKey != true && 13==e.keyCode){
        var value = trim(this.value);
        if (value == ""){
            return;
        }
        sending = true;
        var post = {text:value};
        $.post("/index/submit",post,function(data){
            showItem(data);
            document.getElementById('text').value = "";
            sending = false;
        },'json');
        return false;
    }
}

refreshShow();

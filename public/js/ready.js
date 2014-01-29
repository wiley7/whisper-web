
function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}

function refreshShow() {
    $(".show").scrollTop($(".show")[0].scrollHeight);
}

function showItem(data) {
    var str = "";
    if (data['tag']){
        str += "<div class=sentarea_" + data['tag'] + ">";
    }else{
        str += "<div class=sentarea>";
    }
    str += "<div class=sentence>&nbsp;&nbsp;";
    str += data['text'];
    str += "</div><div class=date>";
    if (data['tag']) {
        str +=  "tag: " + data['tag'] + "&nbsp&nbsp&nbsp&nbsp";
    }
    str += getLocalTime(data['_t']);
    str += "</div></div>";
    $(".show").html($(".show").html() + str);
    refreshShow();
}
function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
}     
function showDel(del) {
    var parent = del.parent();
    del[0].style.top  = parent.offset().top;
    del[0].style.left = parent.width() - del.width() - 2 + parent.offset().left;
    del.click(function(e){
        var id = e.currentTarget.parentNode.children[1].children[0].value;
        console.log(id);
        var post = {sid:id};
        $.post("/index/del",post,function(data){
            if (data.s == "ok"){
                e.currentTarget.parentNode.remove();
                refreshDel();
            }else{
                alert("del error");
            }
        },'json');
    });
}
function refreshDel(){
    // show del icon
    $(".mv-del").each(function (idx) {
        showDel($(this));
    });
}

$(".sentarea").mouseover(function(e) {
    var del = e.currentTarget.children[2];
    del.style.opacity = 1;
});
$(".sentarea").mouseout(function(e) {
    e.currentTarget.children[2].style.opacity = 0;
});
refreshDel();

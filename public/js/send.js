var area = document.getElementById('text');

function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}

area.onkeydown = function(e){
    e = e?e:window.event;
    if(e.ctrlKey && 13==e.keyCode){
        var value = trim(this.value);
        alert(value);
        this.value = "";
    }
}

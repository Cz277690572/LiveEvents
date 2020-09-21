
var wsUrl = "ws://liveevents.com:9580";

var websocket = new WebSocket(wsUrl);

// 实例对象的onopen属性
websocket.onopen = function (ev) {
    // websocket.send("hello websocket");
    console.log("connected-swoole-success");
}

// 实例化onmessage
websocket.onmessage = function (ev) {
    console.log("ws-server-return-data: " + ev.data);
    if(ev.data != 'this is server message'){
        push(ev.data);
    }
}

// 实例化onclose
websocket.onclose = function (ev) {
    console.log("ws-server: close");
}

// onerror
websocket.onerror = function (ev, e) {
   console.log("error:" + ev.data);
}


function push(data) {
    arr = JSON.parse(data);
    console.log(arr);
    html = '<div class="frame">';
    html += '<h3 class="frame-header">';
    html += '<i class="icon iconfont icon-shijian"></i>'+arr.type+' 01：30';
    html += '</h3>';
    html += '<div class="frame-item">';
    html += '<span class="frame-dot"></span>';
    html += '<div class="frame-item-author">';
    if(data.logo){
        html += '<img src="'+arr.logo+'" width="20px" height="20px" />';
    }
    html += arr.title+'</div>';
    html += '<p>'+arr.content+'</p>';
    if(arr.image){
        html += '<p><img src="'+arr.image+'" width="40%" /></p>';
    }
    html += '</div>';
    html += '</div>';
    console.log(html);
    $("#match-result").prepend(html);
}
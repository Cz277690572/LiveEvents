

var wsUrl = "ws://liveevents.com:9581";

var websocket = new WebSocket(wsUrl);

// 实例对象的onopen属性
websocket.onopen = function (ev) {
    websocket.send("hello websocket");
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
    html  = '<div class="comment">';
    html += '<span>'+arr.author+':</span>';
    html += '<span>'+arr.content+'</span>';
    html += '</div>';
    console.log(html);
    $("#comments").append(html);
}
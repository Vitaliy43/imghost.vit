
var curr_time = Date.now();
if (!Date.now) {
  Date.now = function now() {
    return new Date().getTime();
  };
}


window.adBlock = false;

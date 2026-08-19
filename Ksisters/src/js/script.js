window.addEventListener('DOMContentLoaded', ()=>{

  doubleTool();

})

function doubleTool() {
  let tool = document.querySelector('.js-tool');
  let movePart = document.querySelector('.js-tool .inner-move');
  let divider = document.querySelector('.js-tool .divider');
  let pusher = document.querySelector('.js-tool .pusher');
  let isDrag = false;
  let downEvent = document.documentElement.offsetWidth > 375 ? 'mousedown' : 'touchstart';
  let upEvent = document.documentElement.offsetWidth > 375 ? 'mouseup' : 'touchmove';
  let moveEvent = document.documentElement.offsetWidth > 375 ? 'mousemove' : 'touchend';

  pusher.addEventListener(downEvent, ()=>{
    isDrag = true;
  })

  window.addEventListener(upEvent, ()=>{
    isDrag = false;
  })

  tool.addEventListener(moveEvent, (e)=>{
    if(!isDrag) return;
    let rect = tool.getBoundingClientRect();
    let position = e.clientX - rect.left;
    position = Math.max(0, Math.min(position, rect.width));
    movePart.style.width = position + 'px';
    divider.style.left = position + 'px';
  })

}
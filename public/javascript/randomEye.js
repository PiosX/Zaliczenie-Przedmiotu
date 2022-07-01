$=document.querySelector.bind(document); 
setInterval(function(){
  s=document.getElementById('eye').style;
  var documentHeight = document.documentElement.clientHeight;
  var documentWidth = document.documentElement.clientWidth;

  s.top=Math.floor(Math.random()*800) +'px'; 
  s.left=Math.floor(Math.random()*documentWidth-20) +'px'; 
  if(s.top<100)
  {
      s.top += 100;
      if(s.top>documentHeight-100)
      {
          s.top -= 100;
      }
  }
  if(s.left<100)
  {
      s.left += 100;
      if(s.left>documentHeight-100)
      {
          s.left -= 100;
      }
  }
},8000)
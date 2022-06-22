const sendButton = document.querySelector('#reloadChatRoom')
const chatBox = document.querySelector('.chatBox')


  chatBox.scrollTop = chatBox.scrollHeight;

  sendButton.addEventListener("click",refreshDiv(10))


function updateDiv(){ 
  $( ".chatBox" ).load(location.href+ " .chatBox");
//   console.log("test")
}


function refreshDiv(x){
  const myInterval = setInterval(updateDiv(),x)
   clearInterval(myInterval)
}

const refreshAuto =  setInterval(function (){ //refresh la div automatiquement toutes les 3 sec: permettre de voir les nvx messages
  $( ".chatBox" ).load(location.href+ " .chatBox");
  // console.log("test3")
},3000)

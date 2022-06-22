$(document).ready(function () {
  $("input[name='leaderBoard']").change(function () {
    var inputValue = $(this).attr("value");
    var targetBox = $("." + inputValue);
    $(".box-leaderboard").not(targetBox).hide();
    $(targetBox).show();
  });

  $(".toggleButtonAdmin").click(function () {
    $(".toggleShowInfo").toggleClass("hide");
  });

  $(".needCheckedOne").click(function () {
    $(".checkedOne").toggleClass("hide");
  });

  $(".needCheckedTwo").click(function () {
    $(".checkedTwo").toggleClass("hide");
  });

  $(".toggleButtonScore").click(function () {
    $(".numberScore").toggleClass("hide");
  });

  $(".toggleButtonMessage").click(function () {
    $(".messageText").toggleClass("hide");
  });
});

// const hf = setInterval(function (){
//   console.log('je suis la')
// },1000)

// $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
// chatBox.scrollTo(0,document.body.scrollHeight);

// $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
// chatBox.scrollTo(0,document.body.scrollHeight);

// sendScore.addEventListener('click', function() {
//   $(".own-message").load(window.location + " .own-message");
//   $(".global-message").load(window.location + " .own-message");
// })

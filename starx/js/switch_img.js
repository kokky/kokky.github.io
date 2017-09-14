$(function(){

  /*==============================================
    PC・SP画像出し分け対応
  ==============================================*/
  var responceFlag;

  function setFlag() {
    if(document.documentElement.clientWidth > 480) {
      if(responceFlag !== 'pc') {
        responceFlag = 'pc';
      }
    } else {
      if(responceFlag !== 'sp') {
        responceFlag = 'sp';
      }
    }
  }
  setFlag();

  // window幅
  var iw　= document.documentElement.clientWidth;

  // 200ミリ秒毎にリサイズイベント
  var winTimer = false;
  $( window ).resize(function(){
    setFlag();
    if(document.documentElement.clientWidth !== iw) {
      if(winTimer !== false) {
        clearTimeout(winTimer);
      }
      winTimer = setTimeout(function(){
        switchImage();
        // wwを更新
        iw = document.documentElement.clientWidth;
      }, 200);
    }
  });

  function switchImage(){
    if($('body').hasClass('iphone_plus')) {
      responceFlag = 'pc';
    } else if(document.documentElement.clientWidth > 480) {
      responceFlag = 'pc';
    } else {
      responceFlag = 'sp';
    }
    $(".switch_img").each(function(){
      var switchImg = $(this),
        switchSrc;
      if(responceFlag == 'pc') {
        // PC時の処理
        switchSrc = switchImg.attr("data-pcsrc");
      } else {
        // SP時の処理
        switchSrc = switchImg.attr("data-spsrc");
      }
      switchImg.attr("src", switchSrc);
    });
  }
  switchImage();

});

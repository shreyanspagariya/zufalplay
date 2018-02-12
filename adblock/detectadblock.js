var adBlockDetected = function() {
  $('h1 span').text('yes');
  adblock_popup();
}
var adBlockUndetected = function() {
  $('h1 span').text('no');
  adblock_popup();
}

if(typeof FuckAdBlock === 'undefined') {
  $(document).ready(adBlockDetected);
} else {
  var FabPluginGoogleAdsense = function() {
    FuckAdBlock.getPluginClass().apply(this, arguments);
    this.options.set({
      windowVar: 'adsbygoogle',
    });

    var data = {};

    this.start = function() {
      var self = this;
      var windowVar = this.options.get('windowVar');
      data.loopTimeout = setTimeout(function() {
        if(window[windowVar].loaded === true) {
          self.callUndetected();
        } else {
          self.callDetected();
        }
      }, 1);
      return this;
    };
    this.stop = function() {
      clearInterval(data.loopTimeout);
      clearInterval(data.loopInterval);
      return this;
    };
  };
  FabPluginGoogleAdsense.pluginName = 'google-adsense';
  FabPluginGoogleAdsense.versionMin = [4, 0, 0];

  var myFuckAdBlock = new FuckAdBlock;
  myFuckAdBlock.registerPlugin(FabPluginGoogleAdsense);
  myFuckAdBlock.on(true, adBlockDetected).on(false, adBlockUndetected);
  $(document).ready(function() {
    myFuckAdBlock.check(['google-adsense']);
  });
}
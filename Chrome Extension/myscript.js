//adding "Twitch 2.0" to all twitch.tv streams beneath video player in-line with channel stats.

function inject() {
      if(document.getElementsByClassName('channel-stats')[0]){
            var channelName = setChannel();

            var Link       = document.createElement('a');
            Link.href      = 'http://35.9.22.102/beta/twitch/index.php?c=' + channelName;
            Link.target    = '_blank';
            Link.className = 'action button js-sub-button primary subscribe-button';
            Link.setAttribute('style', 'float:left;');
            Link.setAttribute('id', 'twitch-two-point-zero');

            var Container = document.createElement('span');
            Container.setAttribute('id','injected');
            Container.className = 'subscribe-text';
            Container.innerHTML = 'Twitch 2.0 &nbsp';

            Link.appendChild(Container);
            document.getElementsByClassName('channel-stats')[0].appendChild(Link);
            window.clearInterval(intervalId);

            document.getElementById('twitch-two-point-zero').onclick = function(){
              if(document.getElementsByClassName('player')[0].getAttribute("data-paused") == "false"){
                document.getElementsByClassName('player-button player-button--playpause js-control-playpause-button')[0].click();
              }
            };
        }
}

function setChannel() {
      var channel = window.location.href;
      channel = channel.substr(22);
      return channel;
}

if(document.getElementsByClassName("channel_new columns")[0]) {
    var intervalId = setInterval(inject, 500);
}

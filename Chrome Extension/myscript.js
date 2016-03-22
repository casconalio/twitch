function inject() {
      if(document.getElementsByClassName('channel-stats')[0]){
            document.getElementsByClassName('channel-stats')[0].appendChild(Link);
            window.clearInterval(intervalId);
      }
}

if(document.getElementsByClassName("channel_new columns")[0]) {
      var Link       = document.createElement('a');
      Link.href      = 'http://35.9.22.102/beta/twitch/twitch.php';
      Link.target    = '_blank';
      Link.className = 'channel-name';
      Link.setAttribute('style', 'float:left;');

      var Container = document.createElement('span');
      Container.setAttribute('id','injected');
      Container.setAttribute('style', 'padding-top:1px;font-weight:200%;');
      Container.innerHTML = 'Twitch 2.0';
      
      Link.appendChild(Container);
      var intervalId = setInterval(inject, 500);
}
/*
if(document.getElementsByClassName("ad")[0]){
      alert("we're in");
      var Link       = document.createElement("a");
      Link.href      = 'http://35.9.22.102/beta/twitch/twitch.php';
      Link.target    = '_blank';
      Link.className = 'channel-stats';
      Link.setAttribute('style', 'float:left;');

      var Container = document.createElement('span');
      Container.setAttribute('id', 'twitch-improvements-link');
      Container.className = 'twitch-improvements';
      Container.innerHTML = 'Improved Twitch';

      Link.appendChild(Container);
      document.getElementById('topCmts').appendChild(Link);
}*/
//var chans = []; // Channels to initially join

function setChannel() {
	//chans = [];
	var channelName = document.getElementById("Channel").value;
	chans.glob.push(String(channelName));
	alert(chans.glob);
}

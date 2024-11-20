document.addEventListener("DOMContentLoaded", function () {
	gallerySliderSwiper();
});

function gallerySliderSwiper() {
	var gallerySliderSwiper = new Swiper('.swiper-container', {
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		effect: "fade",
		fadeEffect: {
			crossFade: true
		},
	})
}

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubeIframeAPIReady(id) {
	let player = document.querySelectorAll('[iframe-video]');
	let buttons = document.querySelectorAll('[video-buttons]');

	player.forEach(item => {
		var itemElem = item.dataset.videoLink;
		itemElem = new YT.Player(item, {
			videoId: 'V2cF4uE0mXs'
		});

		buttons.forEach(item => {
			item.addEventListener('click', function (e) {
				itemElem.pauseVideo();
			});
		});
	})
}

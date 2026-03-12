function videoParser(card) {
    function outerFind(el, selector) {
        var elements = Array.from(el.querySelectorAll(selector));
        if (el.matches && el.matches(selector)) elements.splice(0, 0, el);
        return elements;
    };
    outerFind(card, '[data-bg-video]').forEach(function(el) {
        console.log(card);
        var videoURL = el.getAttribute('data-bg-video');
        if (!videoURL) return;

        var searchParams = new URLSearchParams(videoURL);
        var startAt = Number(searchParams.has('t') ? searchParams.get('t') : 0) || 0;
        var parsedUrl = videoURL.match(/(http:\/\/|https:\/\/|)?(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(shorts\/|video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(&\S+)?/);

        var img = el.querySelector('.mbr-background-video-preview') || document.createElement('div');

        img.classList.add('mbr-background-video-preview');
        img.style.display = 'none';
        img.style.backgroundSize = 'cover';
        img.style.backgroundPosition = 'center';

        if (!el.querySelector('.mbr-background-video-preview')) {
            el.childNodes[0].before(img)
        }

        const optimizeDisplay = function(player, iframe) {
            let vid = {};
            let win = {};
            win.width = window.outerWidth;
            win.height = window.outerHeight;

            let ratio = player._opts.width / player._opts.height;

            vid.width = win.width;
            vid.height = Math.ceil(vid.width / ratio);
            vid.marginTop = Math.ceil(-((vid.height - win.height) / 2));
            let lowest = vid.height < win.height;

            if (lowest) {
                vid.height = win.height;
                vid.width = Math.ceil(vid.height * ratio);
                vid.marginLeft = Math.ceil(-((vid.width - win.width) / 2))
            }
            player.setSize(vid.width, vid.height);
        };

        if (parsedUrl && (/youtu\.?be/g.test(parsedUrl[3]) || /vimeo/g.test(parsedUrl[3]))) {

            if (parsedUrl && /youtu\.?be/g.test(parsedUrl[3])) {
                parsedUrl[6] = parsedUrl[6].replace('shorts', 'embed')
                var previewURL = 'http' + ('https:' === location.protocol ? 's' : '') + ':';
                previewURL += '//img.youtube.com/vi/' + parsedUrl[6] + '/maxresdefault.jpg';
                var image = new Image();

                image.onload = function() {

                    if (120 === (image.naturalWidth || image.width)) {
                        // selection of preview in the best quality
                        var file = image.src.split('/').pop();

                        switch (file) {
                            case 'maxresdefault.jpg':
                                image.src = image.src.replace(file, 'sddefault.jpg');
                                break;
                            case 'sddefault.jpg':
                                image.src = image.src.replace(file, 'hqdefault.jpg');
                                break;
                            default: // image not found
                                if (isBuilder) {
                                    img.style.backgroundImage = 'url("images/no-video.jpg")';
                                    img.style.display = 'block';
                                }
                        }
                    } else {
                        img.style.backgroundImage = 'url("' + image.src + '")';
                        img.style.display = 'block';
                    }

                    if (el.querySelector('.mbr-background-video')) el.querySelector('.mbr-background-video').remove();

                    var videoElement = document.createElement('div');
                    const wrapperBackground = document.createElement('div');
                    const videoBackground = document.createElement('div')
                    const videoForeground = document.createElement('div')

                    videoForeground.classList.add('mbr-video-foreground');

                    videoForeground.appendChild(videoElement)
                    videoBackground.appendChild(videoForeground)
                    wrapperBackground.appendChild(videoBackground)

                    videoElement.classList.add('mbr-background-video');

                    var playerEl = el.childNodes[1].before(wrapperBackground);

                    var imageResolution = {
                        height: image.naturalHeight,
                        width: image.naturalWidth,
                        scale: image.naturalHeight / image.naturalWidth
                    };

                    var sectionResolution = {
                        height: videoElement.parentNode.clientHeight,
                        width: videoElement.parentNode.clientWidth,
                        scale: videoElement.parentNode.clientHeight / videoElement.parentNode.clientWidth,
                    };

                    var videoResolution = {
                        height: imageResolution.height < sectionResolution.height ? imageResolution.height : sectionResolution.height,
                        width: imageResolution.width > sectionResolution.width ? imageResolution.width : sectionResolution.width
                    };
                    if (videoResolution.height / videoResolution.width != imageResolution.scale) {
                        videoResolution.height = videoResolution.width * imageResolution.scale
                    }
                    var options = {
                        // height: videoResolution.height,
                        // width: videoResolution.width,
                        modestBranding: true,
                        autoplay: true,
                        controls: false,
                        origin: '*',
                        iv_load_policy: false,
                        keyboard: false,
                        captions: false,
                        annotations: false,
                        related: false,
                        start: startAt
                    }

                    var player = new YouTubePlayer(videoElement, options);

                    wrapperBackground.style.overflow = 'hidden';
                    wrapperBackground.style.position = 'absolute';
                    wrapperBackground.style.width = '100%';
                    wrapperBackground.style.height = '100%';
                    wrapperBackground.style.top = '0';
                    wrapperBackground.style.left = '0';

                    videoBackground.style.background = '#000';
                    videoBackground.style.top = '0';
                    videoBackground.style.right = '0';
                    videoBackground.style.bottom = '0';
                    videoBackground.style.left = '0';

                    videoForeground.style.position = 'absolute';
                    videoForeground.style.top = '0';
                    videoForeground.style.left = '0';
                    videoForeground.style.width = '100%';
                    videoForeground.style.height = '100%';
                    videoForeground.style.pointerEvents = 'none';

                    videoElement.style.marginTop = '0';
                    videoElement.style.maxWidth = 'initial';
                    videoElement.style.transitionProperty = 'opacity';
                    videoElement.style.transitionDuration = '1000ms';
                    videoElement.style.pointerEvents = 'none';
                    videoElement.style.position = 'absolute';
                    videoElement.style.top = '0';
                    videoElement.style.left = '0';
                    videoElement.style.width = '100%';
                    videoElement.style.height = '100%';
                    videoElement.style.transform = 'scale(1.2)';

                    player.load(parsedUrl[6], true, startAt);
                    player.play();
                    //player.loadPlaylist();
                    player.setLoop(true);
                    player.mute();
                    player.on('ended', () => player.play());

                    optimizeDisplay(player);
                }
                image.setAttribute('src', previewURL);
            }
        }
    });
}
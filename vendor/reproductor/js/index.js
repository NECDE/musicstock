const disk = $('.disk div');
const audio = $('audio');
const trackName = $('.info h3');
const artistName = $('.info h2');
let currentTrack = 0;

let music = [];

const initPlayer = () => {
  music = [
    {title: "Dreams", artist: "Cramberries", music: "http://192.168.1.137/musicstock/mp3/BohemianRhapsody.mp3", img: "https://upload.wikimedia.org/wikipedia/en/f/f0/Dreams_by_The_Cranberries_1994_UK_European_CD_rerelease.jpg"},
    {title: "Dancing Queen", artist: "ABBA", music: "http://hcmaslov.d-real.sci-nnov.ru/public/mp3/ABBA/ABBA%20'Dancing%20Queen'.mp3", img: "https://upload.wikimedia.org/wikipedia/en/e/ef/ABBA_-_Dancing_Queen.png"},
    {title: "Lazarus", artist: "David Bowie", music: "https://k003.kiwi6.com/hotlink/zxkymksfd0/david_bowie_-_lazarus.mp3", img: "https://upload.wikimedia.org/wikipedia/ru/thumb/7/71/David_Bowie_-_Blackstar_song_cover_art.png/200px-David_Bowie_-_Blackstar_song_cover_art.png"},
    {title: "Ameno", artist: "Era", music: "http://hcmaslov.d-real.sci-nnov.ru/public/mp3/Era/Era%20'Ameno'.mp3", img: "https://upload.wikimedia.org/wikipedia/en/6/6c/Era_-_Ameno.jpg"},
  ]
  setTrack(0)
	$('#next_track').on('click', nextTrack)
	$('#prev_track').on('click', prevTrack)
	$('#player').removeClass('loading')
	$('#toggle_state').on('click', playOrPause);
}


const setTrack = (i) => {
    currentTrack = i;
    $('.disk div img').attr('src', music[i].img)
    audio.attr('src', music[i].music);
    audio[0].currentTime = 0;
    trackName.text(music[i].title);
    artistName.text(music[i].artist);
    if (active) audio[0].play();
    $('.disk div img').on('load', () => {
        if (active) {
            let avg = $('.player img').attr('avg').split('|');
            $('.disk').css('box-shadow', "0 15px 20px rgba(" + avg[0] + "," + avg[1] + "," + avg[2] + ", .6)");
        }
    })

}

const nextTrack = () => {
    if (currentTrack == music.length - 1) {
        setTrack(0)
    } else {
        setTrack(currentTrack + 1)
    }
    $('#next_track').addClass('goRight').delay(300).queue(function() {
        $(this).removeClass("goRight").dequeue();
    });

}
const prevTrack = () => {
    if (currentTrack == 0) {
        setTrack(music.length - 1)
    } else {
        setTrack(currentTrack - 1)
    }
    $('#prev_track').addClass('goLeft').delay(300).queue(function() {
        $(this).removeClass("goLeft").dequeue();
    });

}

const playOrPause = () => {
    if (!$('#toggle_state').hasClass('play')) {
        deactivate();
    } else {
        activate();
    }
    $('#toggle_state').toggleClass('play stop')
}


let active = false;
let rotation = 0;

const rotateDisk = () => {
    if (active) {
        rotation += 30;
        disk.css('transform', 'rotate(' + rotation + 'deg)');
        $('.progress div').css('width', audio[0].currentTime / audio[0].duration * 100 + "%")
    }
    setTimeout(rotateDisk, 1000)
}

rotateDisk();


const activate = () => {
    active = true;
    audio[0].play();
    let avg = $('.player img').attr('avg').split('|');
    $('.disk').css('box-shadow', "0 15px 20px rgba(" + avg[0] + "," + avg[1] + "," + avg[2] + ", .6)");
    $('.info, .player').addClass('active')


}

const deactivate = () => {
    active = false;
    audio[0].pause();
    let avg = $('.player img').attr('avg').split('|');
    $('.disk').css('box-shadow', "0 15px 20px rgba(" + avg[0] + "," + avg[1] + "," + avg[2] + ", 0)");
    $('.info, .player').removeClass('active')
}


const disks = document.querySelectorAll('.player img');
disks.forEach(function(e) {
    e.addEventListener('load', function() {
        let rgb = getAverageColourAsRGB(e);
        e.setAttribute('avg', rgb.r + "|" + rgb.g + "|" + rgb.b)
    })
})

function getAverageColourAsRGB(img) {
    var canvas = document.createElement('canvas'),
        context = canvas.getContext && canvas.getContext('2d'),
        rgb = {
            r: 102,
            g: 102,
            b: 102
        }, // Set a base colour as a fallback for non-compliant browsers
        pixelInterval = 5, // Rather than inspect every single pixel in the image inspect every 5th pixel
        count = 0,
        i = -4,
        data, length;

    // return the base colour for non-compliant browsers
    if (!context) {
        alert('Your browser does not support CANVAS');
        return rgb;
    }

    // set the height and width of the canvas element to that of the image
    var height = canvas.height = img.naturalHeight || img.offsetHeight || img.height,
        width = canvas.width = img.naturalWidth || img.offsetWidth || img.width;

    context.drawImage(img, 0, 0);

    try {
        data = context.getImageData(0, 0, width, height);
    } catch (e) {
        // catch errors - usually due to cross domain security issues
        return rgb;
    }

    data = data.data;
    length = data.length;
    while ((i += pixelInterval * 4) < length) {
        count++;
        rgb.r += data[i];
        rgb.g += data[i + 1];
        rgb.b += data[i + 2];
    }

    // floor the average values to give correct rgb values (ie: round number values)
    rgb.r = Math.floor(rgb.r / count);
    rgb.g = Math.floor(rgb.g / count);
    rgb.b = Math.floor(rgb.b / count);

    return rgb;

}

initPlayer();
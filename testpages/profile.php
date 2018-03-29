<html lang="en" class=""><head>

<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<style>{
  height: 100%;
}
.layout * {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}
.layout body {
  width: 100%;
  height: 100%;
  padding: 20px;
  color: #111;
  background-image: radial-gradient(ellipse farthest-corner at center, #7abcff 0%, #4096ee 100%);
}
.layout h1 {
  font-family: Lobster, Arial;
  text-align: center;
}
.layout .btn {
  position: absolute;
  right: 5px;
  bottom: 5px;
  z-index: 999;
  padding: 6px 10px;
  font-family: "Ubuntu";
  font-size: 16px;
  color: #fff;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#c92437), to(#9e1c2b));
  background-image: linear-gradient(to bottom, #c92437 0%, #9e1c2b 100%);
  border: 0;
  border-radius: 5px;
  -webkit-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
          box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
.ic-container {
  position: relative;
}
.ic-overlay-n,
.ic-overlay-e,
.ic-overlay-s,
.ic-overlay-w {
  position: absolute;
  background-color: #000;
  opacity: 0.7;
}
.ic-overlay-n {
  top: 0;
}
.ic-overlay-e {
  top: 0;
  right: 0;
  bottom: 0;
}
.ic-overlay-s {
  bottom: 0;
}
.ic-overlay-w {
  top: 0;
  bottom: 0;
  left: 0;
}
.ic-resize-handle-ne,
.ic-resize-handle-se,
.ic-resize-handle-nw,
.ic-resize-handle-sw {
  position: absolute;
  width: 10px;
  height: 10px;
  background: #c92437;
  z-index: 999;
}
.ic-resize-handle-nw {
  top: -5px;
  left: -5px;
  cursor: nw-resize;
}
.ic-resize-handle-sw {
  bottom: -5px;
  left: -5px;
  cursor: sw-resize;
}
.ic-resize-handle-ne {
  top: -5px;
  right: -5px;
  cursor: ne-resize;
}
.ic-resize-handle-se {
  bottom: -5px;
  right: -5px;
  cursor: se-resize;
}
.ic-crop-marker {
  position: absolute;
  z-index: 999;
  border: solid 2px rgba(201, 36, 55, 0.5);
  cursor: move;
}
.ic-move-handle {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}
.ic-container img {
  display: block;
  max-width: 100%;
}
* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}
html,
body {
  height: 100%;
}
body {
  padding: 20px;
  text-align: center;
  color: #111;
  background-image: radial-gradient(ellipse farthest-corner at center, #7abcff 0%, #4096ee 100%);
}
img {
  max-width: 100%;
}
section {
  height: 100%;
}
.hidden {
  display: none;
}
.drop {
  position: relative;
  width: 100%;
  height: 100%;
  font-family: Lobster, Arial, serif;
  font-size: 30px;
  color: #333;
  background-color: rgba(255, 255, 255, 0.2);
  border: 5px dashed rgba(51, 51, 51, 0.4);
  cursor: pointer;
  transition-properties: border;
  -webkit-transition-duration: 0.2s;
          transition-duration: 0.2s;
}
.drop.dragging,
.drop:hover {
  border-color: rgba(51, 51, 51, 0.8);
}
.drop p {
  position: absolute;
  top: 50%;
  width: 100%;
  margin-top: -19px;
  margin-bottom: 0;
  text-align: center;
}
.image-resize {
  max-width: 800px;
  margin: auto;
}
.btn {
  margin-top: 20px;
  padding: 8px 25px;
  font-family: "Ubuntu";
  font-size: 16px;
  color: #fff;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#c92437), to(#9e1c2b));
  background-image: linear-gradient(to bottom, #c92437 0%, #9e1c2b 100%);
  border: 0;
  border-radius: 5px;
  -webkit-box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
          box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
.btn .fa:first-child {
  margin-right: 5px;
}
.thumbnail {
  display: inline-block;
  margin: auto;
  padding: 5px;
  background-color: rgba(255, 255, 255, 0.4);
  border-radius: 5px;
}
.thumbnail img {
  display: block;
  border-radius: 5px;
}
</style>
</head><body>

<!-- Upload image -->
<section id="sectionDragAndDrop">
    <div class="drop" id="drop">
        <p>Drag &amp; drop or click here to upload an image.</p>
    </div>
    <input class="file-upload hidden" id="fileUpload" type="file">
</section>

<!-- Resize image -->
<section class="hidden" id="sectionResize">
    <div class="image-resize" id="imageResize"></div>
  <button class="btn" id="crop"><span class="fa fa-crop"></span> Crop</button>
</section>

<!-- Insert thumbnail -->
<section class="hidden" id="sectionThumbnail">
    <div class="thumbnail" id="thumbnail"></div>
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>// Requires jQuery
var imageCrop = function(imageTarget, requiredWidth, requiredHeight) {
    // Variables
    var $doc = $(document),
        $cropMarker,
        $originalImage,
        origSrc = new Image(),
        imageTarget = $(imageTarget).get(0),
        imageScale,
        imageRatio,
        cropRatio,
        adjustedRequiredWidth,
        adjustedRequiredHeight,
        eventState = {},
        allowResize = true,
        keyboardMove = false,
        imageLoaded = new $.Deferred();

    origSrc.crossOrigin = "Anonymous";

    function init() {
        origSrc.onload = function() {
            // Check to make sure the target image is large enough
            if (origSrc.width < requiredWidth || origSrc.height < requiredHeight) {
                console.log('Image Crop error: The required dimensions are larger than the target image.');
                return false;
            }

            // And neccessary html
            $(imageTarget).wrap('<div class="ic-container"></div>').before('\
                <div class="ic-overlay-n" id="icOverlayN"></div>\
                <div class="ic-overlay-e" id="icOverlayE"></div>\
                <div class="ic-overlay-s" id="icOverlayS"></div>\
                <div class="ic-overlay-w" id="icOverlayW"></div>\
                <div class="ic-crop-marker" id="icCropMarker">\
                    <div class="ic-resize-handle-nw" id="icResizeHandleNW"></div>\
                    <div class="ic-resize-handle-ne" id="icResizeHandleNE"></div>\
                    <div class="ic-resize-handle-sw" id="icResizeHandleSW"></div>\
                    <div class="ic-resize-handle-se" id="icResizeHandleSE"></div>\
                    <div class="ic-move-handle" id="icMoveHandle"></div>\
                </div>\
            ');
            $cropMarker = $('#icCropMarker');
            $originalImage = $(imageTarget);
            imageScale = origSrc.width / $originalImage.width();
            imageRatio = origSrc.width / origSrc.height;
            cropRatio = requiredWidth / requiredHeight;
            adjustedRequiredWidth = requiredWidth / imageScale;
            adjustedRequiredHeight = requiredHeight / imageScale;

            centerCropMarker();
            repositionOverlay();

            $cropMarker.on('mousedown touchstart', startResize);
            $cropMarker.on('mousedown touchstart', '#icMoveHandle', startMoving);
            imageLoaded.resolve();
        };
        origSrc.src = imageTarget.src;
    };

    function startResize(e) {
        e.preventDefault();
        e.stopPropagation();
        saveEventState(e);
        $doc.on('mousemove touchmove', resizing);
        $doc.on('mouseup touchend', endResize);
    };

    function endResize(e) {
        e.preventDefault();
        $doc.off('mouseup touchend', endResize);
        $doc.off('mousemove touchmove', resizing);
    };

    function resizing(e) {
        var mouse = {},
            width,
            height,
            left,
            top,
            originalWidth = $cropMarker.outerWidth(),
            originalHeight = $cropMarker.outerHeight(),
            originalOffset = $cropMarker.position();
        mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
        mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();

        var SE = false,
            SW = false,
            NW = false,
            NE = false;

        if ($(eventState.evnt.target).is('#icResizeHandleSE')) {
            SE = true;
        } else if ($(eventState.evnt.target).is('#icResizeHandleSW')) {
            SW = true;
        } else if ($(eventState.evnt.target).is('#icResizeHandleNW')) {
            NW = true;
        } else if ($(eventState.evnt.target).is('#icResizeHandleNE')) {
            NE = true;
        }

        if (SE) {
            width = mouse.x - eventState.containerLeft - $originalImage.offset().left;
            height = width / requiredWidth * requiredHeight;
            left = eventState.containerLeft;
            top = eventState.containerTop;
        } else if (SW) {
            width = eventState.containerWidth - (mouse.x - eventState.containerLeft - $originalImage.offset().left);
            height = width / requiredWidth * requiredHeight;
            left = mouse.x - $originalImage.offset().left;
            top = eventState.containerTop;
        } else if (NW) {
            width = eventState.containerWidth - (mouse.x - eventState.containerLeft - $originalImage.offset().left);
            height = width / requiredWidth * requiredHeight;
            left = mouse.x - $originalImage.offset().left;
            top = originalOffset.top + originalHeight - height;
        } else if (NE) {
            width = mouse.x - eventState.containerLeft - $originalImage.offset().left;
            height = width / requiredWidth * requiredHeight;
            left = eventState.containerLeft;
            top = originalOffset.top + originalHeight - height;
        }

        if (
            top >= 0 &&
            left >= 0 &&
            Math.round(top + height) <= Math.round($originalImage.height()) &&
            Math.round(left + width) <= Math.round($originalImage.width())
        ) {
            allowResize = true;
        }

        if (allowResize) {
            // Over top boundary
            if (top < 0) {
                height = originalHeight + originalOffset.top;
                width = height / requiredHeight * requiredWidth;
                top = 0;
                if (NW) {
                    left = originalOffset.left - (width - originalWidth);
                }
                allowResize = false;
            }
            // Over left boundary
            else if (left < 0) {
                width = originalWidth + originalOffset.left;
                height = width / requiredWidth * requiredHeight;
                left = 0;
                if (SE) {
                    top = originalOffset.top - (height - originalHeight);
                }
                allowResize = false;
            }
            // Over bottom boundary
            else if (Math.round(top + height) > Math.round($originalImage.height())) {
                height = $originalImage.height() - top;
                width = height / requiredHeight * requiredWidth;
                if (SW) {
                    left = originalOffset.left - (width - originalWidth);
                }
                allowResize = false;
            }
            // Over right boundary
            else if (Math.round(left + width) > Math.round($originalImage.width())) {
                width = $originalImage.width() - left;
                height = width / requiredWidth * requiredHeight;
                if (NE) {
                    top = originalOffset.top - (height - originalHeight);
                }
                allowResize = false;
            }

            // Check for min width / height
            if (width > adjustedRequiredWidth && height > adjustedRequiredHeight) {
                $cropMarker.outerWidth(width).outerHeight(height);
                $cropMarker.css({
                    'left': left,
                    'top': top
                });
            } else {
                if (SW || NW) {
                    left = left - (adjustedRequiredWidth - width);
                }
                if (NW || NE) {
                    top = top - (adjustedRequiredHeight - height);
                }
                $cropMarker.outerWidth(adjustedRequiredWidth).outerHeight(adjustedRequiredHeight);
                $cropMarker.css({
                    'left': left,
                    'top': top
                });
            }
        }
        repositionOverlay();
    }

    function startMoving(e) {
        e.preventDefault();
        e.stopPropagation();
        saveEventState(e);
        $doc.on('mousemove touchmove', moving);
        $doc.on('mouseup touchend', endMoving);
    };

    function endMoving(e) {
        e.preventDefault();
        $doc.off('mouseup touchend', endMoving);
        $doc.off('mousemove touchmove', moving);
    };

    function moving(e) {
        var top,
            left,
            mouse = {},
            touches;
        e.preventDefault();
        e.stopPropagation();

        touches = e.originalEvent.touches;

        mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft();
        mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();

        top = mouse.y - (eventState.mouseY - eventState.containerTop);
        left = mouse.x - (eventState.mouseX - eventState.containerLeft);
        if (top < 0) {
            top = 0;
        }
        if (top + $cropMarker.outerHeight() > $originalImage.height()) {
            top = $originalImage.height() - $cropMarker[0].getBoundingClientRect().height;
        }
        if (left < 0) {
            left = 0;
        }
        if (left + $cropMarker.outerWidth() > $originalImage.width()) {
            left = $originalImage.width() - $cropMarker[0].getBoundingClientRect().width;
        }
        $cropMarker.css({
            'top': top,
            'left': left
        });
        repositionOverlay();
    };

    document.addEventListener('keydown', function(e) {
        var top,
            left,
            shiftAmount,
            top = $cropMarker.position().top,
            left = $cropMarker.position().left;
        if (e.shiftKey) {
            shiftAmount = 10;
        } else {
            shiftAmount = 1;
        }

        if (e.keyCode === 37) {
            left = left - shiftAmount;
        } else if (e.keyCode === 38) {
            top = top - shiftAmount;
        } else if (e.keyCode === 39) {
            left = left + shiftAmount;
        } else if (e.keyCode === 40) {
            top = top + shiftAmount;
        }

        if (top < 0) {
            top = 0;
        }
        if (top + $cropMarker.outerHeight() > $originalImage.height()) {
            top = $originalImage.height() - $cropMarker[0].getBoundingClientRect().width;
        }
        if (left < 0) {
            left = 0;
        }
        if (left + $cropMarker.outerWidth() > $originalImage.width()) {
            left = $originalImage.width() - $cropMarker[0].getBoundingClientRect().width;
        }

        if (keyboardMove) {
            $cropMarker.css({
                'top': top,
                'left': left
            });
            repositionOverlay();
        }
    });

    $doc.click(function(e) {
        if ($(e.target).closest('.ic-container').length) {
            keyboardMove = true;
        } else {
            keyboardMove = false;
        }
    })

    var saveEventState = function(e) {
        eventState.containerWidth = $cropMarker.outerWidth();
        eventState.containerHeight = $cropMarker.outerHeight();
        eventState.containerLeft = $cropMarker.position().left;
        eventState.containerTop = $cropMarker.position().top;
        eventState.mouseX = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft();
        eventState.mouseY = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
        eventState.evnt = e;
    };

    var centerCropMarker = function() {
        if (cropRatio > imageRatio) {
            $cropMarker.outerWidth($originalImage.width());
            $cropMarker.outerHeight($cropMarker.outerWidth() / requiredWidth * requiredHeight);
            $cropMarker.css({
                top: ($originalImage.height() - $cropMarker.height()) / 2 + 'px',
                left: 0
            });
        } else {
            $cropMarker.outerHeight($originalImage.height());
            $cropMarker.outerWidth($cropMarker.outerHeight() / requiredHeight * requiredWidth);
            $cropMarker.css({
                left: ($originalImage.width() - $cropMarker.width()) / 2 + 'px',
                top: 0
            });
        }
    }

    function repositionOverlay() {
        var imgWidth = $originalImage[0].getBoundingClientRect().width,
            imgHeight = $originalImage[0].getBoundingClientRect().height,
            cropTop = $cropMarker.position().top,
            cropLeft = $cropMarker.position().left,
            cropWidth = $cropMarker[0].getBoundingClientRect().width,
            cropHeight = $cropMarker[0].getBoundingClientRect().height,
            cropBorder = parseFloat($cropMarker.css('border-top-width'));
        $('#icOverlayN').css({
            right: imgWidth - cropLeft - cropWidth,
            height: cropTop,
            left: cropLeft
        });
        $('#icOverlayE').css({
            left: cropLeft + cropWidth
        });
        $('#icOverlayS').css({
            right: imgWidth - cropLeft - cropWidth,
            top: cropTop + cropHeight,
            left: cropLeft
        });
        $('#icOverlayW').css({
            width: cropLeft
        });
    };

    // Crop to required size
    this.crop = function() {
        var cropCanvas,
            img = new Image(),
            scale = origSrc.width / $originalImage.width(),
            left = Math.round($cropMarker.position().left * scale),
            top = Math.round($cropMarker.position().top * scale),
            width = Math.round($cropMarker.outerWidth() * scale),
            height = Math.round($cropMarker.outerHeight() * scale);
        results;

        cropCanvas = document.createElement('canvas');
        cropCanvas.width = requiredWidth;
        cropCanvas.height = requiredHeight;
        cropCanvas.getContext('2d').drawImage(origSrc, left, top, width, height, 0, 0, requiredWidth, requiredHeight);

        img.src = cropCanvas.toDataURL();

        var results = {
            img: img,
            left: left,
            top: top,
            width: width,
            height: height,
            requiredWidth: requiredWidth,
            requiredHeight: requiredHeight
        };
        return results;
    }

    this.position = function(left, top, width, height) {
        $.when(imageLoaded).done(function() {
            var scale = origSrc.width / $originalImage.width();
            left = Math.round(left / scale),
                top = Math.round(top / scale),
                width = Math.round(width / scale),
                height = Math.round(height / scale);
            $cropMarker.outerWidth(width).outerHeight(height);
            $cropMarker.css({
                'left': left,
                'top': top
            });
            repositionOverlay();
        });
    }

    this.cropReset = function() {
        centerCropMarker();
        repositionOverlay();
    }

    // Viewport resize
    $(window).resize(function() {
        imageScale = origSrc.width / $originalImage.width();
        adjustedRequiredWidth = requiredWidth / imageScale;
        adjustedRequiredHeight = requiredHeight / imageScale;
        centerCropMarker();
        repositionOverlay();
    });

    init();
};

// Initiate Image Crop
if ($('#exampleImage').length) {
    var exampleCrop = new imageCrop('#exampleImage', 200, 200);
}

// Crop event
$('#exampleCrop').on('click', function() {
    var results = exampleCrop.crop();
    $('body').html(results.img);
});
</script>
<script>$('#drop').on('click', function() {
    $('#fileUpload').trigger('click');
});

$('#fileUpload').on('change', function(e) {
    addImage(e.target);
});

$("#drop").on("dragover", function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragging');
});

$("#drop").on("dragleave", function(e) {
    $(this).removeClass('dragging');
});

$("#drop").on("drop", function(e) {
    e.preventDefault();
    e.stopPropagation();
    var data = e.dataTransfer || e.originalEvent.dataTransfer;
    addImage(data);
});

function addImage(data) {
    var file = data.files[0];
    if (file.type.indexOf('image') === -1) {
        alert('Sorry, the file you uploaded doesn\'t appear to be an image.');
        return false;
    }

    var reader = new FileReader();
    reader.onload = function(event) {
        var img = new Image();
        img.onload = function() {
            if (img.width < 200 || img.height < 200) {
                alert('Sorry, the image you uploaded doesn\'t appear to be large enough.');
                return false;
            }
            cropImage(img);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(file);
}

function cropImage(originalImage) {

    $(originalImage).attr('id', 'fullImage');
    $('#imageResize').html(originalImage);
    $('#sectionDragAndDrop').addClass('hidden');
    $('#sectionResize').removeClass('hidden');

    var newImage = new imageCrop('#fullImage', 200, 200);

    $('#crop').on('click', function() {
        var results = newImage.crop();
        $('#thumbnail').html(results.img);
        $('#sectionResize').addClass('hidden');
        $('#sectionThumbnail').removeClass('hidden');
    });

}


</script>
</body></html>

(function( $ ){
    $.fn.initUploader = function(settings) {
        $.extend( {
            'imageListUrl': null
        }, settings );
        var $targetElement = $(this);

        function addImage(item) {
            var $ul = $targetElement.find('ul.uploaded-images'),
                $li = $('<li></li>'),
                $img = $('<img src="">');
            $img.attr('src', item.src);
            $img.attr('data-id', item.id);
            $li.append($img);
            $ul.append($li);
        }

        function addError(error) {
            var $ul = $targetElement.find('ul.errors'),
                $li = $('<li></li>');
            $li.html(error);

            $ul.append($li);

        }

        function formErrors(errors) {
            $(errors).each(function (key, item) {
                addError(item);
            })
        }


        function loadImages() {
            if (settings.imageListUrl === null) {
                return;
            }
            $ul = $targetElement.find('ul.uploaded-images');
            $ul.find('li').remove();
            $.ajax({
                url: settings.imageListUrl,
                method: "GET",
                processData: false,
                contentType: false,
                success: function(data){
                    $(data).each(function (key, item) {
                        addImage(item);
                    });
                }
            });
        }

        loadImages();

        $(this).on('submit', function(e){
            e.preventDefault();
            var form = e.target;
            var data = new FormData(form);
            $.ajax({
                url: form.action,
                method: form.method,
                processData: false,
                contentType: false,
                data: data,
                success: function(data){
                    if (!data.success) {
                        formErrors(data.errorsData);
                    } else {
                        loadImages();
                    }
                }
            });
        });
    };
})( jQuery );
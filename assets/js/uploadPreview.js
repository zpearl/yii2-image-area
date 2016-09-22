$("#fileUpload").on('change', function () {
    if (typeof (FileReader) != "undefined") {
        var image_holder = $("#image-holder");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "thumb-image"
            }).appendTo(image_holder);

            image_holder.imgAreaSelect({
                handles: true,
                onSelectEnd: someFunction,
            });
        }
        image_holder.show();
        if ($(this)[0].files[0]) {
            reader.readAsDataURL($(this)[0].files[0]);
        }
    } else {
        alert("This browser does not support FileReader.");
    }
});
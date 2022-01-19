$(function () {
    $('#test_dialog').on('click', function () {
        var type = $(this).data('type');
        if (type === 'basic') {
            showBasicMessage();
        }
        else if (type === 'with-title') {
            showWithTitleMessage();
        }
        else if (type === 'success') {
            showSuccessMessageX();
        }
        else if (type === 'confirm') {
            showConfirmMessage();
        }
        else if (type === 'html-message') {
            showHtmlMessage();
        }
        else if (type === 'autoclose-timer') {
            showAutoCloseTimerMessage();
        }
        else if (type === 'we-set-buttons') {
            showWeSet3Buttons();
        }
        else if (type === 'AJAX-requests') {
            showAJAXrequests();
        }
        else if (type === 'DOM-content') {
            showDOMContent();
        }
    });
});

//These codes takes from http://t4t5.github.io/sweetalert/

function showBasicMessage() {
    swal("Hello world!");
}
function showWithTitleMessage() {
    swal("Here's a message!", "It's pretty, isn't it?");
}
function showSuccessMessage() {
    swal("Congratulations!", "your password has been changed", "success");
}

function showSuccessMessageX() {
    var v_url = baseURL + "login/logout";
    swal({
        title: 'Congratulations!',
        text: 'your password has been changed',
        icon: "success",
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then(function () {
        window.location.href = v_url;
    })
}
function showConfirmMessage() {
    swal({
        title: "Are you sure?",
        text: "Change my image profile",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                // 
                var url;
                var $form = $('form');
                // var data = {
                //     'foo': 'bar'
                // };

                url = baseURL + "postilion/ajaxcontroller/ajax_change_image";
                
                sImage = $('#change_img').prop('files')[0];

                var data = new FormData();
                data.append('file_avatar', $('#change_img').prop('files')[0]);
                
                // var data = $form.serialize() + '&' + $.param({
                //     ajaxImage: sImage
                // });

                // alert(sImage);
                $.ajax({
                    url: url,
                    type: "POST",
                    processData: false, // important
                    contentType: false, // important
                    data: data,
                    dataType: "JSON",
                    success: function (data) {
                        swal("Success! Your image profile has been updated", {
                            icon: "success",
                        }).then(function () {
                            location.reload();
                        });
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert('Error adding / update data');
                        swal("Error update image profile");
                    }
                });
      
            } else {
                swal("Your imaginary file is safe!");
            }
        });
}
function showHtmlMessage() {
    swal({
        title: "HTML <small>Title</small>!",
        text: "A custom <span style=\"color: #CC0000\">html<span> message.",
        html: true
    });
}
function showAutoCloseTimerMessage() {
    swal({
        title: "Auto close alert!",
        text: "I will close in 2 seconds.",
        timer: 2000,
        showConfirmButton: false
    });
}
function showWeSet3Buttons() {
    swal("A wild Pikachu appeared! What do you want to do?", {
        buttons: {
            cancel: "Run away!",
            catch: {
                text: "Throw Pokéball!",
                value: "catch",
            },
            defeat: true,
        },
    })
        .then((value) => {
            switch (value) {

                case "defeat":
                    swal("Pikachu fainted! You gained 500 XP!");
                    break;

                case "catch":
                    swal("Gotcha!", "Pikachu was caught!", "success");
                    break;

                default:
                    swal("Got away safely!");
            }
        });
}
function showAJAXrequests() {
    swal({
        text: 'Search for a movie. e.g. "La La Land".',
        content: "input",
        button: {
            text: "Search!",
            closeModal: false,
        },
    })
        .then(name => {
            if (!name) throw null;

            return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
        })
        .then(results => {
            return results.json();
        })
        .then(json => {
            const movie = json.results[0];

            if (!movie) {
                return swal("No movie was found!");
            }

            const name = movie.trackName;
            const imageURL = movie.artworkUrl100;

            swal({
                title: "Top result:",
                text: name,
                icon: imageURL,
            });
        })
        .catch(err => {
            if (err) {
                swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
        });
}
function showDOMContent() {
    swal("Write something here:", {
        content: "input",
    })
        .then((value) => {
            swal(`You typed: ${value}`);
        });
}

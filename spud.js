var redirhost = "https://spud.mightypotato.de/rd.php?rd=";
// var redirhost = "localhost/rd.php?rd=";

function onCreateButtonClick() {
    var element = document.getElementById("urlInput");
    var longUrl = element.value;
    if (!longUrl) {
        return null;
    }
    get(longUrl, function (msg) {
        console.log(msg);
        var json = JSON.parse(msg);
        if (jQuery.isEmptyObject(json)) {
            doesNotExistCallback(longUrl);
        } else {
            existsCallback(json);
        }
    });
}

function existsCallback(json) {
    showUrl(json);
}

function doesNotExistCallback(longUrl) {
    create(longUrl, function (msg) {
        get(longUrl, function (msg) {
            var json = JSON.parse(msg);
            if (jQuery.isEmptyObject(json)) {
                alert("Some error occured...");
            } else {
                existsCallback(json);
            }
        });
    });
}

function showUrl(urlObj) {
    var fullUrl = redirhost + urlObj[0].ShortURL;
    var output = document.getElementById("resultOutput");
    output.value = fullUrl;
    //only works when using inline style tag!
    document.getElementById("resultContainer").style.display = "";
}

function getrandom() {
    var random_string = (Math.random() * Date.now()).toString();
    return random_string;
}

function create(longUrl, callback) {
    $.ajax({
        type: "POST",
        url: "create.php",
        data: {
            longUrl: longUrl,
            shortUrl: getrandom(),
        },
        success: callback,
    });
}

function get(longUrl, callback) {
    $.ajax({
        type: "POST",
        url: "get.php",
        data: {
            longUrl: longUrl,
        },
        success: callback,
    });
}

function onCopyButtonClick() {
    var element = document.getElementById("resultOutput");
    element.select();
    element.setSelectionRange(0, 999999);
    navigator.clipboard.writeText(element.value);
}

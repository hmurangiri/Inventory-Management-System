<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <link href="../css/styles2.css" rel="stylesheet">
    <style></style>
</head>

<body>

    <div class="container content"  style="height:100vh;justify-content: center;align-items: center;display: flex;">

        <div class="row align-items-center">
            <div class="col-12">

                <!-- <header class="header">
                    
                </header> -->

                <div class="text-center">
                    <div>
                        <p class="typewriter">Manage your
                            <span data-text="stock, inventory, assets"></span> online.
                        </p>
                    </div>

                    <div class="col-12 text-center" style="height:inherit">
                        <button class="btn btn-primary center" style=" margin-right:100px;padding: 10px 10px;"><a href="user/signup"
                                style="color:inherit;text-decoration:inherit;">Get Started</a></button>

                        <button class="btn btn-primary center" style="padding: 10px 30px;"><a href="user/login"
                                style="color:inherit;text-decoration:inherit;">Login</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var span = document.querySelector(".typewriter span");
        var textArr = span.getAttribute("data-text").split(", ");
        var maxTextIndex = textArr.length;

        var sPerChar = 0.15;
        var sBetweenWord = 1.5;
        var textIndex = 0;

        typing(textIndex, textArr[textIndex]);

        function typing(textIndex, text) {
            var charIndex = 0;
            var maxCharIndex = text.length - 1;

            var typeInterval = setInterval(function () {
                span.innerHTML += text[charIndex];
                if (charIndex == maxCharIndex) {
                    clearInterval(typeInterval);
                    setTimeout(function () { deleting(textIndex, text) }, sBetweenWord * 1000);

                } else {
                    charIndex += 1;
                }
            }, sPerChar * 1000);
        }

        function deleting(textIndex, text) {
            var minCharIndex = 0;
            var charIndex = text.length - 1;

            var typeInterval = setInterval(function () {
                span.innerHTML = text.substr(0, charIndex);
                if (charIndex == minCharIndex) {
                    clearInterval(typeInterval);
                    textIndex + 1 == maxTextIndex ? textIndex = 0 : textIndex += 1;
                    setTimeout(function () { typing(textIndex, textArr[textIndex]) }, sBetweenWord * 1000);
                } else {
                    charIndex -= 1;
                }
            }, sPerChar * 1000);
        }
    </script>

</body>

</html>
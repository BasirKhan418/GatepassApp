
function domReady(fn) {
    if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
    ) {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}
 
domReady(function () {
 
    // If found you qr code
    function onScanSuccess(decodeText, decodeResult) {
        // Handle on success condition with the decoded content
        var audio = document.getElementById("audioplay");
		console.log(`Scan result: ${decodeText}`, decodeResult);
        audio.play();
        setTimeout(() => {
            const form = document.createElement('form');
        form.setAttribute('action', '/gatepassapp/users/scan.php');
        form.setAttribute('method', 'post');

        const input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('name', 'gatepassno');
        input.setAttribute('id', 'gatepassno');
        input.setAttribute('placeholder', 'Enter GatePass No');
        input.setAttribute('value', decodeText);

        form.appendChild(input);
        document.body.appendChild(form);

        // Automatically submit the form
        form.submit();
        }, 1000);
    }
 
    let htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 10, qrbos: 250 }
    );
    htmlscanner.render(onScanSuccess);
});



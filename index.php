<!-- initiaite html structure -->
<!DOCTYPE html>
<html>
<body>
    <script type="text/javascript" src="$WEBAPIS/webapis/webapis.js"></script>
    <script type="text/javascript" src="webOSTV.js"></script>
    <script>
        

        //Samsung
        try {
            var value = webapis.appcommon.getUuid();
            console.log(" Uuid value : " + value);
        } catch (e) {
        if(e.message.indexOf('undefined') == -1) {
            // Error, such as a missing privilege
        } else {
            // Undefined error
            // Older firmware and models do not support this method
            // Consider using a legacy method
        }
        }
        const responseSamsung = fetch('https://reqbin.com/echo/post/json', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({"Uuid value" : value})
        })
        .then(response => response.json())
        .then(response => console.log(JSON.stringify(response)))

        //LG
        var request = webOS.service.request('luna://com.webos.service.sm', {
        method: 'deviceid/getIDs',
        parameters: {
            idType: ['LGUDID'],
        },
        onSuccess: function (inResponse) {
            console.log('Result: ' + JSON.stringify(inResponse));
            const responseLg = fetch('https://reqbin.com/echo/post/json', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(inResponse)
        })
        .then(response => response.json())
        .then(response => console.log(JSON.stringify(response)))
        },
        onFailure: function (inError) {
            console.log('Failed to get system ID information');
            console.log('[' + inError.errorCode + ']: ' + inError.errorText);
            return;
        },
        });
        

        //Others
        const userAgent = navigator.userAgent;
        console.log(JSON.stringify(userAgent));
        // Check if the user agent string contains "Android"
        if (userAgent.indexOf("Android") >= 0) {
        // If it does, extract the Android version number
        const androidVersion = userAgent.match(/Android\s([\d\.]+)/)[1];
        console.log("Android version:", androidVersion);

        // Extract the device model name
        const modelStartIndex = userAgent.indexOf("(") + 1;
        const modelEndIndex = userAgent.indexOf(")");
        const modelName = userAgent.substring(modelStartIndex, modelEndIndex);
        console.log("Device model name:", userAgent);
        const responseLg = fetch('https://reqbin.com/echo/post/json', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(inResponse)
        })
        .then(response => response.json())
        .then(response => console.log(JSON.stringify(response)))
        }

    </script>

</body>
</html>



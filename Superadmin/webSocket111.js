
var smsLog = '';
//$(document).ready(function () {

//Using the HiveMQ public Broker, with a random client Id
    var client = new Messaging.Client("104.131.60.78", 1884, "myclientid_" + parseInt(Math.random() * 100, 10));
    console.log('clinet', client);
//Using the HiveMQ public Broker, with a random client Id


//Gets  called if the websocket/mqtt connection gets disconnected for any reason
    client.onConnectionLost = function (responseObject) {
//Depending on your scenario you could implement a reconnect logic here
        alert("connection lost: " + responseObject.errorMessage);
    };



//Connect Options
    var options = {
        timeout: 3,
//Gets Called if the connection has sucessfully been established
        onSuccess: function () {
            client.subscribe("dispatchLog/#", {qos: 2});
//            alert("Connected");
        },
//Gets Called if the connection could not be established
        onFailure: function (message) {
            alert("Connection failed: " + message.errorMessage);
        }
    };
    client.connect(options);
//Gets called whenever you receive a message for your subscriptions
//     client.onMessageArrived = function (message) {
//        var topicName = message.destinationName;
//        var topic = topicName.split("/");
//        switch (topic[1])
//        {
//            case 'smsLog':
//                smsLog = message.payloadString;
//                break;
//            default :
//                console.log("defu", topic[1]);
//                break;
//        }
//        console.log('message', message);
//        console.log('message.destinationName', message.destinationName);
//        console.log('message.payloadString', message.payloadString);
////Do something with the push message you received
////     $('#messages').append('<span>Topic: ' + message.destinationName + '  | ' + message.payloadString + '</span><br/>');
//    };
//});

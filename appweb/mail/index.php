

<button onclick="myFunction()">Click me</button>

<script>
    function myFunction() {
        window.location.href = "mailto:dadoprso76@gmail.com?subject=ABSENCE INJUSTIFIEES&body=message%20goes%20here";
        var theApp = new ActiveXObject("Outlook.Application")
        var theMailItem = theApp.CreateItem(0) // value 0 = MailItem
//Bind the variables with the email
        theMailItem.to = to
        theMailItem.Subject = (subject);
        theMailItem.Body = (msg);
        theMailItem.Attachments.Add("Test.rtf");
//Show the mail before sending for review purpose
//You can directly use the theMailItem.send() function
//if you do not want to show the message.
        theMailItem.display();
        theMailItem.send();
    }
</script>

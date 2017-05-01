/**
* below click function is performed on the sign in button and ajax is called on the basis of text, and check-in.php page is called through ajax;
*/
$(".check-in").click(function() {
  var text1 = document.getElementById('checking').innerHTML;
  mscConfirm({ title: 'Are you sure, you want to '+text1,
        okText: 'I Agree',    // default: OK
        cancelText: 'I Dont', // default: Cancel,
        dismissOverlay: true, // default: false, closes dialog box when clicked on overlay.
        onOk: function() {
         var xmlhttp;
            if(window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
            }
            else {
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
              if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var newtext = xmlhttp.responseText;
                if(newtext == "Sign Out") {
                  document.getElementById('checking').innerHTML = "Sign Out";
                  location.reload(); 
                }
                if(newtext == "Sign In") {
                  document.getElementById('checking').innerHTML = "Sign In";
                  location.reload(); 
                }
              }
            }
          xmlhttp.open("POST","check-in.php?name="+text1,true);
          xmlhttp.send();
        },
        onCancel: function() {
         
        }
      });
    
  });
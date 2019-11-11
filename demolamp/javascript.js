function O(i) { 
    return typeof i == 'object' ? i : document.getElementById(i);
}

function S(i) { 
    return O(i).style
}

function C(i) { 
    return document.getElementsByClassName(i)
}


window.onload=function(){
    // wrap listener in an if statement so it only attemps when on correct pages
    if (document.getElementById("messagesContainer")){
        var getView = document.getElementById("hidden").textContent;
        console.log(getView);
//        let searchParams = new URLSearchParams(window.location.search);
//        
//        let param = searchParams.get('view')
//        console.log(searchParams);
        
        // call phph with value set
        //var getView = "<?php echo sanitizeString($_GET['view']); ?>";
        //var getView = "<?php echo $view ?>";
        //console.log(getView);
        //var $_GET = JSON.parse("<?php echo json_encode($_GET); ?>");
        
        //$_GET['view']; ?>";
        //var val = "echo $_GET['view']";
        //console.log(getView);
        // get container element
        var x = document.getElementById("messagesContainer");

        x.addEventListener("scroll", function(){

            var scrollTop = x.scrollTop;
            var offsetHeight = x.offsetHeight;
            var clientHt = x.clientHeight;

            var scrollHt = x.scrollHeight;
            var scrollTp = x.scrollTop;
            /*if (offsetHeight <= scrollTop + clientHeight) */ 

            /*console.log("HT" + scrollHt);
            console.log("Tp" + scrollTp);
            console.log("client" + clientHt);*/
            console.log("dif" + (scrollHt - scrollTp));


            if (scrollHt - scrollTp === clientHt){
                
                console.log("in if");
                // add more message divs
                // query content from DB and add into divs
                var requestURL = "dbRequest.php?view=" + getView;

                $.ajax({method: "GET", url: requestURL}).done(function( data ) {
                    // parse result
                    var result = $.parseJSON(data);
                    console.log(data);
                    
                    // loop through the returned values and create new messages
                    $.each(result, function(key, value){
                        
                        //if (value['pm'] == 0 || value['auth'] == $user)
                        
                        var newMessage = "<div class='messageContent'> Date: "
                        newMessage += value['time'];
                        newMessage += " <a href='messages.php?view=";
                        newMessage += value['auth'] + "'>" + value['auth'] + "</a> ";
                        if (value['pm'] == 0){
                            newMessage += "wrote a <em> public post</em>:<div>\"";
                            newMessage += value['message'] + "&quot; ";
                        } else {
                            newMessage += "wrote a <em>private note</em>:<br><div>\"";
                            newMessage += value['message'] + "&quot; ";

                        }

                        newMessage += "</div>";

                        newMessage += "</div>"

                        $('#messagesContainer').append(newMessage);

                        //console.log("first");
                        //console.log(value['time']);
                        //console.log("key" + key);
                        //console.log("value: " + value);
                        //alert(value['time']);
                    });
                    //console.log("something")
                });

                //x.style.backgroundColor = "red";
            }
        });
    }
        
}


//function scrollHandler() {
//        
////the Element.scrollTop property gets or sets the number of pixels that an element's content is scrolled vertically.
////An element's scrollTop value is a measurement of the distance from the element's top to its topmost visible content. //  When an element's content does not generate a vertical scrollbar, then its scrollTop value is 0.
//        
//
//        /*if (offsetHeight <= scrollTop + clientHeight){*/
//    
//    
//    
//    
//        /*if (scrollHeight - x.scrollTop === x.clientHeight) {*/
//    if (scrollHt - scrollTp === clientHt){
//            x.style.backgroundColor = "red";
//        }
//}

//The following equivalence returns true if an element is at the end of its scroll, false if it isn't.

//element.scrollHeight - element.scrollTop === element.clientHeight




 //The HTMLElement.offsetHeight read-only property returns the height of an element, including vertical padding and 
//borders, as an integer.
    
    
//The Element.scrollHeight read-only property is a measurement of the height of an element's content, including content 
    //not visible on the screen due to overflow.
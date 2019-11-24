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
    
    if (document.getElementById("storeSearch")){
        var reqResults;
        var storeResults = {};
        //var storeName;
        //var storeURL;
        
        var searchButton = document.getElementById("storeSearch");
        searchButton.addEventListener("click", function(){
            if ($('#storeSearch').text() != 'Search') {
                console.log($('#storeSearch').text());
                console.log("something");
                $('#storeSearch').text('Search');
                $("#store").toggle();
                $(".secretForm").css("display", "none");
                
            } else {
            
            // clear the drop down menu
            $('#currentStore').html("");
            
            
            
            
            var queryCity = document.getElementById("citySearch").value;
            var queryState = document.getElementById("stateSearch").value;
            
            // if query City and State are set, 
                //querey with both
            // otherwise
                // query with only city
            
            // set up request URL
            if (queryCity != "" && queryState != ""){
                var reqURL = "bookStoreReq.php?city=" +queryCity + "&state=" + queryState;
                //console.log(reqURL);
            } else if (queryState != ""){
                var reqURL = "bookStoreReq.php?state=" + queryState;
            }
            
            //send ajax
            $.ajax({method: "GET", url: reqURL}).done(function( data ) {
                reqResults = $.parseJSON(data);
                //console.log(data);
                //window.alert("the query: " + data);

                
                            // add the options returned from the search
                //<option value="AL">Alabama</option>

                // loop through the returned values and create new messages
                $.each(reqResults, function(key, value){
                    
                    //capitals.set("AR", "Little Rock");
                    storeName = value['name'];
                    storeURL = value['link'];
                    storeResults[storeName] = storeURL;
                    
                    //var keys = storeResu
                    
                    //console.log('storeResults: ' + Object.keys(storeResults));
                                //Object.keys(storeResults));
                    //storeName = value['name'];
                    //storeURL = value['link'];
                    //console.log('storename: ' + storeName + ' link: ' + storeURL);

                    
                    var newOption = "<option value=" + "'" + value['name'] + "'>";
                    newOption += value['name'];
                    newOption += "</option>";
                    $('#currentStore').append(newOption);
                    console.log("option: " + newOption);
                })

                
                //$('.secretForm').css("display", "block");
                
                
                
                });  // end ajax
                
                // hide search and show results of search
                $("#store").toggle();
                $(".secretForm").toggle();
                $('#storeSearch').text('Reset Search');
            
            }         
                                     
          } ) // end event listener for search button
        
        // Send store info to DB when user hits set button
        var selection = document.getElementById('selection');
        selection.addEventListener('click', function() {
            
            // get the value chosen from drop down
            var storeChoiceStr = $("#currentStore :selected").text();
            var storeChoiceURL = storeResults[storeChoiceStr];
            
            //console.log("storeChoice: " + storeChoiceStr);
            //console.log(storeResults[storeChoiceStr]);
            
            // make ajax post to store choice in database
            
            $.ajax({method: "POST", url: "bookStorePost.php", data: {"yourStore": storeChoiceStr, "storeURL": storeChoiceURL},
             }).done(function( data ) { 
                var postResult = $.parseJSON(data); 
                
                //var str = '';
                
//                // check for successful
//                if(postResult == 1) {
//                  str = 'User record saved successfully.';
//                
//                }else if( postResult == 2) {
//                  str == 'All fields are required.';
//                } else{
//                  str = 'User data could not be saved. Please try again'; 
//                }
                
                console.log('post result: ' + postResult);
                
                // send
            }) // end function
            
            
            //reset on selection
            
            $('#storeSearch').text('Search');
            $('#store').toggle();
            $('.secretForm').toggle();
            $('#currentStore').html("");
            //$("a").attr("href", "http://www.google.com/")
            $('#URLLink').attr("href", storeChoiceURL);
            $('#URLLink').text(storeChoiceStr);
        });
    }
    
    
    
    
    
    
    
    // wrap listener in an if statement so it only attemps when on correct pages
    if (document.getElementById("messagesContainer")){
        var getView = document.getElementById("hidden").textContent;
        //console.log(getView);
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
                
                //console.log("in if");
                // add more message divs
                // query content from DB and add into divs
                var requestURL = "dbRequest.php?view=" + getView;
                //console.log("request: ", requestURL);
                //console.log("something esle");

                $.ajax({method: "GET", url: requestURL}).done(function( data ) {
                    // parse result
                    var result = $.parseJSON(data);
                    console.log(data);
                    
                    // loop through the returned values and create new messages
                    $.each(result, function(key, value){
                        
                        //if (value['pm'] == 0 || value['auth'] == $user)
                        
                        var newMessage = "<div class='messageContent'> Date: "
                        newMessage += value['time'];
                        newMessage += " <a href='members.php?view=";
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